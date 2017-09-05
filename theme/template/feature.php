<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    
    
    <title>旅にもつ</title>
    <?php require('load_css.php'); ?>
    <link rel="stylesheet" type="text/css" href="../assets/css/feature.css">

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

    <div id="headerwrap">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class='container'>
              <div class='single-item'>
                <div>
                  <img src="../assets/img/p01.png" class="center-block img-responsive">
                </div>
                <div>
                  <img src="../assets/img/p02.png" class="center-block img-responsive">
                </div>
                <div>
                  <img src="../assets/img/p03.png" class="center-block img-responsive">
                </div>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>


    <!-- <div id="headerwrap"> -->
    <div class="container">
        <!-- <div class="row"> -->
          <!-- <div class="col-lg-12"> -->
            <div class="row">

              <div class="col-lg-6">
                  <img src="../assets/img/beach.jpg" width="500" height="320" class="center-block img-responsive visible-sm visible-md visible-lg img_size">
              </div>

              <div class="col-lg-6">

                <div class="row">
                  <div class="col-lg-12" >   
                    <h2 class="text-center" style="color: #ffffff;text-shadow: 0px 0px 10px rgba(255,255,255,1)" >hoge</h2>
                  </div>
                </div>

                <div class="row">

                  <div class="col-lg-12" style="color: #ffffff;text-shadow: 0px 0px 10px rgba(255,255,255,1)" >   

                    Call your friends and family as often as you want,
                    for as long as you want!
                    Free international voice and video calls make it easy
                    to stay connected with your loved ones.
                    Call your friends and family as often as you want,
                    for as long as you want!
                    Free international voice and video calls make it easy
                    to stay connected with your loved ones.
                    all your friends and family as often as you want,
                    for as long as you want!
                    Free international voice and video calls make it easy
                    to stay connected with your loved ones.
                    all your friends and family as often as you want,
                    for as long as you want!
                    Free international voice and video calls make it easy
                    to stay connected with your loved ones.
                    Free international voice and video calls make it easy
                    to stay connected with your loved ones.
                    to stay connected with your loved ones.
                    to stay connected with your loved ones.


                  </div>                  


                </div> 

              </div>

            </div>


            <div class="row">
              <div class="col-lg-6" >

                <div class="row">
                  <div class="col-lg-12" >
                    <h2 class="text-center" style="color: #ffffff;text-shadow: 0px 0px 10px rgba(255,255,255,1)">hoge</h2>

                  </div>
                </div>
                  
                <div class="row">
                  <div class="col-lg-12" style="color: #ffffff;text-shadow: 0px 0px 10px rgba(255,255,255,1)">   
                    Call your friends and family as often as you want,
                    for as long as you want!
                    Free international voice and video calls make it easy
                    to stay connected with your loved ones.
                    Call your friends and family as often as you want,
                    for as long as you want!
                    Free international voice and video calls make it easy
                    to stay connected with your loved ones.
                    all your friends and family as often as you want,
                    for as long as you want!
                    Free international voice and video calls make it easy
                    to stay connected with your loved ones.
                    all your friends and family as often as you want,
                    for as long as you want!
                    Free international voice and video calls make it easy
                    to stay connected with your loved ones.
                    Free international voice and video calls make it easy
                    to stay connected with your loved ones.
                    to stay connected with your loved ones.
                    to stay connected with your loved ones.
                  </div>                  
                </div> 

                <!--   <div class="col-lg-6">
                   hoge
                  </div>
                             -->

              </div>
              <div class="col-lg-6">
                <img src="../assets/img/beach.jpg" width="500" height="320" class="center-block img-responsive visible-sm visible-md visible-lg img_size">
              </div>

            </div>

            <div class="row">

              <div class="col-lg-6">
                <img src="../assets/img/beach.jpg" width="500" height="320" class="center-block img-responsive visible-sm visible-md visible-lg img_size">
              </div>

              <div class="col-lg-6">

                <div class="row">
                  <div class="col-lg-12" ">   
                    <h2 class="text-center" style="color: #ffffff;text-shadow: 0px 0px 10px rgba(255,255,255,1)" >hoge</h2>

                  </div>
                </div>

                <div class="row"> 
                  <div class="col-lg-12" style="color: #ffffff;text-shadow: 0px 0px 30px rgba(255,255,255,1)">   

                   Call your friends and family as often as you want,
                    for as long as you want!
                    Free international voice and video calls make it easy
                    to stay connected with your loved ones.
                    Call your friends and family as often as you want,
                    for as long as you want!
                    Free international voice and video calls make it easy
                    to stay connected with your loved ones.
                    all your friends and family as often as you want,
                    for as long as you want!
                    Free international voice and video calls make it easy
                    to stay connected with your loved ones.
                    all your friends and family as often as you want,
                    for as long as you want!
                    Free international voice and video calls make it easy
                    to stay connected with your loved ones.
                    Free international voice and video calls make it easy
                    to stay connected with your loved ones.
                    to stay connected with your loved ones.
                    to stay connected with your loved ones.
                  </div>                  


                </div> 

              </div>

            </div>
          <!-- </div> -->
    </div>
    <!-- </div> -->




  <?php require('footer.php'); ?>
  <?php require('load_js.php'); ?>


  </body>
</html>
