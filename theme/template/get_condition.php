<?
	require('../../developer/dbconnect.php');
	echo '両方';

	if(isset($_POST['id'])){
		echo $_POST['id'];
	}

	$sql = 'SELECT * FROM `atom_items` WHERE `id`= ?';
	// $sql = 'SELECT * FROM `atom_searchs` WHERE `id`= ?';
	$data = array($_POST['id']);
	$stmt = $dbh->prepare($sql);
	$stmt ->execute($data);
	$search = $stmt->fetch(PDO::FETCH_ASSOC); //判定結果を取得

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>

	<!-- 条件表示 pop-->
	<?php if(!isset($search['condition_carry_in']) && !isset($search['condition_azukeire'])){ ?>
		<div id="condition">
			<span>条件はありません。</span>
		</div>
	<?php }else{ ?>
		<div id="condition">
			<h2>機内持ち込み条件</h2>
			<?php if(isset($search['condition_carry_in'])) { ?>
				<span><?php echo $search['condition_carry_in'];?></span>
			<?php } ?>
			
			<?php if(isset($search['per_person'])) { ?>
				<p class="per_something">一人当たり</p>
				<span><?php echo $search['per_person'];?></span>
			<?php } ?>
			<hr>
			<h2>お預け条件</h2>
			<?php if(isset($search['condition_azukeire'])){ ?>
				<span><?php echo $search['condition_azukeire'];?></span>
			<?php } ?>
			
			<?php if(isset($search['per_container'])) { ?>
				<p class="per_something">一容器あたり</p>
				<span><?php echo $search['per_container'];?></span>
			<?php } ?>
		</div>
	<? } ?>

</body>
</html>