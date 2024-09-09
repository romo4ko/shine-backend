<?php

namespace Modules\Email;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmedEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Modules\Users\Models\User;

class EmailController extends Controller
{
    public function verify($user_id, $token): View
    {
        $tokenData = EmailConfirmToken::where('user_id', $user_id)
            ->where('token', $token)
            ->first();

        if ($tokenData !== null) {
            $user = User::find($tokenData->user_id);
            $user->email_verified_at = Carbon::now();
            $user->status = User::MODERATION;
            $user->save();

            $tokenData->delete();

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

        return view('mail.status', ['status' => $status]);
    }
}
