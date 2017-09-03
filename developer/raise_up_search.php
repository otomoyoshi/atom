<?php
    require('dbconnect.php');
    // session_start();


    // if (!isset($_SESSION["visited"])){
    //     print('初回の訪問です。セッションを開始します。');
    //     $_SESSION["visited"] = 1;
    // }elseif($_SESSION["visited"] >= 2){
    //     $_SESSION["visited"] == 0;

    //     header('Location: raise_up_search.php');
    //     exit();

    // } else {
    //     $visited = $_SESSION["visited"];
    //     $visited++;
    //     print('訪問回数は'.$visited.'です。<br>');

    //     $_SESSION["visited"] = $visited;
    // }


    $errors = array();
    $isJudge = array();
    $image_paths = array();
    $image_len = 0;

    foreach (glob('assets/img/*') as $file) {
      if(is_file($file)){
      $image_paths[] = $file;
      }
    }
    $image_len = count($image_paths)-1;
    // echo $image_len;
    // echo var_dump($image_paths);


    $word = '';
    $conditions = '';
    $judgeTT = '';
    $judgeTF = '';
    $judgeFT = '';
    $judgeFF = '';
    $classify = '';
    $encourage = '';
    $encourages = array('頑張ろう',
                        'ありがとう',
                        'もっとやれ',
                        '君の未来は安泰だ',
                        '打て打て',
                        '打つまで寝るな',
                        '自分自身を信じてみるだけでいい。きっと、生きる道が見えてくる。-ゲーテ-',
                        );


    if(!empty($_POST)){

      // if($count() >= 2) {
      //   header('Location: raise_up_search.php');
      //   exit();
      // }

      // 入力欄の値が空か判定
      $word = $_POST['word'];
      $conditions = $_POST['conditions'];
      $judgeTT = $_POST['judgeTT']; //機内 ◯　預入荷物 ×
      $judgeTF = $_POST['judgeTF'];
      $judgeFT = $_POST['judgeFT'];
      $judgeFF = $_POST['judgeFF'];
      $classify = $_POST['classify'];

      if($word == '') {
        $errors['word'] = 'blank';
      }
      if($conditions == '') {
        $errors['conditions'] = 'blank';
      }
      if($judgeTT == '') {
        $isJudge['judgeTT'] = 'blank';
      }
      if($judgeTF == '') {
        $isJudge['judgeTF'] = 'blank';
      }
      if($judgeFT == '') {
        $isJudge['judgeFT'] = 'blank';
      }
      if($judgeFF == '') {
        $isJudge['judgeFF'] = 'blank';
      }
      if($classify == '') {
        $errors['classify'] = 'blank';
      }

      if(empty($errors) && empty($isJudge)){
          if($encourage == ''){
            $encourage = 'blank';
          }


      }


    }


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/img/favicon.png">

    <title>検索エンジンを育てよう</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- Fonts from Google Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>
	<!-- 追加css -->

    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  <div class="conteiner">
    <div class="row">
        <div class="col-lg-12 text-center">
          <h1>みんなで検索エンジンを育てよう！目指せ1000件</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-center">
          <form method="POST" action="">
          <div class="input-group col-lg-6 col-lg-offset-3">
            <span class="input-group-addon">単語</span>
            <input type="text" class="form-control" name="word" value="<?php echo $word ?>">
          </div>
            <!-- 単語：<br><input type="text" name="word" value="<?php echo $word ?>"><br> -->
            <?php if(isset($errors['word'])){ ?>
              <p class="alert alert-danger">入力してください</p><br>
            <?php } ?>

            <!-- 条件：<br><input type="text" name="conditions" value="<?php echo $conditions ?>"><br> -->
          <div class="input-group col-lg-6 col-lg-offset-3">
            <span class="input-group-addon">条件</span>
            <input type="text" class="form-control" name="conditions" value="<?php echo $conditions ?>">
          </div>

            <?php if(isset($errors['conditions'])){ ?>
              <p class="alert alert-danger">入力してください</p><br>
            <?php } ?>

          <div class="input-group col-lg-6 col-lg-offset-3">
            <span class="input-group-addon"> True  : ◯<br>False : ✖️</span>
            <input type="text" class="form-control" name="judgeTT" value="<?php echo $judgeTT ?>">
          </div>
            <!-- True or False：<br><input type="text" name="judge" value="<?php echo $judge ?>"><br> -->

            <?php if(isset($isJudge['judgeTT'])){ ?>
              <p class="alert alert-info">入力してください</p><br>
            <?php } ?>

          <div class="input-group col-lg-6 col-lg-offset-3">
            <span class="input-group-addon"> True  : ◯<br>False : ✖️</span>
            <input type="text" class="form-control" name="judgeTF" value="<?php echo $judgeTF ?>">
          </div>
            <!-- True or False：<br><input type="text" name="judge" value="<?php echo $judge ?>"><br> -->

            <?php if(isset($isJudge['judgeTF'])){ ?>
              <p class="alert alert-info">入力してください</p><br>
            <?php } ?>

          <div class="input-group col-lg-6 col-lg-offset-3">
            <span class="input-group-addon"> True  : ◯<br>False : ✖️</span>
            <input type="text" class="form-control" name="judgeFT" value="<?php echo $judgeFT ?>">
          </div>
            <!-- True or False：<br><input type="text" name="judge" value="<?php echo $judge ?>"><br> -->

            <?php if(isset($isJudge['judgeFT'])){ ?>
              <p class="alert alert-info">入力してください</p><br>
            <?php } ?>

          <div class="input-group col-lg-6 col-lg-offset-3">
            <span class="input-group-addon"> True  : ◯<br>False : ✖️</span>
            <input type="text" class="form-control" name="judgeFF" value="<?php echo $judgeFF ?>">
          </div>
            <!-- True or False：<br><input type="text" name="judge" value="<?php echo $judge ?>"><br> -->

            <?php if(isset($isJudge['judgeFF'])){ ?>
              <p class="alert alert-info">入力してください</p><br>
            <?php } ?> 

            <!-- 分類：<br><input type="text" name="classify" value="<?php echo $classify ?>"><br> -->
          <div class="input-group col-lg-6 col-lg-offset-3">
            <span class="input-group-addon">分類</span>
            <input type="text" class="form-control" name="classify" value="<?php echo $classify ?>">
          </div>

            <?php if(isset($errors['classify'])){ ?>
              <p class="alert alert-danger">入力してください</p><br>
            <?php } ?>

            <input type="submit" class="btn btn-info" value="気力を注入">

            <?php if(!empty($encourage)) { ?>
              <p class="alert alert-danger">ファイナルアンサー</p><br>
              <input type="submit" class="btn btn-danger" value="送信">
            <?php } ?>
          </form>

          <?php if(!empty($encourage)) { ?>
            <div class="row">
              <div class="col-lg-12 text-center">

                <h2><?php echo $encourages[rand(0, count($encourages)-1)]; ?></h2>
                <!-- <?php echo rand(0, $image_len); ?> -->
                <img src="<?php echo $image_paths[rand(0, $image_len)]; ?>" class="img-circle">
              </div>
            </div>
          <?php } ?>


        </div>
    </div>

  </div>





    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>
