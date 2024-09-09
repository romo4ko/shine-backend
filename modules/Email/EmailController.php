<?php

namespace Modules\Email;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmedEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\Users\Models\User;

class EmailController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'token' => 'required|string',
        ]);

        $token = EmailConfirmToken::where('user_id', $request->user_id)
            ->where('token', $request->token)
            ->first();

        if ($token) {
            $user = User::find($token->user_id);
            $user->email_verified_at = Carbon::now();
            $user->status = User::MODERATION;
            $user->save();

            $token->delete();

            Mail::to($user->email)
                ->locale('ru')
                ->send(new ConfirmedEmail());

            $status = [
                'title' => 'Почта успешно подтверждена!',
                'description' => 'Анкета была отправлена на модерацию. После проверки анкеты, вы получите уведомление на почту.',
            ];
        } else {
            $status = [
                'title' => 'Произошла ошибка!',
                'description' => 'Похоже, ссылка не действительна. Попробуйте отправить письмо повторно из вашего профиля в приложении.',
            ];
        }

        return view('mail.status')->with('status', $status);
    }
}
