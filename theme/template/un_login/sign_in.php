<?php 
session_start();
require('../../../developer/dbconnect.php');
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
    
    $sql = 'SELECT * FROM `atom_members` WHERE `email`=? AND `password`=?';
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
    <?php require('../child_icon.php'); ?>

    <?php require('../child_load_css.php'); ?>
    <link rel="stylesheet" type="text/css" href="../../assets/css/sign_in.css">

  </head>
  <body>
  <!-- ログインをしてるときとそうでないときで読み込むヘッダを変える -->
  <?php
    // $ini = parse_ini_file("../config.ini");
    // $is_login = $ini['is_login'];
    // $is_login = 0; //ログインしてるときを１とする（仮）
    // if (isset($_SESSION['login_user']['new_user']) && $_SESSION['login_user']['new_user'] != 'yes'){      require('../child_login_header.php');
    // } else {// ログインしてないとき
    //   // echo "login fail";
      require('../child_header.php');
    // }
  ?>

    <div id="headerwrap">
      <div class="container">
        <!-- <div class="row" id="adjustment"> -->
          <!-- <div class="col-lg-6"> -->
            <!-- <div class="row"> -->
              <!-- <div class="text-center title_show">ログイン</div> -->
            <!-- </div> -->
            <!-- <div class="row"> -->
              <!-- <div class="col-lg-12 font_content">
                検索窓に入力するだけで旅行に持っていける荷物がすぐにわかる！
              </div> -->
            <!-- </div> -->
          <!-- </div> -->

            <div class="row text_loc">
              <div class="col-lg-12 text-center"><img class="media-object dp img-circle" src="../../assets/img/user_circle.png " style="width: 80px;height:80px;"></div>
            </div>

            <?php if((isset($_SESSION['login_user']['new_user'])) && $_SESSION['login_user']['new_user'] == 'yes'): ?>
              <div class="row text-center">
                <h3 style="text-align: center; margin-top:0px; margin-bottom: 20px; color: rgba(10,10,10,0.9);">新規登録ありがとうございます！</h3>
              </div>
            <?php $_SESSION['login_user']['new_user'] = ''; ?>
            <?php endif; ?>

          <div class="col-md-12 col-lg-offset-3 col-lg-6 " id="border-space">
           <div class="col-lg-12 text_loc text_left">アカウントをお持ちの方はこちら</div>
            

          
          <form method="POST" action="">
            <div class="row email_input">
              <div class="col-lg-12">

                <div class="text-center text_loc">
                  <!-- <label>メールアドレス </label><br> -->

                  <?php if(isset($_SESSION['login_user']['new_email']) && !empty($_SESSION['login_user']['new_email'])): ?>
                    <input type="email" class="form-control"  name="email" placeholder="メールアドレス" maxlength="50" autofocus value="<?php echo $_SESSION['login_user']['new_email']; ?>">
                    <?php $_SESSION['login_user']['new_email'] = ''; ?>
                  <?php else: ?>
                    <input type="email" class="form-control" name="email" placeholder="メールアドレス" maxlength="50" autofocus value="<?php echo $email; ?>">
                  <?php endif; ?>



                  <!-- メールアドレスが入力されていない時 -->
                  <?php if (isset($errors['email']) && $errors['email'] == 'blank'): ?>
                    <!-- <br> -->
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
                  <!-- <label>パスワード </label><br> -->
                  <input type="password" class="form-control" name="password" placeholder="パスワード"  maxlength="8">
                  <!-- アドレス、パスワードのいずれかが間違っている時 -->
                  <?php if (isset($errors['password']) && $errors['password'] == 'mistake'): ?>
                    <span class="alert alert-danger">
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

            <div class="row">
              <div class="col-lg-12">
                <div class="text-center btn_location">
                 <input type="submit" value="ログイン" class="btn btn_atom text_loc" >
                </div>
              </div>
            </div>
          </form>     

          <div class="row">
            <div class="col-lg-12">
              <div class="text-center">
                <a href="" class="forget_passwprd">パスワードを忘れた場合</a>
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
