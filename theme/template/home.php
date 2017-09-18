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

    if(isset($_POST['to_lists'])){
      echo "yaeh";
    }
}


//1階層目のデータを全件表示する
$sql = 'SELECT * FROM `atom_categories_l1` WHERE 1' ;
$stmt = $dbh->prepare($sql);
$stmt->execute();

//全件取得

$i = 0;
while (1) {
  $results_l1[]= $stmt->fetch(PDO::FETCH_ASSOC);// １レコード分のみ取得
  if ($results_l1[$i] == false) {
    break;
  }
  $i++;
  }
  $DEV = 6;
  $cnt_l1 = count($results_l1)-1;
  $cnt_l1_div = (int)($cnt_l1 / ($DEV+1));
  $cnt_l1_sur = $cnt_l1 % ($DEV+1);
  // echo "cnt_l1: " . $cnt_l1;

foreach ($results_l1 as $result_l1) {
  // echo $result_l1['category_l1'] .'<br>';
}


if(isset($_GET['tab']) && $_GET['tab']=='tab1'){
  echo "get_level_2";
  $tmp_category_l1 = $_GET['level_id'];
//2階層目のデータを取得
$sql = 'SELECT * FROM `atom_categories_l2` WHERE `category_l1_id`=? ' ;
$data = array($tmp_category_l1);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

//全件取得
$results_l2 = array();
$i = 0;
while (1) {
  $results_l2[]= $stmt->fetch(PDO::FETCH_ASSOC);// １レコード分のみ取得
  if ($results_l2[$i] == false) {
    break;
  }
  $i++;
  }

// <<<<<<< HEAD
// foreach ($results_l2 as $result_l2) {
  // echo $result_l2['category_l2'] .'<br>';
// =======
// foreach ($results as $result) {
  // echo $result['category_l2'] .'<br>';
// >>>>>>> 38edd2d7443c46a7c8ab51ba676ee9f54ad28f1c
// }
  $cnt_l2 = count($results_l2)-1;
  $cnt_l2_div = (int)($cnt_l2 / ($DEV+1));
  $cnt_l2_sur = $cnt_l2 % ($DEV+1);
  // echo "cnt_l2: " . $cnt_l2;
}

if(isset($_GET['tab']) && $_GET['tab']=='tab2'){
//3階層目
$tmp_category_l2_id = $_GET['level_id'];
$sql = 'SELECT * FROM `atom_searchs` WHERE `categories_l2_id` = ? ' ;
$data = array($tmp_category_l2_id);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

//全件取得
$results_l3 = array();
$i = 0;
while (1) {
  $results_l3[]= $stmt->fetch(PDO::FETCH_ASSOC);// １レコード分のみ取得
  if ($results_l3[$i] == false) {
    break;
  }
  $i++;
  }


  // var_dump($results);

foreach ($results_l3 as $result_l3) {
  // echo $result_l3['word'] .'<br>';
  // echo $result_l3['condition_azukeire'] .'<br>';
  // echo $result['created'] .'<br>';

}

  $cnt_l3 = count($results_l3)-1;
  $cnt_l3_div = (int)($cnt_l3 / ($DEV+1));
  $cnt_l3_sur = $cnt_l3 % ($DEV+1);
  // echo "cnt_l3: " . $cnt_l3;

}
// $result = get_data($stmt);
// <<<<<<< HEAD
// var_dump($results_l3);
// =======
//var_dump($results);
// >>>>>>> 38edd2d7443c46a7c8ab51ba676ee9f54ad28f1c
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
    <?php require('header.php'); ?>

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

              <input type="text" id="search" class="form-control" placeholder="例：液体物" name = "list_search" maxlength=20 data-intro="調べたい荷物名を入力してください" data-step="2" autofocus>

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
                  <input type="submit" name="list_move" value="リストへ追加" class = "btn btn_atom btn_list_move" >
                </form>

              </div>
            </div>
          <?php  } ?>
        </div>

        <div class="col-xs-12 col-lg-6">
          <div class="output">確認用</div>
          <div id="add_btn" class="btn btn-success">表示・非表示</div>
          <div id="tolists" style="background-color: rgb(0, 153, 255);">
            <form method="POST" action="">
              <input type="submit" name="to_lists" value="リスト1">
              <input type="submit" name="to_lists" value="リスト2">
            </form>
          </div>
          

          <div class='after_event'>
            <ul class='horizontal btn_disabled'>
              <?php if(!isset($_GET['tab'])){ ?>
              <li><a href="#tab-1" id="tab1" class="tab background_white font_size div_border">タブ１</a></li>
              <?php }else { ?>
              <li><a href="#tab-1" id="tab1" class="tab background_white font_size">タブ１</a></li>
              <?php } ?>

              <?php if(isset($_GET['tab']) && $_GET['tab']=='tab1'){?>
            <li><a href="#tab-2" id="tab2" class="tab background_white font_size div_border">タブ２</a></li>
            <?php }else { ?>
            <li><a href="#tab-2" id="tab2" class="tab background_white font_size">タブ２</a></li>
            <?php } ?>

            <?php if(isset($_GET['tab']) && $_GET['tab']=='tab2'){?>
            <li><a href="#tab-3" id="tab3" class="tab background_white font_size div_border">タブ３</a></li>
            </ul>
            <?php }else{ ?>
              <li><a href="#tab-3" id="tab3" class="tab background_white font_size">タブ３</a></li>
            </ul>
            <?php } ?>
            <?php if(!isset($_GET['tab'])){ ?>
              <div id='tab-1'>

                <?php
                  $i=0;
                  for($j=0; $j<=$cnt_l1; $j++) {
                    $div = (int)(($j+1) / ($DEV+1)); //商
                    // echo "j: " . $j . '<br>';
                    // echo "cnt_l1: " . $cnt_l1 . '<br>';
                    // echo "cnt_l1_div: " . $cnt_l1_div . '<br>';
                    // echo "cnt_l1_sur: " . $cnt_l1_sur . '<br>';

                    if($j % $DEV == 0){ //rowタグの開始を出力するタイミングを制御
                      $i = $j + $DEV - 1; //rowのタグの終了を出力するタイミングを制御
                      // echo "i: " . $i . '<br>';

                 ?>
                  <div class="row dev_border">
                    <?php } ?>

                    <a href="home.php?level_id=<?php echo $j+1; ?>&tab=tab1" class="col-lg-2 text-center tabs" id="tab1_<?php echo $j+1; ?>">
                      <?php echo $results_l1[$j]['category_l1']; ?>
                    </a>

                    <?php
                      // rowの閉じタグを出力するタイミンを記述
                      // 商-1までは６個のcolができたら、rowを出力
                      // $jが商と一致するとき、剰余数のcolができたら、rowを出力
                      if( ($j == $i && $div < $cnt_l1_div) || ($cnt_l1_sur == ($j % $DEV) && $div == $cnt_l1_div) ) {
                        // echo "--j: " . $j . '<br>';
                        // echo "--div: " . $div . '<br>';
                    ?>

                    </div><!-- row -->

                  <?php } ?><!-- if -->
                <?php } ?><!-- for -->
              </div>
            <?php } ?>



            <?php if(isset($_GET['tab']) && $_GET['tab']=='tab1'){?>

              <div id='tab-2'>
                <?php
                  $i=0;
                  for($j=0; $j<=$cnt_l2; $j++) {

                  $div = (int)(($j+1) / ($DEV+1));
                  // echo "div-default: " . $j . '<br>';
                  // echo "cnt_l2: " . $cnt_l2 . '<br>';
                  // echo "cnt_l2_div: " . $cnt_l2_div . '<br>';
                  // echo "cnt_l2_sur: " . $cnt_l2_sur . '<br>';
                    if($j % $DEV == 0){
                      $i = $j + $DEV - 1;
                ?>
                      <div class="row dev_border">
                    <?php } ?>

                    <a href="home.php?level_id=<?php echo $j+1; ?>&tab=tab2" class="col-lg-2 text-center tabs" id="tab2_<?php echo $j+1 ?>">
                      <?php echo $results_l2[$j]['category_l2']; ?>
                    </a>

                   <?php if( ($j == $i && $div < $cnt_l2_div) || ($cnt_l2_sur == ($j % $DEV) && $div == $cnt_l2_div) ) { ?>
                    </div><!-- row-->
                  <?php } ?><!-- if -->

                <?php } ?><!-- for -->
              </div><!-- tab2 -->

            <?php } ?>


            <?php if(isset($_GET['tab']) && $_GET['tab']=='tab2'){?>

            <div id='tab-3'>
                            <?php
                $i=0;
                for($j=0; $j<=$cnt_l3; $j++) {
                  $div = (int)(($j+1) / ($DEV+1));
                  if($j % $DEV == 0){
                    $i = $j + $DEV -1;
              ?>
                    <div class="row dev_border">
                  <?php } ?>
                    <!-- <div class="col-lg-2 text-center tabs" id="tab3_<?php echo $i ?>"> -->
                    <a href="home.php?level_id=<?php echo $j+1; ?>&tab=tab3" class="col-lg-2 text-center tabs" id="tab3_<?php echo $j+1 ?>">
                      <?php echo $results_l3[$j]['word']; ?>
                    </a>

                  <?php if( ($j == $i && $div < $cnt_l3_div) || ($cnt_l3_sur == ($j % $DEV) && $div == $cnt_l3_div)){ ?>
                    </div>
                  <?php } ?>
              <?php } ?>

            </div><!-- tab-3 -->
            <?php } ?>


          </div><!-- after_event -->

          <!-- </div> -->
        </div><!-- /col-lg-6 -->

    </div><!-- /row -->
  </div><!-- /container -->
</div><!-- /headerwrap -->


  <?php require('footer.php'); ?>

  <?php require('load_js.php'); ?>
<!--   <script type="text/javascript">
  introJs().start();
  </script> -->

  <!-- カテゴリー分類 -->
  <script type="text/javascript">

    $(document).ready(function(){
      console.log('active_1');
      $('.after_event').tabslet({
      active: 1,
      animation: true
      });

      $('.tabs').click(function(e){
        var id = this.id;
        var data = id.split('_');
        var level = data[0];
        var level_id = data[1];
        
        alert(level);
        alert(level_id);

        if(level == 'tab1') {
          // $.get('home_function/get_home_l2.php',
          //   {
          //     level : level,
          //     level_id : level_id
          //   },
          //   changeHtml
          // );
          // function changeHtml(result){
          //   // $('.output').text(result);
          //   // $('.output').html(result);
          //   // $('#tab-2').html(result);
          //   // alert(result);
          //   // $('.output').html(result);
            
          //   // $(".output").html($('#tab-2', $(result)).html());
          //    var imgArea = $('<div/>').append($.parseHTML(result)).find('.row');
          //    // alert(imgArea);
          //   // $(".output").text(imgArea); 
          //   $("#tab-2").html(imgArea);

          // }
          console.log('tab_1');
          $('#tab2').addClass('div_border');
          $('#tab1').removeClass('div_border');
          $('#tab2').click();

        }

        if(level == 'tab2') {
          // $.get('home_function/get_home_l3.php',
          //   {
          //     level : level,
          //     level_id : level_id
          //   },
          //   changeHtml
          // );
          // function changeHtml(result){
          //   // $('.output').text(result);
          //   // $('.output').html(result);
          //   // $('#tab-3').html(result);
          //   var imgArea = $('<div/>').append($.parseHTML(result)).find('.row');
          //    // alert(imgArea);
          //   // $(".output").text(imgArea); 
          //   $("#tab-3").html(imgArea);
          // }
          console.log('tab-2');
          $('#tab3').addClass('div_border');
          $('#tab2').removeClass('div_border');
          $('#tab3').click();
        }

        if(level == 'tab3') {
          console.log('tab-3');
          console.log('level:%s, level_id:%s', level,level_id);
          // $.get('home_function/get_home_l3.php',
          //   {
          //     level : level,
          //     level_id : level_id
          //   },
          //   changeHtml
          // );
          // function changeHtml(result){
          //   $('.output').text(result);
          // }
          alert("3階層目");
        }

      });
    });
  </script>



  <script type="text/javascript" src="../assets/js/home.js">
  </script>
  <!-- 表示 -->
  <script type="text/javascript">
    $('#add_btn').on('click', function () {
      $("#tolists").slideToggle();
    });
  </script>



  </body>
</html>
