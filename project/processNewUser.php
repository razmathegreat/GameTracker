<?php

include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php';
	
include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/magicquotes.inc.php';

ob_start();
include 'index.php';
ob_clean();
/*
session_start();
$userName = $_SESSION['userName'];
*/
try
{

  $pdo = new PDO('mysql:host=localhost;dbname=gmtracker', 'your_username', 'your_Pword');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
  $error = 'Unable to connect to the database server.';
  include 'error.html.php';
  exit();
}


?>


<html>
<head>
<title>Process New User</title>
<style>
table,th,td
{
border:1px solid black;
padding:5px;
}
</style>
</head>
<body>

    <p>Processing New User...</p><br>
	
	<?php
	  $userName = $_POST["userName"];
	  $firstName = $_GET["firstName"];
	  $lastName = $_GET["lastName"];
	  $pword = $_GET["pword"];
	  $gmTools = $_GET["gmTools"];
	  
	  
	?>

	<?php
	if (isset($_POST['firstName']))
{
  try
  {
    $sql = 'INSERT INTO users SET
		userName = :userName,
		firstName = :firstName,
		lastName = :lastName,
		pword = :pword,
		gmTools = :gmTools';
		
    $s = $pdo->prepare($sql);
    $s->bindValue(':userName', $_POST["userName"]);
    $s->bindValue(':firstName', $_POST["firstName"]);
    $s->bindValue(':lastName', $_POST["lastName"]);
    $s->bindValue(':pword', password_hash($_POST['pword'],PASSWORD_DEFAULT));
    $s->bindValue(':gmTools', $_POST["gmTools"]);
    
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding new user: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }
  header('Location: index.php');
  exit();
}
	
	?>
	
	<p>Your firstName name was: <?php echo $firstName?></p>
	<p>Your lastName value was: <?php echo $lastName?></p>
	<p>Your userName value was: <?php echo $userName?></p>
	<p>Your password value was: <?php echo $pword?></p>
	<p>Your gmToolsMarker value was: <?php echo $gmTools?></p>

	<form action="index.php" method="post">
   <input type="submit" value="Back to User Login">
   </form><br>
   
  </body>
</html>