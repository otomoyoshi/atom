<?php

	if ($email != '') {
		 // メールアドレスの重複チェック
	    $sql = 'SELECT COUNT(*) FROM `atom_members` WHERE `email` = ?' ;
	    $data = array($email);
	    $stmt = $dbh->prepare($sql);
	    $stmt ->execute($data);
	    $record = $stmt->fetch(PDO::FETCH_ASSOC);
	    
	    if ($record['COUNT(*)']>0) {
	      $errors['email'] = 'duplicate';
	    }

	    // メールアドレスの更新
	    if (empty($errors['email'])) {
	    	$sql = 'UPDATE `members` SET `email`=? WHERE `id`=?';
	    	$data = array($email,$_SESSION['login_user']['id']);
			$stmt = $dbh->prepare($sql);
			$stmt->execute($data);

			$_SESSION['login_user']['email'] = $email;
	    }
	}
 ?>