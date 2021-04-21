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

}
