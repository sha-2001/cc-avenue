<?php

use Illuminate\Support\Facades\Route;

Route::get(
    '/',
    function () {
        $merchant_id = 2350717;
        $working_key = '4EEBE5EDB45A0E0B6D903C7D9FA66F05';
        $access_code = 'AVIC04KE88AQ16CIQA' ;
        $order_id = '1';
        $amount = '500';
        $redirect_url = 'http://localhost:8000';

        $data = [
            'merchant_id' => $merchant_id,
            'order_id' => $order_id,
            'amount' => $amount,
            'redirect_url' => $redirect_url,
            'working_key' => $working_key,
            'access_code' => $access_code,
        ];

        ksort($data);

        $hash_string = '';

        foreach ($data as $key => $value) {
            $hash_string .= $key . '=' . $value . '&';
        }

        $hash_string = rtrim($hash_string, '&');

        $hash = strtoupper(hash('sha256', $working_key . '|' . $hash_string . '|' . $access_code));

        $html = '<form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction">';
        foreach ($data as $key => $value) {
            $html .= '<input type="hidden" name="' . $key . '" value="' . $value . '">';
        }

        $html .= '<input type="hidden" name="checksum" value="' . $hash . '">';
        $html .= '</form>';

        $html .= '<script type="text/javascript">';
        $html .= 'document.redirect.submit();';
        $html .= '</script>';

        return $html;
    }
);