<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Socialite;

class LoginController extends Controller
{

    /**
     * Redirect the user to the twitter authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }


    /**
     * Obtain the user information from twitter.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('twitter')->user();
        return $user->getNickname() . ' - ' . $user->getName() . ' - ' . $user->getId();

        // $user->token;
    }
}

?>