<?php
    // 1.SELECT文
    // 2.画面表示
    // 3.ツイート編集
    // 4.更新ボタン押す
    // 5.UPDATE文
    session_start();
   require('../../developer/dbconnect.php');


    if (!isset($_GET['id'])) {
      header('Location: lists.php');
      exit();
    }

    $sql = 'SELECT `t`.* ,`u`.`user_name`,`u`.`profile_image_path` FROM `tweets` AS `t` LEFT JOIN  `users` AS `u` ON `t`. `user_id` = `u`.`id` WHERE `t`.`id`=?';
    $data = array($_GET['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $tweet = $stmt->fetch(PDO::FETCH_ASSOC);

    //更新処理を記述
    // 条件つけないと全てが同じになるので注意！！！
    if (!empty($_POST)) {
      if ($_POST['tweet'] != '') {
        $sql = 'UPDATE `tweets` SET `tweet`= ?,`modified`= NOW() WHERE `id`=?';
        $data = array($_POST['tweet'], $_GET['id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        header('Location: timeline.php');
        exit();
      }
    }
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <title></title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-xs-6 col-xs-offset-3">
        <h3>ツイート詳細画面</h3>
        <?php if ($tweet != false){ ?>
          <form method = "POST" action="">
            <?php echo $tweet['id']; ?>:<?php echo $tweet['user_name']; ?><br>
            <img src="profile_image/<?php echo $tweet['profile_image_path'];?>" width = "40px"><br>
            <textarea name="tweet" cols="40" rows="2"><?php echo $tweet['tweet']; ?></textarea><br>
            <span style="color: #7f7f7f;"><?php echo $tweet['created']; ?></span><br>
            <input type="submit" class="btn btn-info btn-xs" value="更新">
          </form>
        <?php } else { ?>
          <p class="alert alert-danger">そのツイートは削除されたか、URLが間違っています。</p>
        <?php } ?>
        <a href="timeline.php" class="btn btn-xs btn-warning">タイムラインへ</a>
      </div>
    </div>
  </div>
</body>
</html>





































