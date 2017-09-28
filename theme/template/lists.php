<?php
  require('lists_sql.php');

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
    <title>旅にもつ</title>
    <?php require('icon.php'); ?>
    <?php require('load_css.php'); ?>
    <link rel="stylesheet" type="text/css" href="../assets/css/lists.css">

  </head>
  <body>
  <!-- ログインをしてるときとそうでないときで読み込むヘッダを変える -->

  <?php
    $ini = parse_ini_file("config.ini");
    $is_login = $ini['is_login'];
    $is_login = 0; //ログインしてるときを１とする（仮）
    if (isset($_SESSION['login_user'])){ //ログインしてるとき
      // echo "login success";
      require('login_header.php');

    } else {// ログインしてないとき
      // echo "login fail";
      require('header.php');
    }
  ?>

<!-- 画像変更popup -->
<div class="remodal" data-remodal-id="modal" data-remodal-options="hashTracking:false">
  <button data-remodal-action="close" class="remodal-close"></button>
    <h1>画像変更</h1>
      <form id="my_form">
        <input id="pos_btn" type="file" name="image" data-url="../../list_image_path/" >
        <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
        <Button type="button" data-remodal-action="confirm" class="remodal-confirm" onclick="file_upload()">画像変更</Button>
      </form>
</div>

  <!-- 条件表示 pop-->
<div class="remodal" data-remodal-id="modal-condition" data-remodal-options="hashTracking:false">
 <button data-remodal-action="close" class="remodal-close"></button>
  <div class="output">

  </div>
</div>

<!-- リスト移動popup -->
<div class="remodal row" data-remodal-id="modal_edit" data-remodal-options="hashTracking:false">
  <button data-remodal-action="close" class="remodal-close"></button>
    <h1>リスト移動</h1>
    <p>どのカテゴリーに移動させますか？</p>

    <button id="0" data-remodal-action="confirm" class="remodal_atom item_id col-lg-3 col-xs-12 remoda_atom_pad">持ち込み・預け入れ</button>
    <button id="1" data-remodal-action="confirm" class="remodal_atom item_id col-lg-3 col-xs-12 remoda_atom_pad">持ち込み</button>
    <Button id="2" type="button" data-remodal-action="confirm" class="remodal_atom item_id col-lg-offset-1 col-lg-3 col-xs-12">預け入れ</Button>
</div>


<div id="img">
  <div id="headerwrap" class="back">
    <div class="container background-white">
      <!-- リストの情報画面を書いていく -->
      <div class="row height">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
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

            <img id="list_img" data-remodal-target="modal" src="../assets/img/insert_image.png" class="img-circle list_name_location" style="height: 120px; width: 120px" data-intro="旅の思い出写真を登録してね" data-step="1">
            </a>
            <?php } ?>

            <!-- </label> -->
          </div><!-- div -->

          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="" method="POST" class="div_border">

              <!-- リスト名が登録されている場合、そのリスト名を表示する -->
              <input type="text" name="list_name" placeholder="新しいリスト" class="form-control erase_input_border" 
              data-intro="リスト名を入力してね" data-step="2" value="<?php echo $is_image['name']; ?>">

          </div><!-- div -->
        </div>
        <div class="row">
          <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 fix_to_search straight">
            <!-- <hr class="under_line1"> -->
            <!-- <div class="form-inline"> -->
              <input id="searchs" type="text" name = "list_search" class="form-control" placeholder="「リストを追加してね！」" data-intro="ここに入力すると自動でリストが作成されるよ" data-step="3" autofocus>

              <input id="search-btn" type="submit" class="btn btn_atom  btn-lg btn_width" value="検索" name="list_search_btn" onClick="linkCheck(1)">  
            <!-- </div> --> 
          </div>
        </div>

        <?php if(isset($vague_searchs) && !empty($_POST['list_search_btn']) && $_POST['list_search'] != $search['word']){ ?>
          <div class="row">
            <div class = "col-lg-12 col-md-12  col-sm-12 backgrounding">
              <ul class="list-group" id="list_design">
                <label class="width list_searchs">
                  <h3 class="word_title">検索結果が見つかりました</h3>
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
              <h7 class= "undefined_category">(検索ワード：<?php echo htmlspecialchars($_POST['list_search'])?>)</h7>
              <!-- <h7 class= "undefined_category">(検索ワード：<?php //echo $_POST['list_search']?>)</h7> -->
              <input type="hidden" name="undefined_to_lists" value="<?php echo $_POST['list_search'] ?>">
              <div class="list_add_btn">
                <input type="submit" class = "moving_list_direct btn btn_atom" value="”持ち込み・預け入れリスト”に追加する" name="move_both">
                <input type="submit" class = "moving_list_direct btn btn_atom" value="”持ち込みリスト”に追加する" name="move_carry_in">
                <input type="submit" class = "moving_list_direct btn btn_atom" value="”預け入れリスト”に追加する" name="move_azukeire">
              </div>
            </div>
          </div>
          <!-- <hr> -->
        <?php } ?>

            <?php
            if (isset($_POST['vague_search_result'])) {
              if (isset($vargues['baggage_classify'])) {
                if ($vargues['baggage_classify'] == '3') { ?>
                <div class="alert alert-danger text_position">
                  <?php echo '"'.htmlspecialchars($_POST['vague_search_result']).'"'; ?><span class="banned_explanation">は持ち込み・預け入れ共に不可です。</span>
                </div>
            <?php }}} ?>
            <?php
            if (isset($_POST['list_search'])) {
              if (isset($search['baggage_classify'])) {
                if ($search['baggage_classify'] == '3') {
                  if (!isset($vague_searchs)) {?>

                <div class="alert alert-danger text_position">
                  <?php echo '"'.(htmlspecialchars($search['word'])).'"' ?><span class="banned_explanation">は持ち込み・預け入れ共に不可です。</span>
                </div>
            <?php }}}} ?>


        <div class="list_category margin_top row" data-intro="検索結果が自動でここに入るよ" data-step="4">

          <div class="col-lg-4 col-md-4" id="box1">

            <!-- BOTHの欄を作る -->
            <div class="sub_title box-title">
              持ち込み・預け入れ
            </div>
            <div>
              <ul class="list-group responsive_position" id="list_both">
                <?php foreach ($item_boths as $item_both) { ?>
                  <label class="width">
                    <li class="list-group-item list_float" id="<?php echo $item_both['id'];?>">
                      <?php if ($item_both['item_check'] == 1) { ?>
                        <input id="<?php echo $item_both['id'];?>_l" type="hidden" name="check_judge" value="checked" checked>
                        <input type="checkbox" name="che[]" class="left checkbox laggage_both" value="<?php echo $item_both['id'];?>" checked>
                        <span class="checkbox-icon"></span>
                      <?php } else { ?>
                        <input id="<?php echo $item_both['id'];?>_l" type="hidden" name="check_judge" value="checked">
                        <input type="checkbox" name="che[]" class="left checkbox laggage_both" value="<?php echo $item_both['id'];?>">
                        <span class="checkbox-icon"></span>
                      <?php } ?>
                      <span class="text_overflow">
                        <?php  echo htmlspecialchars($item_both['content']);?>
                        <?php //echo $item_both['content'];?>
                      </span>

                        <!-- 削除処理を書いていく -->
                        <a href="delete_category.php?id=<?php echo $_GET['id']?>&item_id=<?php echo $item_both['id'];?>">
                          <i class="fa fa-trash right_position"></i>
                        </a>


                        <!-- 条件表示 -->
                           <!-- <i class="fa fa-pencil-square-o right con" value="<?php //echo $item_both['id'];?>"></i> -->
                           

                        <!-- リスト移動で必要なitemのidを -->
                        <a data-remodal-target="modal_edit" class="edit">
                         <i class="fa fa-tags right edit" value="<?php echo $item_both['id'];?>"></i>
                        </a>

                        <?php if (isset($item_both['condition_azukeire']) || isset($item_both['condition_carry_in'])) { ?>
                          <?php if ($item_both['condition_azukeire'] != '' || $item_both['condition_carry_in'] != '') { ?> 
                            <a data-remodal-target="modal-condition" class="show_condition">
                              <!-- 条件マーク表示 -->
                              <i class="fa fa-exclamation-triangle right_position con" value="<?php echo $item_both['id'];?>"></i>
                            </a>
                          <?php } ?>
                        <?php } ?>

                    </li>
                  </label>
                <?php }?>
              </ul>
            </div>
          </div>
          <!-- 持ち込みの欄を作る -->
          <div class="col-lg-4 col-md-4" id="box2">
            <!-- <strong> -->
              <div class="sub_title box-title for_responsive">
                持ち込み
              </div>
            <!-- </strong> -->
            <div>
              <ul class="list-group responsive_position" id="list_carry">
                <?php foreach ($item_carry_ins as $item_carry_in){ ?>
                  <label class="width">
                    <li class="list-group-item list_float" id="<?php echo $item_carry_in['id'];?>">
                      <?php if ($item_carry_in['item_check'] == 1) { ?>
                        <input id="<?php echo $item_both['id'];?>_l" type="hidden" name="check_judge" value="checked">
                        <input type="checkbox" name="che[]" class="left checkbox" value="<?php echo $item_carry_in['id']?>" checked>
                        <span class="checkbox-icon"></span>
                      <?php } else { ?>
                        <input id="<?php echo $item_both['id'];?>_l" type="hidden" name="check_judge" value="checked">
                        <input type="checkbox" name="che[]" class="left checkbox" value="<?php echo $item_carry_in['id']?>">
                        <span class="checkbox-icon"></span>
                      <?php } ?>
                      <span class="text_overflow">
                      <?php  echo htmlspecialchars($item_carry_in['content']); ?>
                      <?php  //echo $item_carry_in['content'] ?>
                      </span>
                      <a href="delete_category.php?id=<?php echo $_GET['id']?>&item_id=<?php echo $item_carry_in['id'];?>">
                        <i class="fa fa-trash right_position"></i>
                      </a>

                        <!-- リスト移動で必要なitemのidを -->
                        <a data-remodal-target="modal_edit" class="edit">
                         <i class="fa fa-tags right edit" value="<?php echo $item_carry_in['id'];?>"></i>
                        </a>

                      <?php if (isset($item_carry_in['condition_azukeire']) || isset($item_carry_in['condition_carry_in'])) { ?>
                        <?php if ($item_carry_in['condition_azukeire'] != '' || $item_carry_in['condition_carry_in'] != ''){ ?> 
                          <a>
                            <i class="fa fa-exclamation-triangle right_position con" value="<?php echo $item_carry_in['id'];?>"></i>
                          </a>
                        <?php } ?>
                      <?php } ?>
                    </li>
                  </label>
                <?php  } ?>
              </ul>
            </div>
          </div>

          <div class="col-lg-4 col-md-4" id="box3">
            <!-- 持ち込みの欄を作る  -->
              <div class="box-title for_responsive">
                預け入れ
              </div>
            <ul class="list-group responsive_position" id="list_azukeire">
              <?php foreach ($item_azukeires as $item_azukeire) { ?>
                <label class="width">
                    <li class="list-group-item list_float" id="<?php echo $item_azukeire['id'];?>">
                      <?php if ($item_azukeire['item_check'] == 1) { ?>
                        <input id="<?php echo $item_both['id'];?>_l" type="hidden" name="check_judge" value="checked">
                        <input type="checkbox" name="che[]" class="left checkbox" value="<?php echo $item_azukeire['id']?>" checked>
                        <span class="checkbox-icon"></span>
                      <?php } else { ?>
                        <input id="<?php echo $item_both['id'];?>_l" type="hidden" name="check_judge" value="checked">
                        <input type="checkbox" name="che[]" class="left checkbox" value="<?php echo $item_azukeire['id']?>">
                        <span class="checkbox-icon"></span>
                      <?php } ?>

                      <span class="text_overflow"><?php echo htmlspecialchars($item_azukeire['content']); ?></span>
                      <a href="delete_category.php?id=<?php echo $_GET['id']; ?>&item_id=<?php echo $item_azukeire['id'];?>">
                        <i class="fa fa-trash right_position"></i>
                      </a>

                      <a data-remodal-target="modal_edit" class="edit">
                        <i class="fa fa-tags right edit" value="<?php echo $item_azukeire['id'];?>"></i>
                      </a>

                      <?php if (isset($item_azukeire['condition_azukeire']) || isset($item_azukeire['condition_carry_in'])){ ?>
                        <?php if ($item_azukeire['condition_azukeire'] != '' || $item_azukeire['condition_carry_in'] != ''){ ?> 
                          <a>
                            <i class="fa fa-exclamation-triangle right_position con" value="<?php echo $item_azukeire['id'];?>"></i>
                          </a>
                        <?php } ?>
                      <?php } ?>

                    </li>
                </label>
              <?php } ?>
            </ul>
          </div>
        </div>
        <!-- リストの保存機能たち -->

        <div class="list_contents text-center">
            <div class="keep">
              <input class="btn btn_atom keep_btn" value="マイページへ登録" type="submit" name="keep_btn" data-intro="リストの管理と送信もできるよ" data-step="5">
            </div>
          </form>
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

<!-- 条件表示 -->
<script type="text/javascript">
  // var item_id = '';
  $('.con').on('click', function(){
    var item_id = $(this).attr('value');
    // var edit = $(this).attr('value');
    // var item_id =  $('.item_id').attr('value', edit);
    // alert(item_id);

    // POSTでアップロード
    $.ajax({
        url : "get_condition.php",
        type : "POST",
        data : {'id' : item_id},
    })
    .done(function(data, textStatus, jqXHR){
        // alert(data);
        var imgArea = $('<div/>').append($.parseHTML(data)).find('#condition');
        // alert(imgArea);
        $(".output").html(imgArea);
        $(".show_condition").click();
        // $(".output").html(imgArea);
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        // alert("fail");
    });
  });
</script>

<!-- リスト移動 表示 -->
<script type="text/javascript">
  $('.item_id').on('click', function(){
    var category_id = $(this).attr('id');
    var item_id = $(this).attr('value');
    var remove_id = '#'+item_id;
    $(remove_id).remove();

    // alert(remove_id);
    // alert(category_id);
    // alert(item_id);

    // 移動する先のリストを指定
    switch(category_id){
      case '0':
        var add_list = '#list_both';
        break;
      case '1':
        var add_list = '#list_carry';
        break;
      case '2':
        var add_list = '#list_azukeire';
        break;
      default:
        // alert('fault');
    }

 // POSTでアップロード
    $.ajax({
        url : "get_both.php",
        type : "POST",
        data : {'item_id' : item_id,'category_id' : category_id},
    })
    .done(function(data, textStatus, jqXHR){
        // alert(data);
        var imgArea = $('<div/>').append($.parseHTML(data)).find('#condition');
        $(add_list).append(imgArea);
        // alert(imgArea);
        // $(".output").html(imgArea);
        // $(".modal_triger").click();
        // $(".output").html(imgArea);
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        // alert("fail");
    });

  });
</script>

<!-- リスト移動 -->
<script type="text/javascript">
  // var item_id = '';
  $('.edit').on('click', function(){
    var edit = $(this).attr('value');
    $('.item_id').attr('value', edit);
    var isChecked = "#"+edit+"_l";
    // alert(isChecked);
    var area_val = $(isChecked).is(':checked');
    // alert(edit);
    // alert(area_val);
  });

</script>

  <!-- 画像変更 -->
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
              // url  : "http://localhost/atom_newdesign_v1/theme/template/get_image.php",
              url  : "get_image.php",
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


  <!-- more -->
  <script type="text/javascript">
    $(function() {
       var count = 10;
      // console.log('more_start');
        $('.text_overflow').each(function() {
        var thisText = $(this).text().replace(/\s+/g, '');
        // console.log(thisText);
        var textLength = thisText.length;
        console.log('textLength: %s' , textLength);
        if (textLength > count) {
          var showText = thisText.substring(0, count);
          var hideText = thisText.substring(count, textLength);
          var insertText = showText;
          console.log('hideText: %s' , hideText);
          insertText += '<span class="hide_str">' + hideText + '</span>';
          insertText += '<span class="omit span_color">…</span>';
          insertText += '<span class="more span_color">more</span>';
          insertText += '<span class="close_str span_color">close</span>';

          $(this).html(insertText);
        };
      });



    $('.text_overflow .hide_str').hide();
    $('.text_overflow .close_str').hide();

    $('.text_overflow .more').click(function() {
        console.log('more');
        $(this).hide()
        .prev('.omit').hide()
        .prev('.hide_str').fadeIn()
        .siblings('.close_str').fadeIn();

      return false;
    });
      $('.text_overflow .close_str').click(function() {
        console.log('close');
        $(this).hide();
        // .prev('.omit').fadeIn()
        // .prev('.hide_str').hide()
        // .prev('.more').fadeIn();

        // $('.more').fadeIn();
        $('.omit').fadeIn();
        $('.hide_str').hide();
        $('.more').fadeIn(); // close

      return false;
    });
  });
  </script>
</body>
</html>
