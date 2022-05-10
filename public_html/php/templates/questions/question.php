<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include head information from template file -->
    <?php include('head.php'); ?>

</head>

<body>
<!-------------------- NavBar -------------------->
<?php include('navbar.php'); ?>
<!-------------------- End NavBar -------------------->

<?php
require '../../open.php';
//Override the PHP configuration file to display all errors
//This is useful during development but generally disabled before release
/*ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);*/
?>
