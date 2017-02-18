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
	$selfid = $_SESSION['user'];

 
  	
?>

<!DOCTYPE html>
<html>
<head>
<!--meta http-equiv="Content-Type" content="text/html; charset=utf-8" /-->
<!--meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'"-->
<title></title>

<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
<link rel="shortcut icon" href="payra.ico" />
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body class="back-prop">

	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://localhost/Messenger/home.php"><img src='payra.ico' height=40 width=40 ></a>
          <a class="navbar-brand" href="http://localhost/Messenger/home.php">)) পায়রা ((</a>

          
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          <!--li><a href="http://localhost/Messenger/home.php">|</a></li-->
          <li><a href="http://localhost/Messenger/home.php">Home</a></li>
            <li><a href="http://localhost/Messenger/messages.php">Messeges</a></li>
            <li><a href="friends.php">Friends</a></li>
            <li><a href="http://localhost/Messenger/people.php">
            <?php 
            $hen = mysql_query("SELECT * FROM request WHERE to_id=$selfid");
  			$bul2 = mysql_fetch_array($hen);
            if($bul2){ echo "<img src=notify.png height=20 width=20 >"; }; ?>Connecting People</a></li>
            <!--li><form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input type="text" class="form-control">
						</div> 
						<button type="submit" class="btn btn-default">
							Search
						</button>
					</form></li-->
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>
        <!--?php $img = $userRow['user_image'];
              echo "<img src='$img' height=30 width=30 >"; ?-->&nbsp; 
              <?php echo $userRow['user_name']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
              <li><a href="details.php"><span class="glyphicon glyphicon-pencil"></span>&nbsp; Edit details</a></li>
                <li><a href="password.php"><span class="glyphicon glyphicon-lock"></span>&nbsp; Change password</a></li>
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Log out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav> 
	
</body>
</html>
<?php ob_end_flush(); ?>