<?php
  if( isset($_GET['level']) && isset($_GET['level_id']) ){
    
    $level = $_GET['level'];
    $level_id = $_GET['level_id'];

    echo "結果: " . $level . $level_id;

  } else {
    echo "--------- i lost -----------";
  }

?>