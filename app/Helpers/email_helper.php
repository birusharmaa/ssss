<?php

    // function send_app_mail($to, $subject, $message, $optoins = array(), $convert_message_to_html = true){
    //     $email_config = array(
    //         'charset' => 'utf-8',
    //         'mailType' => 'html'
    //     );

    //     //check mail sending method from settings
    //     if (get_setting("email_protocol") === "smtp") {
    //         $email_config["protocol"] = "smtp";
    //         $email_config["SMTPHost"] = get_setting("email_smtp_host");
    //         $email_config["SMTPPort"] = get_setting("email_smtp_port");
    //         $email_config["SMTPUser"] = get_setting("email_smtp_user");
    //         $email_config["SMTPPass"] = get_setting('email_smtp_pass');
    //         $email_config["SMTPCrypto"] = get_setting("email_smtp_security_type");

    //         if (!$email_config["SMTPCrypto"]) {
    //             $email_config["SMTPCrypto"] = "tls"; //for old clients, we have to set this by default
    //         }

    //         if ($email_config["SMTPCrypto"] === "none") {
    //             $email_config["SMTPCrypto"] = "";
    //         }
    //     }

    //     $email = \CodeIgniter\Config\Services::email();
    //     $email->initialize($email_config);
    //     $email->clear(true); //clear previous message and attachment

    //     $email->setNewline("\r\n");
    //     $email->setCRLF("\r\n");
    //     $email->setFrom(get_setting("email_sent_from_address"), get_setting("email_sent_from_name"));

    //     $email->setTo($to);
    //     $email->setSubject($subject);

    //     if ($convert_message_to_html) {
    //         $message = htmlspecialchars_decode($message);
    //     }

    //     $email->setMessage($message);

    //     //add attachment
    //     $attachments = get_array_value($optoins, "attachments");
    //     if (is_array($attachments)) {
    //         foreach ($attachments as $value) {
    //             $file_path = get_array_value($value, "file_path");
    //             $file_name = get_array_value($value, "file_name");
    //             $email->attach(trim($file_path), "attachment", $file_name);
    //         }
    //     }

    //     //check reply-to
    //     $reply_to = get_array_value($optoins, "reply_to");
    //     if ($reply_to) {
    //         $email->setReplyTo($reply_to);
    //     }

    //     //check cc
    //     $cc = get_array_value($optoins, "cc");
    //     if ($cc) {
    //         $email->setCC($cc);
    //     }

    //     //check bcc
    //     $bcc = get_array_value($optoins, "bcc");
    //     if ($bcc) {
    //         $email->setBCC($bcc);
    //     }

    //     //send email
    //     if ($email->send()) {
    //         return true;
    //     } else {
    //         //show error message in none production version
    //         if (ENVIRONMENT !== 'production') {
    //             throw new \Exception($email->printDebugger());
    //         }
    //         return false;
    //     }
    // }

    function static_email_send($to, $subject, $message, $optoins = array(), $convert_message_to_html = true){
        
        $email_config = array(
            'charset' => 'utf-8',
            'mailType' => 'html'
        );

        $email_config["protocol"] = "smtp";
        $email_config["SMTPHost"] = "smtp.gmail.com";
        $email_config["SMTPPort"] = "587";
        $email_config["SMTPUser"] = "sartiadevelopment@gmail.com";
        $email_config["SMTPPass"] = "WST@12345";
        $email_config["SMTPCrypto"] = "";
        if (!$email_config["SMTPCrypto"]) {
            $email_config["SMTPCrypto"] = "tls"; //for old clients, we have to set this by default
        }
        

        $email = \CodeIgniter\Config\Services::email();
        $email->initialize($email_config);
        $email->clear(true); //clear previous message and attachment

        $email->setNewline("\r\n");
        $email->setCRLF("\r\n");
        //$email->setFrom(get_setting("email_sent_from_address"), get_setting("email_sent_from_name"));
        $email->setFrom('sartiadevelopment@gmail.com', 'Demo User');

        $email->setTo($to);
        $email->setSubject($subject);

        if ($convert_message_to_html) {
            $message = htmlspecialchars_decode($message);
        }

        $email->setMessage($message);

        //add attachment
        // $attachments = get_array_value($optoins, "attachments");
        // if (is_array($attachments)) {
        //     foreach ($attachments as $value) {
        //         $file_path = get_array_value($value, "file_path");
        //         $file_name = get_array_value($value, "file_name");
        //         $email->attach(trim($file_path), "attachment", $file_name);
        //     }
        // }

        //check reply-to
        //$reply_to = get_array_value($optoins, "reply_to");
        // if ($reply_to) {
        //     $email->setReplyTo($reply_to);
        // }

        //check cc
        //$cc = get_array_value($optoins, "cc");
        // if ($cc) {
        //     $email->setCC($cc);
        // }

        //check bcc
        //$bcc = get_array_value($optoins, "bcc");
        // if ($bcc) {
        //     $email->setBCC($bcc);
        // }

        //send email
        if ($email->send()) {
            return true;
        } else {
            //show error message in none production version
            if (ENVIRONMENT !== 'production') {
                throw new \Exception($email->printDebugger());
            }
            return false;
        }
    }