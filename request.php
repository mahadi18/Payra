<?php
    ob_start();
    session_start();
	include_once 'dbconnect.php';

// if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    /* select loggedin users detail
    $res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
    $userRow=mysql_fetch_array($res);*/

if(isset($_GET['id']))
{    
	 $id = $_GET['id'];
	 $user = $_SESSION['user'];
	 $res="INSERT INTO request (to_id, from_id) VALUES ('$id', '$user')";
	 
	 if(mysql_query($res))
	 {?>
	 	<script type="text/javascript">
	 		alert('Friend Request Sent!');
	 		window.location.href='profile.php?id=<?php echo $id; ?>'
	 	</script>

	 <?php
	}

}    



ob_end_flush(); ?>