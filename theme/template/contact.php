<?php 

session_start();


// bool mb_send_mail(string $to, string $subject, string $message[, string $headers[, string $headers ]])

$email ='';
$content='';
$errors = array ();


//送信ボタンが押されたとき
if (!empty($_POST)) {

  $email = $_POST['email'];
  $content = $_POST['content'];
  // $to = $_POST['to'];
  




  if ($email == '') {
    $errors['email'] = 'blank';
    # code...
  }

  if ($content == '') {
      $errors['content'] = 'blank';
      # code...
    }elseif (strlen($content) < 5 ) {
      $errors['content'] = 'length';
      # code...
    }

  // if (mb_send_mail($to, $subject, $content, $header)) {
  //  echo "メールを送信しました";
  //   } else {
  //   echo "メールの送信に失敗しました";
  //   }   
  //   # code...
  }

    // メール送信機能実装
    require('contact_function/phpmailer.php');




 ?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php require('icon.php'); ?>

    <title>旅にもつ</title>
    <?php require('load_css.php'); ?>
    <link rel="stylesheet" type="text/css" href="../assets/css/contact.css">

  </head>

  <body>
    <!-- ログインをしてるときとそうでないときで読み込むヘッダを変える -->
  <?php
    // $ini = parse_ini_file("config.ini");
    // $is_login = $ini['is_login'];
    // $is_login = 0; //ログインしてるときを１とする（仮）
    if (isset($_SESSION['login_user'])) { //ログインしてるとき
      // echo "login success";
      require('login_header.php');
    } else {// ログインしてないとき
      // echo "login fail";
      require('header.php');
    }
  ?>

  <!-- <div style="border: solid 1px black;"> -->
    <div id="headerwrap">
      <div class="container">
        <div class="row" id="adjustment">
          <!-- <div class="col-lg-12" style="border: solid 1px black;"> -->
          <div class="col-lg-12" style="margin-top: 20px">
<div class="row text_loc">
  <div class="col-lg-12 text-center"><i class="fa fa-envelope-o" style="font-size: -webkit-xxx-large;"></i></div>
</div>

            <div class="row">
                <div class="col-md-12 col-lg-offset-3 col-lg-6 background_blue"  id="border-space">
                <div class="col-lg-12 text_loc text_left">お客様からのお問い合わせをお受けしています</div>
                <!-- <div class="col-lg-6 background_blue"  id="border-space" style="border: solid 1px black;"> -->
                  <section id="contact" class="content-section text-center">
                    <div class="contact-section">
                         <!--  <div class="row">
                            <div class="col-lg-8 col-md-offset-2"> -->
                            <!-- <form class="form-horizontal"> -->
                              <!-- <form method="POST" action="mailto:maho.atom@gmail.com"> -->
                              <form method="POST" action="">

                                <div class="form-group">
                                  <!-- <label for="exampleInputEmail2">メールアドレス</label> -->
                                  <input type="email" name="email" class="form-control" id="exampleInputEmail2" placeholder="メールアドレス" maxlength="50" autofocus>

                                    <?php if (isset($errors['email']) && $errors['email'] == 'blank') {?>
                                      <div class="alert alert-danger">メールアドレスを入力してください</div>
                                    <?php } ?>
                                                        <!-- </div>
                                <div class="form-group "> -->


                                <br>

                                  <!-- <label for="exampleInputText">お問い合わせ内容</label> -->
                                 <textarea name="content" class="form-control" placeholder="メッセージをご記入ください" maxlength="1000"></textarea>

                                    <?php if (isset($errors['content']) && $errors['content'] == 'blank') { ?>
                                      <div class="alert alert-danger">お問い合わせ内容をご記入してください</div>
                                    <?php } ?>

                                    <?php if (isset($errors['content']) && $errors['content'] == 'length') { ?>
                                      <div class="alert alert-danger">お問い合わせ内容は5文字以上で入力してください</div>
                                    <?php } ?>


                                </div>

                                <br>

                                <button type="submit" class="btn btn_atom">送信</button>



                              </form>
                            <!-- </form> -->
                            <!-- </div>
                          </div> -->
                        <!-- </div> -->
                    </div>
                  </section>
                </div>

            </div>
          </div>
        </div>
      </div>
    </div>

  <!-- </div> -->



  <?php require('footer.php'); ?>
  <?php require('load_js.php'); ?>

  </body>
</html>
