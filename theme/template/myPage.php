<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/img/favicon.png">
    
    <title>旅にもつ</title>
  <?php require('../child_load_css.php'); ?>
  <link rel="stylesheet" type="text/css" href="../../assets/css/akihiro_mypage.css">

  </head>

  <body>
  <!-- ログインをしてるときとそうでないときで読み込むヘッダを変える -->
  <?php
    $ini = parse_ini_file("../config.ini");
    $is_login = $ini['is_login'];
    // $is_login = 1; //ログインしてるときを１とする（仮）
    if ($is_login) { //ログインしてるとき
      // echo "login success";
      require('../child_login_header.php');
    } else {// ログインしてないとき
      // echo "login fail";
      require('../child_header.php');
    }
  ?>

    <div id="headerwrap" style="padding-top: 100px">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
      <!-- 薄い白で囲まれてるメインのディブ -->
      <div class="col-md-8 col-sm-8 col-xs-10 col-md-offset-2 col-sm-offset-2 col-xs-offset-1 akihiro_main_div" style="margin-bottom: 50px">
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-8" style="padding-top: 20px">
                <div class="media">
                  <a class="pull-left" href="#">
                    <img class="media-object dp img-circle" src="https://pbs.twimg.com/profile_images/1653420268/DSC00234_bigger.JPG" style="width: 80px;height:80px;">
                  </a>
                  <div class="media-body">
                    <h3 class="mypage_username">User Nameくん</h3>
                  </div>
                </div>
              </div> 

          </div>

          <div>
            <hr color="blue">
          </div>

        </div>

        <!-- リスト全体 -->
          <div class="row">

                <!-- 追加ボタン -->
              <div class="col-md-4 col-sm-4">
                <div class="wrimagecard wrimagecard-topimage lists_margin">
                  <a href="#">
                    <div class="wrimagecard-topimage_header" style="background-color:rgba(255, 135, 0, 0.2); ">
                      <center><i class="fa fa-plus-square-o" style="color:rgba(255, 135, 0, 0.4);"></i></center>
                    </div>
                    <div class="wrimagecard-topimage_title_add">
                      <h4>新しく追加してね！</h4>
                    </div>
                  </a>
                </div>
              </div>

          <!-- 個々のリスト -->
          <?php for($i = 0;$i <= 4;$i++): ?>
            <div class="col-md-4 col-sm-4">
              <div class="wrimagecard wrimagecard-topimage lists_margin">
                  <a href="#">
                  <div class="wrimagecard-topimage_header" style="background-color: rgba(60, 216, 255, 0.2)">
                    <div class="row">

                      <div class="col-xs-7 col-md-7">
                        <h4 style="text-align: center; padding: 22px 0px 0px 20px">リスト <?php echo $i + 1; ?> </h4>
                      </div>
                      <div class="col-xs-3 col-md-3">
                        <i class = "fa fa-suitcase" style="color:rgba(0, 152, 255, 0.6)"></i>
                      </div>

                    </div>
                  </div>
                  <div class="wrimagecard-topimage_title">
                  <div>
              
                    <div class="container col-md-12">
                      <div class="row">
                        <button type="button" class="col-md-4 col-xs-4"><i class="glyphicon glyphicon-file"></i></button>
                        <button type="button" class="col-md-4 col-xs-4"><i class="glyphicon glyphicon-envelope"></i></button>
                        <button type="button" class="col-md-4 col-xs-4"><i class="glyphicon glyphicon-trash"></i></button>
                      </div>
                    </div>
                  </div>
                 </div>
                </a>
                </div>
              </div>
            <?php endfor; ?>
            </div>

          <div>
            <hr color="blue">
          </div>

          <div style="padding-bottom: 6px">
            <h5 style="text-align: right;">使い方がわからくなった方は<input type="button" name="how_to_use" class="fa fa-info" value="こちら">へ</h5>
          </div>

          </div>
        </div>
      </div>

  <?php require('../footer.php'); ?>
  <?php require('../child_load_js.php'); ?>

  </body>
</html>
