<?
	require('../../developer/dbconnect.php');

	// アイテムのidを取得
	if(isset($_POST['item_id'])){
		echo $_POST['item_id'];
	}

	// 機内・預入の値を取得(0~3)
	if(isset($_POST['category_id'])){
		echo $_POST['category_id'];
		$category_id = (int)$_POST['category_id'];
	}else {
		$category_id = 3;
	}

	// チェックがされているか
	// if(isset($_POST['check'])){
	// 	echo $_POST['check'];
	// 	$check = 1;
	// }else{
	// 	$check = 0;
	// }

	// 更新処理
	// $sql= 'UPDATE `atom_items` SET `categories_id`=?, `item_check`=? WHERE `id`=?';
	$sql= 'UPDATE `atom_items` SET `categories_id`=? WHERE `id`=?';
	// $data = array($category_id, $check, (int)$_POST['item_id']);
	$data = array($category_id, (int)$_POST['item_id']);
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

	<!-- アイテム移動後-->
	<div id="condition">
		<label class="width">
			<li class="list-group-item list_float" id="<?php echo $result['id'];?>">
				<?php if ($result['item_check'] == 1) { ?>
					<input type="hidden" name="check_judge" value="checked" checked>
					<input type="checkbox" name="che[]" class="left checkbox laggage_both" value="<?php echo $result['id'];?>" checked>
					<span class="checkbox-icon"></span>
				<?php } else { ?>
					<input type="hidden" name="check_judge" value="checked">
					<input type="checkbox" name="che[]" class="left checkbox laggage_both" value="<?php echo $result['id'];?>">
					<span class="checkbox-icon"></span>
				<?php } ?>
				<span class="text_overflow">
					<?php  echo htmlspecialchars($result['content']); ?>
				</span>
				<!-- 削除ボタン -->
				<a href="delete_category.php?id=<?php echo $_GET['id']?>&item_id=<?php echo $result['id'];?>">
				<i class="fa fa-trash right_position"></i>
				</a>
				<!-- アイテム移動ボタン -->
				<a data-remodal-target="modal_edit" class="edit">
					<i class="fa fa-tags right edit" value="<?php echo $result['id'];?>"></i>
				</a>

				<!-- 条件表示ボタン -->
				<?php if (isset($result['condition_azukeire']) || isset($result['condition_carry_in'])){ ?>
					<?php if ($result['condition_azukeire'] != '' || $result['condition_carry_in'] != ''){ ?>
					  <a data-remodal-target="modal-condition" class="show_condition">
					    <i class="fa fa-exclamation-triangle right_position con" value="<?php echo $result['id'];?>"></i>
					  </a>
					<?php } ?>
				<?php } ?>
			</li>
		</label>
	</div>
</body>
</html>