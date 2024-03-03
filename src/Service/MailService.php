<?php

namespace Src\Service;

class MailService
{
    public static function sendMail($email, $link , $price)
    {
        $smtpHost = 'mailhog';
        $smtpPort = 1025;
        $to = $email;
        $subject = "Price Notify";
        $message =  "Price for $link product have been updated, new Price : $price";
        $headers = "From: your_email@example.com";

        mail($to, $subject, $message, $headers, "-f your_email@example.com -S $smtpHost:$smtpPort");
    }
}
