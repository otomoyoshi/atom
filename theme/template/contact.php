<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../assets/img/favicon.png">

    <title>旅にもつ</title>
    <?php require('load_css.php'); ?>
    <link rel="stylesheet" type="text/css" href="../assets/css/contact.css">

  </head>

  <body>
    <!-- ログインをしてるときとそうでないときで読み込むヘッダを変える -->
  <?php
    $ini = parse_ini_file("config.ini");
    $is_login = $ini['is_login'];
    // $is_login = 0; //ログインしてるときを１とする（仮）
    if ($is_login) { //ログインしてるとき
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
          <div class="col-lg-12">
            <div class="row">
              <!-- <div class="col-lg-6" style="border: solid 1px black;"> -->

              <div class="col-md-12 col-lg-6 center-block">
                <!-- <h1 style="border: solid 1px black;">阪急電車</h1> -->

<!--                 <figure class="imghvr-push-up">
                  <img src="../assets/img/tabinimotsu_v1.png" style="height: 342px;">
                  <figcaption>
                    <h1 class="text-center">阪急電車</h1>
                    <h2 class="text-center">電車の乗客の人間関係にスポットを当てて進行していくストーリー。電車のように何度も会う関係ではないからこそ。</h2>
                  </figcaption>
                </figure> -->

                <h1 class="text-center your_name">阪急電車</h1>
                <h2 class="text-center your_name">電車の乗客の人間関係にスポットを当てて進行していくストーリー。電車のように何度も会う関係ではないからこそ、悩みを話せたりアドバイスを言えたりできるのかもしれないと感じた。とても心が温かくなる話。</h2>
              </div>

                <div class="col-md-12 col-lg-offset-1 col-lg-6 background_blue center-block"  id="border-space">
                <!-- <div class="col-lg-6 background_blue"  id="border-space" style="border: solid 1px black;"> -->
                  <section id="contact" class="content-section text-center">
                    <div class="contact-section">
                         <!--  <div class="row">
                            <div class="col-lg-8 col-md-offset-2"> -->
                            <form class="form-horizontal">
                              <form method="POST" action="">

                                <div class="form-group">
                                  <label for="exampleInputEmail2"><i class="fa fa-envelope-o"></i>メールアドレス</label>
                                  <input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">

                                    <?php if (isset($errors['email']) && $errors['email'] == 'blank') {?>
                                      <div class="alert alert-danger">メールアドレスを入力してください</div>
                                    <?php } ?>
                                                        <!-- </div>
                                <div class="form-group "> -->
                                  <label for="exampleInputText">お問い合わせ内容</label>
                                 <textarea  class="form-control" placeholder="メッセージをご記入ください"></textarea>

                                    <?php if (isset($errors['content']) && $errors['content'] == 'blank') { ?>
                                      <div class="alert alert-danger">お問い合わせ内容をご記入してください</div>

                                    <?php } ?>

                                    <?php if (isset($errors['content']) && $errors['content'] == 'length') { ?>
                                      <div class="alert alert-danger">お問い合わせ内容は5文字以上で入力してください</div>
                                    <?php } ?>


                                </div>
                                <button type="subm9it" class="btn btn-success">送信</button>
                              </form>
                            </form>
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
