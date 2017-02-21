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
        $nickname = $user->getNickname();
        \Session::put('user', strtolower($nickname));
        return redirect('/admin');
    }
}

?>