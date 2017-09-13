<?php 
require('../../developer/dbconnect.php');
$word = '';
$errors = array();
$condition_carry_in = '';
$condition_azukeire = '';
$judge_azukeire = '';
$judge_carry_in = '';

//検索ボタンが押されたとき
if (!empty($_POST)) {
    if (isset($_POST['list_search']) && $_POST['list_search'] != '') {
      $sql= 'INSERT INTO `atom_searched_words` SET `word` = ?,
                            `created` = NOW()';
      $data = array($_POST['list_search']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);

      $sql = 'SELECT * FROM `atom_searchs` WHERE `word`= ?';
      $data = array($_POST['list_search']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);
      $search = $stmt->fetch(PDO::FETCH_ASSOC);//判定結果を取得
    } elseif (isset($_POST['list_search']) && $_POST['list_search'] == '') {
    $errors['word'] = 'blank';
    }
// <<<<<<< HEAD
}


//1階層目のデータを全件表示する
$sql = 'SELECT * FROM `atom_categories_l1` WHERE 1' ;
$stmt = $dbh->prepare($sql);
$stmt->execute();

//全件取得
$results = array();
$i = 0;
while (1) {
  $results[]= $stmt->fetch(PDO::FETCH_ASSOC);// １レコード分のみ取得
  if ($results[$i] == false) {
    break;
  }
  $i++;
  }

foreach ($results as $result) {
  echo $result['category_l1'] .'<br>';
}

$tmp_category_l1 = 1;
//2階層目のデータを取得
$sql = 'SELECT * FROM `atom_categories_l2` WHERE `category_l1_id`=? ' ;
$data = array($tmp_category_l1);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

//全件取得
$results = array();
$i = 0;
while (1) {
  $results[]= $stmt->fetch(PDO::FETCH_ASSOC);// １レコード分のみ取得
  if ($results[$i] == false) {
    break;
  }
  $i++;
  }

foreach ($results as $result) {
  // echo $result['category_l2'] .'<br>';
}


//3階層目
$tmp_category_l2_id = 3;
$sql = 'SELECT * FROM `atom_searchs` WHERE `categories_l2_id` = ? ' ;
$data = array($tmp_category_l2_id);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

//全件取得
$results = array();
$i = 0;
while (1) {
  $results[]= $stmt->fetch(PDO::FETCH_ASSOC);// １レコード分のみ取得
  if ($results[$i] == false) {
    break;
  }
  $i++;
  }

  //var_dump($results);

foreach ($results as $result) {
  echo $result['word'] .'<br>';
  echo $result['condition_azukeire'] .'<br>';
  echo $result['created'] .'<br>';


}

// $result = get_data($stmt);
//var_dump($results);
// echo "---------";
// echo $result[0]['category'] .'<br>';
// =======



      if (isset($search)) {
        if ($search['baggage_classify'] == '0') {
            //両方持ち込みの場合
           $word = $search['word'];
           $classify = '機内への持ち込み・預け入れ共に可能です';
           $condition_carry_in = $search['condition_carry_in'];
           $condition_azukeire = $search['condition_azukeire'];
           if ($condition_carry_in == '') {
              $judge_carry_in = '<i class="fa fa-circle-o"></i>';
           } else{
              $judge_carry_in = '<i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i>';
           }
           if ($condition_azukeire == '') {
              $judge_azukeire = '<i class="fa fa-circle-o"></i>';
           } else{
              $judge_azukeire = '<i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i>';
           }
                  }
        // 持ち込みの場合
        elseif ($search['baggage_classify'] == '1') {
          $word = $search['word'];
          $classify = '機内持ち込みのみ可能です';
          $condition_carry_in = $search['condition_carry_in'];
          $condition_azukeire = $search['condition_azukeire'];
           if ($condition_carry_in == '') {
              $judge_carry_in = '<i class="fa fa-circle-o"></i>';
           } else{
              $judge_carry_in = '<i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i>';
           }
           if ($condition_azukeire == '') {
              $judge_azukeire = '<i class="fa fa-close"></i>';
           } else{
              $judge_azukeire = '<i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i>';
           }

          

        }
        //預け入れの場合
        elseif ($search['baggage_classify'] == '2') {
          $word = $search['word'];
          $classify = 'お荷物預け入れのみ可能です';
          $condition_carry_in = $search['condition_carry_in'];
          $condition_azukeire = $search['condition_azukeire'];
           if ($condition_carry_in == '') {
              $judge_carry_in = '<i class="fa fa-close"></i>';
           } else{
              $judge_carry_in = '<i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i>';
           }
           if ($condition_azukeire == '') {
              $judge_azukeire = '<i class="fa fa-circle-o"></i>';
           } else{
              $judge_azukeire = '<i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i>';
           }

        } 
        //持ち込めない場合
        elseif ($search['baggage_classify'] == '3'){
          $word = $search['word'];
          $classify = '機内への持ち込み・預け入れ共にできません';
          $condition_carry_in = $search['condition_carry_in'];
          $condition_azukeire = $search['condition_azukeire'];
          if ($condition_carry_in == '') {
              $judge_carry_in = '<i class="fa fa-close"></i>';
           } else{
              $judge_carry_in = '<i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i>';
           }
           if ($condition_azukeire == '') {
              $judge_azukeire = '<i class="fa fa-close"></i>';
           } else{
              $judge_azukeire = '<i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i>';
           }
        } 

      } //アイテムにデータがない時
      else{
          //カテゴリー表示
      }
// >>>>>>> 139007b4d02545674733945456ad5cd057ae5a75

// }

  // カテゴリー表示の開発用
  $results_l1 = array("a"=>"b",
                      "c"=>"d",
                      "e"=>"f");
  $results_l2 = array("g"=>"h");
  $results_l3 = array("i"=>"j",
                      "k"=>"l",
                      "m"=>"n");
?>





<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <!-- <link rel="shortcut icon" href="../..assets/img/favicon.png"> -->
    <!-- <link rel="shortcut icon" href="../assets/img/tabinimotsu_v1.png"> -->

    <title>旅にもつ</title>

    <?php require('load_css.php');?>
    <link rel="stylesheet" type="text/css" href="../assets/css/home.css">



  </head>

  <body>

  <!-- ログインをしてるときとそうでないときで読み込むヘッダを変える -->
  <?php
    // $ini = parse_ini_file("config.ini");
    // $is_login = $ini['is_login'];
    // $is_login = 0; //ログインしてるときを１とする（仮）
    // if ($_SESSION['login_user']) { //ログインしてるとき
    //   // echo "login success";
    //   require('login_header.php');
    // } else {// ログインしてないとき
    //   // echo "login fail";
    //   require('header.php');
    // }
  ?>
  <div id="headerwrap">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-6 col-md-6 col-sm-6">
          <h2 id ="catch_copy">「荷造りの悩み」ここに置いて行きませんか？</h2>
         
          <form method="POST" action="">
            <div class="form-group">
              <!-- <label for="sel1"></label> -->
              <select class="form-control" id="sel1" data-intro="航空会社をお選びください" data-step="1">
                <option>JetStar</option>
              </select>
            </div>

            <div class="form-group">

              <input type="text" id="search" class="form-control" placeholder="例：液体物" name = "list_search" maxlength=15 data-intro="調べたい荷物名を入力してください" data-step="2" autofocus>

               <?php if (isset($errors['word'])  == 'blank') {?>
                  <div class="alert alert-danger error_search">検索ワードを入力してください</div>
                <?php } ?>

            </div>
            <input id="search-btn1" type="submit" class="btn btn_atom btn-lg" value="検索">
          </form>
        </div><!-- /col-lg-6 -->
        <!-- 検索結果を表示していく -->

        <div class="col-xs-12 col-lg-6 col-sm-6 col-md-6">

          <?php if (isset($search)) {?>
            <div class="row">
              <div class = "col-lg-12 col-md-12  col-sm-12 show_size backgrounding">
                <ul class="list-group" id="list_design">
                  <label class="width list_searchs">
                    <h3 class="word_titles"><?php echo $word; ?></h3>
                    <li class="list-group-item list_property">
                      <h2 class="judge_show_icon">機内持ち込み：</h2>
                      <p class="judge_icon">
                        <?php echo $judge_carry_in ?>
                      </p>
                      <p class="conditions">
                        機内持ち込み条件：<br>
                        <?php echo $condition_carry_in; ?>
                      </p>
                    </li>
                    <li class="list-group-item">
                      <h2 class="judge_show_icon">預け入れ：</h2>
                      <p class="judge_icon">
                        <?php echo $judge_azukeire ?>
                      </p>
                      <p class="conditions">
                        機内預け入れ条件：<br>
                        <?php echo $condition_azukeire; ?>
                      </p>
                    </li>
                  </label>
                </ul>
                <form method="POST" action="">
                  <input type="submit" name="list_move" value="リストへ追加" class = "btn btn_atom btn_list_move">
                </form>
              </div>
            </div>
          <?php  } ?>
        </div>
        <!--  
        <div class="col-xs-12 col-lg-6">
          <div class='after_event'>
            <ul class='horizontal btn_disabled'>
            <li><a href="#tab-1" id="tab1" class="tab background_white font_size div_border">タブ１</a></li>
            <li><a href="#tab-2" id="tab2" class="tab background_white font_size">タブ２</a></li>
            <li><a href="#tab-3" id="tab3" class="tab background_white font_size">タブ３</a></li>
            </ul>
            <div id='tab-1'>
              <div class="row background_white">

                <?php
                  $i=1;
                  foreach ($results_l1 as $result_l1) {
                ?>

                  <div class="col-lg-2 text-center dev_border tabs" id="<?php echo $i ?>">
                    <?php echo $result_l1; ?>
                  </div>

                 <?php
                    $i++;
                   }
                 ?>
               </div>
            </div>

            <div id='tab-2'>
              <div class="row background_white">
                <?php
                  $i=1;
                  foreach ($results_l2 as $result_l2) {
                ?>
                <div class="col-lg-2 text-center dev_border tabs" id="<?php echo $i ?>">
                  <?php echo $result_l2; ?>
                </div>

                 <?php
                    $i++;
                   }
                 ?>
               </div>
            </div>
            <div id='tab-3'>
              <div class="row background_white">
                <?php
                  $i=1;
                  foreach ($results_l3 as $result_l3) {
                ?>
                <div class="col-lg-2 text-center dev_border tabs" id="<?php echo $i ?>">
                  <?php echo $result_l3; ?>
                </div>

                 <?php
                    $i++;
                   }
                 ?>
               </div>
            </div>
            </div>
        </div>
      </div><!-- /col-lg-6 -->
    </div><!-- /row -->
  </div><!-- /container -->
</div><!-- /headerwrap -->


  <?php require('footer.php'); ?>

  <?php require('load_js.php'); ?>
<!--   <script type="text/javascript">
  introJs().start();
  </script> -->
  <script type="text/javascript"> 
    $('.after_event').tabslet({
    active: 1,
    animation: true
    });
    // $('.tabs').tabslet({
    // active: 1,
    // animation: true
    // });
    $('.tabs').click(function(e){
      var id = this.id;
      alert(id);
      if(id == 'tab-1') {
        console.log('tab-1');
        $('#tab2').addClass('div_border');
        $('#tab1').removeClass('div_border');
        $('#tab2').click();
      }

      if(id == 'tab-2') {
        console.log('tab-2');
        $('#tab3').addClass('div_border');
        $('#tab2').removeClass('div_border');
        $('#tab3').click();
      }

      if(id == 'tab-3') {
        console.log('tab-3');
        alert("3階層目");
      }


        // if(id == 'tab2') {
        //   $('#tab2').addClass('btn_disabled');
        //   console.log(1);
        //   $('#tab3').removeClass('btn_disabled');
        //   console.log(2);

        // }
        // if(id == 'tab3') {
        //   $('#tab3').addClass('btn_disabled');
        //   console.log(2);
        // }
      });


  </script>
  <script type="text/javascript" src="../assets/js/home.js">
    
  </script>
  </body>
</html>
