<?php

	// 一時アップロード先ファイルパス
	$file_tmp  = $_FILES["image"]["tmp_name"];

	// 正式保存先ファイルパス
	$file_save = "../../list_image_path/" . $_FILES["image"]["name"];

	// ファイル移動
	$result = @move_uploaded_file($file_tmp, $file_save);
	if ( $result === true ) {
	    echo "UPLOAD OK";
	} else {
	    echo "UPLOAD NG";
	}

	// session_start();
 //  	require('../../developer/dbconnect.php');

 //  	if(isset($_POST['id'])){
 //  		$id = $_POST['id'];
 //  	}

 //    // 画像アップロード処理
 //    if(isset($_FILES['image'])){
 //      echo "ファイルが存在します" .'<br>';
 //     $info = new SplFileInfo($_FILES['image']['name']);
 //     $extension = strtolower($info->getExtension());

 //     if($extension != 'png' && $extension != 'jpg' && $extension != 'gif' && $extension != 'jpeg') {
 //      echo '拡張子が異なります' .'<br>';
 //        $errors['extension'] = 'blank';
 //     }
    
 //      $file_name = date('YmdHis') . $_FILES['image']['name'];
 //      // $file_name = $_FILES['image']['name'] . $date->format('YmdHisu');;
 //      $file_path = '../../list_image_path/' . $file_name;
 //      $tmp_name = $_FILES['image']['tmp_name'];


 //      // 画像をサーバに保存
 //      if (move_uploaded_file($tmp_name, $file_path)) { //サーバに画像保存が成功したら
 //        echo $file_name . "をサーバに保存しました" .'<br>';

 //        // リストデータを取得
 //        $sql= 'SELECT * FROM `atom_lists` WHERE `id`=?';
 //        $data = array($_GET['id']);
 //        $stmt = $dbh->prepare($sql);
 //        $stmt ->execute($data);
 //        $is_image = $stmt->fetch(PDO::FETCH_ASSOC);
 //        echo "元の画像" . $is_image['list_image_path'] .'<br>';

 //        if($is_image['list_image_path'] == NULL) { //サーバに画像が登録されていないとき
 //            echo "null" . '<br>';

 //            // 画像名をデータベースに登録する
 //            // $sql= 'UPDATE `atom_lists` SET `list_image_path` =?,`modified`=NOW() WHERE `id`=?';
 //            // $data = array($file_name,$_GET['id']);
 //            // $stmt = $dbh->prepare($sql);
 //            // $stmt ->execute($data);
 //            // header('Location: lists.php?id='. $_GET['id']);
 //            // exit();
 //        } elseif($is_image['list_image_path'] == $file_name){
 //          echo "一緒だよ" .'<br>';
 //        } else { //データベースにすでに画像が登録されていて、登録されている画像名が新しく入力された画像名と異なるとき
 //          echo "登録" . '<br>';
 //          // $is_image_path = '../../list_image_path/' . $is_image['list_image_path'];
 //          // if(file_exists($is_image_path)){
 //          //   // 既存に指定されていた画像をサーバから削除
 //          //   $file_delpath = '../../list_image_path/' . $is_image['list_image_path'];
 //          //   unlink($file_delpath);
 //          // }

 //          // 画像名をデータベースに登録
 //          // $sql= 'UPDATE `atom_lists` SET `list_image_path`=?,`modified`=NOW() WHERE `id`=?';
 //          // $data = array($file_name,$id);
 //          // $stmt = $dbh->prepare($sql);
 //          // $stmt ->execute($data);
 //          // header('Location: lists.php?id='. $_GET['id']);
 //          // exit();

 //        }
 //        // header('Location : lists.php');
 //        // exit();

 //      } else {
 //        echo "アップロードに失敗しました";
 //      }
 //    }
?>
