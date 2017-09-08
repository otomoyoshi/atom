<!-- マイページのリストをコピーするためのページ -->

<?php 
require('../../../developer/dbconnect.php');
session_start();

// ログインしてるかのチェック
// if (!isset($_SESSION['login']['id'])) {
// 	header('Location: ../unlogin/sign_in.php');
// 	exit();
// }

// パラメータが存在するかチェック
// if (!isset($_GET['id'])) {
// 	header('Location: ../login/myPage.php');
// 	exit();
// }

// $copied_list = array();

$sql = 'SELECT * FROM `lists` WHERE `id`=?';
$data = array($_GET['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$copied_list[] = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($copied_list);
// echo $copied_list[0]['members_id'];

$sql = 'INSERT INTO `lists` SET `members_id`=?,
								`name`=?,
								`list_image_path`=?;
								`created`=NOW()';
$data = array($copied_list[0]['members_id'],
			  $copied_list[0]['name'],
			  $copied_list[0]['list_image_path']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

header('Location: ../login/myPage.php');
exit();
 ?>