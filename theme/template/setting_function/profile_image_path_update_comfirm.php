<?php 

$file_name = $_FILES['profile_image']['name'];


if (!empty($file_name)) {
	$ext = substr($file_name, -3);
	$ext = strtolower($ext);
	if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif'){
		$errors['profile_image'] = 'type';
	}

	if (empty($errors['profile_image'])) {
		$upload_image = date('YmdHis') . $file_name;
		move_uploaded_file($_FILES['profile_image']['tmp_name'],'../../../profile_image_path/'. $upload_image);

		$sql = 'UPDATE `atom_members` SET `profile_image_path`=? WHERE `id`=?';
		$data = array($upload_image,$_SESSION['login_user']['id']);
		$stmt = $dbh->prepare($sql);
		$stmt->execute($data);

		$_SESSION['login_user']['profile_image_path'] = $upload_image;
	}
}
 ?>