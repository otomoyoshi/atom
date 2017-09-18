<?php 

if ($account_name != '') {
	$sql = 'UPDATE `atom_members` SET `account_name`=? WHERE `id`=?';
	$data = array($account_name,$_SESSION['login_user']['id']);
	$stmt = $dbh->prepare($sql);
	$stmt->execute($data);

	$_SESSION['login_user']['account_name'] = $account_name;
}

 ?>