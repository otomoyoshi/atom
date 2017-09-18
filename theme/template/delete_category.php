<?php

    //削除機能には画面が不要なので、HTMLは書かない。
    session_start();
    require('../../developer/dbconnect.php');

    //パラメータが存在するかチェック
    if (!isset($_GET['id']) && !isset($_GET['item_id'])) {
      header('Location: login/myPage.php');
      exit();
    }
    // echo $_GET['item_id'];
    // echo $_GET['id'];

    //ログインチェック
    if (!isset($_SESSION['login_user']['id'])) {
        header('Location: login/sign_in.php');
    }

    // 削除するアイテムを取得
    $sql = 'SELECT * FROM `atom_items` WHERE `id`=?';
    $data = array($_GET['item_id']);//パラメータの値
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($record);

    // ユーザ情報を取得
    $sql = 'SELECT * FROM `atom_members` WHERE `id`=?';
    $data = array($_SESSION['login_user']['id']);//パラメータの値
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $user_record = $stmt->fetch(PDO::FETCH_ASSOC);
    var_dump($user_record);

    // ユーザが一致しているか確認
    if ($_SESSION['login_user']['id'] == $user_record['id']) {
        echo 'delete';
        $sql = 'DELETE FROM `atom_items` WHERE `id`= ?';
        $data = array($_GET['item_id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
    }

    header('Location: lists.php?id=' . $_GET['id']);
    exit();



?>