<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../assets/img/favicon.png">

    <title>旅にもつ</title>
    <?php require('load_css.php'); ?>

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
    <div class="row">
      <div class="col-xs-offset-1 col-lg-5" style=" font-size: 100px;">旅にもつ</div>
    </div>
    <div class="row">
      <div class="col-xs-offset-1 col-lg-5" style="border: double 1px red; font-size: 30px;">

      いろいろなスライダー・カルーセルjQueryプラグインを利用してみて、一番簡単でカスタマイズ性に富んだものがこのslickです。非常に便利な分、注意しなければならないこともあるので、その点も含めて紹介したいと思います。
      まとめまとめまとめ。
      </div>
      <div class="col-lg-offset-7">
        <div style="border: solid 1px blue; background-color: rgba(200,223,200,0.7); padding: 50px" class="row">
          <div class="col-lg-12">
            <div class="row">
              <div class="col-lg-12">
                
                 <div class="text-center">
                  <label>アカウント名</label><br> 

                  <input type="acountname" name="acountname">
                  <?php if (isset($errors['acountname']) && $errors['acountname'] == 'blank') {?>
                  <div class="alert alert-danger">アカウント名を入力してください</div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
               <div class="text-center">
                  <label>メールアドレス</label><br>
                  <input type="email" name="email"><br>
                  <?php if (isset($errors['login'])){ 
                    # code...
                   ?>
                  <span style="color:red:">メールアドレスとパスワードを入力してください</span>


                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
               <div class="text-center">
                    <label>パスワード</label><br>
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
              <div class="col-lg-12">
                <div class="text-center">
                  <label>パスワード確認用</label><br>
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
              <div class="col-lg-12">
                <br>
                <br>
                <div class="text-center">
                 <input type="submit" value="新規作成" class="btn btn-info" >
                </div>
              </div>
            </div>         
          </div>
        </div>    
      </div>
    </div>


  </div>
</div>


<!-- ここまで変更する -->

  <?php require('footer.php'); ?>
  <?php require('load_js.php'); ?>

  </body>
</html>
