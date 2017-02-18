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

	$id = $_GET['id'];
	$qry=mysql_query("SELECT * FROM users WHERE user_id ='$id'");
	$idRow=mysql_fetch_array($qry);



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

      <div STYLE = "COLOR: #009999">
        <h1><b><?php echo $idRow['user_name']; ?></b></h1>
        </div>
        
        <div STYLE = "COLOR: #ff0066">
        <h4><i>
        <?php
          if(!empty($idRow['user_pos']))
              echo $idRow['user_pos'] . " @ " . $idRow['user_work']; ?></i></h4>
         </div>
        

        <hr />
        <div STYLE = "COLOR: #660033">
          <h3> Birthday </h3> 
        </div>
        <div STYLE = "COLOR: #cc3300">
        <h4><?php 
            $bdate = $idRow['user_birthday'];
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

         ?></h4><hr>

         <div STYLE = "COLOR: #660033">
          <h3> Interest </h3> 
        </div>
        <div STYLE = "COLOR: #cc3300">
        <h4> <?php echo $idRow['user_interest']; ?>
        </h4></div> <hr/>

        <div STYLE = "COLOR: #660033">
          <h3> Relationship Status </h3> 
        </div>
        <div STYLE = "COLOR: #cc3300">
        <h4> <?php echo $idRow['user_relation']; ?>
        </h4></div> <hr/>

        <div STYLE = "COLOR: #660033">
          <h3> About </h3> 
        </div>
        <div STYLE = "COLOR: #cc3300">
        <h4> <?php $userAbout = $idRow['user_self'];
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
        <hr/>


        </div>

          <div STYLE = "POSITION: absolute; TOP: 25px; LEFT: 750px">

          <?php
              $img = $idRow['user_image'];
              echo "<img src='$img' height=200 width=200 >";


              $fqry = mysql_query("SELECT * FROM friends");
              $isFrnd=0;
              while ($ifFrnd=mysql_fetch_array($fqry)) {
              	if($ifFrnd['friendA']===$_SESSION['user'] && $ifFrnd['friendB']===$idRow['user_id'] ){
              		$isFrnd=1;
              		break;
              	}
              }
              
              $reqSent=0;
              $sqry = mysql_query("SELECT * FROM request");
              while ($reqSent=mysql_fetch_array($sqry)) {
              	if($reqSent['from_id']===$_SESSION['user'] && $reqSent['to_id']===$idRow['user_id'] ){
              		$reqSent=1;
              		break;
              	}
              }

              $requested=0;
              $rqry = mysql_query("SELECT * FROM request");
              while ($requested=mysql_fetch_array($rqry)) {
              	if($requested['to_id']===$_SESSION['user'] && $requested['from_id']===$idRow['user_id'] ){
              		$requested=1;
              		break;
              	}
              }

              if(!$ifFrnd && $reqSent){
              		// if friend request is sent already
              	?>

              	<form action="profile.php?id=<?php echo $idRow['user_id'] ?>" method="post" enctype="multipart/form-data">
          			<button type="submit" name="btn-request" class="btn btn-default">
          			<span class="glyphicon glyphicon-plus"></span> &nbsp; Friend Request Sent
          			</button>
        		</form>
              <br /><br />

              <?php
          	}
          	else if(!$ifFrnd && $requested){?>

              	<form action="accept.php?id=<?php echo $idRow['user_id'] ?>" method="post" enctype="multipart/form-data">
          			<button type="submit" name="btn-accept" class="btn btn-default">
          			<span class="glyphicon glyphicon-plus"></span> &nbsp; Accept Friend Request
          			</button>
        		</form>
              <br /><br />

            <?php
          	}

            else if(!$ifFrnd){?>

              	<form action="request.php?id=<?php echo $idRow['user_id'] ?>" method="post" enctype="multipart/form-data">
          			<button type="submit" name="btn-request" class="btn btn-default">
          			<span class="glyphicon glyphicon-plus"></span> &nbsp; Send a Friend Request
          			</button>
        		</form>
              <br /><br />

              <?php
          }
          else {?>

              	<form action="inbox.php?id=<?php echo $idRow['user_id'] ?>" method="post" enctype="multipart/form-data">
                <button type="submit" name="btn-request" class="btn btn-default">
                <span class="glyphicon glyphicon-envelope"></span> &nbsp; Send a Message to Friend
                </button>
            </form>
              <br /><br />

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