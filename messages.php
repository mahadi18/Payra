<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';

	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	// select loggedin users detail
	$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);
?>
<!DOCTYPE html>
<html>
<head>
  <?php 
      include 'head.php';
  ?>
</head>
<body class="back-prop">



	<div id="wrapper">

	<div class="container">
    
    	<!--div class="page-header">
    	<h3>JJ Messenger</h3>
    	</div-->
        
      <div class="row">
        <div class="col-lg-12">
        <hr/>
        <hr/>
        
      <div class="tabbable" id="tabs-95714">
				<ul class="nav nav-tabs">
					<li>
						<a href="#panel-789343" data-toggle="tab">Inbox</a>
					</li>
					<li class="active">
						<a href="#panel-775290" data-toggle="tab">Compose</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane" id="panel-789343">
						<p>
							<hr>
							<?php include 'friendlist.php'; ?>
						</p>
					</div>
					<div class="tab-pane active" id="panel-775290">
						<p>
							<hr><h3>Compose New Message Now</h3><hr>
							

						</p>
					</div>
				</div>
			</div>


        
        </div>
      </div>
    
    </div>
    
    </div>
    
    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>
<?php ob_end_flush(); ?>