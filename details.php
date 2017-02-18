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
      $ok = 0;

  if ( isset($_POST['btn-update']) ) {
    
    // clean user inputs to prevent sql injections
    $work = trim($_POST['work']);
    $work = strip_tags($work);
    $work = htmlspecialchars($work);
    
    $pos = trim($_POST['position']);
    $pos = strip_tags($pos);
    $pos = htmlspecialchars($pos);
    
    $interest = trim($_POST['interest']);
    $interest = strip_tags($interest);
    $interest = htmlspecialchars($interest);

    $relation = trim($_POST['relation']);
    $relation = strip_tags($relation);
    $relation = htmlspecialchars($relation);

    $about = trim($_POST['about']);
    $about = strip_tags($about);
    $about = htmlspecialchars($about);

    
    
    
    if (empty($about)) {
        $about = $userRow['user_about'];
    }


    if (empty($work) && !empty($pos)) {
      $error = true;
      $workError = "Please enter your Organization name";
      ?>
          <script>
              alert('Please, Enter Both, work and position.');
              </script>
          <?php

    } 
    if (!empty($work) && empty($pos)) {
      $error = true;
      $posError = "Please enter your Role.";
      ?>
          <script>
              alert('Please, Enter Both, work and position.');
              </script>
          <?php

    }
    if($error==false)
    {
      if(empty($pos) && empty($work))
      {
          $pos = $userRow['user_pos'];
          $work = $userRow['user_work'];
      }
      
  }


    if (empty($interest)) {
      $interest = $userRow['user_interest'];
    }


    if (empty($relation)) {
       $relation = $userRow['user_relation'];
    }

    
    


    if( !$error ) {
      
      $query ="UPDATE users SET user_about='$about', user_interest='$interest', user_pos='$pos', user_work='$work', user_relation='$relation' WHERE user_id = ". $_SESSION['user'];
      $res = mysql_query($query);
        
      if ($res) {
          ?>
          <script>
              alert('Information has been updated successfully!');
              window.location.href='index.php';
              </script>
          <?php

        $errTyp = "success";
        $errMSG = "information has been changed successfully!";
        unset($pos);
        unset($work);
        unset($relation);
        unset($about);
        unset($interest);
      } else {
        $errTyp = "danger";
        $errMSG = "Something went wrong, try again."; 
        ?>
          <script>
              alert('Something went wrong, try again.');
              </script>
          <?php
      } 
        
    }
    
    
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Change Details ~ Payra</title>
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

<div class="signin-form">

  <div id="container">
  <form class="form-signin" method="post" id="login-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
      <!--div class="col-md-12">
        
          <div class="form-group"-->
              <h2 class="form-signin-heading">Edit Your Details</h2>
            <!--/div-->
        
          <div class="form-group">
              <hr />
            </div>
            
            

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-education"></span></span>
              <input type="text" name="work" class="form-control" placeholder="Where do you Study or Work?" maxlength="3200" />
                </div>
                <span class="text-danger"><?php echo $workError; ?></span>
            </div>

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-tasks"></span></span>
              <input type="text" name="position" class="form-control" placeholder="Enter your role at Institution or Organization" maxlength="3200" />
                </div>
                <span class="text-danger"><?php echo $posError; ?></span>
            </div>
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-film"></span></span>
              <input type="text" name="interest" class="form-control" placeholder="Enter Your Hobby or Interests" maxlength="3200" />
                </div>
                <span class="text-danger"><?php echo $interestError; ?></span>
            </div>

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-heart"></span></span>
              <input type="text" name="relation" class="form-control" placeholder="Your Relationship Status (Single or Mingle :p ) " maxlength="3200" />
                </div>
                <span class="text-danger"><?php echo $relError; ?></span>
            </div>
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-check"></span></span>
              <input type="text" name="about" class="form-control" placeholder="Say something about yourself" maxlength="3200" />
                </div>
                <span class="text-danger"><?php echo $aboutError; ?></span>
            </div>

            <div class="form-group">
              <hr />
            </div>
            
            <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-update" id="btn-signup">
        <span class="glyphicon glyphicon-log-in"></span> &nbsp; Update Details
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