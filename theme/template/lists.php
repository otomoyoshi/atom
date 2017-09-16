<?php

  require('lists_sql.php');

  // ユーザーが新規でリストを作成する際
  if ($is_image['name'] == '') {
    　
    $sql = 'SELECT COUNT(*) FROM `atom_lists` WHERE `members_id`=?';
    $data = array($_SESSION['login_user']['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    // ログインしているユーザーが作成しているリストの数を取得
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $list_amount = $rec['COUNT(*)'];
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
    <link rel="shortcut icon" href="../favicon.png./assets/img/">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


    <title>旅にもつ</title>
    <?php require('load_css.php'); ?>
    <link rel="stylesheet" type="text/css" href="../assets/css/lists.css">

  </head>
  <body>
  <!-- ログインをしてるときとそうでないときで読み込むヘッダを変える -->

  <?php
    // $ini = parse_ini_file("config.ini");
    // $is_login = $ini['is_login'];
    // $is_login = 0; //ログインしてるときを１とする（仮）
    if (isset($_SESSION['login_user'])){ //ログインしてるとき
      // echo "login success";
      // require('login_header.php');
    } else {// ログインしてないとき
      // echo "login fail";
      require('header.php');
    }
  ?>

<!-- 画像の変更 -->
<form method="POST" action="" enctype="multipart/form-data">
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

            <?php if($is_image['name'] != ''): ?>
              <!-- リスト名が登録されている場合、そのリスト名を表示する -->
              <input type="text" name="list_name" placeholder="新しいリスト" class="form-control list_name_location" 
              data-intro="リスト名を入力してね" data-step="1" value="<?php echo $is_image['name']; ?>">

            <?php else: ?>
              <!-- リスト名が登録されていない場合、自動的にリスト名がvalueに入る -->
              <input type="text" name="list_name" placeholder="新しいリスト" class="form-control list_name_location" 
              data-intro="リスト名を入力してね" data-step="1" value="リスト  <?php echo $list_amount; ?>">

            <?php endif; ?>

                <input type="text" name="created" placeholder="作成日時" class="form-control created_location" value="<?php echo $list_data['created']; ?>">

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
                <?php echo $list_data['account_name']; ?>
              </p>
            <!-- 画像がデータベースに登録されてないとき -->
            <?php } else {?>
              <div>デフォルト画像を表示</div>
                <p class="set_profile">
                <?php echo $list_data['account_name']; ?>
                </p>
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
                        <a href="delete_category.php?id=<?php echo $_GET['id']?>&item_id=<?php echo $item_both['id'];?>">
                          <i class="fa fa-trash right_position"></i>
                        </a>
                    <!--編集ボタン     
                        <span>
                         <i class="fa fa-pencil-square-o right"></i>
                        </span> -->
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
                      <!-- <a href="delete_category.php?id=<?php echo $item_carry_in['id'];?>"> -->
                      <a href="delete_category.php?id=<?php echo $_GET['id']?>&item_id=<?php echo $item_carry_in['id'];?>">
                        <i class="fa fa-trash right_position"></i>
                      </a>
           <!--       編集ボタン     
                      <span>
                       <i class="fa fa-pencil-square-o right"></i>
                      </span> -->
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
                      <!-- <input type="text" class="list_input" name="" value="<?php echo $item_azukeire['content']; ?>"> -->
                      <span class="list_content"><?php echo $item_azukeire['content']; ?></span>
                      
                        <!-- 削除処理を書いていく -->
                        <!-- <a href="delete_category.php?id=<?php echo $item_azukeire['id']; ?>"> -->
                        <a href="delete_category.php?id=<?php echo $_GET['id']; ?>&item_id=<?php echo $item_azukeire['id'];?>">
                          <i class="fa fa-trash right_position"></i>
                        </a>
                     <!--  編集ボタン  <span>
                         <i class="fa fa-pencil-square-o right"></i>
                        </span> -->
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
  
  <script>
   $(window).on('beforeunload', function(e) {
    return '保存されていない内容は破棄されます。 本当によろしいですか？ ';
    });
  </script>

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

