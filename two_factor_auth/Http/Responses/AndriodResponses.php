<?php


namespace TwoFactorAuth\Http\Responses;


use Illuminate\Http\Response;

class AndriodResponses
{
    public function blockUser()
    {
        return response()->json(['err' => 'the account is blocked'], Response::HTTP_BAD_REQUEST);
    }

    public function tokenSend()
    {
        return response()->json(['msg' => 'token was send to ur app.']);

    }
    public function userNotFound()
    {
        return response()
            ->json(['err' => 'email does not exists.', Response::HTTP_BAD_REQUEST] );

    }
    public function emailNotValid()
    {
        return response()
            ->json(['err' => 'your email is not valid.', Response::HTTP_BAD_REQUEST]);

    }
    public function youShouldBeGuest()
    {
        return response()
            ->json(['err' => 'you are logged in.', Response::HTTP_BAD_REQUEST]);
    }
    public function loggedIn()
    {
        return response()
            ->json(['msg' => 'you are logged in.']);
    }
    public function tokenNotFound()
    {
        return response()
            ->json(['msg' => 'token is not valid.']);
    }


}
