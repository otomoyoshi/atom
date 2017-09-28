<?php 
session_start();
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
    <link rel="stylesheet" type="text/css" href="../assets/css/feature.css">
 
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
<!--     <div class='single-item' style="padding-top: 50px;">
      <div>
        <img src="../assets/img/suitcase1 fixed.jpg" class="top_images center-block img-responsive">
      </div>
      <div>
        <img src="../assets/img/flower1 fixed.jpg" class="center-block img-responsive">
      </div> -->
      <!-- <div>
        <img src="../assets/img/flower2 fixed.jpg" class="center-block img-responsive">
      </div> -->

    </div>
    <div id="headerwrap">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 col-lg-offset-1" style="padding-bottom: 20px">
            <div class='single-item'>
              <div>
                <img src="../assets/img/suitcase1 fixed.jpg" class="center-block img-responsive">
              </div>
              <div>
                <img src="../assets/img/flower1 fixed.jpg" class="center-block img-responsive">
              </div>
              <div>
                <img src="../assets/img/kouyou1 fixed.png" class="center-block img-responsive">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- <div id="headerwrap"> -->
    <div class="container col-lg-10 col-lg-offset-1">
        <!-- <div class="row"> -->
          <!-- <div class="col-lg-12"> -->
<!--             <div class="row">

              <div class="col-lg-6">
                  <img src="../assets/img/beach.jpg" width="500" height="320" class="center-block img-responsive visible-sm visible-md visible-lg img_size">
              </div>

              <div class="col-lg-6">

                <div class="row">
                  <div class="col-lg-12" style="position: relative;">
                    <img src="../assets/img/Tabinimotsu_txt.png" style="width: 95%; height: auto; position: absolute; top: 40px;">
                    <h1 class="text-center" style="color: #ffffff;text-shadow: 0px 0px 10px rgba(255,255,255,1); padding-top: 50px">旅にもつ</h1><br>

                  </div>
                </div>

                <div class="row">

                  <div class="col-lg-12 font_cotent" style="color: #ffffff;text-shadow: 0px 0px 10px rgba(255,255,255,1)" > 本サービスでは検索機能と持ち物リスト作成機能を用いて、空港を利用し旅行の前の荷造りにかかる時間や労力を減らして、”旅行をより楽しく、快適なもの”にすることができます。
                  </div>
                </div>
              </div>
            </div> -->


            <div class="row" style="padding-bottom: 30px;">
              <div class="col-lg-6" >

                <div class="row">
                  <div class="col-lg-12" style="position: relative;">
                    <img src="../assets/img/search_function.png" style="width: 95%; height: auto; position: absolute; top: 25px;">
                    <h1 class="text-center" style="color: #ffffff;text-shadow: 0px 0px 10px rgba(255,255,255,1); padding-top: 30px">検索機能</h1><br>

                  </div>
                </div>
                  
                <div class="row">
                  <div class="col-lg-12" style="color: #ffffff;text-shadow: 0px 0px 10px rgba(255,255,255,1)">  
                    航空会社を選択し、検索窓に持っていきたい持ちものを入力して検索するだけで、持ち物が機内持ち込み可能か、お預け入れのみ可能かの判断と持ち込み条件を一目で確認することができます。さらに、このページから検索した持ち物を持ち物リストへ直接追加することができます。この機能により、自分だけの持ち物リストが自動で作成されます。
                  </div>
                </div> 

                <!--   <div class="col-lg-6">
                   hoge
                  </div>
                             -->

              </div>
              <div class="col-lg-6">

                <!-- <img src="../assets/img/home_search.png" width="500" height="320" class="center-block img-responsive visible-sm visible-md visible-lg img_size"> -->

<!--                               <img src="../assets/img/beach4.jpg" width="500" height="320" class="center-block img-responsive visible-sm visible-md visible-lg img_size"> -->
                <!-- スマホ画像投入 -->
                <img src="../assets/img/phone_home_v1_fix_v2.png" style="height: 300px; width: auto; margin: auto;" class="center-block img-responsive visible-sm visible-md visible-lg img_size">

              </div>

            </div>

            <div class="row">

              <div class="col-lg-6">
<!--                 <img src="../assets/img/beach.jpg" width="500" height="320" class="center-block img-responsive visible-sm visible-md visible-lg img_size"> -->
                <!-- スマホ画像投入 -->
                <img src="../assets/img/phone_list_fix.png" style="height: 300px; width: auto; margin: auto;" class="center-block img-responsive visible-sm visible-md visible-lg img_size">

              </div>

              <div class="col-lg-6 text_loc">

                <div class="row">
                  <div class="col-lg-12" style="position: relative;">
                    <img src="../assets/img/list_of_baggage.png " style="width: 95%; height: 100%; position: absolute; top: 40px;">
                    <h1 class="text-center" style="color: #ffffff;text-shadow: 0px 0px 10px rgba(255,255,255,1); padding-top: 46px">持ち物リスト作成</h1><br>

                  </div>
                </div>

                <div class="row "> 
                  <div class="col-lg-12 text_loc" style="color: #ffffff;text-shadow: 0px 0px 1   0px rgba(255,255,255,1)">    このページでは、自分だけの持ち物リストが作成できます。持ち込みたいアイテムを打ち込むと自動で分類してリストへ追加することができます。一時保存システムによって一度作業を中断しても途中から作業を続けることができ、持ち物リストをマイページへ保存することができます。

                   
                  </div>                  


                </div> 

              </div>

            </div>
          <!-- </div> -->
          <div class="row" style="padding-bottom: 50px">
            <div class="col-lg-offset-10">
              <p id="page-top"><a href="#wrap">PAGE TOP</a></p>
            </div>
          </div>
    </div>
    <!-- </div> -->




  <?php require('footer.php'); ?>
  <?php require('load_js.php'); ?>
  <script type="text/javascript">
    $(function() {
      var topBtn = $('#page-top');    
      topBtn.hide();
      //スクロールが100に達したらボタン表示
      $(window).scroll(function () {
          if ($(this).scrollTop() > 100) {
              topBtn.fadeIn();
          } else {
              topBtn.fadeOut();
          }
      });
      //スクロールしてトップ
      topBtn.click(function () {
          $('body,html').animate({
              scrollTop: 0
          }, 500);
          return false;
      });
  });
  </script>


  </body>
</html>
