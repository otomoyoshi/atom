<?php 


mb_language("Japanese"); 
mb_internal_encoding("UTF-8");


if(!empty($_POST)){

	$to = $_POST['email'];

	$subject = "お問い合わせ"; // 題名 
	$content = $_POST['content']; // 本文
	$email = 'maho.atom@gmail.com';
	// $header = "From: $email\nReply-email: $email\n";
	$header = "MIME-Version: 1.0\n";
	$header .= "Content-Transfer-Encoding: 7bit\n";
	$header .= "Content-Type: text/plain; charset=ISO-2022-JP\n";
	$header .= "Message-Id: <" . md5(uniqid(microtime())) . "@gmail.com>\n";
	$header .= "from: " . $to . "\n";
	$header .= "Reply-email: " . $email . "\n";
	$header .= "Return-Path: ". $email ."\n";
	$header .= "X-Mailer: PHP/". phpversion();
	// $header = "From: ". $email . "\n" . "Reply-email: " . "$email" . "\n";

	// $email = 'maho.aemailm@gmail.com';
	// $subject = 'テスト SUBJECT';
	// $content = 'テスト BODY';

	// if (mb_send_mail($email, $subject, $content)) {
	//     echo '送信完了';
	// } else {
	//     echo '送信失敗';
	// }
	// echo '送信しました。';

	echo "email: " . $to . " content: " . $content . ":" . '<br>';
	if(mb_send_mail($email, $subject, $content, $header)){
		echo "メールを送信しました" . '<br>';
	} else {
		echo "メールを失敗しました" . '<br>';
	}

}




 


 ?>

<!--  <!DOCTYPE html>
 <html lang="ja">
 <head>
 	<meta charset="utf-8">
 	<title>メール確認用</title>
 </head>
 <body>
 	<h1>メール確認用</h1> 
 	<a href="../contact.php">お問い合わせページへ戻る</a>
 </body>
 </html> -->