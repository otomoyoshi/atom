<?php 
session_start();
require('../../developer/dbconnect.php');
$word = '';
$errors = array();
$condition_carry_in = '';
$condition_azukeire = '';
$judge_azukeire = '';
$judge_carry_in = '';
$no_result = '';
$per_person = '';
$per_container = '';
 
// カテゴリーの3階層目を押したとき
if(isset($_GET['tab']) && $_GET['tab']=='tab3'){

  $sql = 'SELECT * FROM `atom_searchs` WHERE `id`=?';
  $data = array($_GET['level_id']);
  $stmt = $dbh->prepare($sql);
  $stmt ->execute($data);
  $search = $stmt->fetch(PDO::FETCH_ASSOC);
}

//検索ボタンが押されたとき
if (isset($_GET['home_search_word']) && $_GET['home_search_word'] != '') {
      $_SESSION['home']['home_search_word'] = $_GET['home_search_word'];
      $sql= 'INSERT INTO `atom_searched_words` SET `word` = ?,
                            `created` = NOW()';
      $data = array($_GET['home_search_word']);
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);

      $sql = 'SELECT * FROM `atom_searchs` WHERE `word` LIKE ?';
      $data = array('%' . $_GET['home_search_word'] . '%');
      $stmt = $dbh->prepare($sql);
      $stmt ->execute($data);


      while (1) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);//判定結果を取得
        if ($rec == false) {
          break;
        }
        $tmp_searchs[] = $rec;
      }

      // var_dump($search);
      // var_dump($tmp_searchs);
      // echo count($tmp_searchs);

      if (isset($tmp_searchs)) { // 検索結果が存在する時
        if(count($tmp_searchs) == 1){ // 検索結果が一つだけの時
          $search = $tmp_searchs[0];
        }else{ // 検索結果が複数ある時
          foreach($tmp_searchs as $ts){
            $vague_searchs[] = $ts;
          }
        }
      }else{ // 検索結果が存在しない時
        $no_result = 'no_result';//ここにカテゴリーの裏を書く
      }

// フォームの空チェック 
} elseif (isset($_POST['list_search']) && $_POST['list_search'] == '') {
  $errors['word'] = 'blank';
}

// <<<<<<< HEAD
//     if(isset($_POST['to_lists'])){
//       echo "yaeh";
//     }
// =======

// リストへ追加ボタンが押された時
if (isset($_POST['list_move'])) { 
  if (!isset($_SESSION['login_user']['id'])) { // ユーザーがログインしていない時
    // 新規登録画面に飛ばす けどまだポップアップなどつけてない
    header('Location: un_login/sign_up.php');
    exit();
  }else{ // ユーザーがログインしている時
    $sql = 'SELECT COUNT(*) FROM `atom_lists` WHERE `members_id`=?';
    $data = array($_SESSION['login_user']['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    // ログインしているユーザーが作成しているリストの数を取得
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $list_amount = $rec['COUNT(*)'];


    if($list_amount == 0) { // ユーザーが作成しているリストの数がゼロの時
      // 新しいリストを一つ作成
      // $sql = 'INSERT `atom_lists` SET `members_id` = ?,
      //                                 `name`=? ,
      //                                 `created` = NOW()';
      // $data = array($_SESSION['login_user']['id'],'リスト 1');
      // $stmt = $dbh->prepare($sql);
      // $stmt ->execute($data);

      // $sql = 'SELECT `id` FROM `atom_lists` WHERE `members_id`=?';
      // $data = array($_SESSION['login_user']['id']);
      // $stmt = $dbh->prepare($sql);
      // $stmt->execute($data);

      // $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      // $created_list_id = $rec['id']; // ユーザーが作成しているリストのIDを取得

      // // ログインユーザーの唯一作っているリストに検索結果のワードを登録
      // $sql= 'INSERT INTO `atom_items` SET `lists_id`=?,
      //                                     `content`=?,
      //                                     `categories_id` =?';
      // $data = array($created_list_id,$_POST['word'],$_POST['baggage_classify']);
      // $stmt = $dbh->prepare($sql);
      // $stmt ->execute($data);
      $user_lists = 'no_lists';


    }else{ // ユーザーが作成しているリストが存在する時
      $sql = 'SELECT * FROM `atom_lists` WHERE `members_id`=?';
      $data = array($_SESSION['login_user']['id']);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      while (1) {
      $rec = $stmt->fetch(PDO::FETCH_ASSOC); //ユーザーが作成している複数のリストのじょうほうを取得
      if ($rec == false) {
        break;
      }
      $user_lists[] = $rec;
      }
    }
  }
}


// 曖昧検索の結果からなにかしらが選択された時
if (isset($_GET['id']) && !isset($tmp_searchs) && empty($no_result)) {
  $sql = 'SELECT * FROM `atom_searchs` WHERE `id`=?';
  $data = array($_GET['id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  // ↓ があると検索結果が表示される
  $search = $stmt->fetch(PDO::FETCH_ASSOC);

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


  // var_dump($results_l3);

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
     $per_person = $search['per_person'];
     $per_container = $search['per_container'];
     if ($condition_carry_in == '' && $per_container == '' && $per_person == '') {
        $judge_carry_in = '<i class="fa fa-circle-o"></i>';
     } else{
        $judge_carry_in = '<i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i>';
     }
     if ($condition_azukeire == '' && $per_container == '' && $per_person == '') {
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
    $per_person = $search['per_person'];
    $per_container = $search['per_container'];
     if ($condition_carry_in == '' && $per_container == '' && $per_person == '') {
        $judge_carry_in = '<i class="fa fa-circle-o"></i>';
     } else{
        $judge_carry_in = '<i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i>';
     }
     if ($condition_azukeire == '' && $per_container == '' && $per_person == '') {
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
    $per_person = $search['per_person'];
    $per_container = $search['per_container'];
     if ($condition_carry_in == '' && $per_container == '' && $per_person == '') {
        $judge_carry_in = '<i class="fa fa-close"></i>';
     } else{
        $judge_carry_in = '<i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i>';
     }
     if ($condition_azukeire == '' && $per_container == '' && $per_person == '') {
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

// リストに追加を押した後、ユーザーが新しいリストを選択した時
if (isset($_POST['add_new_list'])) {
  $sql = 'SELECT COUNT(*) FROM `atom_lists` WHERE `members_id`=?';
  $data = array($_SESSION['login_user']['id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  // ログインしているユーザーが作成しているリストの数を取得
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  $list_amount = $rec['COUNT(*)'] + 1;

  // 新しい空のリストを作成する
  $sql = 'INSERT INTO `atom_lists` SET  `members_id` = ?,
                                        `name` = ?,
                                        `created` = NOW()';
  $data = array($_SESSION['login_user']['id'],'リスト '.$list_amount);
  $stmt = $dbh->prepare($sql);
  $stmt ->execute($data);

  // 新しく作ったリストのIDを取得する
  $sql = 'SELECT `id` FROM `atom_lists` WHERE `members_id`=? ORDER BY `id` DESC';
  $data = array($_SESSION['login_user']['id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  $new_list_id = $rec['id']; // 新しく作ったリストのIDを取得する

  // 検索された項目を新しいリストに登録する
  $sql= 'INSERT INTO `atom_items` SET `lists_id`=?,
                                      `content`=?,
                                      `categories_id` =?';
  $data = array($new_list_id,$_POST['word'],$_POST['baggage_classify']);
  $stmt = $dbh->prepare($sql);
  $stmt ->execute($data);

  header('Location: login/myPage.php');
  exit();
}

// リストに追加を押してからユーザーが複数作成しているリストのどのリストに項目を追加するか選んだ時
if (!empty($_POST['user_lists_id'])) {
  $sql= 'INSERT INTO `atom_items` SET `lists_id`=?,
                                      `content`=?,
                                      `categories_id` =?';
  $data = array($_POST['user_lists_id'],$_POST['word'],$_POST['baggage_classify']);
  $stmt = $dbh->prepare($sql);
  $stmt ->execute($data);

  header('Location: login/myPage.php');
  exit();
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

    <?php require('icon.php'); ?>
    <?php require('header.php'); ?>

    <title>旅にもつ</title>

    <?php require('load_css.php');?>
    <link rel="stylesheet" type="text/css" href="../assets/css/home.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/home_header.css">

    <style type="text/css">
      body {
        background: url(../assets/img/beach4.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        background-color: #f1f1f1;
        /*color: #fff;*/
      }
      input::-webkit-input-placeholder{
      color: white;
      }

    </style>

  </head>
  <body>

  <!-- ログインをしてるときとそうでないときで読み込むヘッダを変える -->
    <?php
      // $ini = parse_ini_file("config.ini");
      // $is_login = $ini['is_login'];
      // $is_login = 0; //ログインしてるときを１とする（仮）
      if (isset($_SESSION['login_user']['id'])) { //ログインしてるとき
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
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <h2 id ="catch_copy">「荷造りの悩み」ここに置いて行きませんか？</h2>

            <form method="GET" action="">
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- <label for="sel1"></label> -->
                <select class="form-control" data-intro="航空会社をお選びください" data-step="1" style="background-color: rgba(0,0,0,0.1); border-color: rgba(0,0,0,0.1); color: white;">
                  <option>JetStar</option>
                </select>
              </div>

              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display: inline-flex;">
                <input type="text" id="search" class="form-control" placeholder="例：液体" name = "home_search_word" maxlength=20 data-intro="調べたい荷物名を入力してください" data-step="2" autofocus style="background-color: rgba(0,0,0,0.1); border-color: rgba(0,0,0,0.1); color: white;">
                <?php if (isset($errors['word'])  == 'blank') {?>
                  <div class="alert alert-danger error_search">検索ワードを入力してください</div>
                <?php } ?>
                <input id="search-btn1" type="submit" class="btn btn_atom btn-lg" value="検索">
              </div>
            </form>
          </div> <!-- /col-lg-6 -->

          <!-- 検索結果が見つからない時 -->
          <!-- カテゴリー表示 -->
          <?php if($no_result == 'no_result'): ?>
            <!-- 検索結果を表示していく -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 div_bottom">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="alert alert-danger not_match_error" style="text-align: center;">'<?php echo $_SESSION['home']['home_search_word'] ?>' という検索結果は見つかりませんでした</div>
                </div>
                </div>
              </div>
              <!-- 一階層目の表示 -->
              <div class="row">
                <div class="col-lg-12">
                  <!-- <div class='after_event'> -->
                    <ul class='horizontal btn_disabled row after_event'>
                      <?php if(!isset($_GET['tab'])){ ?>
                        <li><a href="#tab-1" id="tab1" class="tab background_white font_size div_border">選択１</a></li>
                      <?php }else { ?>
                        <li><a href="#tab-1" id="tab1" class="tab background_white font_size">選択１</a></li>
                      <?php } ?>

                      <?php if(isset($_GET['tab']) && $_GET['tab']=='tab1'){?>
                        <li><a href="#tab-2" id="tab2" class="tab background_white font_size div_border">選択２</a></li>
                      <?php }else { ?>
                        <li><a href="#tab-2" id="tab2" class="tab background_white font_size">選択２</a></li>
                      <?php } ?>

                      <?php if(isset($_GET['tab']) && $_GET['tab']=='tab2'){?>
                        <li><a href="#tab-3" id="tab3" class="tab background_white font_size div_border">選択３</a></li>
                      <?php }else{ ?>
                        <li><a href="#tab-3" id="tab3" class="tab background_white font_size">選択３</a></li>
                      <?php } ?>
                    </ul>
                </div>
              </div>

              <?php if(!isset($_GET['tab'])){ ?>
                <div id='tab-1' class="row">
                  <div class="col-lg-12">
                    <?php for($j=0; $j<$cnt_l1; $j++) { ?>
                        <!-- <label> -->
                      <a href="home.php?level_id=<?php echo $results_l1[$j]['id']; ?>&tab=tab1" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center tabs box_bottom" id="tab1_<?php echo $results_l1[$j]['id']; ?>">
                        <div class="all_center background_white">
                        <?php echo $results_l1[$j]['category_l1']; ?>
                        </div>

                      </a>
                        <!-- </label> -->
                    <?php } ?><!-- for -->
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
          <?php endif; ?>

          <!-- 二階層目の表示 -->
          <?php if(isset($_GET['tab']) && $_GET['tab']=='tab1'){ ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 div_bottom">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-danger not_match_error" style="text-align: center;">'<?php echo $_SESSION['home']['home_search_word'] ?>' という検索結果は見つかりませんでした
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div class='after_event'> -->
                <ul class='horizontal btn_disabled row after_event'>
                  <?php if(!isset($_GET['tab'])){ ?>
                    <li><a href="#tab-1" id="tab1" class="tab background_white font_size div_border">選択１</a></li>
                  <?php }else { ?>
                    <li><a href="#tab-1" id="tab1" class="tab background_white font_size">選択１</a></li>
                  <?php } ?>

                  <?php if(isset($_GET['tab']) && $_GET['tab']=='tab1'){?>
                    <li><a href="#tab-2" id="tab2" class="tab background_white font_size div_border">選択２</a></li>
                  <?php }else { ?>
                    <li><a href="#tab-2" id="tab2" class="tab background_white font_size">選択２</a></li>
                  <?php } ?>

                  <?php if(isset($_GET['tab']) && $_GET['tab']=='tab2'){?>
                    <li><a href="#tab-3" id="tab3" class="tab background_white font_size div_border">選択３</a></li>
                    </ul>
                  <?php }else{ ?>
                    <li><a href="#tab-3" id="tab3" class="tab background_white font_size">選択３</a></li>
                    </ul>
                  <?php } ?>
                  <!-- 二回層目の表示 -->
                  <div id='tab-2'>
                    <?php for($j=0; $j<$cnt_l2; $j++) { ?>
                      <!-- <label> -->
                        <a href="home.php?level_id=<?php echo $results_l2[$j]['id']; ?>&tab=tab2" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center tabs box_bottom" id="tab2_<?php echo $results_l2[$j]['id']; ?>">
                          <div class="all_center background_white">
                            <?php echo $results_l2[$j]['category_l2']; ?>
                          </div>

                        </a>
                      <!-- </label> -->
                  <?php } ?><!-- for -->
                </div>
              </div>
            </div>
          <?php } ?>

          <!-- 三階層目の表示 -->
          <?php if(isset($_GET['tab']) && $_GET['tab']=='tab2'){ ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 div_bottom">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-danger not_match_error" style="text-align: center;">'<?php echo $_SESSION['home']['home_search_word']; ?>' という検索結果は見つかりませんでした
                    </div>
                  </div>
                </div>
              </div>
              <div class='after_event'>
                <ul class='horizontal btn_disabled row'>
                  <?php if(!isset($_GET['tab'])){ ?>
                    <li><a href="#tab-1" id="tab1" class="tab background_white font_size div_border">選択１</a></li>
                  <?php }else { ?>
                    <li><a href="#tab-1" id="tab1" class="tab background_white font_size">選択１</a></li>
                  <?php } ?>

                  <?php if(isset($_GET['tab']) && $_GET['tab']=='tab1'){?>
                    <li><a href="#tab-2" id="tab2" class="tab background_white font_size div_border">選択２</a></li>
                  <?php }else { ?>
                    <li><a href="#tab-2" id="tab2" class="tab background_white font_size">選択２</a></li>
                  <?php } ?>

                  <?php if(isset($_GET['tab']) && $_GET['tab']=='tab2'){?>
                    <li><a href="#tab-3" id="tab3" class="tab background_white font_size div_border">選択３</a></li>
                    </ul>
                  <?php }else{ ?>
                    <li><a href="#tab-3" id="tab3" class="tab background_white font_size">選択３</a></li>
                    </ul>
                  <?php } ?>
                  <div id='tab-3'>
                    <?php for($j=0; $j<$cnt_l3; $j++) { ?>
                      <!-- <label> -->
                        <a href="home.php?level_id=<?php echo $results_l3[$j]['id']; ?>&tab=tab3" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center tabs box_bottom" id="tab3_<?php echo $results_l3[$j]['id']; ?>">
                          <div class="all_center background_white">
                            <?php echo $results_l3[$j]['word']; ?>
                          </div>

                        </a>
                      <!-- </label> -->
                  <?php } ?><!-- for -->
                </div>
              </div>
            </div>
          <?php } ?>

          <!-- 曖昧検索表示 -->
          <?php if(isset($vague_searchs)): ?>
            <!-- <div class="row"> -->
              <div class ="col-lg-6 col-md-6 col-sm-12 col-xs-12 backgrounding">
                <ul class="list-group" id="list_design">
                  <label class="width list_searchs">
                    <h3 class="word_titles">検索結果が見つかりました</h3>
                    <li class="list-group-item word_list_design">
                      <?php if(isset($vague_searchs)): ?>
                        <?php foreach($vague_searchs as $tss): ?>
                          <a href="home.php?id=<?php echo $tss['id'] ?>">
                            <label style="text-decoration: underline; cursor: pointer; cursor: hand; margin-top: 5px"><?php echo $tss['word']. "\n"; ?></label><br>
                          </a>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </li>
                  </label>
                </ul>
              </div>
            <!-- </div> -->
          <?php endif; ?>
          <!-- 曖昧検索表示終わり -->

          <!-- 検索結果の表示 -->
          <?php if (isset($search)) {?>
          <!-- <div class="row"> -->
          <form method="POST" action=""> <!-- リストへ追加を押したときに値を取得するフォーム -->
          <!-- formのとじタグがないきがする -->
          <!-- 検索結果をリストへ追加するときに、検索結果の分類を$_POST['baggage_classify']に入れる -->
            <input type="hidden" name="baggage_classify" value="<?php echo $search['baggage_classify'];?>">
            <div class ="col-lg-6 col-md-6  col-sm-12 col-xs-12 backgrounding">
                <ul class="list-group" id="list_design">
                  <label class="width list_searchs">
                    <!-- 検索結果をリストへ追加するときに、検索結果の品目名を$_POST['word']に入れる -->
                    <input type="hidden" name="word" value="<?php echo $search['word']; ?>">
                    <h3 class="word_titles"><?php echo $word; ?></h3>
                    <li class="list-group-item list_property">
                      <h2 class="judge_show_icon">機内持ち込み</h2>
                      <p class="judge_icon">
                        <?php echo $judge_carry_in ?>
                      </p>
                      <p class="conditions">
                        <p class="result_show_title">条件：</p>
                        <p class="removing_margin"><?php echo $condition_carry_in; ?></p>
                        <?php if (isset($per_person) && $per_person != '') {?>
                          <hr class="length_line">
                        <p class="per_something">1人当たり：</p>
                        <p><?php echo $per_person; ?></p>
                        <?php } ?>
                        <?php if ( isset($per_container) && $per_container != '') {?>
                          <hr class="length_line">
                          <p class="per_something">１容器あたり：</p>
                          <p class="removing_margin"><?php echo $per_container; ?></p>
                        <?php } ?>
                     </p> 
                    </li>
                    <li class="list-group-item">
                      <h2 class="judge_show_icon">預け入れ</h2>
                      <p class="judge_icon">
                        <?php echo $judge_azukeire ?>
                      </p>
                      <p class="conditions">
                        <p class="result_show_title">条件：</p>
                        <p class="removing_margin"><?php echo $condition_azukeire; ?></p>
                        <?php if (isset($per_person) && $per_person != '') {?>
                          <hr class="length_line">
                          <p class="per_something">1人当たり：</p>
                          <?php echo $per_person; ?>
                        <?php } ?>
                        <?php if (isset($per_container) && $per_container != '') {?>
                          <hr class="length_line">
                          <p class="result_show_title per_something">１容器あたり:</p>
                          <?php echo $per_container; ?>
                        <?php } ?>
                      </p>
                    </li>
                  </label>
                  <?php if(!isset($_POST['list_move'])): ?>
                    <form method="POST" action="">
                      <input type="submit" name="list_move" value="リストへ追加" class ="btn btn_atom home_to_list_btn">
                    </form>
                  <?php endif; ?>
                </ul>

          <!-- ユーザーが登録している複数のリストの表示 -->
          <div class="row">
            <div class = "col-lg-12 col-md-12  col-sm-12 backgrounding">
              <?php if(isset($user_lists)): ?>
                <label class="width list_searchs">
                  <h3 class="word_titles">追加したいリストを選んでください</h3>
                  <div class="user_lists_select"  style="margin-bottom: 90px">
                    <form method="POST" action="">
                      <input type="hidden" name="word" value="<?php echo $search['word']; ?>">
                      <input type="hidden" name="baggage_classify" value="<?php echo $search['baggage_classify'];?>">
                      <input type="hidden" name="add_new_list" value="add_new_list">
                      <input type="submit" class="col-lg-4 col-xs-4 btn btn-default" style="border: 1px solid black; border-bottom: 1px solid black; margin-top: 2px" name="" value="新しいリストに追加する">
                    </form>
                    <?php if($user_lists != 'no_lists'): ?>
                      <?php foreach($user_lists as $ul): ?>
                        <form method="POST" action="">
                          <input type="hidden" name="word" value="<?php echo $search['word']; ?>">
                          <input type="hidden" name="baggage_classify" value="<?php echo $search['baggage_classify'];?>">
                          <input type="hidden" name="user_lists_id" value="<?php echo $ul['id']; ?>">
                          <input type="submit" class="col-lg-4 col-xs-4 btn btn_atom" style="border: 2px solid white; border-bottom: 6px solid white; border-radius: 0px;" name="" value="<?php echo $ul['name']; ?>">
                        </form>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                </label>
              <?php endif; ?>
            </div>
          </div>
            </div>
          </form>

          <!-- </div> -->

          <?php } ?>

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
        
        // alert(level);
        // alert(level_id);

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
          // alert("3階層目");
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

  <!-- header -->
<!--   <script type="text/javascript">
    $('.nav').on('click', function () {
      $(this).addClass('change_color');
      // $('#tab1').removeClass('div_border');

    });
  </script> -->

  </body>
</html>
