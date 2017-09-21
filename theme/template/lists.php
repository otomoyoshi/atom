<?php

  require('lists_sql.php');

  // ユーザーが新規でリストを作成する際
  if ($is_image['name'] == '') {

    $sql = 'SELECT COUNT(*) FROM `atom_lists` WHERE `members_id`=?';
    $data = array($_SESSION['login_user']['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    // ログインしているユーザーが作成しているリストの数を取得
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $list_amount = $rec['COUNT(*)'];
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
    <link rel="shortcut icon" href="../favicon.png./assets/img/">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


    <title>旅にもつ</title>
    <?php require('load_css.php'); ?>
    <link rel="stylesheet" type="text/css" href="../assets/css/lists.css">

  </head>
  <body>
  <!-- ログインをしてるときとそうでないときで読み込むヘッダを変える -->

  <?php
    // // $ini = parse_ini_file("config.ini");
    // // $is_login = $ini['is_login'];
    // // $is_login = 0; //ログインしてるときを１とする（仮）
    // if (isset($_SESSION['login_user'])){ //ログインしてるとき
    //   // echo "login success";
    //   require('login_header.php');

    // } else {// ログインしてないとき
    //   // echo "login fail";
    //   require('header.php');
    // }
  ?>
<div class="remodal" data-remodal-id="modal" data-remodal-options="hashTracking:false">
    <button data-remodal-action="close" class="remodal-close"></button>
  <!-- <form id="img_form"> -->

      <h1>画像変更</h1>
      <!-- <p>コンテンツを記述します。</p> -->
      <form id="my_form">
        <input id="pos_btn" type="file" name="image" data-url="../../list_image_path/" >
        <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
        <Button type="button" data-remodal-action="confirm" class="remodal-confirm" onclick="file_upload()">画像変更</Button>
      </form>
      <!-- <button data-remodal-action="confirm" class="remodal-confirm">OK</button> -->
      <!-- <button type="button" data-remodal-action="confirm" class="remodal-confirm">画像の変更</button> -->
  <!-- </form> -->
</div>



 <div id="img">
    <div id="headerwrap" class="back">
      <div class="container">
        <!-- リストの情報画面を書いていく -->
        <div class="row height">
          <div class="col-lg-offset-2 col-lg-5 col-md-12 col-sm-12 col-xs-12">
            <form action="" method="POST">

            <?php if($is_image['name'] != ''): ?>
              <!-- リスト名が登録されている場合、そのリスト名を表示する -->
              <input type="text" name="list_name" placeholder="新しいリスト" class="form-control list_name_location" 
              data-intro="リスト名を入力してね" data-step="1" value="<?php echo $is_image['name']; ?>">

            <?php else: ?>
              <!-- リスト名が登録されていない場合、自動的にリスト名がvalueに入る -->
              <input type="text" name="list_name" placeholder="新しいリスト" class="form-control list_name_location" 
              data-intro="リスト名を入力してね" data-step="1" value="リスト  <?php echo $list_amount; ?>">

            <?php endif; ?>
            </div>
              <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 text-center">

<!-- <<<<<<< HEAD -->
            <?php if (isset($errors['extension'])) { ?>
              <div class="alert alert-danger">
                拡張子は、jpg,png,gifの画像を選択ください
              </div>
            <?php } ?>

            <!-- <div id="output"></div> -->
            <label>

              <a id="list_img" data-remodal-target="modal">
              <!-- 画像がデータベースに登録されているとき -->
              <?php if ($is_image['list_image_path'] != NULL) { ?>
                <img src="../../list_image_path/<?php echo $is_image['list_image_path']?>" class="img-circle" width="150px" alt="画像を読み込んでいます" class="padding_img" data-intro="旅の思い出写真を登録してね" data-step="2"><br>
              </a>

            <!-- 画像がデータベースに登録されてないとき -->
            <?php } else {?>
            <a id="list_img" data-remodal-target="modal">
              <div >デフォルト画像を表示</div>
            </a>
            <?php } ?>

            </label>
          </div>
        </div>
        <div class="row">
        </div>
        <!-- リストの大枠を作って行く -->
        <div class="row height_fix">
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center fix_to_search">
            <hr class="under_line1">
            <input type="text" name = "list_search" id="searchs" class="form-control search_window_1" placeholder="「リストを追加してね！」" data-intro="ここに入力すると自動でリストが作成されるよ" data-step="3" autofocus>
            <input id="search-btn" type="submit" class="btn btn-warning  btn-lg btn_width" value="検索" name="list_search_btn" onClick="linkCheck(1)">
          </div>

        </div>
        <?php if(isset($tmp_searchs) && !empty($_POST['list_search_btn']) && count($tmp_searchs) > 1){ ?>
          <div class="row">
            <div class = "col-lg-12 col-md-12  col-sm-12 backgrounding">
              <ul class="list-group" id="list_design">
                <label class="width list_searchs">
                  <h3 class="word_titles">複数件の結果が見つかりました</h3>
                  <li class="list-group-item list_property">
                    <?php if(isset($vague_searchs)): ?>
                      <?php foreach($vague_searchs as $tss): ?>
                        <input type="hidden" name="vague_search_content" value="<?php echo $tss['word'] ?>">
                        <input type="submit" name="vague_search_result" value="<?php echo $tss['word'] ?>" 
                        class ="vanish_border"><br>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </li>
                </label>
              </ul>
            </div>
          </div>
        <?php } 
        //以下に検索・曖昧検索共に一致しない場合について書いていく
        elseif (!isset($tmp_searchs) && !empty($_POST['list_search_btn']) && $_POST['list_search'] != ''){ ?>
          <div class="row">
            <div class = "col-lg-12 col-md-12  col-sm-12 show_size backgrounding vargues_position">
              <h5 class="undefined_word">検索結果が見つかりませんでした</h5>
              <h7 class= "undefined_category">(検索ワード：<?php echo $_POST['list_search']?>)</h7><br>
              <input type="submit" class = "moving_category btn btn_atom" value="カテゴリーから探す" name=""><br>
              <input type="hidden" name="undefined_to_lists" value="<?php echo $_POST['list_search'] ?>">
              <input type="submit" class = "moving_list_direct btn btn_atom" value="”持ち込み・預け入れリスト”に追加する" name="move_both">
              <input type="submit" class = "moving_list_direct btn btn_atom" value="”持ち込みリスト”に追加する" name="move_carry_in">
              <input type="submit" class = "moving_list_direct btn btn_atom" value="”預け入れリスト”に追加する" name="move_azukeire">
            </div>
          </div>
            <?php } ?>

            <?php
            if (isset($_POST['vague_search_result'])) {
              if (isset($vargues['baggage_classify'])) {       
                if ($vargues['baggage_classify'] == '3') { ?>
                <div class="alert alert-danger text_position">
                  <?php echo '"'.$_POST['vague_search_result'].'"'; ?><span class="banned_explanation">は持ち込み・預け入れ共に不可です。</span>
                </div>
            <?php }}} ?>
            <?php 
            if (isset($_POST['list_search'])) {
              if (isset($search['baggage_classify'])) {       
                if ($search['baggage_classify'] == '3') { ?>
                <div class="alert alert-danger text_position">
                  <?php echo '"'.($_POST['list_search']).'"' ?><span class="banned_explanation">は持ち込み・預け入れ共に不可です。</span>
                </div>
            <?php }}} ?>

        <div class="list_category margin_top row" data-intro="検索結果が自動でここに入るよ" data-step="4">
          <div class="both_contents well col-lg-4">
            <!-- BOTHの欄を作る -->
            <strong>
              <p class="sub_title fa fa-fighter-jet">
                持ち込み・預け入れ
              </p>
            </strong>
            <div>
              <ul class="list-group" id="list_design">
                <?php foreach ($item_boths as $item_both) { ?>
                  <label class="width">
                    <li class="list-group-item list_float">
                        <input type="hidden" name="check_judge" value="checked">
                        <input type="checkbox" name="che[]" class="left checkbox" value="<?php echo $item_both['id']?>">
                      <span class="checkbox-icon"></span>
                      <?php echo $item_both['content'];?>
                        <!-- 削除処理を書いていく -->
                        <a href="delete_category.php?id=<?php echo $_GET['id']?>&item_id=<?php echo $item_both['id'];?>">
                          <i class="fa fa-trash right_position"></i>
                        </a>
                    <!--編集ボタン
                        <span>
                         <i class="fa fa-pencil-square-o right"></i>
                        </span> -->
                    </li>
                  </label>
                <?php }?>
              </ul>
            </div>
          </div>
          <!-- 持ち込みの欄を作る -->
          <div class="carry_in well col-lg-4">
            <strong>
              <p class="sub_title fa fa-hand-o-right">
                持ち込み
              </p>
            </strong>
            <div>
              <ul class="list-group">
                <?php foreach ($item_carry_ins as $item_carry_in){ ?>
                  <label class="width">
                    <li class="list-group-item list_float">
                        <input type="hidden" name="check_judge" value="checked">
                        <input type="checkbox" name="che[]" class="left checkbox" value="<?php echo $item_carry_in['id']?>">
                      <span class="checkbox-icon"></span>
                      <?php  echo $item_carry_in['content']; ?>
                      <a href="delete_category.php?id=<?php echo $_GET['id']?>&item_id=<?php echo $item_carry_in['id'];?>">
                        <i class="fa fa-trash right_position"></i>
                      </a>
           <!--       編集ボタン
                      <span>
                       <i class="fa fa-pencil-square-o right"></i>
                      </span> -->
                      <?php  ?>
                    </li>
                  </label>
                <?php  } ?>
              </ul>
            </div>  
          </div>

          <div class="azukeire well col-lg-4">
            <!-- 持ち込みの欄を作る -->
            <strong>
              <p class="sub_title fa fa-suitcase ">
                預け入れ
              </p>
            </strong>
            <ul class="list-group">
              <?php foreach ($item_azukeires as $item_azukeire) { ?>
                <label class="width">
                    <li class="list-group-item list_float">
                        <input type="hidden" name="check_judge" value="checked">
                        <input type="checkbox" name="che[]" class="left checkbox" value="<?php echo $item_azukeire['id']?>">
                      <span class="checkbox-icon"></span>
                      <span class="list_content"><?php echo $item_azukeire['content']; ?></span>
                        <a href="delete_category.php?id=<?php echo $_GET['id']; ?>&item_id=<?php echo $item_azukeire['id'];?>">
                          <i class="fa fa-trash right_position"></i>
                        </a>
                     <!--  編集ボタン  <span>
                         <i class="fa fa-pencil-square-o right"></i>
                        </span> -->
                      <?php  ?>
                    </li>
                </label>
              <?php } ?>
            </ul>
          </div>
        </div>
        <!-- リストの保存機能たち -->

          <div class="list_contents text-center">
<!--               <div class="tmp_keep">
                <input class="btn btn-info tmp_btn" value="一時保存" type="submit" name="tmp_btn" data-intro="作成の続きからリストが作れるよ" data-step="4">
              </div> -->
<!--             <div class="cansel">
              <input value="キャンセル" class="btn btn-warning can_btn" type="submit" name="can_btn">
            </div> -->
            <div class="keep">

              <input class="btn btn-success keep_btn" value="マイページへ登録" type="submit" name="keep_btn" data-intro="リストの履歴やメールに送信できるよ" data-step="5">
            </div>  

          </form>
        </div>
        <div>
          

        </div>
      </div>
    </div>
  </div>

  <?php require('footer.php'); ?>
  <?php require('load_js.php'); ?>


  <?php if ($is_items == false) { ?>
    <script type="text/javascript">
      introJs().start();
    </script>
  <?php } ?>
  <script type="text/javascript" src="../assets/js/lists.js"></script>
  
<!--   <script>
   $(window).on('beforeunload', function(e) {
    return '保存されていない内容は破棄されます。 本当によろしいですか？ ';
    });
  </script> -->

    <!-- remodal -->
<!--   <script type="text/javascript">
    $(document).on('opening', '.remodal', function () {
      console.log('Modal is opening');
    });

    $(document).on('opened', '.remodal', function () {
      console.log('Modal is opened');
    });

    $(document).on('closing', '.remodal', function (e) {

      // Reason: 'confirmation', 'cancellation'
      console.log('Modal is closing' + (e.reason ? ', reason: ' + e.reason : ''));
    });

    $(document).on('closed', '.remodal', function (e) {

      // Reason: 'confirmation', 'cancellation'
      console.log('Modal is closed' + (e.reason ? ', reason: ' + e.reason : ''));
    });

    $(document).on('confirmation', '.remodal', function () {
      console.log('Confirmation button is clicked');
       var formdata = new FormData($('#fileupload').get(0));
       console.log(formdata);



     // GETでid取得
      var arg  = new Object;
       url = location.search.substring(1).split('&');

      for(i=0; url[i]; i++) {
          var k = url[i].split('=');
          arg[k[0]] = k[1];
      }

      var get_id = arg.id;
      console.log(get_id);


      // alert("ajax_finish");
      // window.location.href='';

    });

    $(document).on('cancellation', '.remodal', function () {
      console.log('Cancel button is clicked');

    });
  </script> -->

<!-- btnが押されたとき -->
  <script type="text/javascript">
    function file_upload()
      {
          // フォームデータを取得
          var formdata = new FormData($('#my_form').get(0));

          // GETでid取得
          var arg  = new Object;
           url = location.search.substring(1).split('&');

          for(i=0; url[i]; i++) {
              var k = url[i].split('=');
              arg[k[0]] = k[1];
          }

          var get_id = arg.id;
          console.log(get_id);

          // window.sessionStorage.setItem('lists_id',get_id);

          // POSTでアップロード
          $.ajax({
              url  : "http://localhost/atom/theme/template/get_image.php",
              type : "POST",
              data : formdata,
              cache       : false,
              contentType : false,
              processData : false,
              dataType    : "html"
          })
          .done(function(data, textStatus, jqXHR){
              // alert(data);
              var imgArea = $('<div/>').append($.parseHTML(data)).find('#list_img');
             // alert(imgArea);
              // $("#output").html(imgArea);
              $("#list_img").html(imgArea);
          })
          .fail(function(jqXHR, textStatus, errorThrown){
              alert("fail");
          });
      }
  </script>
  <!-- 戻るときだけコンファームを出すためのjs -->
  <script type="text/javascript">
  // console.log(test);
  $(document).ready(function(){

    $(window).on('beforeunload', function() {
      //個々の変数をクリックしたオブジェクトで変更できれば実装できそう
      var test = 0;
      function linkCheck(btn){
        if (btn == 1) {
          var test = 1;
        }
      }
      console.log(test);
        if(test == 0){
          return "このページを離れると、入力したデータが削除されます。\n修正したい場合には、「マイページへ登録」ボタンをクリックしてください。";
        }
    });
});

</script>
</body>
</html>


<?php
// // 条件用

      // INSERT INTO `searchs` SET `word` = 'まさきっき',
      //                           `condition` = 'ほげ',
      //                           `baggage_classify` = 2, // 1:両方 2:機内 3:預け 4:不可
      //                           `aviation_id` = 1,
      //                           `categoryies_l2_id` =3, 
      //                           `created` = NOW()
      //                           // aviation_id  categoryies_l2_id 

// listsにデータを挿入するためのsql
// INSERT INTO `lists`(`members_id`, `name`, `created`) VALUES (1,"a",NOW())

      // INSERT INTO `atom_searchs` SET `word` = 'くり',
      //                           `condition` = 'ほげ',
      //                           `baggage_classify` = 2, // 1:両方 2:機内 3:預け 4:不可
      //                           `aviation_id` = 1,
      //                           `categories_l2_id` =3, 
      //                           `created` = NOW()
                                // aviation_id  categories_l2_id 
 ?>

