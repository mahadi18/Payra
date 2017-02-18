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
<!DOCTYPE html>
<html>
<head>
  <title>Payra ~ Home</title>
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
        
        
      <br><br>
        <div STYLE = "COLOR: #009999">
        <h1><b><?php echo $userRow['user_name']; ?></b></h1>
        </div>
        
        <div STYLE = "COLOR: #ff0066">
        <h4><i>
        <?php
          if(!empty($userRow['user_pos']))
              echo $userRow['user_pos'] . " @ " . $userRow['user_work']; ?></i></h4>
         </div>
        

        
        <div STYLE = "COLOR: #660033">
          <h3> Birthday </h3> 
        </div>
        <div STYLE = "COLOR: #cc3300">
        <h4><?php 
            $bdate = $userRow['user_birthday'];
            if($bdate[0]=='0')
            {
              echo "";
            }
            else
            {
            for ($i=8; $i <10 ; $i++) { 
              echo $bdate[$i];
            }
            echo " ";
            $mon="";
            for ($i=5; $i <7 ; $i++) { 
              $mon.= $bdate[$i];
            }
            $month = (int)$mon;
            if($month==1) echo "January "; if($month==2) echo "Febryary ";
            if($month==3) echo "March ";   if($month==4) echo "April ";

            if($month==5) echo "May ";    if($month==6) echo "June ";
            if($month==7) echo "July ";   if($month==8) echo "August ";

            if($month==9) echo "September "; if($month==10) echo "October ";
            if($month==11) echo "November ";   if($month==12) echo "December ";

            for ($i=0; $i <4 ; $i++) { 
              echo $bdate[$i];
            }
          }

         ?></h4>

         <div STYLE = "COLOR: #660033">
          <h3> Interest </h3> 
        </div>
        <div STYLE = "COLOR: #cc3300">
        <h4> <?php echo $userRow['user_interest']; ?>
        </h4></div> 

        <div STYLE = "COLOR: #660033">
          <h3> Relationship Status </h3> 
        </div>
        <div STYLE = "COLOR: #cc3300">
        <h4> <?php echo $userRow['user_relation']; ?>
        </h4></div> 

        <div STYLE = "COLOR: #660033">
          <h3> About </h3> 
        </div>
        <div STYLE = "COLOR: #cc3300">
        <h4> <?php $userAbout = $userRow['user_self'];
                  $len = strlen($userAbout);
                  $s=0;
                for ($i=0; $i <$len ; $i++) { 
                  if($s>=80 && $userAbout[$i]==' ')
                  {
                    echo "<br><br>";
                    $s = 0;
                  }
                  else 
                  {
                    echo $userAbout[$i];
                    $s++;
                  }
                }

               ?>
        </h4></div> 
        

        </div>

          <div STYLE = "POSITION: absolute; TOP: 90px; LEFT: 750px">

          <?php
              $img = $userRow['user_image'];
              echo "<img src='$img' height=200 width=200 >";
        ?>

        
        
        <form action="upload.php" method="post" enctype="multipart/form-data">

          <input type="file" class="custom-file-input" name="file" />
          <button type="submit" name="btn-upload" class="btn btn-default">
          <span class="glyphicon glyphicon-upload"></span> &nbsp; Update Profile Picture
          </button>
        </form>
              <br /><br />
        </div>

         <?php
 if(isset($_GET['success']))
 {
  ?>
        <label>File Uploaded Successfully...</label>
        <?php
 }
 else if(isset($_GET['fail']))
 {
  ?>
        <label>Problem While File Uploading !</label>
        <?php
 }
 else
 {
  ?>
        <?php
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