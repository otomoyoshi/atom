<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../assets/img/favicon.png">


      <!-- <div class="center-block"> -->
 
       <!--  <div  style="color: #ffffff;text-shadow: 0px 0px 10px rgba(255,255,255,1)" >
          旅にもつ
        </div> -->
        
    </div>
    <?php require('load_css.php'); ?>
    <link rel="stylesheet" type="text/css" href="../assets/css/sign_up.css">


  </head>
  <body>
  <?php require('header.php'); ?>
  <!-- ここから変更する -->
<br>
<br>
<br>
<br>

 

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
          いろいろなスライダー・カルーセルjQueryプラグインを利用してみて、一番簡単でカスタマイズ性に富んだものがこのslickです。非常に便利な分、注意しなければならないこともあるので、その点も含めて紹介したいと思います。
          まとめまとめまとめ。
          </div>
        </div>

      </div>

  <form method="POST" action="">
      <div class="col-lg-5 background_white" id="space"> 
        <div class="row">
          <div class="col-lg-12">
            
             <div class="text-center">


              <label><i class="fa fa-user" aria-hidden="true"></i>アカウント名 </label><br> 
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
              <label><i class="fa fa-envelope-o"></i>メールアドレス </label><br>
                <input type="mail" name="mail" placeholder="tabi@example.com">

              <?php if (isset($errors['login'])){ ?>
              <span style="color:red:">メールアドレスとパスワードを入力してください</span>


              <?php } ?>
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
                <div class="alert alert-danger">パスワードは4文字以上で入力してください</div>
              <?php } ?>
            </div>
          </div>
        </div>

        <br>
        <div class="row">
          <div class="col-lg-12">
            <div class="text-center">
              <label><i class="fa fa-unlock-alt" aria-hidden="true"></i>パスワード確認用 </label><br>
              <input type="password" name="password">
              <?php if (isset($errors['comfirmpassword']) && $errors['comfirmpassword'] == 'blank') {?>
              <div class="alert alert-danger">パスワードを入力してください</div>
              <?php } ?>

              <?php if (isset($errors['comfirmpassword']) && $errors['comfirmpassword'] == 'length') {?>
                <div class="alert alert-danger">パスワードは4文字以上で入力してください</div>
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

</form>
<!-- ここまで変更する -->

  <?php require('footer.php'); ?>
  <?php require('load_js.php'); ?>

  </body>
</html>
