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
  $qry=mysql_query("SELECT * FROM users WHERE user_id !=".$_SESSION['user']." ORDER BY user_name ASC");
  //$allUserRow=mysql_num_rows($qry);
  //
	$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);

  $myid = $_SESSION['user'];
  $pen = mysql_query("SELECT * FROM request WHERE to_id=$myid");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Search For Friends</title>
  <?php 
      include 'head.php';
      //echo 'refresh';
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
      <?php
              
              $bul = mysql_fetch_array($pen);

              if( $bul ){
              ?>
        <div STYLE = "COLOR: #009999">
        <h1><b>Pending Friend Requests</b></h1>
        </div>
            <hr/>
            <hr/>
              <?php 
              
                $pend = mysql_query("SELECT * FROM request WHERE to_id=$myid");
                while($pRow = mysql_fetch_array($pend))
                {
                  $nem=mysql_query("SELECT * FROM users WHERE user_id !=".$_SESSION['user']." ORDER BY user_name ASC");
                  while($qRow = mysql_fetch_array($nem)){
                    if($pRow['from_id'] === $qRow['user_id'])
                    {
                      $pimg = $qRow['user_image'];?>
                      <h4><a href="profile.php?id=<?php echo $pRow['from_id']?>"> <?php  
                      echo "<img src='$pimg' height=40 width=40 >";
                      echo " ". $qRow['user_name'];?></a></h4><hr>
                    
                    <?php
                    }

                  }
              } 

            }         
        ?>
          


        <div STYLE = "COLOR: #009999">
        <h1><b>People You May Know</b></h1>
        </div>
            <hr/>
            <hr/>

          <?php

          while($row = mysql_fetch_array($qry))
          {

              $fqry = mysql_query("SELECT * FROM friends");
              $isFrnd=0;
              while ($ifFrnd=mysql_fetch_array($fqry)) {
                if($ifFrnd['friendA']===$_SESSION['user'] && $ifFrnd['friendB']===$row['user_id'] ){
                  $isFrnd=1;
                  break;
                }
              }
              
              $reqSent=0;
              $sqry = mysql_query("SELECT * FROM request");
              while ($reqSent=mysql_fetch_array($sqry)) {
                if($reqSent['from_id']===$_SESSION['user'] && $reqSent['to_id']===$row['user_id'] ){
                  $reqSent=1;
                  break;
                }
              }

              $requested=0;
              $rqry = mysql_query("SELECT * FROM request");
              while ($requested=mysql_fetch_array($rqry)) {
                if($requested['to_id']===$_SESSION['user'] && $requested['from_id']===$row['user_id'] ){
                  $requested=1;
                  break;
                }
              }

                if(!$ifFrnd && !$reqSent && !$requested){
                    $img = $row['user_image'];?>
                      
                     <h4><a href="profile.php?id=<?php echo $row['user_id']?>"> <?php  
                      echo "<img src='$img' height=40 width=40 >";
                    echo " ".$row['user_name']."<br>";?></a></h4><hr>
                    
                    <?php
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


