<?php


namespace App\Auth;


class PasswordGrantVerifier
{
    public function verify($username, $password)
    {
        /**
         * TODO: Adjust the verification to the application needs
         */
        $credentials = [
            'email'     => $username,
            'password'  => $password,
        ];

        if (auth()->once($credentials)) {
            return auth()->user()->id;
        }

        return false;
    }
}