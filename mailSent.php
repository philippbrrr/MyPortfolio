<?php
$message_sent =false;
//echo "been here";
//echo "".$_POST['email'];
if(isset($_POST['email']) && $_POST['email'] != '') {
 //   echo "mail is there";
    if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $email = $_POST["email"];
        $subject = $_POST["subject"];
        $subject1 = $_POST["subject1"];
        $subject .= ' '. $subject1;
        $message = $_POST["message"];
        $uploadStatus =1;

        $to = "philipp.br95@gmail.com";
        $body = "From: " . $email . "\r\n";
        $body .= "Message:". $message;
        
        $headers = 'From: info@philippbrunke.de';
        
       // echo "mail is aight";
       if(!empty($_FILES["attachment"]["name"])){
        //Get the uploaded file information
            $name_of_uploaded_file = basename($_FILES['attachment']['name']);

            $targetDir = "upload/";
            $targetFilePath = $targetDir . $name_of_uploaded_file;
            //get the file extension of the file
            $type_of_uploaded_file = substr($name_of_uploaded_file, strrpos($name_of_uploaded_file, '.') + 1);

            $size_of_uploaded_file = $_FILES["attachment"]["size"]/1024;//size in KBs

            //Settings
            $max_allowed_file_size = 10000; // size in KB
            $allowed_extensions = array("jpg", "jpeg", "pdf");

            //Validations
            if($size_of_uploaded_file > $max_allowed_file_size ){
                $uploadStatus = 0;
                $errors .= "\n Size of file should be less than $max_allowed_file_size";
            }

            //------ Validate the file extension -----
            $allowed_ext = false;
            for($i=0; $i<sizeof($allowed_extensions); $i++){
                if(strcasecmp($allowed_extensions[$i],$type_of_uploaded_file) == 0){
                    $allowed_ext = true;
                }
            }

            if(!$allowed_ext){
                $uploadStatus = 0;
                $errors .= "\n The uploaded file is a not supported file type. ".
                " Only the following file types are supported: ".implode(',',$allowed_extensions);
            }

            if(move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)){
                $uploadedFile = $targetFilePath;
            } else {
                $uploadStatus = 0;
                $errors .= "Sorry, there was an error uploading your file.";
            }

            if($uploadStatus==1){
                

                if(!empty($uploadedFile) && file_exists($uploadedFile)){
                    
                    // Boundary 
                    $semi_rand = md5(time()); 
                    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
                    
                    // Headers for attachment 
                    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
                    
                    // Multipart boundary 
                    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
                    "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
                    
                    // Preparing attachment
                    if(is_file($uploadedFile)){
                        $message .= "--{$mime_boundary}\n";
                        $fp =    @fopen($uploadedFile,"rb");
                        $data =  @fread($fp,filesize($uploadedFile));
                        @fclose($fp);
                        $data = chunk_split(base64_encode($data));
                        $message .= "Content-Type: application/octet-stream; name=\"".basename($uploadedFile)."\"\n" . 
                        "Content-Description: ".basename($uploadedFile)."\n" .
                        "Content-Disposition: attachment;\n" . " filename=\"".basename($uploadedFile)."\"; size=".filesize($uploadedFile).";\n" . 
                        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                    }
                    
                    $message .= "--{$mime_boundary}--";
                    $returnpath = "-f" . $email;
                    
                    // Send email
                    $mail = mail($to, $subject, $message, $headers, $returnpath);
                    $message_sent = true;
                    
                    // Delete attachment file from the server
                    @unlink($uploadedFile);
                }else{
                     // Set content-type header for sending HTML email
                    $headers .= "\r\n". "MIME-Version: 1.0";
                    $headers .= "\r\n". "Content-type:text/html;charset=UTF-8";
                    
                    // Send email
                    $mail = mail($to, $subject, $message, $headers); 
                    $message_sent = true;
                }
            }

        
        } else{
            mail($to,$subject,$body, $headers);
        
            $message_sent = true;
        } 
    } else{
        $errors .= "The email you have submitted isn't valid.";
    }
    
   
} else{
    $errors .= "Please enter an email address before submitting the form.";
}
if($message_sent):
    ?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lobster&family=Raleway:wght@100;200;500;700&display=swap">
    <link rel="stylesheet" href="./css/mail.css">
    
</head>

<body style=" ">
    <div id="envelope-wrapper">
        <div class="circle">
            <svg id="plane" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paper-plane"
            class="svg-inline--fa fa-paper-plane fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512">
            <path fill="currentColor"
                d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z">
            </path>
        </svg>
        <img id="check" src="./images/pngwave.png" alt="" srcset="">
        </div>
       
    </div>
        <div id="text-wrapper" style="font-family: 'Raleway';">
            <div>
                <h1>Message has been sent.</h1>
                <h2>I'll be answering as soon as possible!</h2>
                <a href="./index.html">Back</a>
            </div>
        </div>
    

</body>

</html>

    <?php
     else:
    ?> 
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lobster&family=Raleway:wght@100;200;500;700&display=swap">
        <link rel="stylesheet" href="./css/mailerror.css">
        
    </head>
    
    <body style=" ">
        <div id="wrapper">
        <div id="envelope-wrapper">
            <div class="circle">
                
                <img id="check" src="./images/X_img.png" alt="" srcset="">
            </div>
           
        </div>
            <div id="text-wrapper" style="font-family: 'Raleway';">
                <div>
                    <h1>Sorry, something went wrong</h1>
                    <p>(<?php echo $errors?>)</p>
                    <h2>Contact me on contact@philippbrunke.com</h2>
                    <a onclick="console.log('hello')" href="./index.html">Back</a>
                </div>
            </div>
        
        </div>
    </body>
    

</body>



  

  
        <?php
    endif;
    ?>
</html>
