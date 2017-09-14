<?php 
session_start();
require('../../../developer/dbconnect.php');

// var_dump($_SESSION['user_info']);

if(!empty($_POST)){
  // echo "post" . '<br>';
  // 新規リストを作成
  if(isset($_POST['new'])){
    $sql = 'INSERT `atom_lists` SET `members_id` = ?,
                                     -- `name` = ?,
                                     -- `list_image_path` = ?,
                                     `created` = NOW()';
    // $data = array($_SESSION['login_user']['id'], $_POST['list_name']);
    $data = array($_SESSION['login_user']['id']);
    $stmt = $dbh->prepare($sql);
    $stmt ->execute($data);

    // ユーザが持つリストを全て取得
    $sql = 'SELECT * FROM `atom_lists` WHERE `members_id`=? ORDER BY `id` DESC';
    $data = array($_SESSION['login_user']['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // var_dump($stmt) .'<br>';
    header('Location: ../lists.php?id=' . $result['id']);
    exit();
  }

}


// ユーザがリスト作成ページで戻るボタンで戻って来た場合
$sql = 'SELECT * FROM `atom_lists` WHERE `name`=""';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$empty_name_list = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($empty_name_list);

// 名前が空のデータをDBから削除
$sql = 'DELETE FROM `atom_lists` WHERE `id`=?';
$data = array($empty_name_list['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

// ユーザが持つリストを全て取得
$sql = 'SELECT * FROM `atom_lists` WHERE `members_id`=?';
$data = array($_SESSION['login_user']['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$lists = array();
$max = 0;
while(1){
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($rec == false) {
    break;
  }
  $lists[] = $rec;
}
// var_dump($lists);

 ?>



<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php echo require('../child_icon.php'); ?>
    <title>旅にもつ</title>

  <?php require('../child_load_css.php'); ?>
  <link rel="stylesheet" type="text/css" href="../../assets/css/mypage.css">

  </head>

  <body>
  <!-- ログインをしてるときとそうでないときで読み込むヘッダを変える -->
  <?php
    // $ini = parse_ini_file("../config.ini");
    // $is_login = $ini['is_login'];
    // $is_login = 1; //ログインしてるときを１とする（仮）
    if (isset($_SESSION['login_user'])) { //ログインしてるとき
      // echo "login success";
      require('../child_login_header.php');
    } else {// ログインしてないとき
      // echo "login fail";
      require('../child_header.php');
    }
  ?>

    <div id="headerwrap" style="padding-top: 100px">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
      <!-- 薄い白で囲まれてるメインのディブ -->
      <div class="col-md-8 col-sm-8 col-xs-10 col-md-offset-2 col-sm-offset-2 col-xs-offset-1 tabinimotsu_main_div" style="margin-bottom: 50px">
        <div class="container-fluid">

        <!-- ユーザーユーザー情報の表示 -->
          <div class="row">
            <div class="col-md-4"></div>
              <div class="col-md-8" style="padding-top: 20px">
                <div class="media">
                  <a class="pull-left" href="#">
                  <?php if(isset($_SESSION['login_user']['profile_image_path'])): ?>
                    <img class="media-object dp img-circle" src="../../../profile_image_path/<?php echo $_SESSION['login_user']['profile_image_path']; ?>" style="width: 80px;height:80px;">
                  <?php else: ?>
                    <img class="media-object dp img-circle" src="../../../profile_image_path/masaki.png" style="width: 80px;height:80px;">
                  <?php endif; ?>
                  </a>
                  <div class="media-body">
                    <h3 class="mypage_username">
                      <?php if(isset($_SESSION['login_user']['account_name'])) { ?>
                        <?php echo $_SESSION['login_user']['account_name']; ?>くん
                      <?php } ?>
                    </h3>
                  </div>
                </div>
              </div> 

          </div>

          <div>
            <hr color="blue">
          </div>

        </div>

        <!-- リスト全体 -->
          <div class="row">
              
                <!-- 追加ボタン -->
              <div class="col-md-4 col-sm-4" data-intro="新しい持ち物リストを作成できるよ" data-step="1">
                <div class="wrimagecard wrimagecard-topimage lists_margin">

                  <form method="POST" action="">
                      <input type="hidden" value="new" name="new">

                    <label>
                        <input type="submit" hidden="True">
                        <div class="wrimagecard-topimage_header" style="background-color:rgba(255, 135, 0, 0.2); ">
                          <div style="text-align: center"><i class="fa fa-plus-square-o" style="color:rgba(255, 135, 0, 0.4);"></i></div>
                        </div>
                        <div class="wrimagecard-topimage_title_add">
                          <h4>新しく追加してね！</h4>
                        </div>

                    </label>

                  </form>

                </div>
              </div>
            

          <!-- 個々のリスト -->
          <?php foreach($lists as $list): ?>
            <div class="col-md-4 col-sm-4">
              <div class="wrimagecard wrimagecard-topimage lists_margin">
                <a href="../lists.php?id=<?php echo $list['id']; ?>">
                  <div class="wrimagecard-topimage_header" style="background-color: rgba(60, 216, 255, 0.2)">
                    <div class="row" style="margin-right: 0px">

                      <div class="col-xs-8 col-lg-8" style="padding-right: 0px">
                      <?php if(isset($list['name']) && $list['name'] != ''): ?>
                        <h4 style="text-align: center; padding: 10px 0px 0px 20px; font-size: 20px">
                        <?php echo $list['name']; 
                        $_SESSION['list_info']['list_name'] = $list['name']; ?></h4>
                      <?php else: ?>
                        <h4 style="text-align: center; padding: 10px 0px 0px 20px">LIST NAME</h4>
                      <?php endif; ?>
                        <h5 style="text-align: center; padding: 0px 0px 0px 20px">
                          <?php echo $list['modified']; ?>
                        </h5>
                      </div>
                      <div class="col-xs-3 col-mlg-4" style="padding-left: 0px;">
                        <?php if(!empty($list['list_image_path'])): ?>
                          <img src="../../../list_image_path/<?php echo $list['list_image_path'] ?>" class="img-circle" style="width: 70px; height: 70px; margin: 8px">
                        <?php else: ?>
                          <i class = "fa fa-suitcase" style="color:rgba(0, 152, 255, 0.6);"></i>
                        <?php endif; ?>
                      </div>

                    </div>
                  </div>
                </a>
                  <div class="wrimagecard-topimage_title">
<!-- <<<<<<< HEAD
                  <div>

                    <div class="container col-md-12">
                      <div class="row">
                        <button type="button" class="col-md-4 col-xs-4" data-intro="持ち物リストを複製できるよ" data-step="2"><i class="glyphicon glyphicon-file"></i></button>
                        <button type="button" class="col-md-4 col-xs-4" data-intro="メールで持ち物リストを送信できるよ" data-step="3"><i class="glyphicon glyphicon-envelope"></i></button>
                        <button type="button" class="col-md-4 col-xs-4" data-intro="削除はここで" data-step="4"><i class="glyphicon glyphicon-trash"></i></button>
======= -->
                    <div>
                    <!-- <div class="container col-md-12"> -->

                      <div class="row">
<!--                         <a href="../myPage_function/list_copy.php?id=<?php echo $list['id']; ?>">
                          <button name="list_copy" type="button" class="col-md-4 col-xs-4" data-intro="持ち物リストを複製できるよ" data-step="2"><i class="glyphicon glyphicon-file"></i></button>
                        </a> -->
                        <a href="../myPage_function/list_copy.php?id=<?php echo $list['id']; ?>">
                          <!-- <span class="tooltip" title="ダウンロード"></span> -->
                          <button name="list_copy" type="button" class="col-md-4 col-xs-4" data-intro="持ち物リストを複製できるよ" data-step="2" title="持ち物リストを複製できるよ"><i class="glyphicon glyphicon-file" title="持ち物リストを複製できるよ"></i></button>
                          
                        </a>
                        <!-- <a href="../function/list_email.php"> -->
                          <button name="list_email" type="button" class="col-md-4 col-xs-4" data-intro="メールで持ち物リストを送信できるよ" data-step="3" title="ダウンロード"><i class="glyphicon glyphicon-envelope"></i></button>
                        <!-- </a> -->
                        <a href="../myPage_function/list_delete.php?id=<?php echo $list['id']; ?>" onClick="return confirm('削除します。\nよろしいですか？');">
                          <button name="list_delete" type="button" class="col-md-4 col-xs-4" title="削除" data-intro="削除はここで" data-step="4"><i class="glyphicon glyphicon-trash"></i></button>
                        </a>

                      </div>
    <!--                 </div> -->
                  </div>
                 </div>
                </div>
              </div>
            <?php endforeach; ?>
            </div>

          <div>
            <hr color="blue">
          </div>

          <div style="padding-bottom: 6px">
            <h5 style="text-align: right;">使い方がわからくなった方は<input type="button" name="how_to_use" class="fa fa-info" value="こちら">へ</h5>
          </div>

          </div>
        </div>
      </div>

  <?php require('../footer.php'); ?>
  <?php require('../child_load_js.php'); ?>

  <script src="../../assets/js/myPage.js"></script>


  <?php if(!isset($lists)){ ?>
  <script type="text/javascript"></script>
  introJs().start();
  </script>
  <?php } ?>
  <script type="text/javascript">
    $(function(){
      $('.tooltip').tooltipster();
    });
  </script>

  </body>
</html>
