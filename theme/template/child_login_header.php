<?php
// session_start();
// require('../../../developer/dbconnect.php');

  //ログインチェック
  if (!isset($_SESSION['login_user']['id'])) {
      header('Location: un_login/sign_in.php');
      exit();
  }
  // ユーザID表示
  // echo "ユーザ： " . $_SESSION['login_user']['id'] .'<br>';

  // ユーザ情報を取得
  $sql = 'SELECT * FROM `atom_members` WHERE `id`=?';
  $data = array($_SESSION['login_user']['id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  // var_dump($result);

?>
<div class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="../home.php"><b>旅にもつ</b></a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="../contact.php" class="header">お問い合わせ</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="setting.php" class="header">
          <?php if(isset($_SESSION['login_user']['profile_image_path'])): ?>
            <img class="media-object dp img-circle" src="../../../profile_image_path/<?php echo $_SESSION['login_user']['profile_image_path']; ?>" style="width:auto; height: 15px;"><?php echo $result['account_name'];?>さん
          <?php else: ?>
            <img class="media-object dp img-circle" src="../../../profile_image_path/masaki.png" style="width:auto; height: 30px;">
          <?php endif; ?>
          <?php echo $result['account_name'];?>さん</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="myPage.php" class="header">マイページ</a></li>
      </ul>
<!--       <ul class="nav navbar-nav navbar-right">
        <li><a href="../lists.php" class="header">リスト作成</a></li>
      </ul> -->
      <ul class="nav navbar-nav navbar-right">
        <li><a href="../feature.php" class="header">特徴</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="../home.php" class="header">ホーム</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>