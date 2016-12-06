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
<title>Process New Game</title>
<style>
table,th,td
{
border:1px solid black;
padding:5px;
}
</style>
</head>
<body>

  
	
	<?php
    $pwdHash = $_GET['pwdHash'];
	  $login = $_GET['login'];
	?>
	<?php
	  $campaignName = $_POST["campaignName"];
	 
	  
	?>
	
	<?php
	if (isset($_POST['campaignName']))
{
  try
  {
    $sql = 'INSERT INTO Games SET
		campaignName = :campaignName,		
		runBy = :runBy';
		
    $s = $pdo->prepare($sql);
    $s->bindValue(':campaignName', $_POST["campaignName"]);    
    $s->bindValue(':runBy', $_SESSION['userName']);
    
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding new game: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }
  try
  {
    $sql = 'SELECT gameID FROM Games WHERE campaignName = :campaignName AND runBy = :runBy';
    
    $s = $pdo->prepare($sql);       
    $s->bindValue(':campaignName', $_POST["campaignName"]);   
    $s->bindValue(':runBy', $_SESSION['userName']);    
    $s->execute();
    $thisEncounter = $s->fetch();
    $_SESSION['thisGame'] = $thisEncounter[0];
  }
  catch (PDOException $e)
  {
    $error = 'Error retrieving encounterID: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }
}
	

if (isset($_GET['AddToParty'])){
  try
  {
    $addPartySql = 'INSERT INTO CharacterParty SET
    gameID = :gameID,
    characterID = :characterID';
    
    $s = $pdo->prepare($addPartySql);       
    $s->bindValue(':characterID', $_POST["characterID"]);   
    $s->bindValue(':gameID', $_SESSION['thisGame']);       
        
    $s->execute();    
  }
  catch (PDOException $e)
  {
    $error = 'Error adding characters to party: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }
}

try
{
  $charSql = 'SELECT * FROM characters WHERE characterID NOT IN (SELECT characterID FROM CharacterParty where gameID = :gameID)';
  $s = $pdo->prepare($charSql);
  $s->bindValue(':gameID',$_SESSION['thisGame']);
  $s->execute();
  $charResults = $s->fetchAll();
}

catch (PDOException $e)
{
  $error = 'Error fetching departments: ' . $e->getMessage();
  include 'error.html.php';
  exit();
}

	?>
<body>Please select characters to add to <?php echo $_POST['campaignName']?>: </body>
  
	<table >
  <tr>
  <th style= "width:50px">Character Name</th>
  <th style= "width:50px">totalHP</th>
  <th style= "width:50px">Player</th>
  <th style= "width:50px">Add</th>
  
  </tr>
    <?php foreach ($charResults as $char): ?>
      <tr>
      <td> <?php echo $char['charName']; ?> </td>
       <td > <?php echo $char['totalHP']; ?> </td>
         <td> <?php echo $char['createdBy']?>  </td>
         <td>
          <form action="?AddToParty" method="post">
          <input type="hidden" name="characterID" value="<?php echo $char['characterID']; ?>">
         <input type="submit" value="Add">
        </form>
      </td>
      </tr>
    <?php endforeach; ?>
    </table>
  
  <form action="gamemasterView.php" method="post">
   <input type="submit" value="Back to Main Page">
   </form><br>
   <br><br>