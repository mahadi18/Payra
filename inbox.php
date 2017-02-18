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
	$self = $_SESSION['user'];
	$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);

	$id = $_GET['id'];
	$qry=mysql_query("SELECT * FROM users WHERE user_id ='$id'");
	$idRow=mysql_fetch_array($qry);
    $msg2;

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Inbox ~ Payra</title>
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
        <h1><b><?php echo $idRow['user_name']; ?></b></h1>
        </div><hr>
        
        
        							
      
		<form action="send.php?id=<?php echo $idRow['user_id']; ?>" method="post" enctype="multipart/form-data">
		<textarea name="message" placeholder="Enter Your Messages" style="resize:none" rows="4" cols="100"></textarea><br/><br/> 
			<div STYLE = "POSITION: absolute; TOP: 195px; LEFT: 750px">
                <button type="submit" name="btn-request" class="btn btn-default">
                <span class="glyphicon glyphicon-envelope"></span> &nbsp; Send
                </button>
            </form>
              <br /><br />
             </div>

<?php
    
        $msg_retrv_query = mysql_query("SELECT * FROM message WHERE (from_id='$self' AND to_id='$id') OR (from_id='$id' AND to_id='$self') ORDER BY msg_time DESC");

      $count=0;
      while($msg_row = mysql_fetch_array($msg_retrv_query))
	    {
        $count++;
		   	if( $msg_row['from_id'] == $id)
        {
          echo "<hr><h3>".$idRow['user_name']."</h3>";
        }
        else
        {
          echo "<hr><h3>".$userRow['user_name']."</h3>";
        }
		   	echo "<br><b>".$msg_row['body']."</b>";
		   	$t = $msg_row['msg_time'];

        $hh="";
        for($i=11; $i<13; $i++)
        {
          $hh = $hh.$t[$i];
        }
        $hh = (int)$hh;
        $am_pm="am";
        if($hh>12)
        {
          $am_pm = "pm";
          $hh = $hh-12;
        }

        $mm="";
        for($i=14; $i<16; $i++)
        {
          $mm = $mm.$t[$i];
        }
        //$mm = (int)$mm;

        echo "<br>".$hh.":".$mm." ".$am_pm."<br>";


        for ($i=8; $i <10 ; $i++) { 
              echo $t[$i];
            }
            echo " ";
            $mon="";
            for ($i=5; $i <7 ; $i++) { 
              $mon.= $t[$i];
            }
            $month = (int)$mon;
            if($month==1) echo "January "; if($month==2) echo "Febryary ";
            if($month==3) echo "March ";   if($month==4) echo "April ";

            if($month==5) echo "May ";    if($month==6) echo "June ";
            if($month==7) echo "July ";   if($month==8) echo "August ";

            if($month==9) echo "September "; if($month==10) echo "October ";
            if($month==11) echo "November ";   if($month==12) echo "December ";

            for ($i=0; $i <4 ; $i++) { 
              echo $t[$i];
            }





        //if($count===5) break;
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