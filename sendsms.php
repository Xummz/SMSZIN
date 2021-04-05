<?php
use Classes\SMS;

$body = file_get_contents('php://input');

if(!$body){
    echo 'Registro não encontrado';
    die();
}

header('content-type: application/json');

require_once './vendor/autoload.php';

$form = json_decode($body);

$sms = new SMS();
echo json_encode($sms->sendSMS($form->formattedPhone,$form->message));