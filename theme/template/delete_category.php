<?php
 
    //削除機能には画面が不要なので、HTMLは書かない。
    session_start();
    require('../../developer/dbconnect.php');

    //パラメータが存在するかチェック

    if (!isset($_GET['id'])) {
      header('Location: lists.php');
      exit();
    }
    //ログインチェック
    if (!isset($_SESSION['login_user']['id'])) {
        header('Location: lists.php');
    }


    $sql = 'SELECT * FROM `atom_items` WHERE `id`=?';
    $data = array($_GET['id']);//パラメータの値
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = 'SELECT * FROM `atom_members` WHERE `id`=?';
    $data = array($_SESSION['login_user']['id']);//パラメータの値
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $user_record = $stmt->fetch(PDO::FETCH_ASSOC);
    //var_dump($record);

    if ($_SESSION['login_user']['id'] == $user_record['id']) {
        echo 'hogehbsjdasva';
        $sql = 'DELETE FROM `atom_items` WHERE `id`= ?';
        $data = array($_GET['id']); 
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
    }

    // パラメータのidを使ってDELETE文発行
    //削除文(DELETE文)
    // $sql = 'DELETE FROM `テーブル名` WHERE `カラム`= 値';

    header('Location: lists.php');
    exit();


?>