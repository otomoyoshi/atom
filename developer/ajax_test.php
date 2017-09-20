

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>hello world</h1>
	<!-- <div id="result"></div> -->
	<?php
      if (isset($_POST['result'])){ //ajaxの値が存在したら
        echo $_POST['result'];
        if($_POST['result'] == true) {
            $encourage = 'encourage';
            echo "T";
        } else {
            echo "F";
        }
      }
?>

</body>
</html>