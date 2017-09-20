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
    // $condition = '';
    // $condition_azukeire = '';
    // $judge = 'default';
    // $judge_blank = '';
    $classify = 'default';
    $classify_blank = '';
    $res = 'default';
    $res_blank = '';
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
      // if(isset($_POST['condition'])){
      //   $condition = $_POST['condition'];
      // }
      // if(isset($_POST['condition_azukeire'])){
      //   $condition_azukeire = $_POST['condition_azukeire'];
      // }

      if(isset($_POST['judge'])){
        $judge = $_POST['judge'];
        $judge_blank = "judge";
      }

      if(isset($_POST['classify'])){
        $classify = $_POST['classify'];
        $classify_blank = "classify";
      }

      if(isset($_POST['res'])){
        $res = $_POST['res'];
        $res_blank = "res";
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
      // if($judge_blank == '') {
      //   $errors['judge_blank'] = 'blank';
      // }
      if($classify_blank == '') {
        $errors['classify_blank'] = 'blank';
      }
      if($res_blank == '') {
        $errors['res_blank'] = 'blank';
      }
      // echo var_dump($errors);
      if(empty($errors)){ //全て入力が存在したとき
        // echo "hello";
        if (isset($_POST['result'])){
            $encourage = 'encourage';
            // echo $judge;
            // echo $word . $classify;
            $sql = 'INSERT INTO `atom_categories_l2`(`category_l2`, `category_l1_id`, `result`) VALUES (?, ?, ?)';
            $data = array($word, $classify, $res);
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
            <h2>階層２用</h2>
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

                <span class="input-group-addon">分類名</span>
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
          <div class="form-group">
            <div class="col-xs-offset-2 col-xs-8 col-lg-offset-3 col-lg-6">
              <div class="input-group">
                <?php for($i=0; $i < 9; $i++) { ?>
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
          <div class="form-group">
            <div class="col-xs-offset-2 col-xs-8 col-lg-offset-3 col-lg-6">
              <div class="input-group">
                <h4>結果表示:1 結果非表示:2</h4>
                <?php for($i=0; $i < 2; $i++) { ?>
                  <? if(isset($res) && $i == $res && $res != 'default') { ?>
                    <label class="radio-inline"><?php echo $i+1 ?><input type="radio" name="res" value="<?php echo $i+1;?>" checked></label>
                  <?php } else { ?>
                    <label class="radio-inline"><?php echo $i+1 ?><input type="radio" name="res" value="<?php echo $i+1;?>"></label>
                  <?php } ?>
                <?php } ?>
              </div>
            </div>

            <?php if(isset($errors['res_blank']) && $res == 'default') { ?>
              <p class="alert alert-danger">入力してください</p><br>
            <?php } ?>
          </div>
        </div>

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
          <a href="raise_up_category_l2.php" class="btn btn-success">次の入力へ</a>
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