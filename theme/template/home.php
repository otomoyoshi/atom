<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../assets/img/favicon.png">

    <title>旅にもつ</title>
    <?php require('load_css.php'); ?>

  </head>

  <body>
  <?php require('header.php'); ?>
	<div id="headerwrap">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-lg-8">
					<h2>「荷造りの悩み」ここに置いて行きませんか？</h2>
					<form>
						<div class="form-group">
						  <!-- <label for="sel1"></label> -->
						  <select class="form-control" id="sel1">
						    <option>JetStar</option>
						  </select>
						</div>

					  <div class="form-group">
					  	<input type="text" id="search" class="form-control" placeholder="例：液体物" maxlength=10>
					  </div>
					  <button id="search-btn" type="submit" class="btn btn-warning btn-lg ">検索</button>
					</form>
				</div><!-- /col-lg-6 -->
				<div class="col-xs-12 col-lg-4">
					<!-- <img class="img-responsive" src="assets/img/ipad-hand.png" alt=""> -->
          <!-- <img class="img-responsive" src="assets/img/taiki.jpg" alt=""> -->
				</div><!-- /col-lg-6 -->

			</div><!-- /row -->
		</div><!-- /container -->
	</div><!-- /headerwrap -->


  <?php require('footer.php'); ?>

  <?php require('load_js.php'); ?>

  </body>
</html>
