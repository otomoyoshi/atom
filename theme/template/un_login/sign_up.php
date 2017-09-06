<?php 
session_start();
require('../../../developer/dbconnect.php');


$acount_name = '';
$email = '';
$password = '';
$comfirm_password = '';

$errors = array ();

// 新規登録ボタンが押されたとき
if (!empty($_POST)) {

    $acount_name = $_POST['acount_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $comfirm_password = $_POST['comfirm_password'];


    if ($acount_name == '') {
    $errors['acount_name'] = 'blank';

    }
    if ($email == '') {
    $errors['email'] = 'blank';
    }

    if ($password == '') {
    $errors['password'] = 'blank';

    }elseif (strlen($password) < 8 ) {
    $errors['password'] = 'length';

    }

  if ($comfirm_password == '') {
  $errors['comfirm_password'] = 'blank';

    }elseif (strlen($comfirm_password) < 8 ) {
      $errors['comfirm_password'] = 'length';

    }



// //メールアドレスの重複チェック
//  if (empty($errors)) {
//   $sql = 'SELECT COUNT(*) FROM `users` WHERE `email` = ?' ;
//   //COUNT集計関数は、取得したデータの個数を計算する関数
//   //カラム名はCOUNT(*)になる
//   //$record['COUNT(*)']として個数を取得できる

//   $data = array($email);
//   $stmt = $dbh->prepare($sql);
//   $stmt ->execute($data);
//   $record = $stmt->fetch(PDO::FETCH_ASSOC);
//   if ($record['COUNT(*)']>0) {
//     $errors['email'] = 'duplicate';// duplicate → 重複
    
//   }
 

if (empty($errors)) {
  $_SESSION['user_info']['account_name'] = $acount_name;
  $_SESSION['user_info']['email'] = $email;
  $_SESSION['user_info']['password'] = $password;
  $_SESSION['user_info']['comfirm_password'] = $comfirm_password;
  header('Location: sign_in.php');
  exit();//POST送信は破棄される

}



  //バリデーション(すべての値の入力チェックのみ)
  if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['acount_name']) && !empty($_POST['comfirm_password'])) {
 if (empty($errors)) {
  $sql = 'SELECT COUNT(*) FROM `members` WHERE `email` = ?' ;
  //COUNT集計関数は、取得したデータの個数を計算する関数
  //カラム名はCOUNT(*)になる
  //$record['COUNT(*)']として個数を取得できる

  $data = array($email);
  $stmt = $dbh->prepare($sql);
  $stmt ->execute($data);
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($record['COUNT(*)']>0) {
    $errors['email'] = 'duplicate';// duplicate → 重複
  }
 }

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
    <link rel="shortcut icon" href="../../assets/img/favicon.png">

    </div>
    <?php require('../child_load_css.php'); ?>
    <link rel="stylesheet" type="text/css" href="../../assets/css/sign_up.css">


  </head>
  <body>
    

  
<br>
<br>
<br>
<br>

  <!-- ログインをしてるときとそうでないときで読み込むヘッダを変える -->
  <?php
    $ini = parse_ini_file("../config.ini");
    $is_login = $ini['is_login'];
    // $is_login = 0; //ログインしてるときを１とする（仮）
    if ($is_login) { //ログインしてるとき
      // echo "login success";
      require('../child_login_header.php');
    } else {// ログインしてないとき
      // echo "login fail";
      require('../child_header.php');
    }
  ?>

<div id="headerwrap">
  <div class="container">
    <div class="row" id="adjustment">

      <div class="col-lg-6">
         <div class="row">
            <div class="text-center font_title">旅にもつ</div>
            <!-- <div class="col-lg-12 font_title">旅にもつ</div> -->
        </div>

        <div class="row">
          <div class="col-lg-12 font_content">
          この荷物持っていける？重さは？そんな旅の疑問をスマートに解決します！空港を利用して旅行を予定している人の荷造りの悩みを解決します！


          </div>
        </div>

      </div>

  <form method="POST" action="">
      <div class="col-lg-5 background_white" id="space"> 
        <div class="row">
          <div class="col-lg-12">
            
             <div class="text-center">


              <label><i class="fa fa-user" aria-hidden="true"></i>アカウント名 </label><br> 
              <input type="text" name="acount_name" placeholder="アカウント名" autofocus>

              <?php if (isset($errors['acount_name']) && $errors['acount_name'] == 'blank') {?>
              <div class="alert alert-danger">アカウント名を入力してください</div>
              <?php } ?>
            </div>
          </div>
        </div>


        <br>
        <div class="row">
          <div class="col-lg-12">
           <div class="text-center">
              <label><i class="fa fa-envelope-o"></i>メールアドレス </label><br>
                <input type="email" name="email" placeholder="tabi@example.com">

              <?php if (isset($errors['email']) && $errors['email'] == 'blank'): ?>
               <!--  <span style="color:red:">メールアドレスを入力してください</span> -->
               <div class="alert alert-danger">メールアドレスを入力してください</div>

              <?php elseif (isset($errors['email']) && $errors['email'] == 'duplicate'): ?>
                <div class="alert alert-danger">入力したメールアドレスは既に登録されています</div>
              <?php endif; ?>
              







            </div>
          </div>
        </div>


        <br>
        <div class="row">
          <div class="col-lg-12">
           <div class="text-center">
                <label><i class="fa fa-unlock-alt" aria-hidden="true"></i>パスワード </label><br>
              <input type="password" name="password" >
              <?php if (isset($errors['password']) && $errors['password'] == 'blank') {?>
              <div class="alert alert-danger">パスワードを入力してください</div>
              <?php } ?>

              <?php if (isset($errors['password']) && $errors['password'] == 'length') {?>
                <div class="alert alert-danger">パスワードは8文字以上で入力してください</div>
              <?php } ?>
            </div>
          </div>
        </div>

        <br>
        <div class="row">
          <div class="col-lg-12">
            <div class="text-center">
              <label><i class="fa fa-unlock-alt" aria-hidden="true"></i>確認用パスワード </label><br>
              <input type="password" name="comfirm_password">
              <?php if (isset($errors['comfirm_password']) && $errors['comfirm_password'] == 'blank') {?>
              <div class="alert alert-danger">確認用パスワードを入力してください</div>
              <?php } ?>

              <?php if (isset($errors['comfirm_password']) && $errors['comfirm_password'] == 'length') {?>
                <div class="alert alert-danger">確認用パスワードは8文字以上で入力してください</div>
              <?php } ?>
            </div>
          </div>
        </div>

        <br>
        <div class="row">
          <div class="col-lg-12 text-center">
            全て必須項目です
          </div>
        </div>
          <br>

        <div class="row">
          <div class="col-lg-12">
            <div class="text-center">
             <input type="submit" value="新規作成" class="btn btn-info" >
            </div>
          </div>      
        </div>

       </div>
      </form>
    </div>         
  </div>
</div>

<!-- ここまで変更する -->

  <?php require('../footer.php'); ?>
  <?php require('../child_load_js.php'); ?>

  </body>
</html>
