<?php
  session_start();
  require('../../developer/dbconnect.php');
  $items = array();
  $item_boths = array();
  $item_azukeires = array();
  $item_carry_ins = array();
  $list_name = '';
  $vargues = array();
  $check_confirm = array();
  $item_both = '';
  $item_azukeire = '';
  $item_carry_in = '';

  //$banned_baggage = '';
  // $_GET['id'] = '3'; //リストid
  

  //ログインチェック
  if (!isset($_SESSION['login_user']['id'])) {
      header('Location: un_login/sign_in.php');
      exit();
  }

      //パラメータが存在するかチェック
    if (!isset($_GET['id'])) {
      header('Location: login/myPage.php');
      exit();
    } else {
      $_SESSION['login_user']['lists_id'] = $_GET['id'];
    }
  // ユーザID表示
  // echo "ユーザ： " . $_SESSION['login_user']['id'] .'<br>';

    //ユーザーとリストのリンク
  $sql= 'SELECT `l`.*,`m`.`account_name`,`m`.`id`
           FROM `atom_lists`AS`l`
           LEFT JOIN `atom_members` AS `m`
           ON `l`.`members_id`=`m`.`id`
           WHERE `l`.`id`=?';
  $data = array($_GET['id']);
  $stmt = $dbh->prepare($sql);
  $stmt ->execute($data);
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  // var_dump($record);
  echo '<br>';

  //リストとアイテムを結合
  $sql= 'SELECT `i`.*,`l`.`name`, `l`.`created`,`m`.`id`, `m`.`account_name`
         FROM `atom_items` AS `i`
         LEFT JOIN `atom_lists` AS `l`
         ON `i`.`lists_id` = `l`.`id`
         LEFT JOIN `atom_members` AS `m`
         ON `m`.`id` = `l`.`members_id`
         WHERE `l`.`id` = ?';
  $data = array($_GET['id']);
  $stmt = $dbh->prepare($sql);
  $stmt ->execute($data);
  $list_data = $stmt->fetch(PDO::FETCH_ASSOC);
  // var_dump($list_data) . '<br>';

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
        // echo $file_name . "をサーバに保存しました" .'<br>';

        // リストデータを取得
        $sql= 'SELECT * FROM `atom_lists` WHERE `id`=?';
        $data = array($_GET['id']);
        $stmt = $dbh->prepare($sql);
        $stmt ->execute($data);
        $is_image = $stmt->fetch(PDO::FETCH_ASSOC);
        // echo "元の画像" . $is_image['list_image_path'] .'<br>';

        if($is_image['list_image_path'] == NULL) { //サーバに画像が登録されていないとき
            // echo "null" . '<br>';

            // 画像名をデータベースに登録する
            $sql= 'UPDATE `atom_lists` SET `list_image_path` =?,`modified`=NOW() WHERE `id`=?';
            $data = array($file_name,$_GET['id']);
            $stmt = $dbh->prepare($sql);
            $stmt ->execute($data);
            header('Location: lists.php?id='. $_GET['id']);
            exit();
        } elseif($is_image['list_image_path'] == $file_name){
          // echo "一緒だよ" .'<br>';
        } else { //データベースにすでに画像が登録されていて、登録されている画像名が新しく入力された画像名と異なるとき
          // echo "登録" . '<br>';
          $is_image_path = '../../list_image_path/' . $is_image['list_image_path'];
          if(file_exists($is_image_path)){
            // 既存に指定されていた画像をサーバから削除
            $file_delpath = '../../list_image_path/' . $is_image['list_image_path'];
            unlink($file_delpath);
          }

          // 画像名をデータベースに登録
          $sql= 'UPDATE `atom_lists` SET `list_image_path`=?,`modified`=NOW() WHERE `id`=?';
          $data = array($file_name,$_GET['id']);
          $stmt = $dbh->prepare($sql);
          $stmt ->execute($data);
          header('Location: lists.php?id='. $_GET['id']);
          exit();

        }
        header('Location : lists.php');
        exit();

      } else {
        // echo "アップロードに失敗しました";
      }
    }

  }
  if (!empty($_POST['list_search_btn'])){
          $sql= 'UPDATE `atom_items` SET `item_check`= 0 WHERE `lists_id`=?';
          $data = array($_GET['id']);
          $stmt = $dbh->prepare($sql);
          $stmt ->execute($data);
          if (isset($_POST['che'])) {
              $c = count($_POST['che']);
              $check_items = $_POST['che'];
              // var_dump($check_items);
          // $sql= 'UPDATE `atom_items`(`item_check`) VALUES';
              for ($i=0; $i < $c ; $i++) { 
                  // $data = '(' . 1 . ')';
                  // $s = '';
                  // if($i != 0){
                  //   $s = ',';
                  // }
                  // $sql .= $s . $data;

                  $sql= 'UPDATE `atom_items` SET `item_check`= 1 WHERE `id`=?';
                  $data = array($check_items[$i]);
                  $stmt = $dbh->prepare($sql);
                  $stmt ->execute($data);
                  // $check_confirm = $stmt->fetch(PDO::FETCH_ASSOC);
              }
        }
      if (!empty($_POST['list_name'])) {
        $sql = 'UPDATE `atom_lists` SET `members_id` = ?,
                                        `name` = ?,
                                      -- `list_image_path` = ,
                                        `created` = NOW()
                                  WHERE `id`=?' ;
        $data = array(($_SESSION['login_user']['id']), $_POST['list_name'], $_GET['id']);
        $stmt = $dbh->prepare($sql);
        $stmt ->execute($data);
    }
  }

    //検索ボタンが押された時
  if (!empty($_POST['list_search']) && $_POST['list_search'] != ''){
      //検索収集用テーブルに登録
      $sql= 'INSERT INTO `atom_searched_words` SET `word` = ?,
                                      `created` = NOW()';
      $data = array($_POST['list_search']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);

      $sql = 'SELECT * FROM `atom_searchs` WHERE `word`= ?';
      $data = array($_POST['list_search']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);
      $search = $stmt->fetch(PDO::FETCH_ASSOC); //判定結果を取得

      $sql = 'SELECT * FROM `atom_searchs` WHERE `word` LIKE ?';
      $data = array('%' . $_POST['list_search'] . '%');
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);

      
      while (1) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);//判定結果を取得
        if ($rec == false) {
          break;
        }
        $tmp_searchs[] = $rec;
      }

      // var_dump($search);
      // var_dump($tmp_searchs);
      // echo count($tmp_searchs);

      if (isset($tmp_searchs)) { // 検索結果が存在する時
        // if(count($tmp_searchs) == 1){ // 検索結果が一つだけの時
        //   $search = $tmp_searchs[0];
        // }else{ // 検索結果が複数ある時
          foreach($tmp_searchs as $ts){
            $vague_searchs[] = $ts;
          }
        // }
      }else{ // 検索結果が存在しない時
        $no_result = 'no_result';
      }
// echo $_POST['list_search'];
      //①ユーザの検索と一致した場合 ：
      // var_dump($search) .'<br>';
      // var_dump($_POST['list_search']) . '<br>';
      if ($search['word'] == $_POST['list_search']) {
        // アイテムに追加
          $sql= 'INSERT INTO `atom_items` SET `categories_id` =?,
                                              `content` = ?,
                                              `lists_id` = ?,
                                              `condition_azukeire` =?,
                                              `condition_carry_in` = ?';
          $data = array($search['baggage_classify'], $_POST['list_search'], $_GET['id'], $search['condition_azukeire'], 
          $search['condition_carry_in']);
          $stmt = $dbh->prepare($sql);
          $stmt ->execute($data);
          header('Location:lists.php?id='.$_GET['id']);
          exit();
      }
  }

  //曖昧アイテムたちが押された時の処理を書いて行く
  if (isset($_POST['vague_search_result'])){
    if (!empty($_POST['vague_search_result'])){
      $sql = 'SELECT * FROM `atom_searchs` WHERE `word`= ?';
      $data = array($_POST['vague_search_result']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);
      $vargues = $stmt->fetch(PDO::FETCH_ASSOC); //判定結果を取得

      $sql= 'INSERT INTO `atom_items` SET `categories_id` =?,
                                          `content` = ?,
                                          `lists_id` = ?,
                                          `condition_azukeire` =?,
                                          `condition_carry_in` = ?';
      $data = array($vargues['baggage_classify'], $_POST['vague_search_result'], $_GET['id'], $vargues['condition_azukeire'],$vargues['condition_carry_in']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);
      header('Location: lists.php?id='. $_GET['id']);
      exit();
    }
  }

  // 保存ボタンが押された時
  if (!empty($_POST['keep_btn'])) {

          $sql= 'UPDATE `atom_items` SET `item_check`= 0 WHERE `lists_id`=?';
          $data = array($_GET['id']);
          $stmt = $dbh->prepare($sql);
          $stmt ->execute($data);
        if (isset($_POST['che'])) {
          $c = count($_POST['che']);
          $check_items = $_POST['che'];
          // var_dump($check_items);
          
          // $sql= 'UPDATE `atom_items`(`item_check`) VALUES';

          for ($i=0; $i < $c ; $i++) { 
            // $data = '(' . 1 . ')';
            // $s = '';
            // if($i != 0){
            //   $s = ',';
            // }
            // $sql .= $s . $data;

            $sql= 'UPDATE `atom_items` SET `item_check`= 1 WHERE `id`=?';
            $data = array($check_items[$i]);
            $stmt = $dbh->prepare($sql);
            $stmt ->execute($data);
            // $check_confirm = $stmt->fetch(PDO::FETCH_ASSOC);
          }
        }

    if(isset($_POST['list_name'])) {
      $list_name = $_POST['list_name'];
    }
    // echo "list_name :" . $list_name . '<br>';
    // リストを保存
    $sql = 'UPDATE `atom_lists` SET `members_id` = ?,
                                    `name` = ?,
                                    -- `list_image_path` = ,
                                    `created` = NOW()
                                WHERE `id`=?' ;
    $data = array(($_SESSION['login_user']['id']), $list_name, $_GET['id']);
    $stmt = $dbh->prepare($sql);
    $stmt ->execute($data);

    header('Location: login/myPage.php');
    exit();
  }

  $is_image = ''; //画像が存在するか確認する
  //持ち込み預け入れボタンが押された時にリストに追加する処理を書いて行く
  // 持ち込み・預け入れに追加する場合
  if (!empty($_POST['move_both'])) {
    $sql= 'INSERT INTO `atom_items` SET `categories_id` =0,
                                    `content` = ?,
                                    `lists_id` = ?';
    $data = array(htmlspecialchars($_POST['undefined_to_lists']), $_GET['id']);
    $stmt = $dbh->prepare($sql);
    $stmt ->execute($data);
    header('Location: lists.php?id='. $_GET['id']);
    exit();
  }
  // 持ち込みに追加する場合
  if (!empty($_POST['move_carry_in'])) {
    $sql= 'INSERT INTO `atom_items` SET `categories_id` =1,
                                    `content` = ?,
                                    `lists_id` = ?';
    $data = array(htmlspecialchars($_POST['undefined_to_lists']), $_GET['id']);
    $stmt = $dbh->prepare($sql);
    $stmt ->execute($data);
    header('Location: lists.php?id='. $_GET['id']);
    exit();
  }
  // 預け入れに追加する場合
  if (!empty($_POST['move_azukeire'])) {
    $sql= 'INSERT INTO `atom_items` SET `categories_id` =2,
                                    `content` = ?,
                                    `lists_id` = ?';
    $data = array(htmlspecialchars($_POST['undefined_to_lists']), $_GET['id']);
    $stmt = $dbh->prepare($sql);
    $stmt ->execute($data);
    header('Location: lists.php?id='. $_GET['id']);
    exit();
  }
  // itemのデータを全て取得
  $sql = 'SELECT * FROM `atom_items` WHERE `lists_id` = ?';
  $data = array($_GET['id']);
  $stmt = $dbh->prepare($sql);
  $stmt ->execute($data);

  $i = 0;
  while(true){
    $items[] = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($items[$i] == false) {
        break;
    }

    //アイテムにデータがあるとき
    if (isset($items)) {
      if ($items[$i]['categories_id'] == '0') {
          //両方持ち込みの場合
          $item_boths[] = $items[$i];
      }
      // 持ち込みの場合
      elseif ($items[$i]['categories_id'] == '1') {
          $item_carry_ins[] = $items[$i];
      }
      //預け入れの場合
      elseif ($items[$i]['categories_id'] == '2') {
          $item_azukeires[] = $items[$i];
      }
      //持ち込めない場合
      elseif ($items[$i]['categories_id'] == '3'){
          $banned_baggages = $items[$i];
      }

    } //アイテムにデータがない時
    else{
        //カテゴリー表示
    }
    $i++;
  }
  if(!empty($items)) {
    $is_items = $items[0];
  }else {
    $is_items = false;
  }
  // リストデータを取得
  $sql= 'SELECT * FROM `atom_lists` WHERE `id`=?';
  $data = array($_GET['id']);
  $stmt = $dbh->prepare($sql);
  $stmt ->execute($data);
  $is_image = $stmt->fetch(PDO::FETCH_ASSOC);
  // echo "出力画像" . $is_image['list_image_path'].'<br>';

  //キャンセルボタンが押された時
  if (!empty($_POST['can_btn'])) {
      $sql = 'DELETE FROM `atom_items` WHERE `lists_id`= ?';
      $data = array($_GET['id']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);
      header('Location:lists.php?id='.$_GET['id']);
      exit();
      // echo $_GET['id'];
  }

?>

