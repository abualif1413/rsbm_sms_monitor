<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\DProv\Outbox;
use \App\Exceptions\OutboxException as OutEx;

class SMSController extends Controller
{
    public function send(Request $req)
    {
        try {
            $ob = new Outbox;
            $ob->insert($req->destination_number, $req->text, $req->application_key, $req->application_record_id);

            return response()->json([
                "success" => 1,
                "message" => "Your message has been sent to outbox"
            ]);
        } catch (OutEx $ex) {
            return response()->json([
                "success" => 0,
                "message" => $ex->getMessage()
            ], 401);
        }

        // return response()->json(["salam" => 1]);
    }
}
