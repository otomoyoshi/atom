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
    <!-- ログインをしてるときとそうでないときで読み込むヘッダを変える -->

  <?php
    $ini = parse_ini_file("../config.ini");
    $is_login = $ini['is_login'];
    // echo "is_login : " . $is_login;
    // $is_login = 0; //ログインしてるときを１とする（仮）
    if ($is_login == 1) { //ログインしてるとき1
      // echo "login success";
      require('../child_login_header.php');
    } else {// ログインしてないとき0
      // echo "login fail";
      require('../child_header.php');
    }
  ?>

<br>
<br>
<br>
<br>

 

<div id="headerwrap">
  <div class="container">
    <div class="row" id="adjustment">

      <div class="col-lg-6">
         <div class="row">
            <div class="col-lg-12 font_title">旅にもつ</div>
        </div>

        <div class="row">
          <div class="col-lg-12 font_content">
          いろいろなスライダー・カルーセルjQueryプラグインを利用してみて、一番簡単でカスタマイズ性に富んだものがこのslickです。非常に便利な分、注意しなければならないこともあるので、その点も含めて紹介したいと思います。
          まとめまとめまとめ。
          </div>
        </div>

      </div>


      <div class="col-lg-6 background_white" id="space"> 
        <div class="row">
          <div class="col-lg-12">
            
             <div class="text-center">
              <label>アカウント名 ※</label><br> 
              <input type="acountname" name="acountname" placeholder="アカウント名">
              <?php if (isset($errors['acountname']) && $errors['acountname'] == 'blank') {?>
              <div class="alert alert-danger">アカウント名を入力してください</div>
              <?php } ?>
            </div>
          </div>
        </div>


        <br>
        <div class="row">
          <div class="col-lg-12">
           <div class="text-center">
              <label>メールアドレス ※</label><br>
                <input type="mail" name="mail" placeholder="tabi@example.com">

              <?php if (isset($errors['login'])){ 
                # code...
               ?>
              <span style="color:red:">メールアドレスとパスワードを入力してください</span>


              <?php } ?>
            </div>
          </div>
        </div>


        <br>
        <div class="row">
          <div class="col-lg-12">
           <div class="text-center">
                <label>パスワード ※</label><br>
              <input type="password" name="password" >
              <?php if (isset($errors['password']) && $errors['password'] == 'blank') {?>
              <div class="alert alert-danger">パスワードを入力してください</div>
              <?php } ?>

              <?php if (isset($errors['password']) && $errors['password'] == 'length') {?>
                <div class="alert alert-danger">パスワードは4文字以上で入力してください</div>
              <?php } ?>
            </div>
          </div>
        </div>

        <br>
        <div class="row">
          <div class="col-lg-12">
            <div class="text-center">
              <label>パスワード確認用 ※</label><br>
              <input type="password" name="password">
              <?php if (isset($errors['password']) && $errors['password'] == 'blank') {?>
              <div class="alert alert-danger">パスワードを入力してください</div>
              <?php } ?>

              <?php if (isset($errors['password']) && $errors['password'] == 'length') {?>
                <div class="alert alert-danger">パスワードは4文字以上で入力してください</div>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12 text-center">
            ※は必須項目です
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
    </div>         
  </div>
</div>


<!-- ここまで変更する -->

  <?php require('../footer.php'); ?>
  <?php require('../child_load_js.php'); ?>

  </body>
</html>
