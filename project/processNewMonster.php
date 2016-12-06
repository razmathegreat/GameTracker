<?php

include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php';
	
include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/magicquotes.inc.php';

ob_start();
include 'gamemasterView.php';
ob_clean();

session_start();
$userName = $_SESSION['userName'];

try
{

  $pdo = new PDO('mysql:host=localhost;dbname=gmtracker', 'MFlatley', 'Flatley0');
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
<title>Process New Monster</title>
<style>
table,th,td
{
border:1px solid black;
padding:5px;
}
</style>
</head>
<body>

    <p>UPDATED Processing New Monster...</p><br>
	
	<?php
    $pwdHash = $_GET['pwdHash'];
	  $login = $_GET['login'];
	?>
	<?php
	  $monsterName = $_POST["monsterName"];
	  $totalHP = $_GET["totalHP"];
	  $experience = $_GET["experience"];
	  $isShared = $_GET["isShared"];
	  
	?>
	
	<?php
	if (isset($_POST['monsterName']))
{
  try
  {
    $sql = 'INSERT INTO Monsters SET
		monstername = :monsterName,
		totalHp = :totalHP,
		experience = :experience,
		isShared = :isShared,		
		createdBy = :createdBy';
		
    $s = $pdo->prepare($sql);
    $s->bindValue(':monsterName', $_POST["monsterName"]);
    $s->bindValue(':totalHP', $_POST["TotalHP"]);
    $s->bindValue(':experience', $_POST["Experience"]);    
    $s->bindValue(':isShared', $_POST["isShared"]);   
    $s->bindValue(':createdBy', $_SESSION['userName']);
    
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding new monster: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }
  header('Location: gamemasterView.php');
  exit();
}
	
	?>
	
	<p>Your monster name was: <?php echo $monsterName?></p>
	<p>Your isShared value was: <?php echo $isShared?></p>
	<form action="gamemasterView.php" method="post">
   <input type="submit" value="Back to Monsters">
   </form><br>
   
  </body>
</html>