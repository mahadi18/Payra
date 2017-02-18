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
                      
                     <h4><a href="profile.php?id=<?php echo $rw['user_id']; ?>"> <?php  
                      echo "<img src='$img' height=40 width=40 >";

                       echo "   ".$rw['user_name']."<br>";?></a></h4><hr>
                    
                    <?php
                    }
                  }
              }

ob_end_flush(); ?>