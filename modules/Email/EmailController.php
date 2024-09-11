<?php

namespace Modules\Email;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmedEmail;
use App\Mail\VerifyEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Modules\Users\Models\User;

class EmailController extends Controller
{
    public function verify(int $user_id, string $token): View
    {
        $tokenData = EmailConfirmToken::where('user_id', $user_id)
            ->where('token', $token)
            ->first();

        if ($tokenData !== null) {
            $user = User::find($tokenData->user_id);
            $user->email_verified_at = Carbon::now();
            if ($user->status == User::CONFIRMATION) {
                $user->status = User::MODERATION;
            }
            $user->save();

            $tokenData->delete();

            Mail::to($user->email)
                ->locale('ru')
                ->send(new ConfirmedEmail());

            $message = [
                'title' => 'Почта успешно подтверждена!',
                'description' => 'Анкета была отправлена на модерацию. После проверки анкеты, вы получите уведомление на почту.',
            ];
        } else {
            $message = [
                'title' => 'Произошла ошибка!',
                'description' => 'Похоже, ссылка не действительна. Попробуйте отправить письмо повторно из вашего профиля в приложении.',
            ];
        }

        return view('pages.message', ['message' => $message]);
    }

    public function sendConfirmationEmail()
    {
        $user = Auth::guard('api')->user();

        $emailCheckToken = Str::random(30);
        EmailConfirmToken::create([
            'user_id' => $user->id,
            'token' => $emailCheckToken,
        ]);

        Mail::to($user->email)
            ->locale('ru')
            ->send(new VerifyEmail($user, $emailCheckToken));

        return ['status' => 'success'];
    }
}
