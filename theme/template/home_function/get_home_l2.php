<?php
	require('../../../developer/dbconnect.php');
  if( isset($_GET['level']) && isset($_GET['level_id']) ){
    
    $level = $_GET['level'];
    $level_id = $_GET['level_id'];
    // echo "level: " . $level . '<br>';
    // echo "level_id: ". $level_id .'<br>';
	 // $tmp_category_l1 = 1;

	//2階層目のデータを取得
	$sql = 'SELECT * FROM `atom_categories_l2` WHERE `category_l1_id`=? ' ;
	$data = array($level_id);
	$stmt = $dbh->prepare($sql);
	$stmt->execute($data);

	//全件取得
	$results_l2 = array();
	$i = 0;
	while (1) {
	  $results_l2[]= $stmt->fetch(PDO::FETCH_ASSOC);// １レコード分のみ取得
	  if ($results_l2[$i] == false) {
	    break;
	  }
	  $i++;
  	}
  $DEV = 6;

  $cnt_l2 = count($results_l2)-1;
  $cnt_l2_div = (int)($cnt_l2 / ($DEV+1));
  $cnt_l2_sur = $cnt_l2 % ($DEV+1);
  // var_dump($results_l2);

  } else {
    echo "--------- i lost -----------";
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<!-- <meta charset="utf-8">
	<title></title> -->
</head>
<body>
  <div id='tab-2'>
    <?php
      $i=0;
      for($j=0; $j<=$cnt_l2; $j++) {

      $div = (int)(($j+1) / ($DEV+1));
      // echo "div-default: " . $j . '<br>';
      // echo "cnt_l2: " . $cnt_l2 . '<br>';
      // echo "cnt_l2_div: " . $cnt_l2_div . '<br>';
      // echo "cnt_l2_sur: " . $cnt_l2_sur . '<br>';
        if($j % $DEV == 0){
          $i = $j + $DEV - 1;
    ?>
          <div class="row dev_border">
        <?php } ?>

        <div class="col-lg-2 text-center tabs" id="tab2_<?php echo $j+1 ?>">
          <?php echo $results_l2[$j]['category_l2']; ?>
        </div>

       <?php if( ($j == $i && $div < $cnt_l2_div) || ($cnt_l2_sur == ($j % $DEV) && $div == $cnt_l2_div) ) { ?>
        </div><!-- row-->
      <?php } ?><!-- if -->

    <?php } ?><!-- for -->
  </div><!-- tab2 -->
</body>
</html>


