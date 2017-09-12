<?php 
require('../../developer/dbconnect.php');
$word = '';
$errors = array();

//検索ボタンが押されたとき
if (!empty($_POST)) {
    if (isset($_POST['list_search']) && $_POST['list_search'] != '') {
      $sql= 'INSERT INTO `atom_searched_words` SET `word` = ?,
                            `created` = NOW()';
      $data = array($_POST['list_search']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);

      $sql = 'SELECT * FROM `atom_searchs` WHERE `word`= ?';
      $data = array($_POST['list_search']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);
      $search = $stmt->fetch(PDO::FETCH_ASSOC);//判定結果を取得
    } elseif (isset($_POST['list_search']) && $_POST['list_search'] == '') {
    $errors['word'] = 'blank';
    }
      if (isset($search)) {
        if ($search['baggage_classify'] == '1') {
            //両方持ち込みの場合
           $word = $search['word'];
           $classify = '機内への持ち込み・預け入れ共に可能です';
           $condition_carry_in = $search['condition_carry_in'];
           $condition_azukeire = $search['condition_azukeire'];
           $judge_carry_in = '◯';
           $judge_azukeire = '◯';
        }
        // 持ち込みの場合
        elseif ($search['baggage_classify'] == '2') {
          $word = $search['word'];
          $classify = '機内持ち込みのみ可能です';
          $condition_carry_in = $search['condition_carry_in'];
          $condition_azukeire = $search['condition_azukeire'];
          $judge_carry_in = '◯';
          $judge_azukeire = '×';

        }
        //預け入れの場合
        elseif ($search['baggage_classify'] == '3') {
          $word = $search['word'];
          $classify = 'お荷物預け入れのみ可能です';
          $condition_carry_in = $search['condition_carry_in'];
          $condition_azukeire = $search['condition_azukeire'];
          $judge_carry_in = '×';
          $judge_azukeire = '◯';
        } 
        //持ち込めない場合
        elseif ($search['baggage_classify'] == '4'){
          $word = $search['word'];
          $classify = '機内への持ち込み・預け入れ共にできません';
          $condition_carry_in = '';
          $condition_azukeire = '';
          $judge_carry_in = '×';
          $judge_azukeire = '×';

        } 

      } //アイテムにデータがない時
      else{
          //カテゴリー表示
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
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <!-- <link rel="shortcut icon" href="../..assets/img/favicon.png"> -->
    <!-- <link rel="shortcut icon" href="../assets/img/tabinimotsu_v1.png"> -->

    <title>旅にもつ</title>

    <?php require('load_css.php');?>
    <link rel="stylesheet" type="text/css" href="../assets/css/home.css">



  </head>

  <body>

  <!-- ログインをしてるときとそうでないときで読み込むヘッダを変える -->
  <?php
    // $ini = parse_ini_file("config.ini");
    // $is_login = $ini['is_login'];
    // $is_login = 0; //ログインしてるときを１とする（仮）
    if ($_SESSION['login_user']) { //ログインしてるとき
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
        <div class="col-xs-12 col-lg-6">
          <h2 id ="catch_copy">「荷造りの悩み」ここに置いて行きませんか？</h2>
         
        <form method="POST" action="">
            <div class="form-group">
              <!-- <label for="sel1"></label> -->
              <select class="form-control" id="sel1" data-intro="航空会社をお選びください" data-step="1">
                <option>JetStar</option>
              </select>
            </div>

            <div class="form-group">

              <input type="text" id="search" class="form-control" placeholder="例：液体物" name = "list_search" maxlength=15 data-intro="調べたい荷物名を入力してください" data-step="2" autofocus>

               <?php if (isset($errors['word'])  == 'blank') {?>
                  <div class="alert alert-danger error_search">検索ワードを入力してください</div>
                <?php } ?>

            </div>
            <input id="search-btn1" type="submit" class="btn btn-warning btn-lg" value="検索">
          </form>
        </div><!-- /col-lg-6 -->
        <!-- 検索結果を表示していく -->
        <div class="col-xs-12 col-lg-6 ">
              <?php if (isset($search)) {?>
                  <div class="row">
                    <div class = "col-lg-12">
                      <?php echo $word; ?>
                      <?php echo $word; ?>
                    </div>
                  </div>
              <?php  } ?>
          </div>
        </div><!-- /col-lg-6 -->
      </div><!-- /row -->
    </div><!-- /container -->
  </div><!-- /headerwrap -->



  <?php require('footer.php'); ?>

  <?php require('load_js.php'); ?>
  <script type="text/javascript">
  introJs().start();
  </script>
  <script type="text/javascript" src="../assets/js/home.js"></script>
  </body>
</html>
