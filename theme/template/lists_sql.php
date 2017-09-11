<?php


  $items = array();
  $item_boths = array();
  $item_azukeires = array();
  $item_carry_ins = array();
  //$banned_baggage = '';
  $list_data['lists_id'] = '3'; //リストid

  if (!isset($_SESSION['login_user']['id'])) {
      header('Location: un_login/sign_in.php');
      exit();
  }
    //リストとアイテムを結合
  $sql= 'SELECT `i`.*,`l`.`id`,`l`.`name`
         FROM `atom_items` AS `i`
         LEFT JOIN `atom_lists` AS `l`
         ON `i`.`lists_id` = `l`.`id`
         WHERE 1';
  $data = array();
  $stmt = $dbh->prepare($sql);
  $stmt ->execute();
  $list_data = $stmt->fetch(PDO::FETCH_ASSOC);
  var_dump($list_data) . '<br>';

  // ファイル選択ボタンが押された時
  if(!empty($_FILES)){
    echo "sendが押されました" .'<br>';
    date_default_timezone_set('Asia/Tokyo'); //date()用
    // $date = new DateTime(time, 'Asia/Tokyo');
    
    // echo date('YmdHis');
    // 画像アップロード処理
    if(isset($_FILES['image'])){
      echo "ファイルが存在します" .'<br>';
     $info = new SplFileInfo($_FILES['image']['name']);
     $extension = strtolower($info->getExtension());

     if($extension != 'png' && $extension != 'jpg' && $extension != 'gif' && $extension != 'jpeg') {
      echo '拡張子が異なります' .'<br>';
        $errors['extension'] = 'blank';
     }
    
      $file_name = date('YmdHis') . $_FILES['image']['name'];
      // $file_name = $_FILES['image']['name'] . $date->format('YmdHisu');;
      $file_path = '../../list_image_path/' . $file_name;
      $tmp_name = $_FILES['image']['tmp_name'];


      // 画像をサーバに保存
      if (move_uploaded_file($tmp_name, $file_path)) { //サーバに画像保存が成功したら
        echo $file_name . "をサーバに保存しました" .'<br>';

        // リストデータを取得
        $sql= 'SELECT * FROM `atom_lists` WHERE `id`=?';
        $data = array($list_data['lists_id']);
        $stmt = $dbh->prepare($sql);
        $stmt ->execute($data);
        $is_image = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "元の画像" . $is_image['list_image_path'] .'<br>';

        if($is_image['list_image_path'] == NULL) { //サーバに画像が登録されていないとき

            // 画像名をデータベースに登録する
            $sql= 'UPDATE `atom_lists` SET `list_image_path` =?,`modified`=NOW() WHERE `id`=?';
            $data = array($file_name,$list_data['lists_id']);
            $stmt = $dbh->prepare($sql);
            $stmt ->execute($data);
            // header('Location : lists.php');
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
          $data = array($file_name,$list_data['lists_id']);
          $stmt = $dbh->prepare($sql);
          $stmt ->execute($data);
          // header('Location : lists.php');
          // exit();

        }
        // header('Location : lists.php');
        // exit();

      } else {
        echo "アップロードに失敗しました";
      }
    }

  }

    //検索ボタンが押された時
  if (!empty($_POST['list_search']) && $_POST['list_search'] != ''){
    // リストに追加
    $sql = 'INSERT `atom_lists` SET `members_id` = ?,
                               `name` = ?, 
                               -- `list_image_path` = ?,
                               `created` = NOW()';
    $data = array($_SESSION['login_user']['id'], $_POST['list_name']);
    $stmt = $dbh->prepare($sql);
    $stmt ->execute($data);

// <<<<<<< HEAD
//     $sql = 'SELECT * FROM `atom_searchs` WHERE `word`= ?';
//     $data = array($_POST['list_search']);
//     $stmt = $dbh->prepare($sql);
//     $stmt ->execute($data);
//     $search = $stmt->fetch(PDO::FETCH_ASSOC);//判定結果を取得
//     //①ユーザの検索と一致した場合 ：
//     if ($search['word'] == $_POST['list_search']) {
//       // アイテムに追加
//         $sql= 'INSERT INTO `atom_items` SET `categories_id` =?,
//                                        `content` = ?,
//                                        `lists_id` = ?';
//         $data = array($search['baggage_classify'], $_POST['list_search'], 3);
//         $stmt = $dbh->prepare($sql);
//         $stmt ->execute($data);
//     }

//       // //アイテムにデータがない時
//       //   else {
//       //     //カテゴリー表示
//       //   }

//     //検索収集用テーブルに登録
//     $sql= 'INSERT INTO `atom_searched_words` SET `word` = ?,
//                                     `created` = NOW()';
//     $data = array($_POST['list_search']);
//     $stmt = $dbh->prepare($sql);
//     $stmt ->execute($data);
// =======
      $sql = 'SELECT * FROM `atom_searchs` WHERE `word`= ?';
      $data = array($_POST['list_search']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);
      $search = $stmt->fetch(PDO::FETCH_ASSOC);//判定結果を取得
      //①ユーザの検索と一致した場合 ：
      // var_dump($search) .'<br>';
      // var_dump($_POST['list_search']) . '<br>';
      if ($search['word'] == $_POST['list_search']) {
        // アイテムに追加
          $sql= 'INSERT INTO `atom_items` SET `categories_id` =?,
                                         `content` = ?,
                                         `lists_id` = ?';
          // echo $search['baggage_classify'] . '<br>';
          // echo $_POST['list_search'] . '<br>';
          echo $list_data['id'] . '<br>';

          $data = array($search['baggage_classify'], $_POST['list_search'], $list_data['id']);
          $stmt = $dbh->prepare($sql);
          $stmt ->execute($data);

      }

      //検索収集用テーブルに登録
      $sql= 'INSERT INTO `atom_searched_words` SET `word` = ?,
                                      `created` = NOW()';
      $data = array($_POST['list_search']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);
// >>>>>>> 8a48efcae0c5c3563068c672fadd36eafe7684ac
  }

  // 一時保存ボタンが押された時
  if (!empty($_POST['tmp_btn'])) {
    if (!isset($list_data)) {
      $sql = 'INSERT `atom_lists` SET `members_id` = ?,
                                      `name` = ?, 
                                      `list_image_path` = ?,
                                      `created` = NOW()';
      $data = array(($_SESSION['login_user']['id']), $_POST['list_name'], );
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);
    }
    else {
      $sql = 'UPDATE `atom_lists` SET `members_id` = ?,
                                      `name` = ?, 
                                  -- `list_image_path` = ,
                                      `modified` = NOW()';
      $data = array(($_SESSION['login_user']['id']), $_POST['list_name']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);
    }
  }
  //キャンセルボタンが押された時
  if (!empty($_POST['can_btn'])) {
      $sql = 'DELETE FROM `atom_items` WHERE `lists_id`= ?';
      $data = array($list_data['lists_id']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);
      // header('Location:lists.php');
      // exit();
      echo $list_data['lists_id'];
  }

  // 保存ボタンが押された時
  if (!empty($_POST['keep_btn'])) {
    if (!isset($list_data)) {
      $sql = 'INSERT `atom_lists` SET `members_id` = ?,
                                      `name` = ?, 
                                   -- `list_image_path` = ,
                                      `created` = NOW()';
      $data = array(($_SESSION['login_user']['id']), $_POST['list_name']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);
    }
// <<<<<<< HEAD
  } else {

      if(isset($_POST['list_name'])) {
// =======
//     else {
// >>>>>>> 8a48efcae0c5c3563068c672fadd36eafe7684ac
      $sql = 'UPDATE `atom_lists` SET `members_id` = ?,
                                      `name` = ?, 
                                  -- `list_image_path` = ,
                                      `modified` = NOW()';
      $data = array(($_SESSION['login_user']['id']), $_POST['list_name']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);
    }
  }
  //ユーザーとリストのリンク
  $sql= 'SELECT `l`.*,`m`.`account_name`,`m`.`id`
           FROM `atom_lists`AS`l`
           LEFT JOIN `atom_members` AS `m`
           ON `l`.`members_id`=`m`.`id`
           WHERE 1';
  $data = array();
  $stmt = $dbh->prepare($sql);
  $stmt ->execute();
  $record = $stmt->fetch(PDO::FETCH_ASSOC);



  $is_image = ''; //画像が存在するか確認する


  $sql = 'SELECT * FROM `atom_items` WHERE `lists_id` = ?';
  $data = array($list_data['lists_id']);
  $stmt = $dbh->prepare($sql);
  $stmt ->execute($data);
  $is_items = $stmt->fetch(PDO::FETCH_ASSOC);

  $i = 0;
  while(true){
    $items[] = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($items[$i] == false) {
        break;
    }


    //アイテムにデータがあるとき
    if (isset($items)) {
      if ($items[$i]['categories_id'] == '1') {
          //両方持ち込みの場合 
          $item_boths[] = $items[$i];
      }
      // 持ち込みの場合
      elseif ($items[$i]['categories_id'] == '2') {
          $item_carry_ins[] = $items[$i];
      }
      //預け入れの場合
      elseif ($items[$i]['categories_id'] == '3') {
          $item_azukeires[] = $items[$i];    
      } 
      //持ち込めない場合
      elseif ($items[$i]['categories_id'] == '4'){
          $banned_baggage = 'その荷物は持ち込めません！！';
      } 

     } //アイテムにデータがない時
    else{
        //カテゴリー表示
    } 
      $i++;
  }

  // リストデータを取得
  $sql= 'SELECT * FROM `atom_lists` WHERE `id`=?';
  $data = array($list_data['lists_id']);
  $stmt = $dbh->prepare($sql);
  $stmt ->execute($data);
  $is_image = $stmt->fetch(PDO::FETCH_ASSOC);
  echo "出力画像" . $is_image['list_image_path'].'<br>';


?>