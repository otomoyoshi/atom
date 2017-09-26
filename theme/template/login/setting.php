<?php 
session_start();
require('../../../developer/dbconnect.php');

//ログインチェック
if (!isset($_SESSION['login_user']['id'])) {
    header('Location: ../un_login/sign_in.php');
    exit();
}

$errors = array();
$account_name = '';
$email = '';
$new_password = '';
$comfirm_password = '';
$now_password = '';
$gender = 0;
$age = 0;

if ($_SESSION['login_user']['gender'] != '') {
    if ($_SESSION['login_user']['gender'] == 1) {
      $registered_gender = '男性';
    }elseif ($_SESSION['login_user']['gender'] == 2) {
      $registered_gender = '女性';
    }
  }

if ($_SESSION['login_user']['age'] != '') {
      $registered_age = $_SESSION['login_user']['age'];
    }

if (!empty($_POST)) {
    $account_name = $_POST['account_name'];
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $comfirm_password = $_POST['comfirm_password'];
    $now_password = $_POST['now_password'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];

    // アカウント名変更処理とバリデーション
    require('../setting_function/account_name_update_comfirm.php'); 

    // メールアドレス変更処理とバリデーション 
    require('../setting_function/email_update_comfirm.php');

    // パスワード変更処理とバリデーション
    require('../setting_function/password_update_comfirm.php');

    // 性別の登録処理
    if ($gender != '') {
      $sql = 'UPDATE `atom_members` SET `gender`=? WHERE `id`=?';
      $data = array($gender,$_SESSION['login_user']['id']);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $_SESSION['login_user']['gender'] = $gender;

      if ($gender == 1) {
        $registered_gender = '男性';
      }elseif ($gender == 2) {
        $registered_gender = '女性';
      }
    }

    // 年齢の登録処理
    if ($age != '') {
      $sql = 'UPDATE `atom_members` SET `age`=? WHERE `id`=?';
      $data = array($age,$_SESSION['login_user']['id']);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $_SESSION['login_user']['age'] = $age;

      $registered_age = $age;
    }

    // プロフィール画像の登録処理とバリデーション
    require('../setting_function/profile_image_path_update_comfirm.php');

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
    <?php require('../child_icon.php');?>
    <title>旅にもつ</title>

     <?php require('../child_load_css.php'); ?>
    <link rel="stylesheet" type="text/css" href="../../assets/css/setting.css">

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

<div class="container">

<div class="row">
    <div class="col-xs-10 col-sm-8 col-md-8 col-xs-offset-1 col-sm-offset-2 col-md-offset-2 tabinimotsu_main_div" style="padding:0px 60px 30px 60px; margin-bottom: 50px; margin-top: 50px">

      <h2>会員情報設定</h2>
      <!-- <hr color="blue"> -->
      <hr>
      <form method="POST" action="" enctype="multipart/form-data">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
              <label style="font-size: 18px">アカウント名</label>
                <input type="text" name="account_name" id="first_name" class="form-control input-lg" placeholder="<?php if(isset($_SESSION['login_user']['account_name'])) {
                  echo $_SESSION['login_user']['account_name'];
                  } else{
                    echo "アカウント名";
                  }
                ?>" tabindex="1">
            </div>
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
              <label style="font-size: 18px">メールアドレス</label>
              <input type="email" name="email" id="last_name" class="form-control input-lg" placeholder="<?php if(isset($_SESSION['login_user']['email'])) {
                  echo $_SESSION['login_user']['email'];
                  } else{
                    echo "メールアドレス";
                  }
                ?>" tabindex="2">
              <?php if(isset($errors['email']) && $errors['email'] == 'duplicate'): ?>
                <div class="alert alert-danger">既に使用されているメールアドレスです</div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <hr>

        <div class="row" style="height: 88px">

              <div class="col-xs-12 col-md-4" style="margin-right: 0px;">
                <label style="font-size: 18px">パスワード</label>
                <input type="password" name="now_password" id="" style="margin: 5px 0px;" class="form-control input-lg" placeholder="現在のパスワード" tabindex="3"><br>
                <?php if(isset($errors['now_password']) && $errors['now_password'] == 'blank'): ?>
                  <div class="alert alert-danger">現在のパスワードを入力してください</div>
                <?php endif; ?>

                <?php if(isset($errors['now_password']) && $errors['now_password'] == 'mismatch'): ?>
                  <div class="alert alert-danger">パスワードが間違っています<br>もう一度入力してください</div>
                <?php endif; ?>
            </div>

            <div class="col-xs-12 col-lg-4" style="margin-right: 0px;">
              <label style="font-size: 18px">　　　　</label>
              <input type="password" name="new_password" id="password" class="form-control input-lg" placeholder="新しいパスワード" tabindex="4" style="margin: 5px 0px;">
              <?php if(isset($errors['new_password']) && $errors['new_password'] == 'length'): ?>
                <div class="alert alert-danger">８文字以上入力してください</div>
              <?php endif; ?>
            </div>

            <div class="col-xs-12 col-lg-4" style="margin-right: 0px">
              <label style="font-size: 18px">　　　　</label>
              <input type="password" name="comfirm_password" id="password_confirmation" class="form-control input-lg" placeholder="確認用パスワード" tabindex="5" style="margin: 5px 0px;">
              <?php if(isset($errors['comfirm_password']) && $errors['comfirm_password'] == 'length'): ?>
                <div class="alert alert-danger">８文字以上入力してください</div>
              <?php endif; ?>

              <?php if(isset($errors['comfirm']) && $errors['comfirm'] == 'mismatch'): ?>
                <div class="alert alert-danger">確認用パスワードが間違っています</div>
              <?php endif; ?>             
            </div>

        </div>

        <hr>

        <div class="row">
          <div class="col-xs-12 col-md-4 col-lg-4">
            <label style="font-size: 20px">性別 </label>
              <input type="hidden" name="gender">
              <label>
                <?php if(isset($registered_gender) && $registered_gender == '男性'): ?>
                  <input type="radio" name="gender" value="1" tabindex="6" style="margin-left: 5px" checked>男性
                <?php else: ?>
                  <input type="radio" name="gender" value="1" tabindex="6" style="margin-left: 5px">男性
                <?php endif; ?>
              </label>
              <label>
                <?php if(isset($registered_gender) && $registered_gender == '女性'): ?>
                  <input type="radio" name="gender" value="2" tabindex="6" style="margin-left: 5px" checked>女性
                <?php else: ?>
                  <input type="radio" name="gender" value="2" tabindex="6" style="margin-left: 5px">女性
                <?php endif; ?>
            </label>
          </div>
        </div>

        <hr>

        <div class="row" style="margin-bottom: 10px">
          <div class="col-lg-4">
            <label style="font-size: 20px">年齢</label>
            <select name="age">
            <?php if(!isset($registered_age)): ?>
              <option>選択してください</option>
            <?php endif; ?>
              <?php for($i = 10;$i <= 80;$i=$i+10): ?>
                <option value="<?php echo $i; ?>" <?php if(isset($registered_age) && $registered_age == $i): ?> selected <?php endif; ?>>
                  <?php if($i == 80): ?>
                    <?php echo $i; ?>代以上
                  <?php else: ?>
                    <?php echo $i; ?>代
                  <?php endif; ?>
                </option>
              <?php endfor; ?>
            </select>
          </div>
        </div>

        <hr>

        <div class="control-group">
          <div class="controls" style="padding-bottom: 10px">
            <?php if($_SESSION['login_user']['profile_image_path']): ?>
              <img class="media-object dp img-circle" src="../../../profile_image_path/<?php echo $_SESSION['login_user']['profile_image_path']; ?>" style="width: 80px;height:80px;">
            <?php else: ?>
                    <img class="media-object dp img-circle" src="../../assets/img/user_circle.png" style="width: 80px;height:80px;">
            <?php endif; ?>
              <input type="file" name="profile_image">
            <?php if(isset($errors['profile_image']) && $errors['profile_image'] == 'type'): ?>
              <div class="alert alert-danger">jpg png gif のいずれかの画像を挿入してください</div>
            <?php endif; ?>
            <!-- ログアウトボタン -->
            <div style="text-align: right;">

              <a href="../setting_function/logout.php" onClick="return confirm('ログアウトします。\nよろしいですか？')";>ログアウト</a>

            </div>
          </div>
        </div>

<!--           <div class="row">
            <div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-1 col-sm-offset-1">
             <strong class="label label-primary">登録</strong>をクリックすると、本サイトで設定されている<a href="#" data-toggle="modal" data-target="#t_and_c_m">利用規約</a>（Cookieの使用を含む）に同意したことになります。
            </div>
          </div> -->
      
        <!-- <hr color="blue"> -->
        <hr>
        <div class="row">
          <div class="col-xs-12 col-md-12"><input type="submit" value="登録" class="btn btn_atom btn-block btn-lg" tabindex="7"></div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
      </div>
      <!--<div class="modal-body">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
      </div>-->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</btton>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div><!-- container ends-->


    <?php require('../footer.php'); ?>
    <?php require('../child_load_js.php'); ?>

  </body>
</html>
