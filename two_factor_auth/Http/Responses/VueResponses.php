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

}
