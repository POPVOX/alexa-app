<?php

namespace App\Http\Controllers;

use Alexa;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SentimentController extends Controller
{
    public function getBillSentiment()
    {
        $bill_type = Alexa::slot('BillType');
        $bill_number = Alexa::slot('BillNumber');

        \Log::info($bill_type);

//        $bill_type = request('BillType');
//        $bill_number = request('BillNumber');

        $client = new Client();
        $url = 'https://api.popvox.com/api/bill-sentiment/115/' . $bill_type . $bill_number . '?pvoxKey=4a849e323b72398c498f546a047a4451b788a446';
        $res = $client->request('GET', $url);

        $body = json_decode($res->getBody());

        $bill_info = $body->data;

        $total_users = $bill_info->POPVOX_users_supporting + $bill_info->POPVOX_users_opposing;
        $support_percentage =  $total_users > 0 ? round($bill_info->POPVOX_users_supporting / $total_users * 100, 0) : 0;
        $oppose_percentage =  $total_users > 0 ? round($bill_info->POPVOX_users_opposing / $total_users * 100, 0) : 0;

        $alexa_speech = $bill_info->bill_number . ' ... ' . $bill_info->bill_name;
        $alexa_speech .= ' ... ... ';
        $alexa_speech .= $support_percentage . ' percent of people support this bill and ' . $oppose_percentage . ' percent oppose it.';

        return Alexa::say($alexa_speech);
    }
}
