<?php

class GCM {
    function __construct() {

    }

    /**
     * Sending Push Notification
     */
    public function send_notification($registatoin_ids,$department, $message,$title) {
        // include config
        include_once 'PushServer/config2.php';
        $msg = array
        (
              'message' 	=> $message,
              'title'		=> $title,
            'department'    => $department,
             // 'subtitle'	=> 'งานไปรษณีย์อิเลกทรอนิกส์',
            //  'tickerText'	=> 'Ticker Text',
              'vibrate'	      => 1,
              'sound'		=> 1,
              'largeIcon'	=> 'large_icon',
              'smallIcon'	=> 'small_icon'
        );
        
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $msg
        );

        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // edit
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        // end edit
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
    }

}

?>
