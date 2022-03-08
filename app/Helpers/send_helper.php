<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    function myMail($to=null, $from=null, $subject=null, $message=null, $name = null){
        $random_number      = rand(999999999, 9999999999);
        $random_number      = md5($random_number);
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host         = 'smtp.gmail.com'; //smtp.google.com
            $mail->SMTPAuth     = true;
            $mail->Username     = 'sartiadevelopment@gmail.com';
            $mail->Password     = 'WST@12345';
            $mail->SMTPSecure   = 'tls';
            $mail->Port         = 587;
            $mail->Subject      = $subject;

            $mail->Body         = $message;
            $mail->setFrom($from, $name);

            $mail->addAddress($to);
            $mail->isHTML(true);
            if (!$mail->send()) {
                $data['status'] = "failed";
                $data['message'] = "Something went wrong. Please try again.";
                return false;
            } else {
               return true;
            }
        } catch (Exception $e) {
            $data['status'] = "failed";
            $data['type'] = "email";
            $data['message'] = "Your email id don't not exists.";
            //echo json_encode($data);
            return $this->fail($data);
        }
    }


    function sendSms($fields){
        $curl = curl_init();
        // echo "<pre>";
        // print_r($fields);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => array(
                "authorization: K7WLdu6yZ3UtzIPlYfJmGVRxDi8SeApsnc9TNhC5wMgoqarHQEMKyLXmJgVW0evTzYUbPSFc6dslkOD4",
                "accept: */*",
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return "cURL Error #:" . $err;
        } else {
            //return $response;
            return true;
        }
    }