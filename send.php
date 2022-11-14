 <?php
$to = '637347@wwpager.ru,vyacheslaw.kilin@mail.ru';

if ( isset( $_POST['sendMail'] ) ) {
  $theme  = substr( $_POST['theme'], 0, 64 );
  $tel = substr( $_POST['phone'], 0, 64 );
  $name = substr( $_POST['name'], 0, 64 );



  $utm_medium = $_POST["utm_medium"];
$utm_source = $_POST["utm_source"];
$utm_campaign = $_POST["utm_campaign"];
$utm_content = $_POST["utm_content"];
$utm_term = $_POST["utm_term"];
 

  if ( !empty( $_FILES['file']['tmp_name'] ) and $_FILES['file']['error'] == 0 ) {
    $filepath = $_FILES['file']['tmp_name'];
    $filename = $_FILES['file']['name'];
  } else {
    $filepath = '';
    $filename = '';
  }

  if($theme){
    $body .= "Тема:\r\n".$theme."\r\n\r\n";
  }

  if($tel){
    $body .= "Телефон:\r\n".$tel."\r\n\r\n";
  }

  if($name){
    $body .= "Имя:\r\n".$name."\r\n\r\n";
  }


  if($utm_medium){
    $body .= "utm_medium: \r\n".$utm_medium."\r\n\r\n";
  }
  if($utm_source){
    $body .= "utm_source: \r\n".$utm_source."\r\n\r\n";
  }
  if($utm_campaign){
    $body .= "utm_campaign: \r\n".$utm_campaign."\r\n\r\n";
  }
  if($utm_content){
    $body .= "utm_content: \r\n".$utm_content."\r\n\r\n";
  }
  if($utm_term){
    $body .= "utm_term: \r\n".$utm_term."\r\n\r\n";
  }




  send_mail($to, $body, $email, $filepath, $filename);

}

// Вспомогательная функция для отправки почтового сообщения с вложением
function send_mail($to, $body, $email, $filepath, $filename)
{
  $subject = substr( $_POST['theme'], 0, 64 );
  $boundary = "--".md5(uniqid(time())); // генерируем разделитель
  $headers = "From: Kinetic-Service <no-repeat@kinetic>\r\n";   
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .="Content-Type: multipart/mixed; boundary=\"".$boundary."\"\r\n";
  $multipart = "--".$boundary."\r\n";
  $multipart .= "Content-type: text/plain; charset=\"utf-8\"\r\n";
  $multipart .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";

  $body = $body."\r\n\r\n";
 
  $multipart .= $body;
 
  $file = '';
  if ( !empty( $filepath ) ) {
    $fp = fopen($filepath, "r");
    if ( $fp ) {
      $content = fread($fp, filesize($filepath));
      fclose($fp);
      $file .= "--".$boundary."\r\n";
      $file .= "Content-Type: application/octet-stream\r\n";
      $file .= "Content-Transfer-Encoding: base64\r\n";
      $file .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
      $file .= chunk_split(base64_encode($content))."\r\n";
    }
  }
  $multipart .= $file."--".$boundary."--\r\n";
	mail($to, $subject, $multipart, $headers);

  $theme  = substr( $_POST['theme'], 0, 64 );
  if($theme == 'Заказ звонка'){
    // echo "<script>location.href= 'index.html';</script>";
    echo '<script>location.href= "thanks.html";</script>';

  }
  // else {
  //   echo '<script>location.href= "thanks.html";</script>';
  // }
  
}
?>