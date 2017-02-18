<?php
    ob_start();
    session_start();
include_once 'dbconnect.php';

// if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    // select loggedin users detail
    $res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
    $userRow=mysql_fetch_array($res);

if(isset($_POST['btn-upload']))
{    
     
 $file = rand(1000,100000)."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 $folder="uploads/";
 
 // new file size in KB
 $new_size = $file_size/1024;  
 // new file size in KB
 
 // make file name in lower case
 $new_file_name = strtolower($file);
 // make file name in lower case
 
 $final_file=str_replace(' ','-',$new_file_name);

 $img = $folder.$final_file;
 
 if(move_uploaded_file($file_loc,$folder.$final_file))
 {
    //echo $img;

    $id = $_SESSION['user'];

    //$sql="INSERT INTO users (user_image) VALUES ('kichu') WHERE user_id=".$_SESSION['user'];

    //$sql = "UPDATE users SET user_image ='$img' WHERE user_id='$_SESSION['user']'";

    $sql = "UPDATE users SET user_image='$img' WHERE user_id = ". $_SESSION['user'];

  

  mysql_query($sql);
  ?>
  <script>
        window.location.href='index.php?success';
        </script>
  <?php
 }
 else
 {
  ?>
  <script>
  alert('error while uploading file');
        window.location.href='index.php?fail';
        </script>
  <?php
 }
}
?>

<?php ob_end_flush(); ?>