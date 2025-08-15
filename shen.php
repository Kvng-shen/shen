

<?php
require_once ('index.html');
require_once ('db_conn.php');

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Submit'])){
    $fname = $_POST['Name'];
    $email = $_POST['Email'];
    $message = $_POST['Message'];

    $sql = "INSERT INTO `message` (`Name`,`Email`,`Message`)
    VALUES ('$fname','$email','$message')";
    if($cn->query($sql)){

        echo '<script>
        alert("Successfully Sent");
        window.location = "index.html";
        </script>';
    }else { 
         echo '
        <script>
        alert("All fields must be filled.");
        window.history.back();
        </script>
        ';
        ;
    }
 }



?>