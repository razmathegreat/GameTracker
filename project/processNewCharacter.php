<?php

include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php';
	
include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/magicquotes.inc.php';

ob_start();
include 'playerView.php';
ob_clean();

try
{

  $pdo = new PDO('mysql:host=localhost;dbname=gmtracker', 'your_userName', 'your_pswd');
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
<title>Process New Character</title>
<style>
table,th,td
{
border:1px solid black;
padding:5px;
}
</style>
</head>
<body>

    <p>Processing New Character...</p><br>
	
	<?php
      $pwdHash = $_GET['pwdHash'];
	  $login = $_GET['login'];
	?>
	<?php
	  $charName = $_POST["charName"];
	  $totalHP = $_GET["totalHP"];
	  $strength = $_GET["strength"];
	  $dexterity = $_GET["dexterity"];
	  $wisdom = $_GET["wisdom"];
	  $constitution = $_GET["constitution"];
	  $intelligence = $_GET["intelligence"];
	  $charisma = $_GET["charisma"];
	  
	  
	?>
	
	


	<?php
	if (isset($_POST['charName']))
{
  try
  {
    $sql = 'INSERT INTO characters SET
		charName = :charName,
		totalHP = :totalHP,
		strength = :strength,
		dexterity = :dexterity,
		wisdom = :wisdom,
		constitution = :constitution,
		intelligence = :intelligence,
		charisma = :charisma,
		createdBy = :createdBy';
		
    $s = $pdo->prepare($sql);
    $s->bindValue(':charName', $_POST["charName"]);
    $s->bindValue(':totalHP', $_POST["totalHP"]);
    $s->bindValue(':strength', $_POST["strength"]);
    $s->bindValue(':dexterity', $_POST["dexterity"]);
    $s->bindValue(':wisdom', $_POST["wisdom"]);
    $s->bindValue(':constitution', $_POST["constitution"]);
    $s->bindValue(':intelligence', $_POST["intelligence"]);
    $s->bindValue(':charisma', $_POST["charisma"]);
    $s->bindValue(':createdBy', $_SESSION['userName']);
    
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding new character: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }
  header('Location: playerView.php');
  exit();
}
	
	?>
	
	
	
	
	
	
	<p>Your character name was: <?php echo $charName?></p>
	<p>Your dexterity value was: <?php echo $dexterity?></p>
	<form action="playerView.php" method="post">
   <input type="submit" value="Back to Characters">
   </form><br>
   
  </body>
</html>