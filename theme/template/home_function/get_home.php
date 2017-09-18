<?php
	require('../../developer/dbconnect.php');
  if( isset($_GET['level']) && isset($_GET['level_id']) ){
    
    $level = $_GET['level'];
    $level_id = $_GET['level_id'];
    echo "level: " . $level . '<br>';
    echo "level_id: ". $level_id .'<br>';
 //3階層目
	// $tmp_category_l2_id = 3;
	$sql = 'SELECT * FROM `atom_searchs` WHERE `categories_l2_id` = ? ' ;
	$data = array($level_id);
	$stmt = $dbh->prepare($sql);
	$stmt->execute($data);

	//全件取得
	$results_l3 = array();
	$i = 0;
	while (1) {
	  $results_l3[]= $stmt->fetch(PDO::FETCH_ASSOC);// １レコード分のみ取得
	  if ($results_l3[$i] == false) {
	    break;
	  }
	  $i++;
	  }

	  var_dump($results_l3);
	  // echo $DEV;

  } else {
    echo "--------- i lost -----------";
  }

?>