<?php

namespace Classes;

use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

class SMS {

    public function sendSMS($phone,$message){
        try {


            // Send an SMS using Twilio's REST API and PHP
            $sid = "ACa6f93ff9871950f6828ac1c0f06412d7"; // Your Account SID from www.twilio.com/console
            $token = "8304e5c5c84a08f60616a1551d4cbd90"; // Your Auth Token from www.twilio.com/console
            $twilio_number = '+12673802797';
            $client = new Client($sid, $token);
            $message = $client->messages->create(
                $phone, // Text this number
                [
                    'from' => $twilio_number, // From a valid Twilio number
                    'body' => $message
                ]
            );

            return $this->response(true, 'Mensagem enviada com sucesso!!');
        }catch (RestException $e){
            return $this->response(false, $e->getMessage());
        }
    }
    protected function response($status,$message){
        return[
            'status' => $status,
            'message' => $message
        ];
    }

}