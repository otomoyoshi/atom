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


$sql = 'DELETE FROM `lists` WHERE `id`=?';
$data = array($_GET['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

header('Location: ../login/myPage.php');
exit();
 ?>