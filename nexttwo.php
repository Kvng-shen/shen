
<!DOCTYPE html>
<html>
  <title>SHEN PORTFOLIO</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/shen.css">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/aos.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="css/font-awesome.min.css">
<script src="https://kit.fontawesome.com/b1a88444ca.js" crossorigin="anonymous"></script>
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar" id="myNavbar">
    <a class="w3-bar-item w3-button w3-hover-black w3-hide-medium w3-hide-large w3-right" href="javascript:void(0);" onclick="toggleFunction()" title="Toggle Navigation Menu">
      <i class="fa fa-bars"></i>
    </a>
    <a href="index.html" class="w3-bar-item w3-button">HOME</a>
    <a href="#about" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-user"></i> ABOUT</a>
    <a href="#portfolio" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-th"></i> PORTFOLIO</a>
    <a href="#contact" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-envelope"></i> CONTACT</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-right w3-hover-red">
      <i class="fa fa-search"></i>
    </a>
  </div>

  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
    <a href="#about" class="w3-bar-item w3-button" onclick="toggleFunction()">ABOUT</a>
    <a href="#portfolio" class="w3-bar-item w3-button" onclick="toggleFunction()">PORTFOLIO</a>
    <a href="#contact" class="w3-bar-item w3-button" onclick="toggleFunction()">CONTACT</a>
    <a href="#" class="w3-bar-item w3-button">SEARCH</a>
  </div>
</div>

<!-- First Parallax Image with Logo Text -->
<div class="bgimg-1 w3-display-container w3-opacity-min" id="home">
   <div class="w3-display-middle" style="white-space:nowrap;">
     
   </div>
 </div>
 
 <!-- Container (Portfolio Section) -->
 <div class="w3-content w3-container w3-padding-64" id="portfolio">
   <div data-aos="fade-up" data-aos-duration="2000">
   <h3 class="w3-center">MY WORK</h3>
   <p class="w3-center"><em>Here are some of my latest work.<br> Click on the images to make them bigger</em></p><br>
   </div>
   <div class="w3-row-padding w3-center">
     <div class="w3-col m3 mywork">
   <div data-aos="zoom-in" data-aos-duration="1000" >
    
    <?php
        require_once ("db_conn.php");
    $sql = "SELECT name,location, passport FROM upload WHERE name= 'bisola'";
$result = mysqli_query($cn, $sql);

if (mysqli_num_rows($result) > 0) {
  while($data = mysqli_fetch_assoc($result)) {
    echo "<h2>{$data['name']}</h2>";
    echo "<img src='{$data['passport']}'width='100%'>";
    echo "<h2>{$data['location']}</h2>";
  }
} else {
  echo "0 results";
}


    ?>

     </div>
 </div>
    <div class="w3-col m3">
      <div data-aos="zoom-in" data-aos-duration="1000">
       <?php
        require_once ("db_conn.php");
    $sql = "SELECT name,location, passport FROM upload WHERE name= 'shen'";
$result = mysqli_query($cn, $sql);

if (mysqli_num_rows($result) > 0) {
  while($data = mysqli_fetch_assoc($result)) {
    echo "<h2>{$data['name']}</h2>";
    echo "<img src='{$data['passport']}'width='100%'>";
    echo "<h2>{$data['location']}</h2>";
  }
} else {
  echo "0 results";
}

    ?>

    </div>
</div>

 <div class="w3-col m3">
      <div data-aos="zoom-in" data-aos-duration="1000">
       <?php
        require_once ("db_conn.php");
    $sql = "SELECT name,location, passport FROM upload WHERE name= 'winco'";
$result = mysqli_query($cn, $sql);

if (mysqli_num_rows($result) > 0) {
  while($data = mysqli_fetch_assoc($result)) {
   echo "<h2>{$data['name']}</h2>";
    echo "<img src='{$data['passport']}'width='100%'>";
    echo "<h2>{$data['location']}</h2>"; 
  }
} else {
  echo "0 results";
}

    ?>

    </div>
</div>
    
     <div class="w3-col m3" >
      <div data-aos="zoom-in" data-aos-duration="1000" onclick="onClick(this)">
       <?php
        require_once ("db_conn.php");
    $sql = "SELECT name,location, passport FROM upload WHERE name= 'lekan'";
$result = mysqli_query($cn, $sql);

if (mysqli_num_rows($result) > 0) {
  while($data = mysqli_fetch_assoc($result)) {
    echo "<h2>{$data['name']}</h2>";
    echo "<img src='{$data['passport']}'width='100%'>";
    echo "<h2>{$data['location']}</h2>";
     
  }
} else {
  echo "0 results";
}

    ?>

    </div>
</div>
  </div>
</div>
  
 <div class="w3-center" style="margin-top: 20px;">
   <div class="w3-bar w3-border w3-round">
     <a href="#" class="w3-bar-item w3-button">&laquo;</a>
     <a href="nextone.php" class="w3-bar-item w3-button">1</a>
     <a href="nexttwo.php" class="w3-bar-item w3-button">2</a>
     <a href="#" class="w3-bar-item w3-button">3</a>
     <a href="#" class="w3-bar-item w3-button">4</a>
     <a href="#" class="w3-bar-item w3-button">&raquo;</a>
   </div>
   </div>
 </div>
 
 <!-- Modal for full size images on click-->
 <div id="modal01" class="w3-modal w3-black" onclick="this.style.display="none"">
   <span class="w3-button w3-large w3-black w3-display-topright" title="Close Modal Image"><i class="fa fa-remove"></i></span>
   <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
   <img id="img01" class="w3-image" style="width: 100%;">
     <p id="caption" class="w3-opacity w3-large"></p>
   </div>
 </div>
 


<!-- Footer -->
<footer class="w3-center w3-black w3-padding-64 w3-opacity w3-hover-opacity-off">
    <a href="#home" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
    <div class="w3-xlarge w3-section">
      <i class="fa fa-facebook-official w3-hover-opacity"></i>
      <i class="fa fa-instagram w3-hover-opacity"></i>
      <i class="fa fa-snapchat w3-hover-opacity"></i>
      <i class="fa fa-pinterest-p w3-hover-opacity"></i>
      <i class="fa fa-twitter w3-hover-opacity"></i>
      <i class="fa fa-linkedin w3-hover-opacity"></i>
    </div>
    <p>Powered by <a href="index.html" class="w3-hover-text-green">Shen</a></p>
  </footer>
  
  
  <script src="js/jquery.js"></script>
      <script src="js/bootstrap.min.js"></script>
  <script src="http://code.jquery.com/jquery-git.js"></script>
      <script src="js/shen.js"></script>
  <script src="js/shen.js"></script>
  <script src="js/aos.js"></script>
  <script>
    AOS.init();
  </script>
  </body>
  </html>
  