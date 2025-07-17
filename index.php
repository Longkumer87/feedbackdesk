<?php 
    require 'classes/Database.php';

    $db = new Database();
    $conn = $db->getDb();
    
?>

<?php 
$titles = 'home';
require 'includes/header.php'?>

<div class="container mt-4">
  <?php require './login.php';?>
</div>

<a href="signup.php">signup</a>
 
<?php require 'includes/script.php';?>
<?php require 'includes/footer.php' ?>