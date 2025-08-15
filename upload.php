
<?php
require_once 'header.html';
require_once 'db_conn.php';

if($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['upsubmit'])){      
   $name = $_POST['name'];
      $location = $_POST['location'];
      $message = $_POST['message'];


    $targetdir = "new/";
    $srcfile = $_FILES['passport']['tmp_name'];
    
    $target_file = $targetdir.basename($_FILES['passport']['name']);
    
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    $check = getimagesize($_FILES["passport"]["tmp_name"]);
    $uploadOk = 1;
    $err = "";
    if(file_exists($target_file)){
      $uploadOk = 0 ;
      $err .= "<script>alert('Sorry, file already exists. ')</script>";
    }
    if($check === false){
        $uploadOk = 0;
        $err .= "<script>alert('File is not an image')</script>";
    }
    
    if($file_type !== 'jpg' && $file_type !== 'png' && $file_type !== 'jpeg' ){
      $uploadOk = 0;
      $err .= "<script>alert(' | Sorry, only JPG, JPEG, & PNG files are allowed')</script>";
    }
    
    if($_FILES["passport"]["size"] > 100000000){
      $err .= "<script>alert('Sorry, your file is too large.')</script>";
      $uploadOk = 0;
    }
    
    if($uploadOk == 0){
      echo "<script>alert('File could be uploaded because ').$err </script>";
    }else{

      if(move_uploaded_file($_FILES["passport"]["tmp_name"], $target_file)){
          $upl = "INSERT INTO `upload` (`name`,`location`,`message`,`passport`)
      VALUES ('$name','$location','$message','$target_file')";

      if($cn->query($upl) === TRUE){
           echo "<script>alert('Upload Successful ')</script>";
      }else {
          echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
      }
    
    }
  }
}


    //  $upl = "INSERT INTO `upload` (`name`,`location`,`message`,`passport`)
    //   VALUES ('$name','$location','$message','$target_file')";
    //   if($cn->query($upl) === TRUE){
    //       // echo "<script>alert('Upload Successful ')</script>";
    //   }else {
    //       die('unable to insert');
    //   }

  
    
  


  function cleandata($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    //$data = mysql_real_escape_string($data);
    return $data;
  }

?>


<div class="w3-content w3-container w3-padding-64" id="contact">
  <div data-aos="fade-up" data-aos-duration="2000">
    

  <h3 class="w3-center">Uploading or pictures</h3>
  <div class="w3-row w3-padding-32 w3-section">
    <div data-aos="fade-right"
      data-aos-offset="300"
      data-aos-easing="ease-in-sine"
      data-aos-duration="1000">
    <div class="w3-col m4 w3-container">
      <img src="img/34.JPG" class="w3-image w3-round" style="width:100%">
    </div>
    </div>
    <div class="w3-col m8 w3-panel">
      <div data-aos="fade-left"
      data-aos-offset="300"
      data-aos-easing="ease-in-sine"
      data-aos-duration="1000">
      <form action="" enctype="multipart/form-data" method="POST">
        <div class="w3-row-padding" style="margin:0 -16px 8px -16px">
          <div class="w3-half">
            <input class="w3-input w3-border" type="text" placeholder="Name" required name="name">
          </div>
          <div class="w3-half">
            <input class="w3-input w3-border" type="text" placeholder="Location" required name="location">
          </div>
          <div class="w3-half">
          Select image to upload:
            <input type="file"  name="passport" id="fileToUpload"><br>
          </div>
          <div class="w3-half">
          <textarea name="message" id="" cols="30" rows="10" placeholder="Message"></textarea>
          </div>
        </div>
        <button class="w3-button w3-black w3-right w3-section" type="submit" name="upsubmit">
          <i class="fa fa-paper-plane"></i> Submit
        </button>
      </form>
      </div>
    </div>
  </div>
</div>
</div>
<?php
     require_once ("footer.html");
?>