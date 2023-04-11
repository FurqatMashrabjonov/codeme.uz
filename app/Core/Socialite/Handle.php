<?php

namespace App\Core\Socialite;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Routing\Controller;
class Handle extends Controller
{

    public function __invoke($driver, Request $request)
    {
        $user = Socialite::driver($driver)->user();
        $login = User::query()->where('email', $user->email)->first();
        return is_null($login) ? $this->login() : $this->register();
    }

    public function register()
    {

        return 0;
    }

    public function login($credentials){
        return $this->loginPipeline($credentials)->then(function ($request) {
            return app(LoginResponse::class);
        });
    }

}
