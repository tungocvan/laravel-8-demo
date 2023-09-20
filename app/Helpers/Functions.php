<?php 
use Illuminate\Support\Facades\Mail;
use File;
function send_mail($options){    
    $to = $options['to'] ?? 'tungocvan@gmail.com';    
    $cc = $options['cc'] ?? '';    
    $content  = $options['content'] ?? '<h3>This is test mail<h3>';
    $subject = $options['subject'] ?? 'Email send from HAMADA';
    $attach = $options['attach'] ?? ''; 
    if($attach !== ''){
        $attach = storage_path("app/public/$attach");
        if (!File::exists($attach)) {
            $attach = '';
        }
    }   
    try {
    Mail::send([], [], function ($message) use ($to,$cc,$content, $subject,$attach) {
        $message->to($to);
        $cc && $message->cc($cc);
        $message->subject($subject);
        $message->setBody($content, 'text/html');
        $attach && $message->attach($attach);
    });
    } catch (\Exception $e) {
        // Xử lý lỗi khi gửi email
        return false;
    }
    return true;
}

// Hàm cấu hình .env

function setEnv($newEnvData,$keyDelete=null){ 
    
    if(count($newEnvData) <=0) return false;
    $envFilePath = base_path('.env');
    // Đọc nội dung của file .env hiện có
    $envContent = file_get_contents($envFilePath);
    if($keyDelete === null){                
        foreach ($newEnvData as $key => $value) {
            // Tạo chuỗi ghi đè cho mỗi biến môi trường
            $overrideString = "{$key}={$value}";
            // Kiểm tra xem biến môi trường đã tồn tại trong file .env hay chưa
            if (strpos($envContent, "{$key}=") !== false) {
                // Nếu tồn tại, thay thế giá trị cũ bằng giá trị mới
                $envContent = preg_replace("/^{$key}=.*/m", $overrideString, $envContent);
            } else {
                // Nếu không tồn tại, thêm mới vào cuối file .env
                $envContent .= PHP_EOL . $overrideString;
            }
        }
    }else{        
        $envContent = preg_replace("/^{$keyDelete}=.*/m", '', $envContent);
    }
    
    // Ghi đè nội dung mới vào file .env
    file_put_contents($envFilePath, $envContent);
    return true;

}

function getFileToArray($file){     
    if (file_exists($file)) {
        $envContent = file_get_contents($file);
        $envLines = preg_split('/\r\n|\r|\n/', $envContent);
        return $envLines;
    }
    return null;
}
function getEnvToArray($file){     
    $envLines = getFileToArray($file);
    if (count($envLines) > 0) {
        $envArray = [];
        foreach ($envLines as $line) {
            $key = Str::before($line,'=');
            $value = Str::after($line,'=');
            $envArray[$key] = $value;
        }    
        return $envArray;
    }
    return null;
}