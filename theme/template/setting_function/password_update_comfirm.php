<?php

    // 新パスワードが入力されている際の、文字数チェック
    if (!empty($new_password) && strlen($new_password) < 8) {
      $errors['new_password'] = 'length';
    }
    // 確認用パスワードが入力されている際の、文字数チェック
    if (!empty($comfirm_password) && strlen($comfirm_password) < 8) {
      $errors['comfirm_password'] = 'length';
    }

    if (!empty($new_password) && strlen($new_password) >= 8 && !empty($comfirm_password) && strlen($comfirm_password) >= 8) {
      // 新パスワードと確認用パスワードが一致しているかチェック
      if ($new_password != $comfirm_password) {
        $errors['comfirm'] = 'mismatch';
      }else{
        // 現在のパスワードが入力されているかチェック
        if ($now_password == '') {
          $errors['now_password'] = 'blank';
        }else{
        // 入力された現在のパスワードがあっているかのチェック
        $sql = 'SELECT * FROM `atom_members` WHERE `id`=?';
        $data = array($_SESSION['login_user']['id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        $login_user_info = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($login_user_info['password'] != sha1($now_password)) {
          $errors['now_password'] = 'mismatch';
        }
        // エラーが一つもない場合
        if (empty($errors)) {
          $sql = 'UPDATE `atom_members` SET `password`=? WHERE `id`=?';
          $data = array(sha1($new_password),$_SESSION['login_user']['id']);
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);

          // パスワードの上書き
          $_SESSION['login_user']['password'] = sha1($new_password);
        }
        }
      }
    }

    ?>