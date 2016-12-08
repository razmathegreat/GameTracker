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

  $pdo = new PDO('mysql:host=localhost;dbname=gmtracker', 'username', 'password');
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
<title>Process New Encounter</title>
<style>
table,th,td
{
border:1px solid black;
padding:5px;
}
</style>
</head>
<body>

    <p>Processing New Encounter...</p><br>
	
	<?php
    $pwdHash = $_GET['pwdHash'];
	  $login = $_GET['login'];
	?>
	<?php
	  $encounterName = $_POST["description"];	 
	  $isShared = $POST["isShared"];
	  
	?>
	
	<?php
	if (isset($_POST['description']))
{
  try
  {
    $sql = 'INSERT INTO Encounter SET		 	
    description = :description,
		isShared = :isShared,		
		createdBy = :createdBy';
		
    $s = $pdo->prepare($sql);       
    $s->bindValue(':isShared', $_POST["isShared"]);   
    $s->bindValue(':description', $_POST["description"]);
    $s->bindValue(':createdBy', $_SESSION['userName']);
    
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding new encounter: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }
  try
  {
    $sql = 'SELECT encounterID FROM Encounter WHERE description = :description';
    
    $s = $pdo->prepare($sql);       
    $s->bindValue(':description', $_POST["description"]);   
        
    $s->execute();
    $thisEncounter = $s->fetch();
    $_SESSION['thisEncounter'] = $thisEncounter[0];
  }
  catch (PDOException $e)
  {
    $error = 'Error retrieving encounterID: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }


  header('Location: processNewEncounter.php');
  
}

if (isset($_GET['addMonster'])){
  try
  {
    $addMonsterSql = 'INSERT INTO EncounterMonsters SET
    monsterID = :monsterID,
    encounterID = :encounterID,
    monsterCount = :monsterCount';
    
    $s = $pdo->prepare($addMonsterSql);       
    $s->bindValue(':monsterID', $_POST["monsterID"]);   
    $s->bindValue(':monsterCount', $_POST["monsterCount"]);   
    $s->bindValue(':encounterID', $_SESSION['thisEncounter']);   
        
    $s->execute();

    
  }
  catch (PDOException $e)
  {
    $error = 'Error adding monsters to encounter: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }

  try{
    $updateEpxSQL = 'UPDATE encounter SET totalEXP = (Select SUM(experience * monsterCount) as encounterExp FROM monsters m JOIN encountermonsters em on m.monsterID=em.monsterID where encounterID=:encounterID Group BY encounterID) where   encounterid = :encounterID';

    $s = $pdo->prepare($updateEpxSQL);
    $s->bindValue(':encounterID', $_SESSION['thisEncounter']);

    $s->execute();

  }
  catch (PDOException $e){
    $error = 'Error updating encounter experience: ' .$e->getMessage();
    include 'error.html.php';
    exit();
  }

  header('Location: processNewEncounter.php');
}

	?>
	

  <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Encounter Creation:</title>
  </head>  
     <table >
      <tr>
      <th style= "width:50px">ID</th>
      <th style= "width:150px">Name</th>
      <th style= "width:50px">Total HP</th>
      <th style= "width:50px">Experience</th>
      <th style= "width:50px">MonsterCount</th>    
      </tr>
        <?php foreach ($monsterQueryResult as $monster): ?>
          <tr>
          <td> <?php echo $monster['monsterID']; ?> </td>
           <td style= "width:150px"> <?php echo $monster['monsterName']; ?> </td>
           <td style= "width:50px"> <?php echo $monster['totalHP']; ?> </td>
           <td style= "width:50px"> <?php echo $monster['experience']; ?> </td>
             <td>  
             <form action="?addMonster" method="post">
              <input type="text" name="monsterCount" id="monsterCount"></label>
              <input type="hidden" name="monsterID" value="<?php echo $monster['monsterID']; ?>">
             <input type="submit" value="Add to Encounter">
            </form>
          </td>
          </tr>
        <?php endforeach; ?>
        </table>

<form action="gamemasterView.php" method="post">
   <input type="submit" value="Back to Main Page">
   </form><br>

  <body>
    
  </body>
</html>