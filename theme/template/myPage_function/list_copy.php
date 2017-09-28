<!-- マイページのリストをコピーするためのページ -->

<?php 
require('../../../developer/dbconnect.php');
session_start();

// ログインしてるかのチェック
if (!isset($_SESSION['login_user'])) {
	header('Location: ../un_login/sign_in.php');
	exit();
}

// パラメータが存在するかチェック
if (!isset($_GET['id'])) {
	header('Location: ../login/myPage.php');
	exit();
}

// $copied_list = array();

// コピーしたいリストの情報を取得する
$sql = 'SELECT * FROM `atom_lists` WHERE `id`=?';
$data = array($_GET['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$copied_list[] = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($copied_list);
// echo $copied_list[0]['members_id'];

// 新しい空のリストを作る
$sql = 'INSERT INTO `atom_lists` SET `members_id`=?,
								`name`=?,
								`list_image_path`=?;
								`created`=NOW()';
$data = array($copied_list[0]['members_id'],
			  $copied_list[0]['name'].'のコピー',
			  $copied_list[0]['list_image_path']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

// 新しく作ったリストのIDを取得する
$sql = 'SELECT `id` FROM `atom_lists` WHERE `members_id`=? ORDER BY `id` DESC';
$data = array($_SESSION['login_user']['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$rec = $stmt->fetch(PDO::FETCH_ASSOC);
$new_list_id = $rec['id']; // 新しく作ったリストのIDを取得する

$sql = 'SELECT * FROM `atom_items` WHERE `lists_id`=?';
$data = array($_GET['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

while(1){
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($rec == false) {
		break;
	}
	$copied_items[] = $rec;
}
var_dump($copied_items);

// 取得したアイテムたちを新しいリストにインサート
foreach($copied_items as $ci){
$sql = 'INSERT INTO `atom_items` SET `lists_id`=?,
									 `content`=?,
									 `item_check`=?,
									 `categories_id`=?';
$data = array($new_list_id,
			  $ci['content'],
			  $ci['item_check'],
			  $ci['categories_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
}

header('Location: ../login/myPage.php');
exit();
 ?>