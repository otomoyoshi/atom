<?php
    require('dbconnect.php');
    session_start();


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


      if(!empty($_SESSION['blank'])) {
            $_SESSION['blank'] = '';
            header('Location: raise_up_search.php');
            exit();
      }

    $errors = array();
    $isJudge = array();
    $image_paths = array();
    $image_len = 0;

    foreach (glob('../theme/assets/img/*') as $file) {
      if(is_file($file)){
      $image_paths[] = $file;
      }
    }
    $image_len = count($image_paths)-1;
    // echo $image_len;
    // echo var_dump($image_paths);


    $word = '';
    $conditions = '';
    $judge = '';
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
    $category = array('両方可能',
                      '機内持ち込み可能',
                      'お預け可能',
                      '持ち込みできない');


    if(!empty($_POST)){
      // 入力欄の値が空か判定
      $word = $_POST['word'];
      $conditions = $_POST['conditions'];

      if(isset($_POST['judge'])){
        $judge = $_POST['judge'];
      }

      if(isset($_POST['classify'])){
        $classify = $_POST['classify'];
      }

      if($word == '') {
        $errors['word'] = 'blank';
      }
      if($conditions == '') {
        $errors['conditions'] = 'blank';
      }
      if($judge == '') {
        $errors['judge'] = 'blank';
      }
      if($classify == '') {
        $errors['classify'] = 'blank';
      }



      if(empty($errors)){

          $result = '<script type="text/javascript">document.write(confirm("本当に登録しても良いですか？ もう一度確認よろしく"));</script>';
          // echo $result;
          if($result == true) {
              $encourage = 'blank';
              $_SESSION['encourage'] = 'blank';
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

    <link rel="stylesheet" type="text/css" href="../theme/assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../theme/assets/css/main.css">
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>

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

          <div class="input-group col-lg-6 col-lg-offset-3 text-left">
          <?php for($i=0; $i < 4; $i++) { ?>
            <label class="radio-inline"><? echo $category[$i]; ?><input type="radio" name="judge" value="<?php echo $category[$i];?>"></label>
            <?php } ?>
          </div>

          <?php if(isset($errors['judge'])){ ?>
            <p class="alert alert-danger">入力してください</p><br>
          <?php } ?>

          <div class="input-group col-lg-6 col-lg-offset-3 text-left">
            <?php for($i=0; $i < 8; $i++) { ?>
            <label class="radio-inline">分類<?php echo $i ?><input type="radio" name="classify" value="<?php echo $i;?>"></label>
            <?php } ?>
          </div>

            <?php if(isset($errors['classify'])){ ?>
              <p class="alert alert-danger">入力してください</p><br>
            <?php } ?>

            <input type="submit" class="btn btn-info" value="気力を注入">

          </form>

          <?php if(!empty($encourage)) { ?>
            <div class="row">
              <div class="col-lg-12 text-center">
                <h2><?php echo $encourages[rand(0, count($encourages)-1)]; ?></h2>
                <!-- <?php echo rand(0, $image_len); ?> -->
                <img src="<?php echo $image_paths[rand(0, $image_len)]; ?>" class="img-circle" style="width:auto; height: 320px;">
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
    <script src="../theme/assets/js/bootstrap.min.js"></script>
  </body>
</html>
