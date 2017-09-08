<?php 
require('../../../developer/dbconnect.php');
session_start();
$errors = array();
$email = '';

// 新規登録ボタンが押された時
if (!empty($_POST)) {

  $email = $_POST['email'];
  $password = $_POST['password'];

  if ($email == '') {
    $errors['email'] = 'blank';
  }
  if ($password == '') {
    $errors['password'] = 'blank';
  } 

  if (empty($errors)) {
    
    $sql = 'SELECT * FROM `members` WHERE `email`=? AND `password`=?';
    // $data = array($email,sha1($password));
    $data = array($email,sha1($password));
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($user_info);

    if ($user_info) {
      $_SESSION['login_user']['id'] = $user_info['id'];
      $_SESSION['login_user'] = $user_info;

      header('Location: ../login/myPage.php');
      exit();

    }else{
      $errors['password'] = 'mistake';
    }

  
  }else{

  }


}else{

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

    <?php require('../child_load_css.php'); ?>
    <link rel="stylesheet" type="text/css" href="../../assets/css/sign_in.css">

  </head>
  <body>
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
              <div class="text-center title_show">ログイン</div>
            </div>
            <div class="row">
              <div class="col-lg-12 font_content">
                検索窓に入力するだけで旅行に持っていける荷物がすぐにわかる！
              </div>
            </div>
          </div>

        <form method="POST" action="">
          <div class="col-lg-6 flame">
            <div class="row email_input">
              <div class="col-lg-12">
                <div class="text-center text_loc">
                  <label>メールアドレス ※</label><br>

                  <input type="email" name="email"　placeholder="tabi@example.com"  maxlength="50" autofocus value="<?php echo $email; ?>">
                  <!-- メールアドレスが入力されていない時 -->
                  <?php if (isset($errors['email']) && $errors['email'] == 'blank'): ?>
                    <br>
                    <div class="alert alert-danger">
                      メールアドレスを入力してください
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <div class="row password_input">
              <div class="col-lg-12">
                <div class="text-center text_loc">
                  <label>パスワード ※</label><br>
                  <input type="password" name="password" maxlength="8">
                  <!-- アドレス、パスワードのいずれかが間違っている時 -->
                  <?php if (isset($errors['password']) && $errors['password'] == 'mistake'): ?>
                    <br><br><span class="alert alert-danger">
                      メールアドレス・もしくはパスワードが間違っています
                    </span>
                  <!-- パスワードが入力されていない時 -->
                  <?php elseif(isset($errors['password']) && $errors['password'] == 'blank'): ?>
                    <div class="alert alert-danger">
                      パスワードを入力してください
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </form>

            <div class="row">
              <div class="col-lg-12">
                <div class="text-center">
                  <a href="" class="forget_passwprd"><u>パスワードを忘れた場合</u></a>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-12">
                <div class="text-center btn_location">
                 <input type="submit" value="ログイン" class="btn btn-success" >
                </div>
              </div>
            </div>         
          </div>
        </div>    
      </div>
    </div>
    <?php require('../footer.php'); ?>
    <?php require('../child_load_js.php'); ?>

  </body>
</html>
