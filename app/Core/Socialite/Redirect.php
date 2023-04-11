<?php

namespace App\Core\Socialite;

use Laravel\Socialite\Facades\Socialite;

class Redirect
{

    public function __invoke($driver)
    {
       return Socialite::driver($driver)->redirect();
    }

}
