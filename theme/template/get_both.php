<?
	require('../../developer/dbconnect.php');
	echo '両方';

	if(isset($_POST['item_id'])){
		echo $_POST['item_id'];
	}

	if(isset($_POST['category_id'])){
		echo $_POST['category_id'];
		$category_id = $_POST['category_id'];
	}else {
		$category_id = 4;
	}

	// 削除処理
	$sql = 'UPDATE `atom_items` WHERE `id`= ?';
	$sql= 'UPDATE `atom_items` SET `baggage_classify`=? WHERE `id`=?';
	$data = array($category_id);
	$stmt = $dbh->prepare($sql);
	$stmt ->execute($data);

	// 情報取得
	$sql= 'SELECT * FROM `atom_items` WHERE `id`=?';
    $data = array($_POST['item_id']);
    $stmt = $dbh->prepare($sql);
    $stmt ->execute($data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>

	<!-- 条件表示 pop-->
	<div id="condition">
		 <li class="list-group-item list_float">
            <input type="hidden" name="check_judge" value="checked">
            <input type="checkbox" name="che[]" class="left checkbox" value="<?php echo $result['id']?>" checked>
            <span class="checkbox-icon"></span>
          <span class="text_overflow">
          	<?php  echo htmlspecialchars($result['content']); ?>
          </span>
          <a href="delete_category.php?id=<?php echo $_GET['id']?>&item_id=<?php echo $item_carry_in['id'];?>">
            <i class="fa fa-trash right_position"></i>
          </a>
<!--       編集ボタン
          <span>
           <i class="fa fa-pencil-square-o right"></i>
          </span> -->
        </li>
	</div>

</body>
</html>