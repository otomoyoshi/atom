<?php
	require('../../../developer/dbconnect.php');
  if( isset($_GET['level']) && isset($_GET['level_id']) ){
    
    $level = $_GET['level'];
    $level_id = $_GET['level_id'];
    // echo "level: " . $level . '<br>';
    // echo "level_id: ". $level_id .'<br>';
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
	  $DEV = 6;

	  $cnt_l3 = count($results_l3)-1;
	  $cnt_l3_div = (int)($cnt_l3 / ($DEV+1));
	  $cnt_l3_sur = $cnt_l3 % ($DEV+1);
	// var_dump($results_l3);
	

  } else {
    echo "--------- i lost -----------";
  }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<!-- 	<meta charset="utf-8">
	<title></title> -->
</head>
<body>
            <!-- <div id='tab-3'> -->

              <?php
                $i=0;
                for($j=0; $j<=$cnt_l3; $j++) {
                  $div = (int)(($j+1) / ($DEV+1));
                  if($j % $DEV == 0){
                    $i = $j + $DEV -1;
              ?>
                    <div class="row dev_border">
                  <?php } ?>
                    <!-- <div class="col-lg-2 text-center tabs" id="tab3_<?php echo $i ?>"> -->
                    <div class="col-lg-2 text-center tabs" id="tab3_<?php echo $j+1 ?>">
                      <?php echo $results_l3[$j]['word']; ?>
                    </div>

                  <?php if( ($j == $i && $div < $cnt_l3_div) || ($cnt_l3_sur == ($j % $DEV) && $div == $cnt_l3_div)){ ?>
                    </div>
                  <?php } ?>
              <?php } ?>
            <!-- </div>tab-3 -->
</body>
</html>

