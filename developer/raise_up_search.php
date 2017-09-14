<?php
    require('dbconnect.php');
    session_start();

    $errors = array();
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
    $condition = '';
    $condition_azukeire = '';
    $condition_per_person = '';
    $condition_per_container='';
    $judge = 'default';
    $judge_blank = '';
    $classify = 'default';
    $classify_blank = '';
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
      if(isset($_POST['word'])){
        $word = $_POST['word'];
      }
      if(isset($_POST['condition'])){
        $condition = $_POST['condition'];
      }
      if(isset($_POST['condition_azukeire'])){
        $condition_azukeire = $_POST['condition_azukeire'];
      }
      if(isset($_POST['condition_per_person'])){
        $condition_per_person = $_POST['condition_per_person'];
      }
      if(isset($_POST['condition_container'])){
        $condition_container = $_POST['condition_container'];
      }

      if(isset($_POST['judge'])){
        $judge = $_POST['judge'];
        $judge_blank = "judge";
      }

      if(isset($_POST['classify'])){
        $classify = $_POST['classify'];
        $classify_blank = "classify";
      }

      if($word == '') {
        $errors['word'] = 'blank';
      }
      // if($condition == '') {
      //   $errors['condition'] = 'blank';
      // }
      // if($condition_azukeire == '') {
      //   $errors['condition_azukeire'] = 'blank';
      // }
      if($judge_blank == '') {
        $errors['judge_blank'] = 'blank';
      }
      if($classify_blank == '') {
        $errors['classify_blank'] = 'blank';
      }
      // echo var_dump($errors);
      if(empty($errors)){ //全て入力が存在したとき
        // echo "hello";
        if (isset($_POST['result'])){
            $encourage = 'encourage';
            // echo $judge;
            // echo $word . $condition . $condition_azukeire . $judge . $classify;
            $sql = 'INSERT INTO `atom_searchs`(`word`, `condition_carry_in`, `condition_azukeire`, `created`, `aviation_id`, `categories_l2_id`, `baggage_classify`, `per_container`, `per_person`) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?)';
            $data = array($word,$condition, $condition_azukeire, 1, $classify, $judge, $condition_per_container, $condition_per_person);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
            // echo var_dump($stmt);
        }

        if(isset($_POST['delete'])){

            $sql = 'DELETE FROM `atom_searchs` WHERE `word`=?';
            $data = array($word);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
            header('Location: raise_up_search.php');
            exit();
        }
      }


      }
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="shortcut icon" href="assets/img/favicon.png"> -->
    <link rel="shortcut icon" href="../theme/assets/img/tabinimotsu_v1.png">
    <title>検索エンジンを育てよう</title>

    <link rel="stylesheet" type="text/css" href="../theme/assets/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="../theme/assets/css/main.css">
	 <link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>
   <!-- <script type="text/javascript" src="check.js"></script> -->
   <script type="text/javascript" src="../theme/assets/js/jquery-3.1.1.js"></script>
  </head>
  <body>
    <div class="conteiner">
      <div class="row">
          <div class="col-lg-12 text-center">
            <h1>みんなで検索エンジンを育てよう！目指せ1000件</h1>
            <h2>階層3用</h2>
          </div>
      </div>
      <!-- <div class="row"> -->
          <!-- <div class="col-lg-12"> -->

      <form method="POST" action="" class="form-horizontal">
        <div class="row">
          <div class="col-xs-offset-2 col-xs-8 col-lg-offset-3 col-lg-6">
            <div class="form-group text-center">
              <div class="input-group">
                <?php if($encourage == 'encourage') { ?>
                <input type="submit" class="btn btn-danger" value="今の登録を削除" onclick="return confirm('確認してね?');" name="delete"><br>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-offset-2 col-xs-8 col-lg-offset-3 col-lg-6">
            <div class="form-group block-center">
              <div class="input-group">
              <!-- <div class="input-group col-lg-6 col-lg-offset-3"> -->

                <span class="input-group-addon">単語</span>
                <input type="text" class="form-control" name="word" value="<?php echo $word ?>">
              </div>
                <!-- 単語：<br><input type="text" name="word" value="<?php echo $word ?>"><br> -->
              <?php if(isset($errors['word'])){ ?>
                <p class="alert alert-danger">入力してください</p><br>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-offset-2 col-xs-8 col-lg-offset-3 col-lg-6">
            <div class="form-group">
                <div class="input-group">
                <?php for($i=0; $i < 4; $i++) { ?>
                  <? if(isset($judge) && $i == $judge && $judge != 'default') { ?>
                    <label class="radio-inline"><? echo $category[$i]; ?><input type="radio" name="judge" value="<?php echo $i;?>" checked></label>
                  <?php } else { ?>
                    <label class="radio-inline"><? echo $category[$i]; ?><input type="radio" name="judge" value="<?php echo $i;?>"></label>
                  <?php } ?>
                <?php } ?>
                </div>

              <?php if(isset($errors['judge_blank']) && $judge == 'default'){ ?>
                <p class="alert alert-danger">入力してください</p><br>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-group">
            <div class="col-xs-offset-2 col-xs-8 col-lg-offset-3 col-lg-6">
              <div class="input-group">
                <?php for($i=0; $i < 8; $i++) { ?>
                  <? if(isset($classify) && $i == $classify && $classify != 'default') { ?>
                    <label class="radio-inline">分類<?php echo $i+1 ?><input type="radio" name="classify" value="<?php echo $i+1;?>" checked></label>
                  <?php } else { ?>
                    <label class="radio-inline">分類<?php echo $i+1 ?><input type="radio" name="classify" value="<?php echo $i+1;?>"></label>
                  <?php } ?>
                <?php } ?>
              </div>
            </div>

            <?php if(isset($errors['classify_blank']) && $classify == 'default') { ?>
              <p class="alert alert-danger">入力してください</p><br>
            <?php } ?>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-offset-2 col-xs-8 col-lg-offset-3 col-lg-6">
            <div class="form-group">
              <!-- 条件：<br><input type="text" name="condition" value="<?php echo $condition ?>"><br> -->
              <div class="input-group">
                <span class="input-group-addon">持ち込み条件</span>
                <input type="text" class="form-control" name="condition" value="<?php echo $condition; ?>">
              </div>

              <?php if(isset($errors['condition'])){ ?>
                <p class="alert alert-danger">入力してください</p><br>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-offset-2 col-xs-8 col-lg-offset-3 col-lg-6">
            <div class="form-group">
              <!-- 条件：<br><input type="text" name="condition" value="<?php echo $condition ?>"><br> -->
              <div class="input-group">
                <span class="input-group-addon">お預け入れ条件</span>
                <input type="text" class="form-control" name="condition_azukeire" value="<?php echo $condition_azukeire; ?>">
              </div>

              <?php if(isset($errors['condition_azukeire'])){ ?>
                <p class="alert alert-danger">入力してください</p><br>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-offset-2 col-xs-8 col-lg-offset-3 col-lg-6">
            <div class="form-group">
              <!-- 条件：<br><input type="text" name="condition" value="<?php echo $condition ?>"><br> -->
              <div class="input-group">
                <span class="input-group-addon">1容器あたりの条件</span>
                <input type="text" class="form-control" name="condition_per_container" value="<?php echo $condition_per_container; ?>">
              </div>

              <?php if(isset($errors['condition_container'])){ ?>
                <p class="alert alert-danger">入力してください</p><br>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-offset-2 col-xs-8 col-lg-offset-3 col-lg-6">
            <div class="form-group">
              <!-- 条件：<br><input type="text" name="condition" value="<?php echo $condition ?>"><br> -->
              <div class="input-group">
                <span class="input-group-addon">1人あたりの条件</span>
                <input type="text" class="form-control" name="condition_per_person" value="<?php echo $condition_per_person; ?>">
              </div>

              <?php if(isset($errors['condition_per_person'])){ ?>
                <p class="alert alert-danger">入力してください</p><br>
              <?php } ?>
            </div>
          </div>
        </div>

        <!--  結果表示 -->
        <div class="row block-center">
          <div class="col-xs-offset-2 col-xs-8 col-lg-offset-3 col-lg-6">
            <div class="form-group">
              <!-- <input type="submit" class="btn btn-info" value="気力を注入" id="check_btn"> -->
              <div class="input-group col-lg-6 col-lg-offset-3 text-center">
              <?php if($encourage != 'encourage') { ?>
                <input type="submit" class="btn btn-info" value="気力を注入" onclick="return confirm('確認してね?');" name="result">
              <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </form>
        <!-- </div> -->
      <!-- </div> -->

      <?php if($encourage == 'encourage') { ?>
        <div class="row">
          <div class="col-xs-offset-2 col-xs-8 col-lg-offset-3 col-lg-6">
          <a href="raise_up_search.php" class="btn btn-success">次の入力へ</a>
          <h2><?php echo $encourages[rand(0, count($encourages)-1)]; ?></h2>
            <!-- <?php echo rand(0, $image_len); ?> -->
            <img src="<?php echo $image_paths[rand(0, $image_len)]; ?>" class="img-circle" style="width:auto; height: 320px;">
          </div>
        </div>
      <?php } ?>
          <!-- </div> -->
      <!-- </div> -->
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../theme/assets/js/bootstrap.min.js"></script>
  </body>
</html>