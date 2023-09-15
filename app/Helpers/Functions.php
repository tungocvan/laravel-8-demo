<?php 
use Illuminate\Support\Facades\Mail;
function send_mail($options){    
    $to = $options['to'] ?? 'tungocvan@gmail.com';    
    $cc = $options['cc'] ?? '';    
    $content  = $options['content'] ?? '<h3>This is test mail<h3>';
    $subject = $options['subject'] ?? 'Email send from HAMADA';
    $status = Mail::send([], [], function ($message) use ($to,$cc,$content, $subject) {
        $message->to($to);
        $cc && $message->cc($cc);
        $message->subject($subject);
        $message->setBody($content, 'text/html');
    });

    return $status;
}