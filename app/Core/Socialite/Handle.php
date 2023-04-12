<?php

namespace App\Core\Socialite;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Routing\Controller;
use function Illuminate\Events\queueable;

class Handle extends Controller
{

    public function __invoke($driver, Request $request)
    {

        $userFromSocial = Socialite::driver($driver)->user();
        dd($userFromSocial);
        $user = User::query()->where('email', $userFromSocial->getEmail())->first();

        if (!$user){
            $user = new User();
            $user->name = $userFromSocial->getName() ?? $userFromSocial->getNickname();
            $user->email = $userFromSocial->getEmail();
            $user->avatar = $userFromSocial->getAvatar();
            $user->social_details = json_encode($userFromSocial);
            $user->email_verified_at = Carbon::now();
            $user->save();
        }


        $this->login($user);

    }

    public function register()
    {

        return 0;
    }

    public function login($user)
    {
        try {
            Auth::login(User::first());
            return redirect('/dashboard');
        }catch (\Exception $e){
            Log::error('login error', $e);
        }
        return redirect()->back();
    }

}
