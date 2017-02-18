<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';

  $page = $_SERVER['PHP_SELF'];
  $sec = "10";
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	// select loggedin users detail
	$res=mysql_query("SELECT * FROM users WHERE user_id = ".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);

  
?>
<!DOCTYPE html>
<html>
<head>
<title>Friends ~ Payra</title>
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
        
        
        <div STYLE = "COLOR: #009999">
        <h1><b>Friends of yours</b></h1>
        </div>

        <hr/>
        <hr>
        <?php
              
              $qry=mysql_query("SELECT * FROM users WHERE user_id !=".$_SESSION['user']." ORDER BY user_name ASC");
              //$friendRow=mysql_fetch_array($resf);
              //var_dump($friendRow);
              while($rw = mysql_fetch_array($qry))
              { 
                //var_dump($row['friendB']);
                  $resf=mysql_query("SELECT friendB FROM friends WHERE friendA=".$_SESSION['user']);
                  
                 while($row = mysql_fetch_array($resf))
                  {
                    
                    if($row['friendB'] == $rw['user_id'])
                    {
                      $img = $rw['user_image'];?>
                      
                     <h4><a href="profile.php?id=<?php echo $rw['user_id']?>"> <?php  
                      echo "<img src='$img' height=40 width=40 >";

                       echo "   ".$rw['user_name']."<br>";?></a></h4><hr>
                    
                    <?php
                    }
                  }
              }

        ?>


       </div> 
       </div> 
    </div>
    
    </div>
    
    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>
<?php ob_end_flush(); ?>