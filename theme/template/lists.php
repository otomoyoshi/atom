<?php
  session_start();
  require('../../developer/dbconnect.php');
  $items = array();
  $item_boths = array();
  $item_azukeires = array();
  $item_carry_ins = array();
  //$banned_baggage = '';


  // if (!isset($_SESSION[''])) {
  //   header('Location: sign_in.php');
  //   exit();
  // }

  
  // この中に各種ボタンが押された時の条件を書き込んでいく

    //検索ボタンが押された時
    if (!empty($_POST['list_search']) && $_POST['list_search'] != ''){
          // リストに追加
          $sql = 'INSERT `lists` SET `members_id` = 1 ,
                                     `name` = ?, 
                                     -- `list_image_path` = ,
                                     `created` = NOW()';
          $data = array($_POST['list_name']);
          $stmt = $dbh->prepare($sql);
          $stmt ->execute($data);
          // リストとアイテムを結合
          $sql= 'SELECT `i`.*,`l`.`id`,`l`.`name`
                 FROM `items` AS `i`
                 LEFT JOIN `lists` AS `l`
                 ON `i`.`lists_id` = `l`.`id`
                 WHERE 1';
          $data = array();
          $stmt = $dbh->prepare($sql);
          $stmt ->execute();
          $list_data = $stmt->fetch(PDO::FETCH_ASSOC);

          // ユーザーとリストのリンク
          $sql= 'SELECT `l`.*,`m`.`account_name`
                   FROM `lists`AS`l`
                   LEFT JOIN `members` AS `m`
                   ON `l`.`members_id`=`m`.`id`
                   WHERE 1';
          $data = array();
          $stmt = $dbh->prepare($sql);
          $stmt ->execute($data);
          $record = $stmt->fetch(PDO::FETCH_ASSOC);

          $sql = 'SELECT * FROM `searchs` WHERE `word`= ?';
          $data = array($_POST['list_search']);
          $stmt = $dbh->prepare($sql);
          $stmt ->execute($data);
          $search = $stmt->fetch(PDO::FETCH_ASSOC);//判定結果を取得
          
          

          //①ユーザの検索と一致した場合 ：
          if ($search['word'] == $_POST['list_search']) {
            // アイテムに追加
            $sql= 'INSERT INTO `items` SET `categories_id` =?,
                                           `content` = ?,
                                           `lists_id` = ?';
            $data = array($search['baggage_classify'], $_POST['list_search'], 3);
            $stmt = $dbh->prepare($sql);
            $stmt ->execute($data);
          
            // 一致したアイテムの結果を取得
            $sql = 'SELECT * FROM `items` WHERE 1';
            $data = array($_POST['list_search']);
            $stmt = $dbh->prepare($sql);
            $stmt ->execute($data);
          }   
          while(true){
            $items = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($items == false) {
              break;
            }
            //アイテムにデータがあるとき
            if (isset($items)) {
              if ($items['categories_id'] == '1') {
                  //両方持ち込みの場合 
                  $item_boths[] = $items['content'];
              }
                // 持ち込みの場合
              elseif ($items['categories_id'] == '2') {
                  $item_carry_ins[] = $items['content'];
              }
                //預け入れの場合
              elseif ($items['categories_id'] == '3') {
                  $item_azukeires[] = $items['content'];    
              } 
                //持ち込めない場合
              else {
                $banned_baggage = 'その荷物は持ち込めません！！';
              } 
            }  
          }
          // //アイテムにデータがない時
          //   else {
          //     //カテゴリー表示
          //   }
         
        //検索収集用テーブルに登録
        $sql= 'INSERT INTO `searched_words` SET `word` = ?,
                                        `created` = NOW()';
        $data = array($_POST['list_search']);
        $stmt = $dbh->prepare($sql);
        $stmt ->execute($data);
      }

    // 一時保存ボタンが押された時
    if (!empty($_POST['tmp_btn'])) {
        $sql = 'INSERT `lists` SET `members_id` = 1 ,
                                   `name` = ?, 
                                   -- `list_image_path` = ,
                                   `created` = NOW()';
        $data = array($_POST['list_name']);
        $stmt = $dbh->prepare($sql);
        $stmt ->execute($data);

    }

    //キャンセルボタンが押された時
    if (!empty($_POST['can_btn'])) {
          header('Location:lists.php');
    }

    // 保存ボタンが押された時
    if (!empty($_POST['keep_btn'])) {
        $sql = 'INSERT `lists` SET 
                           `members_id` = 1 ,
                           `name` = ?, 
                           -- `list_image_path` = ,
                           `created` = NOW()';
        $data = array($_POST['list_name']);
        $stmt = $dbh->prepare($sql);
        $stmt ->execute($data);
    } else {
      // $sql = '';
      // $data = array(,$_POST['list_name'],$_FILES['']);
      // $stmt = $dbh->prepare();
      // $stmt ->execute();
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
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    

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

 <div id="img"> 
    <div id="headerwrap" class="back">
      <div class="container">
      <!-- リストの情報画面を書いていく -->
        <div class="row height">
          <div class="col-lg-offset-2 col-lg-5 col-md-12 col-sm-12 col-xs-12">
            <form action="" method="POST">
              <input type="text" name="list_name" placeholder="新しいリスト" class="form-control list_name_location" data-intro="リスト名を入力してね" data-step="1">
              <input type="text" name="created" placeholder="作成日時" class="form-control created_location">

            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 center_shift">
              <?php if (!isset($hoge)) {?>
                <img src="../assets/img/pic1.jpg" class="img-circle" width="150px" class="padding_img" data-intro="旅の思い出写真を登録してね" data-step="2"><br>
                <p class="set_profile">
                  <?php echo $record['account_name']?>
                </p>
              <?php } else {?>

              <?php } ?>
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
                         <?php echo $item_both;?> 
                          <!-- 削除処理を書いていく -->
                         <?php  ?>
                           <a href="delete_category.php?id=<?php echo $tweet['id'];?>">
                             <i class="fa fa-trash"></i>
                           </a>
                         <?php  ?>
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
                        <?php  echo $item_carry_in; ?>
                        <!-- 削除処理を書いていく -->
                        <?php  ?>
                          <a href="delete_category.php?id=<?php echo $tweet['id'];?>">
                            <i class="fa fa-trash"></i>
                          </a>
                        <?php  ?>
                      </li>
                    </label>
                  <?php  }?>
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
                        <?php echo $item_azukeire; ?>
                        <!-- 削除処理を書いていく -->
                        <?php  ?>
                          <a href="delete_category.php?id=<?php echo $tweet['id'];?>">
                            <i class="fa fa-trash"></i>
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
              <div class="tmp_keep">
                <input class="btn btn-info tmp_btn" value="一時保存" type="submit" name="tmp_btn" data-intro="作成の続きからリストが作れるよ" data-step="4">
              </div>
            <div class="cansel">
              <input value="キャンセル" class="btn btn-warning can_btn" type="submit" name="can_btn">
            </div>
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
  <script type="text/javascript">
  introJs().start();
  </script>
</body>
</html>


<?php 
// // 条件用
//       INSERT INTO `searchs` SET `word` = 'まさきっき',
//                                 `condition` = 'ほげ',
//                                 `baggage_classify` = 2, // 1:両方 2:機内 3:預け 4:不可
//                                 `aviation_id` = 1,
//                                 `categoryies_l2_id` =3, 
//                                 `created` = NOW()
//                                 // aviation_id  categoryies_l2_id 
 ?>










