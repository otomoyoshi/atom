<?php
 
    // //削除機能には画面が不要なので、HTMLは書かない。
    // session_start();
    // require('../../developer/dbconnect.php');

    // //パラメータが存在するかチェック

    // if (!isset($_GET['id'])) {
    //   header('Location: lists.php');
    //   exit();
    // }
    // //ログインチェック
    // // if (!isset($_SESSION['login_user']['id'])) {
    // //     header('Location: lists.php');
    // // }

    // //本人チェック（削除ツイートがログインユーザーのものかどうか）
    // //ログインユーザー本人のidは$_SESSIOON['login_user']['id']
    // // 削除ツイートのuser_idはSELECTで取得する。
    // $sql = 'SELECT `items` FROM `items` WHERE `id` = ?';
    // $data = array($_GET['id']);//パラメータの値
    // $stmt = $dbh->prepare($sql);
    // $stmt->execute($data);
    // $record = $stmt->fetch(PDO::FETCH_ASSOC);
    // //ASSOC →　associate
    // //配列　→array
    // //連想配列 →　associative array
    // // 連想配列にする→
    // // テーブルから１レコード分のデータ
    // //redordがなくなるとfalse
    // if ($_SESSION['login_user']['id'] == $record['user_id']) {
    //     $sql = 'DELETE FROM `` WHERE `id`= ?';
    //     $data = array($_GET['id']);
    //     $stmt = $dbh->prepare($sql);
    //     $stmt->execute($data);
    // }

    // // パラメータのidを使ってDELETE文発行
    // //削除文(DELETE文)
    // // $sql = 'DELETE FROM `テーブル名` WHERE `カラム`= 値';

    // header('Location: timeline.php');
    // exit();


?>