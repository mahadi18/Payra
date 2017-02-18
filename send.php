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
	$self = $_SESSION['user'];
	$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);

	$id = $_GET['id'];
	//var_dump($id);
	$qry=mysql_query("SELECT * FROM users WHERE user_id ='$id'");
	$idRow=mysql_fetch_array($qry);
    //$msg2;

    if(isset($_POST['message']))
   {        	
   		$msg = trim($_POST['message']);
		$msg = strip_tags($msg);
    	$msg = htmlspecialchars($msg);

    	/*$c=0;
    	for($i=0; $i<strlen($msg); $i++)
    	{
    		if($msg[$i] === $msg2[$i])
    			$c++;
    		else
    			break;
    	}*/

    	$date = new DateTime("now", new DateTimeZone('Asia/Dhaka') );
            //echo $date." <br>";
		$time = $date->format('Y-m-d H:i:s');

		

	?><hr><hr><?php
    		//echo $msg."<br>";
    		if($c != strlen($msg))
    		{
            	$msg_insrt_query="INSERT INTO message (to_id, from_id, body, msg_time) VALUES ('$id', '$self', '$msg', '$time')";
            	$msg_qry = mysql_query($msg_insrt_query);
            }
            //echo $time." <br>";
			//echo strlen($time);

            $msg2 = $msg;

			if($msg_qry)
				unset($msg);

        }
        $ii = $idRow['user_id'];

        echo $ii." == id <br>";
        //var_dump($ii);
?>

        <script>
              
              window.location.href='inbox.php?id=<?php echo $idRow['user_id']; ?>';
        </script>
<?php 
ob_end_flush(); ?>