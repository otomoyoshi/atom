<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <?php require('load_css.php'); ?>
    <link rel="stylesheet" type="text/css" href="../assets/css/sign_in.css">

  </head>
  <body>
    <?php require('header.php'); ?>

    <div id="headerwrap">
      <div class="container">
        <div class="row">
          <div class="col-xs-offset-1 col-lg-5 title_show">旅にもつ</div>
        </div>
        <div class="row">
          <div class="col-xs-offset-1 col-lg-5 explain">

          </div>
          <div class="col-lg-offset-7 flame">
            <div class="row">
              <div class="col-lg-12">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="text-center text_loc">
                        <label>メールアドレス ※</label><br>
                        <input type="email" name="email"　placeholder="アカウント名">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="text-center text_loc">
                      <label>パスワード ※</label><br>
                      <input type="password" name="password" >
                      <?php if (isset($errors['password']) && $errors['password'] == 'mistake') {?>
                      <div class="alert alert-danger">メールアドレス・もしくはパスワードが間違っています</div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
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
                     <input type="submit" value="新規作成" class="btn btn-success" >
                    </div>
                  </div>
                </div>         
              </div>
            </div>    
          </div>
        </div>
      </div>
    </div>
    <?php require('footer.php'); ?>
    <?php require('load_js.php'); ?>

  </body>
</html>
