<?php
session_start();
require('../../../developer/dbconnect.php');


$account_name = '';
$email = '';
$password = '';
$comfirm_password = '';

$errors = array ();

// 新規登録ボタンが押されたとき
if (!empty($_POST)) {

    $account_name = $_POST['account_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $comfirm_password = $_POST['comfirm_password'];



    if ($account_name == '') {
    $errors['account_name'] = 'blank';

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



  //バリデーション(すべての値の入力チェックのみ)
if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['account_name']) && !empty($_POST['comfirm_password'])) {
  if (empty($errors)) {
  
  // メールアドレスの重複チェック！！
  $sql = 'SELECT COUNT(*) FROM `atom_members` WHERE `email` = ?' ;
  $data = array($email);
  $stmt = $dbh->prepare($sql);
  $stmt ->execute($data);
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($record['COUNT(*)']>0) {
    $errors['email'] = 'duplicate';// duplicate → 重複
  }
  }

  // パスワードと確認用パスワードが一致しているかの確認
  if ($password != $comfirm_password) {
    $errors['comfirm'] = 'mismatch';
  }

  }

  if (empty($errors)) {
    $sql = 'INSERT INTO `atom_members` SET `account_name`=?,
                                      `email`=?,
                                      `password`=?,
                                      `created`=NOW()';
    $data = array($account_name,$email,sha1($password));
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $_SESSION['login_user']['new_user'] = 'yes';
    $_SESSION['login_user']['new_email'] = $email;

    header('Location: sign_in.php');
    exit();

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
    <?php require('../child_icon.php'); ?>


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
    // $ini = parse_ini_file("../config.ini");
    // $is_login = $ini['is_login'];
    // $is_login = 0; //ログインしてるときを１とする（仮）
    // if (isset($_SESSION['login_user'])) { //ログインしてるとき
    //   // echo "login success";
    //   require('../child_login_header.php');
    // } else {// ログインしてないとき
      // echo "login fail";
      require('../child_header.php');
    // }
  ?>

<div id="headerwrap">
  <div class="container">
    <div class="row" id="adjustment">
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 visible-sm visible-md visible-lg">
         <!-- <div class="row"> -->
            <!-- <br> -->
            <!-- <div class="text-center font_title">新規登録</div> -->
            <!-- <div class="col-lg-12 font_title">旅にもつ</div> -->
        <!-- </div> -->

        <!-- <div class="row"> -->
          <!-- <img src="../../assets/img/tabinimotsu_v1.png" class="img-responsive text_loc" style="margin: auto; height: 50px; width: 50px;"> -->
          <img src="../../assets/img/phone_home_v1_fix.png" class="img-responsive img_adj_slant">
      </div>
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <img src="../../assets/img/phone_list_fix.png" class="img-responsive img_adj_front">

          <!-- <div class="col-lg-12 font_content">
          <br>
          旅にもつ会員になって、あなたの旅行をもっと便利にもっと快適に
          </div> -->
        <!-- </div> -->
      </div>

      
      <div class="col-lg-offset-1 col-lg-4 col-md-6 col-sm-6 col-xs-offset-1 col-xs-10 background_white" id="space">
        <form method="POST" action="">
        <div class="row text_loc">
          <div class="col-lg-12">
           <!--  <img src="../../assets/img/tabinimotsu_v1.png" class="img-responsive text_loc" style="margin: auto; height: 50px; width: 50px;"> -->
            <div class="col-lg-12 font_content">
            <!-- <br> -->
              旅にもつを使おう
            </div>
          </div>
        </div>

        <div class="row text_loc">
          <div class="col-lg-12">
             <div class="text-center">

              <!-- <label><i  aria-hidden="true"></i>アカウント名 </label><br> -->


                <input type="text"  class="form-control" name="account_name" placeholder="アカウント名" maxlength="15" autofocus value="<?php echo $account_name; ?>">

              <?php if (isset($errors['account_name']) && $errors['account_name'] == 'blank') {?>
              <div class="alert alert-danger">アカウント名を入力してください</div>
              <?php } ?>
            </div>
          </div>
        </div>


        <!-- <br> -->
        <div class="row text_loc">
          <div class="col-lg-12">
           <div class="text-center">
              <!-- <label><i></i>メールアドレス </label><br> -->
                <input type="email"  class="form-control" name="email" placeholder="メールアドレス" maxlength="50" value="<?php echo $email; ?>">

              <?php if (isset($errors['email']) && $errors['email'] == 'blank'): ?>
               <!--  <span style="color:red:">メールアドレスを入力してください</span> -->
               <div class="alert alert-danger">メールアドレスを入力してください</div>

              <?php elseif (isset($errors['email']) && $errors['email'] == 'duplicate'): ?>
                <div class="alert alert-danger">入力したメールアドレスは既に登録されています</div>
              <?php endif; ?>

            </div>
          </div>
        </div>


        <!-- <br> -->
        <div class="row text_loc">
          <div class="col-lg-12">
           <div class="text-center">
                <!-- <label><i  aria-hidden="true"></i>パスワード </label><br> -->
              <input type="password" name="password" placeholder="パスワード"　maxlength="50"  class="form-control"　>
              <!-- <input type="password" 　placeholder="パスワード"　> -->
              <?php if (isset($errors['password']) && $errors['password'] == 'blank') {?>
              <div class="alert alert-danger">パスワードを入力してください</div>
              <?php } ?>

              <?php if (isset($errors['password']) && $errors['password'] == 'length') {?>
                <div class="alert alert-danger">パスワードは8文字以上で入力してください</div>
              <?php } ?>
            </div>
          </div>
        </div>

        <!-- <br> -->
        <div class="row text_loc">
          <div class="col-lg-12">
            <div class="text-center">
              <!-- <label><i  aria-hidden="true"></i>確認用パスワード </label><br> -->

              <input type="password" name="comfirm_password" placeholder="確認用パスワード"　maxlength="50"  class="form-control">
              <?php if (isset($errors['comfirm_password']) && $errors['comfirm_password'] == 'blank') {?>
              <div class="alert alert-danger">確認用パスワードを入力してください</div>
              <?php } ?>

              <?php if (isset($errors['comfirm_password']) && $errors['comfirm_password'] == 'length') {?>
                <div class="alert alert-danger">確認用パスワードは8文字以上で入力してください</div>
              <?php } ?>

              <?php if(isset($errors['comfirm']) && $errors['comfirm'] == 'mismatch'): ?>
                <div class="alert alert-danger">確認用パスワードが一致しません</div>
              <?php endif; ?>

            </div>
          </div>
        </div>

        <!-- <br> -->
        <div class="row">
          <!-- <div class="col-lg-12 text-center">
            全て必須項目です
          </div> -->
        </div>
          <!-- <br> -->

        <div class="row">
          <div class="col-lg-12">
            <div class="text-center">
             <input type="submit" value="新規登録" class="btn btn_atom" >
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
