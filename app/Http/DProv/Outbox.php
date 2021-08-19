<?php

namespace App\Http\DProv;

use \App\Models\Outbox as OutboxModel;
use \App\Models\ApplicationOutbox as AO;
use \App\Models\ApplicationList as AL;
use \App\Exceptions\OutboxException as OutEx;

class Outbox
{
    private $outbox_model;

    public function insert($destination_number, $text, $application_key, $application_record_id)
    {
        $app_list = AL::where('application_key', $application_key)->first();
        if($app_list) {
            $ob = new OutboxModel;
            $ob->DestinationNumber = $destination_number;
            $ob->TextDecoded = $text;
            $ob->CreatorID = $app_list->application_name;
            $ob->save();
            $this->outbox_model = $ob;

            $this->insertApplicationOutbox($application_key, $application_record_id);

        } else {
            throw new OutEx("Application not found. Your application key does not match within our application list");
        }
    }

    public function insertApplicationOutbox($application_key, $application_record_id)
    {
        $ao = new AO;
        $ao->application_key = $application_key;
        $ao->application_record_id = $application_record_id;
        $ao->outbox_id = $this->outbox_model->ID;
        $ao->save();
    }
}
