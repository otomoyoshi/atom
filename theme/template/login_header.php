<?php
// session_start();
require('../../developer/dbconnect.php');

  //ログインチェック
  // if (!isset($_SESSION['login_user']['id'])) {
  //     header('Location: un_login/sign_in.php');
  //     exit();
  // }
  // ユーザID表示
  // echo "ユーザ： " . $_SESSION['login_user']['id'] .'<br>';

  // ユーザ情報を取得
  $sql = 'SELECT * FROM `atom_members` WHERE `id`=?';
  $data = array($_SESSION['login_user']['id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<div class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php"><b>旅にもつ</b></a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a id="contact_head" href="contact.php" class="header">お問い合わせ</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li ><a id="setting_head" href="login/setting.php" class="header" id="move_header">
          <?php if(isset($_SESSION['login_user']['profile_image_path'])): ?>
            <img id="setting_img" class="media-object dp img-circle" src="../../profile_image_path/<?php echo $_SESSION['login_user']['profile_image_path']; ?>" style="width: 40px; height: 40px;">
            <span>
              <?php echo $result['account_name'];?>さん
            </span>
          <?php else: ?>
            <img id="setting_img" class="media-object dp img-circle" src="../assets/img/user_circle.png" style="width: 40px; height: 40px;">
            <!-- <img class="media-object dp fa fa-user-circle" style="width: 40px; height: 40px;"> -->
            <!-- <i class="fa fa-user-circle" aria-hidden="true" style="font-size: xx-large; color: #ffffff; vertical-align: middle; "></i> -->
            <?php echo $result['account_name'];?>さん
          <?php endif; ?>
        </a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a id="mypage_head" href="login/myPage.php" class="header">持ち物リスト</a></li>
      </ul>
<!--       <ul class="nav navbar-nav navbar-right">
        <li><a href="lists.php" class="header">リスト作成</a></li>
      </ul> -->
      <ul class="nav navbar-nav navbar-right">
        <li><a id="feature_head" href="feature.php" class="header">特徴</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a id="home_head" href="home.php" class="header">ホーム</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>