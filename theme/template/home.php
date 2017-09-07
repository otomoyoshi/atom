<?php 
require('../../developer/dbconnect.php');

$word = '';
$errors = array ();

//検索ボタンが押されたとき
if (!empty($_POST)) {

    $word = $_POST['search'];

    if ($word == '') {
    $errors['word'] = 'blank';
    }

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
    <!-- <link rel="shortcut icon" href="../..assets/img/favicon.png"> -->
    <!-- <link rel="shortcut icon" href="../assets/img/tabinimotsu_v1.png"> -->

    <title>旅にもつ</title>

    <?php require('load_css.php');?>




  </head>

  <body>

  <!-- ログインをしてるときとそうでないときで読み込むヘッダを変える -->
  <?php
    $ini = parse_ini_file("config.ini");
    $is_login = $ini['is_login'];
    // $is_login = 0; //ログインしてるときを１とする（仮）
    if ($is_login) { //ログインしてるとき
      // echo "login success";
      require('login_header.php');
    } else {// ログインしてないとき
      // echo "login fail";
      require('header.php');
    }
  ?>
  <div id="headerwrap">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-8">
          <h2>「荷造りの悩み」ここに置いて行きませんか？</h2>
         
        <form method="POST" action="">
            <div class="form-group">
              <!-- <label for="sel1"></label> -->
              <select class="form-control" id="sel1" data-intro="航空会社をお選びください" data-step="1">
                <option>JetStar</option>
              </select>
            </div>

            <div class="form-group">
              <input type="text" id="search" class="form-control" placeholder="例：液体物" maxlength=10 data-intro="調べたい荷物名を入力してください" data-step="2" autofocus>

               <?php if (isset($errors['word'])  == 'blank') {?>
                  <div class="alert alert-danger">検索ワードを入力してください</div>
                <?php } ?>

            </div>
            <button id="search-btn" type="submit" class="btn btn-warning btn-lg">検索</button>
          </form>
        </div><!-- /col-lg-6 -->
        <div class="col-xs-12 col-lg-4">
        </div><!-- /col-lg-6 -->

      </div><!-- /row -->
    </div><!-- /container -->
  </div><!-- /headerwrap -->



  <?php require('footer.php'); ?>

  <?php require('load_js.php'); ?>
  <script type="text/javascript">
  introJs().start();
  </script>

  </body>
</html>
