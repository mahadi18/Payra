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
	$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);
?>

<?php $error = false;

	if ( isset($_POST['btn-change']) ) {
		
		// clean user inputs to prevent sql injections
		$oldpass = trim($_POST['oldpass']);
		$oldpass = strip_tags($oldpass);
		$oldpass = htmlspecialchars($oldpass);
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		
		$passagain = trim($_POST['passagain']);
		$passagain = strip_tags($passagain);
		$passagain = htmlspecialchars($passagain);

		
		// basic name validation
		if (empty($oldpass)) {
			$error = true;
			$oldPassError = "Please enter your old password";

		} 
		if (empty($pass)) {
			$error = true;
			$passError = "Please enter your new password";

		}
		if (empty($passagain)) {
			$error = true;
			$matchError = "Please enter your new password again";

		}

		/*OLD password matching*/
		$old = $userRow['password'];
		if(strlen($old) != strlen($oldpass))
		{ ?>
			<script>
  				alert('Current password is not correct');
        	</script>
		<?php 
			//echo "old = ". $old . " oldPass = " . $oldpass;
			$error = true;
		}
		else{
			for ($i=0; $i <strlen($old) ; $i++) { 
				if($old[$i] != $oldpass[$i] )
				{
					?>
					<script>
  						alert('Current password is not correct');
        			</script>
					<?php
					$error = true;
					break;
				}
			}
		}

		/* Start here 
		else if (strlen($name) < 3) {
			$error = true;
			$nameError = "Name must have atleat 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
			$error = true;
			$nameError = "Name must contain alphabets and space.";
		}
		*/
		//basic email validation
		
		// new password validation
		if(strlen($pass) < 6) {
			$error = true;
			$passError = "Password must have atleast 6 characters.";
		}
		
		if(strlen($pass) != strlen($passagain))
		{ ?>
			<script>
  				alert('Re-enter new password correctly');
        	</script>
		<?php 
			$error = true;
		}
		else{
			for ($i=0; $i <strlen($pass) ; $i++) { 
				if($pass[$i] != $passagain[$i] )
				{
					?>
					<script>
  						alert('Re-enter new password correctly');
        			</script>
					<?php
					$error = true;
					break;
				}
			}
		}


		// password encrypt using SHA256();
		//$password = hash('sha256', $pass);
		
		// if there's no error, continue to signup
		if( !$error ) {
			
			//$query = "INSERT INTO users(user_name,user_email,password) VALUES('$name','$email','$pass')";

			$query ="UPDATE users SET password='$pass' WHERE user_id = ". $_SESSION['user'];
			$res = mysql_query($query);
				
			if ($res) {
					?>
					<script>
  						alert('Password has been changed successfully!');
  						window.location.href='index.php';
        			</script>
					<?php

				$errTyp = "success";
				$errMSG = "Password has been changed successfully!";
				unset($old);
				unset($pass);
				unset($passagain);
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again.";	
			}	
				
		}
		
		
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Change Password</title>

 <?php 
      include 'head.php';
  ?>

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

<div class="signin-form">

	<div id="container">
	<form class="form-signin" method="post" id="login-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
    	<!--div class="col-md-12">
        
        	<div class="form-group"-->
            	<h2 class="form-signin-heading">Change Password</h2>
            <!--/div-->
        
        	<div class="form-group">
            	<hr />
            </div>
            
          
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-qrcode"></span></span>
            	<input type="password" name="oldpass" class="form-control" placeholder="Enter Current Password" maxlength="32" />
                </div>
                <span class="text-danger"><?php echo $oldPassError; ?></span>
            </div>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            	<input type="password" name="pass" class="form-control" placeholder="Enter New Password" maxlength="32" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-check"></span></span>
            	<input type="password" name="passagain" class="form-control" placeholder="Enter New Password Again" maxlength="32" />
                </div>
                <span class="text-danger"><?php echo $matchError; ?></span>
            </div>

            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-change" id="btn-signup">
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Change
			</button> 


        </div> 
            
           
            
           
        
        
   
    </form>
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