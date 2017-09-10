

<?php
  session_start();
  require('../../developer/dbconnect.php');
  $items = array();
  $item_boths = array();
  $item_azukeires = array();
  $item_carry_ins = array();

  //$banned_baggage = '';
  // $list_data['lists_id'] = '3'; //リストid

  if (!isset($_SESSION['login_user']['id'])) {
      header('Location: un_login/sign_in.php');
      exit();
  }




  echo "ユーザ： " . $_SESSION['login_user']['id'] .'<br>';

  //   //ユーザーとリストのリンク
  // $sql= 'SELECT `l`.*,`m`.`account_name`,`m`.`id`
  //          FROM `atom_lists`AS`l`
  //          LEFT JOIN `atom_members` AS `m`
  //          ON `l`.`members_id`=`m`.`id`
  //          WHERE `l`.`id`=?';
  // $data = array($_GET['id']);
  // $stmt = $dbh->prepare($sql);
  // $stmt ->execute($data);
  // $record = $stmt->fetch(PDO::FETCH_ASSOC);
  // var_dump($record);
  // echo '<br>';

if(isset($_GET['id'])){
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
  var_dump($list_data) . '<br>';
}


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
          // echo $list_data['id'] . '<br>';

          if(isset($_GET['id'])){
            $data = array($search['baggage_classify'], $_POST['list_search'], $_GET['id']);
          } else {
            echo "$_GET['new']: " . $_GET['new'];
            $data = array($search['baggage_classify'], $_POST['list_search'], $_GET['new']);
          }
          $stmt = $dbh->prepare($sql);
          $stmt ->execute($data);

      }

      //検索収集用テーブルに登録
      $sql= 'INSERT INTO `atom_searched_words` SET `word` = ?,
                                      `created` = NOW()';
      $data = array($_POST['list_search']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);

  }

  // 保存ボタンが押された時
  if (!empty($_POST['keep_btn'])) {
    if(isset($_GET['new'])) {
      echo "新規作成";
      // 新規リスト作成
      $sql = 'INSERT `atom_lists` SET `members_id` = ?,
                                       `name` = ?,
                                       -- `list_image_path` = ?,
                                       `created` = NOW()';
      $data = array($_SESSION['login_user']['id'], $_POST['list_name']);
      // $data = array($_SESSION['login_user']['id']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);
      // var_dump($stmt) .'<br>';
  }elseif (!isset($list_data)) {
      $sql = 'INSERT `atom_lists` SET `members_id` = ?,
                                      `name` = ?, 
                                      -- `list_image_path` = ,
                                      `created` = NOW()';
      $data = array(($_SESSION['login_user']['id']), $_POST['list_name']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);
    }
    header('Location: login/myPage.php');
    exit();
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




  $is_image = ''; //画像が存在するか確認する

  // itemのデータを全て取得
  if(isset($_GET['id'])) { //GET['id']がある時
    $sql = 'SELECT * FROM `atom_items` WHERE `lists_id` = ?';
    $data = array($list_data['lists_id']);
    $stmt = $dbh->prepare($sql);
    $stmt ->execute($data);
    $is_items = $stmt->fetch(PDO::FETCH_ASSOC);
  } else { //GET[new]のとき
    $is_items = false;
  }

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

  if(isset($_GET['id'])){
    // リストデータを取得
    $sql= 'SELECT * FROM `atom_lists` WHERE `id`=?';
    $data = array($list_data['lists_id']);
    $stmt = $dbh->prepare($sql);
    $stmt ->execute($data);
    $is_image = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "出力画像" . $is_image['list_image_path'].'<br>';
  } else {
    $is_image = NULL;
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


?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href=".favicon.png./assets/img/">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


    <title>旅にもつ</title>
    <?php require('load_css.php'); ?>
 
  </head>
  <body>
  <!-- ログインをしてるときとそうでないときで読み込むヘッダを変える -->

  <?php
    // $ini = parse_ini_file("config.ini");
    // $is_login = $ini['is_login'];
    // // $is_login = 0; //ログインしてるときを１とする（仮）
    // if ($is_login) { //ログインしてるとき
    //   // echo "login success";
    //   require('login_header.php');
    // } else {// ログインしてないとき
    //   // echo "login fail";
    //   require('header.php');
    // }
  ?>

<!-- 画像の変更 -->
<form method="POST" action="" enctype="multipart/form-data"> -->
  <input type="file" name="image">
  <input type="submit" value="send">
</form>
 <div id="img">
    <div id="headerwrap" class="back">
      <div class="container">
        <!-- リストの情報画面を書いていく -->
        <div class="row height">
          <div class="col-lg-offset-2 col-lg-5 col-md-12 col-sm-12 col-xs-12">
            <form action="" method="POST">
              <input type="text" name="list_name" placeholder="新しいリスト" class="form-control list_name_location" 
              data-intro="リスト名を入力してね" data-step="1" value="<?php if(!empty($_POST)){ echo $_POST['list_name']; }?>">
              <?php if(isset($_GET['id'])){ ?>
                <input type="text" name="created" placeholder="作成日時" class="form-control created_location" value="<?php echo $list_data['created']; ?>">
              <?php } else { ?>
                <input type="text" name="created" placeholder="作成日時" class="form-control created_location" value="<?php echo ""; ?>">
              <?php } ?>


            </div>
              <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 center_shift">






            <?php if (isset($errors['extension'])) { ?>
              <div class="alert alert-danger">
                拡張子は、jpg,png,gifの画像を選択ください
              </div>
            <?php } ?>

            <label>
            <!-- 画像がデータベースに登録されているとき -->
            <?php if ($is_image['list_image_path'] != NULL) { ?>
              <img src="../../list_image_path/<?php echo $is_image['list_image_path']?>" class="img-circle" width="150px" alt="画像を読み込んでいます" class="padding_img" data-intro="旅の思い出写真を登録してね" data-step="2"><br>
              <p class="set_profile">
                <?php echo $list_data['account_name'] ?>
              </p>
            <!-- 画像がデータベースに登録されてないとき -->
            <?php } else {?>
            <div>デフォルト画像を表示</div>
            <!--                <div class="panel panel-default">
                              <div class="panel-body">
                                Drop Zone
                                <div class="upload-drop-zone" id="drop-zone"> Or drag and drop files here </div>
                                <div class="upload-drop-zone" id="drop-zone">

                                </div>
                              </div>
                            </div> -->

                          <!-- 画像の変更 -->
            <!--               <form method="post" action="" enctype="multipart/form-data">
                            <span class="btn btn-primary">
                                Choose File
                                <input type="file" name="image" style="display:none;">
                            </span>
                            <span class="btn btn-success">
                                Send
                              <input type="submit" style="display:none;">
                            </span>

                            </form> -->
            <?php } ?>
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-xs-12">
            <hr class="under_line1">
          </div>
        </div>
        <!-- リストの大枠を作って行く -->
        <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
            <input type="text" name = "list_search" id="searchs" class="form-control search_window_1" placeholder="「リストを追加してね！」" data-intro="ここに入力すると自動でリストが作成されるよ" data-step="3" autofocus>

            <input id="search-btn" type="submit" class="btn btn-warning  btn-lg btn_width" value="検索">
          </div>
<!-- <<<<<<< HEAD -->
        </div>

        <div class="list_category margin_top row" data-intro="検索結果が自動でここに入るよ" data-step="4">
          <div class="both_contents well col-lg-4">
            <!-- BOTHの欄を作る -->
            <strong>
              <p class="sub_title fa fa-fighter-jet">
                持ち込み・預け入れ
              </p>
            </strong>
            <div>
              <ul class="list-group" id="list_design">
                <?php foreach ($item_boths as $item_both) { ?>
                  <label class="width">
                    <li class="list-group-item list_float">
                      <input type="checkbox" name="che" class="left checkbox">
                      <span class="checkbox-icon"></span>
                      <?php echo $item_both['content'];?>
                        <!-- 削除処理を書いていく -->
                        <a href="delete_category.php?id=<?php echo $item_both['id'];?>">
                          <i class="fa fa-trash right_position"></i>
                        </a>
                        <a href="edit_category.php?id=<?php echo $item_carry_in['id'];?>">
                         <i class="fa fa-pencil-square-o right"></i>
                        </a>
                    </li>
                  </label>
                <?php }?>
              </ul>
            </div>
          </div>
          <!-- 持ち込みの欄を作る -->
          <div class="carry_in well col-lg-4">
            <strong>
              <p class="sub_title fa fa-hand-o-right">
                持ち込み
              </p>
            </strong>
            <div>
              <ul class="list-group">
                <?php foreach ($item_carry_ins as $item_carry_in){ ?>
                  <label class="width">
                    <li class="list-group-item list_float">
                      <input type="checkbox" name="che" class="left checkbox">
                      <span class="checkbox-icon"></span>
                      <?php  echo $item_carry_in['content']; ?>
                      <?php  ?>
                      <!-- 削除処理を書いていく -->
                      <a href="delete_category.php?id=<?php echo $item_carry_in['id'];?>">
                        <i class="fa fa-trash right_position"></i>
                      </a>
                      <a href="edit_category.php?id=<?php echo $item_carry_in['id'];?>">
                       <i class="fa fa-pencil-square-o right"></i>
                      </a>
                      <?php  ?>
                    </li>
                  </label>
                <?php  } ?>
              </ul>
            </div>  
          </div>

          <div class="azukeire well col-lg-4">
            <!-- 持ち込みの欄を作る -->
            <strong>
              <p class="sub_title fa fa-suitcase ">
                預け入れ
              </p>
            </strong>
            <ul class="list-group">
              <?php foreach ($item_azukeires as $item_azukeire) { ?>
                <label class="width">
                    <li class="list-group-item list_float">
                      <input type="checkbox" name="che" class="left checkbox">
                      <span class="checkbox-icon"></span>
                      <?php echo $item_azukeire['content']; ?>
                      <?php  ?>
                        <!-- 削除処理を書いていく -->
                        <a href="delete_category.php?id=<?php echo $item_azukeire['id']; ?>">
                          <i class="fa fa-trash right_position"></i>
                        </a>
                        <a href="edit_category.php?id=<?php echo $item_carry_in['id'];?>">
                         <i class="fa fa-pencil-square-o right"></i>
                        </a>
                      <?php  ?>
                    </li>
                </label>
              <?php } ?>
            </ul>
          </div>
        </div>
        <!-- リストの保存機能たち -->

          <div class="list_contents text-center">
<!--               <div class="tmp_keep">
                <input class="btn btn-info tmp_btn" value="一時保存" type="submit" name="tmp_btn" data-intro="作成の続きからリストが作れるよ" data-step="4">
              </div> -->
<!--             <div class="cansel">
              <input value="キャンセル" class="btn btn-warning can_btn" type="submit" name="can_btn">
            </div> -->
            <div class="keep">

              <input class="btn btn-success keep_btn" value="マイページへ登録" type="submit" name="keep_btn" data-intro="リストの履歴やメールに送信できるよ" data-step="5">
            </div>  

          </form>
        </div>
      </div>
    </div>
  </div>

  <?php require('footer.php'); ?>
  <?php require('load_js.php'); ?>


  <?php if ($is_items == false) { ?>
    <script type="text/javascript">
      introJs().start();
    </script>
  <?php } ?>
  <script type="text/javascript" src="../assets/js/lists.js"></script>

</body>
</html>


<?php
// // 条件用

      // INSERT INTO `searchs` SET `word` = 'まさきっき',
      //                           `condition` = 'ほげ',
      //                           `baggage_classify` = 2, // 1:両方 2:機内 3:預け 4:不可
      //                           `aviation_id` = 1,
      //                           `categoryies_l2_id` =3, 
      //                           `created` = NOW()
      //                           // aviation_id  categoryies_l2_id 

// listsにデータを挿入するためのsql
// INSERT INTO `lists`(`members_id`, `name`, `created`) VALUES (1,"a",NOW())

      // INSERT INTO `atom_searchs` SET `word` = 'くり',
      //                           `condition` = 'ほげ',
      //                           `baggage_classify` = 2, // 1:両方 2:機内 3:預け 4:不可
      //                           `aviation_id` = 1,
      //                           `categories_l2_id` =3, 
      //                           `created` = NOW()
                                // aviation_id  categories_l2_id 
 ?>

