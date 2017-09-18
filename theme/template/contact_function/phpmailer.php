<?php 

require('PHPMailer-master/class.phpmailer.php');

ini_set('SMTP', 'smtp.gmail.com');
ini_set('smtp_port', '465');
ini_set('username', 'hana.mare55@gmail.com');
ini_set('password', '0820mw55');
ini_set('sendmail_from', 'hana.mare55@gmail.com');

//言語設定、内部エンコーディングを指定する
mb_language("japanese");
mb_internal_encoding("UTF-8");
 
if(mb_send_mail(
	"hana.mare55@gmail.com",
	"テスト",
	"以下の内容で送信されました。",
	"From :".mb_encode_mimeheader("テスト送信先")."<test@tomtom.com>"
	)
){
	echo "送信しました";
}

//日本語添付メールを送る
$to = "maho.atom@gmail.com"; //宛先
$subject ="お問い合わせ内容"; //題名
$body="以下の内容でフォームより送信されました。";
$body.="お問い合わせ内容";
$from = "hana.mare55@gmail.com"; //送り主
// $attachfile = "files/test.xls"; //添付ファイルパス
 
$mail = new PHPMailer();
$mail->CharSet = "iso-2022-jp";
$mail->Encoding = "7bit";
 
$mail->AddAddress($to);
$mail->From = $from;
// $mail->FromName = mb_encode_mimeheader(mb_convert_encoding($fromname,"JIS","UTF-8"));
$mail->Subject = mb_encode_mimeheader(mb_convert_encoding($subject,"JIS","UTF-8"));
$mail->Body  = mb_convert_encoding($body,"JIS","UTF-8");
 
// //添付ファイル追加
// $mail->AddAttachment($attachfile);
// $mail->AddAttachment($attachfile2);
$mail->Send(); //メール送信

// echo "email: " . $to . " content: " . $content . ":" . '<br>';
// 	if(mb_send_mail($email, $subject, $content, $header)){
// 		echo "メールを送信しました" . '<br>';
// 	} else {
// 		echo "メールを失敗しました" . '<br>';
// 	}



// echo "email: " . $to . " content: " . $content . ":" . '<br>';
// 	if(mb_send_mail($email, $subject, $content, $header)){
// 		echo "メールを送信しました" . '<br>';
// 	} else {
// 		echo "メールを失敗しました" . '<br>';
// 	}

 ?>