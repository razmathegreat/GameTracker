<?php
/*
if (isset($_GET['createNewCharacter']))
{
  include 'createNewCharacter.php';
  exit();
}*/
	

   $userName = $_POST["userName"];
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

//sql statement to retrieve all games to be displayed in table 
//tried to include where clause that would retrieve only those made by UserName
try
{
  $gameSql = 'SELECT * FROM games WHERE runBy = :userName';
  $s = $pdo->prepare($gameSql);
  $s->bindValue(':userName',$_POST["userName"]);
  $s->execute();
  $gameQueryResult  = $s->fetchAll();
  
}
catch (PDOException $e)
{
  $error = 'Error fetching games: ' . $e->getMessage();
  include 'error.html.php';
  exit();
}

//sql statement to retrieve all encounters to be displayed in table 
//tried to include where clause that would retrieve only those made by UserName
try
{
  $encounterSql = 'SELECT * FROM encounter WHERE createdBy = :userName';
  $s = $pdo->prepare($encounterSql);
  $s->bindValue(':userName',$_POST["userName"]);
  $s->execute();
  $encounterQueryResult  = $s->fetchAll();  
}
catch (PDOException $e)
{
  $error = 'Error fetching encounters: ' . $e->getMessage();
  include 'error.html.php';
  exit();
}

//sql statement to retrieve all monsters to be displayed in table 
//tried to include where clause that would retrieve only those made by UserName
try
{
  $monsterSql = 'SELECT * FROM monsters WHERE createdBy = :userName';
  $s = $pdo->prepare($monsterSql);
  $s->bindValue(':userName',$_POST["userName"]);
  $s->execute();
  $monsterQueryResult  = $s->fetchAll();
  
}
catch (PDOException $e)
{
  $error = 'Error fetching monsters: ' . $e->getMessage();
  include 'error.html.php';
  exit();
}



//sql statement for when user wishes to delete a game
if (isset($_GET['deleteGame']))
{
  try
  {
    $deleteGameSql = 'DELETE FROM games WHERE gameID = :id';
    $s = $pdo->prepare($deleteGameSql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting game: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }

  header('Location: gamemasterView.php');
  exit();
}
	
//sql statement for when user wishes to delete an encounter
if (isset($_GET['deleteEncounter']))
{
  try
  {
    $deleteEncounterSql = 'DELETE FROM encounter WHERE encounterID = :id';
    $s = $pdo->prepare($deleteEncounterSql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting encounter: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }

  header('Location: gamemasterView.php');
  exit();
}


//sql statement for when user wishes to delete a monster
if (isset($_GET['deleteMonster']))
{
  try
  {
    $deleteMonsterSql = 'DELETE FROM monsters WHERE monsterID = :id';
    $s = $pdo->prepare($deleteMonsterSql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting monster: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }

  header('Location: gamemasterView.php');
  exit();
}
if (isset($_POST['monsterName']))
{
  try{
    $addMonsterSQL = 'INSERT INTO Monsters SET
    monsterName = :monsterName,
    totalHP = :totalHP,
    experience = :Experience,
    createdBy = :userName,
    isShared = :isShared';
    $s = $pdo->prepare($addMonsterSql);
    $s->bindValue(':monsterName', $_POST['monsterName']);
    $s->bindValue(':totalHP', $_POST['totalHP']);
    $s->bindValue(':Experience', $_POST['Experience']);
    $s->bindValue(':userName', $userName);
    $s->bindValue(':isShared', $_POST['isShared']);    
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding monster: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }
  header('Location: .');
  exit();

}
	
	
?>


<html>
<head>
<title>Game Master View</title>
<style>
table,th,td
{
border:1px solid black;
padding:5px;
}
</style>
</head>
<body>

    <p>Here are the existing Games:</p>
   
    <table >
	<tr>
	<th style= "width:50px">ID</th>
	<th style= "width:50px">Campaign Name</th>
	<th style= "width:50px">Delete</th>
	</tr>
    <?php foreach ($gameQueryResult as $game): ?>
      <tr>
      <td> <?php echo $game['gameID']; ?> </td>
       <td style= "width:150px"> <?php echo $game['campaignName']; ?> </td>
         <td>  
         <form action="?deleteGame" method="post">
          <input type="hidden" name="id" value="<?php echo $game['gameID']; ?>">
         <input type="submit" value="delete">
        </form>
      </td>
      </tr>
    <?php endforeach; ?>
    </table>
	
   <form action="createNewGame.php" method="post">
   <input type="submit" value="Create New Game">
   </form><br><br>
   
   
   <p>Here are the existing Encounters:</p>
   
    <table >
	<tr>
	<th style= "width:50px">ID</th>
	<th style= "width:50px">Created By</th>
	<th style= "width:50px">Total Exp</th>
	<th style= "width:50px">Delete</th>
	</tr>
    <?php foreach ($encounterQueryResult as $encounter): ?>
      <tr>
      <td> <?php echo $encounter['encounterID']; ?> </td>
       <td style= "width:50px"> <?php echo $encounter['createdBy']; ?> </td>
       <td style= "width:50px"> <?php echo $encounter['totalExp']; ?> </td>
         <td>  
         <form action="?deleteEncounter" method="post">
          <input type="hidden" name="id" value="<?php echo $encounter['encounterID']; ?>">
         <input type="submit" value="delete">
        </form>
      </td>
      </tr>
    <?php endforeach; ?>
    </table>
	
   <form action="createNewEncounter.php" method="post">
   <input type="submit" value="Create New Encounter">
   </form><br><br>
   
   <p>Here are the existing Monsters:</p>
   
    <table >
	<tr>
	<th style= "width:50px">ID</th>
	<th style= "width:150px">Name</th>
	<th style= "width:50px">Total HP</th>
	<th style= "width:50px">Experience</th>
	<th style= "width:50px">Delete</th>
	</tr>
    <?php foreach ($monsterQueryResult as $monster): ?>
      <tr>
      <td> <?php echo $monster['monsterID']; ?> </td>
       <td style= "width:150px"> <?php echo $monster['monsterName']; ?> </td>
       <td style= "width:50px"> <?php echo $monster['totalHP']; ?> </td>
       <td style= "width:50px"> <?php echo $monster['experience']; ?> </td>
         <td>  
         <form action="?deleteMonster" method="post">
          <input type="hidden" name="id" value="<?php echo $monster['monsterID']; ?>">
         <input type="submit" value="delete">
        </form>
      </td>
      </tr>
    <?php endforeach; ?>
    </table>
	
   <form action="createNewMonster.php" method="post">
   <input type="submit" value="Create New Monster">
   </form><br><br>
   
   
   
   
	<form action="index.php" method="post">
   <input type="submit" value="Log Out">
   </form><br>
	
   
  </body>
</html>
