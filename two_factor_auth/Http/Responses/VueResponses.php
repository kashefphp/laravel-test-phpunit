<?php


namespace TwoFactorAuth\Http\Responses;


use Illuminate\Http\Response;

class VueResponses
{
    public function blockUser()
    {
        return response()->json(['error' => 'you are blocked'], Response::HTTP_BAD_REQUEST);
    }

    public function tokenSend()
    {
        return response()->json(['message' => 'token was send.']);

    }
    public function userNotFound()
    {
        return response()
            ->json(['error' => 'email does not exists.',Response::HTTP_BAD_REQUEST]);

    }
    public function emailNotValid()
    {
        return response()
            ->json(['error' => 'your email is not valid.', Response::HTTP_BAD_REQUEST]);
    }

    public function youShouldBeGuest()
    {
        return response()
            ->json(['error' => 'you are logged in.', Response::HTTP_BAD_REQUEST]);
    }
    public function loggedIn()
    {
        return response()
            ->json(['message' => 'you are logged in.']);
    }

    public function tokenNotFound()
    {
        return response()
            ->json(['message' => 'token is not valid.']);
    }

}
