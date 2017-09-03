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
    <link rel="stylesheet" type="text/css" href="../assets/css/akihiro_setting.css">

  </head>

  <body>
  <?php require('header.php'); ?>

    <div class="container">

<div class="row">
    <div class="col-xs-10 col-sm-8 col-md-8 col-xs-offset-1 col-sm-offset-2 col-md-offset-2 akihiro_main_div" style="padding:0px 60px 30px 60px; margin-bottom: 15px;/* background-color: rgba(255,255,255,0.6)*/;
    ">

      <h2>会員情報設定<span style="font-size: 15px" font-color="white">※印の欄は必須項目です</span></h2>
      <hr color="blue">
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="form-group">
            <label style="font-size: 18px">アカウント名入力　※</label>
                        <input type="text" name="acount_name" id="first_name" class="form-control input-lg" placeholder="アカウント名" tabindex="1">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="form-group">
            <label style="font-size: 18px">メールアドレス入力　※</label>
            <input type="text" name="mail_address" id="last_name" class="form-control input-lg" placeholder="メールアドレス" tabindex="2">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="form-group">
            <label style="font-size: 18px">パスワード名入力　※</label>
            <input type="password" name="password" id="password" class="form-control input-lg" placeholder="パスワード" tabindex="3" style="margin: 5px 0px;">
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="form-group">
            <label style="font-size: 18px">確認用パスワード入力　※</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-lg" placeholder="確認用パスワード" tabindex="4" style="margin: 5px 0px;">
          </div>
        </div>
      </div>

      <div>
        <label style="font-size: 20px">性別　</label>
          <label>
          <input type="checkbox" name="gender_male" value="1" tabindex="5" />男
          </label>
          <label>
          <input type="checkbox" name="gender_female" value="2" tabindex="6" style="margin-left: 5px" />女
        </label>
      </div>

      <div style="margin-bottom: 10px">
        <label style="font-size: 20px">年齢　</label>
        <select name="age">
        <?php for($i = 10;$i <= 80;$i++): ?>
          <option value="<?php echo $i; ?>"><?php echo $i; ?>歳</option>
        <?php endfor; ?>
        </select>
      </div>

      <div class="control-group">
        <div class="controls" style="padding-bottom: 10px">
          <img src="http://api.randomuser.me/portraits/women/76.jpg" alt="Glenda Patterson" class="img-circle" width="70px" />
          <a href="#">画像を変更する</a><br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-1 col-sm-offset-1">
           <strong class="label label-primary">登録</strong>をクリックすると、本サイトで設定されている<a href="#" data-toggle="modal" data-target="#t_and_c_m">利用規約</a>（Cookieの使用を含む）に同意したことになります。
        </div>
      </div>
      
      <hr color="blue">
      <div class="row">
        <div class="col-xs-12 col-md-12"><input type="submit" value="登録" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
      </div>
      <!--<div class="modal-body">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
      </div>-->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</btton>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div><!-- container ends-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 text-center">

                    <p class="copyright text-muted small">Designed by XeQt for IEM. Copyright © 2014. All Rights Reserved.</p>
                </div>
            </div>
        </div><!--container ends-->
    </footer>


      <?php require('footer.php'); ?>
      <?php require('load_js.php'); ?>
  </body>
</html>
