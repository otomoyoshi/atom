<?php

	session_start();
	require('../../developer/dbconnect.php');

	if(isset($_SESSION['login_user']['lists_id'])){
		$id = $_SESSION['login_user']['lists_id'];
	}

	// // // 一時アップロード先ファイルパス
	// $file_tmp  = $_FILES["image"]["tmp_name"];

	// // 正式保存先ファイルパス
	// $file_save = "../../list_image_path/" . $_FILES["image"]["name"];

	// // ファイル移動
	// $result = @move_uploaded_file($file_tmp, $file_save);
	// if ( $result === true ) {
	//     echo "UPLOAD OK";
	// } else {
	//     echo "UPLOAD NG";
	// }

    // 画像アップロード処理
if(isset($_FILES['image'])){
	echo "ファイルが存在します" .'<br>';
	$info = new SplFileInfo($_FILES['image']['name']);
	$extension = strtolower($info->getExtension());

	// 拡張子が異なる場合の処理
	if($extension != 'png' && $extension != 'jpg' && $extension != 'gif' && $extension != 'jpeg') {
	echo '拡張子が異なります' .'<br>';
	$errors['extension'] = 'blank';
	} else{ // 拡張子が正しい場合の処理
		$file_name = date('YmdHis') . $_FILES['image']['name'];
		// $file_name = $_FILES['image']['name'] . $date->format('YmdHisu');;
		$file_path = '../../list_image_path/' . $file_name;
		$tmp_name = $_FILES['image']['tmp_name'];

		// 画像をサーバに保存
		if (move_uploaded_file($tmp_name, $file_path)) { //サーバに画像保存が成功したら
			echo $file_name . "をサーバに保存しました" .'<br>';

			// リストデータを取得
			$sql= 'SELECT * FROM `atom_lists` WHERE `id`=?';
			$data = array($id);
			$stmt = $dbh->prepare($sql);
			$stmt ->execute($data);
			$is_image = $stmt->fetch(PDO::FETCH_ASSOC);
			echo "元の画像" . $is_image['list_image_path'] .'<br>';

			if($is_image['list_image_path'] == NULL) { //サーバに画像が登録されていないとき
			    echo "null" . '<br>';

			    // 画像名をデータベースに登録する
			    $sql= 'UPDATE `atom_lists` SET `list_image_path` =?,`modified`=NOW() WHERE `id`=?';
			    $data = array($file_name,$id);
			    $stmt = $dbh->prepare($sql);
			    $stmt ->execute($data);
			    // header('Location: lists.php?id='. $id);
			    // exit();
			} elseif($is_image['list_image_path'] == $file_name){
				echo "一緒だよ" .'<br>';
			} else { //データベースにすでに画像が登録されていて、登録されている画像名が新しく入力された画像名と異なるとき
				echo "登録" . '<br>';
				$is_image_path = '../../list_image_path/' . $is_image['list_image_path'];
				if(file_exists($is_image_path)){
				// 既存に指定されていた画像をサーバから削除
				$file_delpath = '../../list_image_path/' . $is_image['list_image_path'];
				unlink($file_delpath);
			  }

				// 画像名をデータベースに登録
				$sql= 'UPDATE `atom_lists` SET `list_image_path`=?,`modified`=NOW() WHERE `id`=?';
				$data = array($file_name,$id);
				$stmt = $dbh->prepare($sql);
				$stmt ->execute($data);
				// header('Location: lists.php?id='. $id);
				// exit();

			}
				// header('Location : lists.php');
				// exit();

			} else {
				echo "アップロードに失敗しました";
			}
	}

} // $_FILES['image']

	//リストとアイテムを結合
	$sql= 'SELECT `i`.*,`l`.`name`, `l`.`created`,`m`.`id`, `m`.`account_name`
	     FROM `atom_items` AS `i`
	     LEFT JOIN `atom_lists` AS `l`
	     ON `i`.`lists_id` = `l`.`id`
	     LEFT JOIN `atom_members` AS `m`
	     ON `m`.`id` = `l`.`members_id`
	     WHERE `l`.`id` = ?';
	$data = array($id);
	$stmt = $dbh->prepare($sql);
	$stmt ->execute($data);
	$list_data = $stmt->fetch(PDO::FETCH_ASSOC);
	// var_dump($list_data) . '<br>';

	// リストデータを取得
	$sql= 'SELECT * FROM `atom_lists` WHERE `id`=?';
	$data = array($id);
	$stmt = $dbh->prepare($sql);
	$stmt ->execute($data);
	$is_image = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
  <!-- 画像がデータベースに登録されているとき -->
  <div id="list_img">
	  <?php if ($is_image['list_image_path'] != NULL) { ?>
	    <img src="../../list_image_path/<?php echo $is_image['list_image_path']?>" class="img-circle" width="150px" alt="画像を読み込んでいます" class="padding_img" data-intro="旅の思い出写真を登録してね" data-step="2"><br>
	        <?php if (isset($errors['extension'])) { ?>
              <div class="alert alert-danger">
                拡張子は、jpg,png,gifの画像を選択ください
              </div>
            <?php } ?>
    <!-- 画像がデータベースに登録されてないとき -->
    <?php } else {?>

      <div>デフォルト画像を表示</div>
        <?php if (isset($errors['extension'])) { ?>
          <div class="alert alert-danger">
            拡張子は、jpg,png,gifの画像を選択ください
          </div>
        <?php } ?>
    <?php } ?>
  </div>

</body>
</html>
