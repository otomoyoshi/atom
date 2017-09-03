<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    

    <title>旅にもつ</title>
    <?php require('load_css.php'); ?>
 
  </head>

  <body>
    <?php require('login_header.php'); ?>
     <div id="img"> 
    <div id="headerwrap" class="back">
      <div class="container">
      <!-- リストの情報画面を書いていく -->
        <div class="row height">
          <div class="col-lg-offset-2 col-lg-5 col-md-12 col-sm-12 col-xs-12">
            <form action="" method="POST">
              <input type="text" name="list_name" placeholder="新しいリスト" class="form-control list_name_location">
              <input type="text" name="created" placeholder="作成日時" class="form-control created_location">
            </form>
          </div>
          <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 center_shift">
            <img src="../assets/img/pic1.jpg" class="img-circle" width="150px" class="padding_img"><br>
            <p class="set_profile">user nameくん</p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-xs-12">
            <hr class="under_line1">
          </div>
        </div>
        <!-- リストの大枠を作って行く -->
        <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
            <form action="" method="">
              <input type="text" id="searchs" class="form-control search_window_1" placeholder="「リストを追加してね！」">
              <input id="search-btn" type="submit" class="btn btn-warning  btn-lg btn_width" value="検索">
            </form>
          </div>
        </div>
        <div class="list_category margin_top row">
          <div class="both_contents well col-lg-4">             

            <!-- BOTHの欄を作る -->
            <strong><p class="sub_title fa fa-fighter-jet">持ち込み・預け入れ</p></strong>
            <div>
              <ul class="list-group" id="list_design">
                <?php for ($i=0; $i <5 ; $i++) { ?>
                  <label class="width">
                  <li class="list-group-item list_float">
                    <input type="checkbox" name="che" class="left checkbox">
                    <span class="checkbox-icon"></span>
                    リスト1
                  </li>
                  </label>
                <?php  }?>
              </ul>
            </div>
          </div>
                <!-- 持ち込みの欄を作る -->
          <div class="carry_in well col-lg-4">
            <strong><p class="sub_title fa fa-hand-o-right">持ち込み</p></strong>
            <div>
              <ul class="list-group">
                <?php for ($i=0; $i <5 ; $i++) { ?>
                  <label class="width">
                  <li class="list-group-item list_float">
                    <input type="checkbox" name="che" class="left checkbox">
                    <span class="checkbox-icon"></span>
                    リスト1
                  </li>
                  </label>
                <?php  }?>
              </ul>
            </div>  
          </div>
          <div class="azukeire well col-lg-4">
                <!-- 持ち込みの欄を作る -->
            <strong><p class="sub_title fa fa-suitcase ">預け入れ</p></strong>
              <ul class="list-group">
                <?php for ($i=0; $i <5 ; $i++) { ?>
                  <label class="width">
                  <li class="list-group-item list_float">
                    <input type="checkbox" name="che" class="left checkbox">
                    <span class="checkbox-icon"></span>
                    リスト1
                  </li>
                  </label>
                <?php  }?>
              </ul>
          </div>
        </div>                  
        
      <!-- リストの保存機能たち -->
        <div class="list_contents text-center">
          <div class="tmp_keep">
            <a class="btn btn-info tmp_btn">一時保存</a>
          </div>
          <div class="cansel">
            <a class="btn btn-warning can_btn">キャンセル</a>
          </div>
          <div class="keep">
            <a class="btn btn-success keep_btn">マイページへ移動</a>
          </div>  
        </div>
      </div>
    </div>
  </div>
    <?php require('footer.php'); ?>
    <?php require('load_js.php'); ?>

  </body>
</html>
