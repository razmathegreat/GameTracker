
<?php 
session_start();
$userName = $_SESSION['userName'];
if (!isset($_SESSION['gameID'])){
  $_SESSION['gameID'] = $_POST["gameID"];
}


try
{

  $pdo = new PDO('mysql:host=localhost;dbname=gmtracker', 'userName', 'password');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
  $error = 'Unable to connect to the database server.';
  include 'error.html.php';
  exit();
}

//Get Game info
try
{
  $gameSql = 'SELECT * FROM games WHERE gameID = :gameID';
  $s = $pdo->prepare($gameSql);
  $s->bindValue(':gameID',$_SESSION['gameID']);
  $s->execute();
  $gameQuery  = $s->fetchAll();
  
}
catch (PDOException $e)
{
  $error = 'Error fetching games: ' . $e->getMessage();
  include 'error.html.php';
  exit();
}

try
{
  $partySql = 'SELECT * FROM characters WHERE characterID IN (SELECT characterID FROM CharacterParty where gameID = :gameID)';
  $s = $pdo->prepare($partySql);
  $s->bindValue(':gameID',$_SESSION['gameID']);
  $s->execute();
  $partyQuery  = $s->fetchAll();
  
}
catch (PDOException $e)
{
  $error = 'Error fetching party: ' . $e->getMessage();
  include 'error.html.php';
  exit();
}

try
{
  $gESql = 'SELECT * FROM gameEncounters ge JOIN encounter e ON ge.encounterid =e.encounterID WHERE gameID = :gameID';
  $s = $pdo->prepare($gESql);
  $s->bindValue(':gameID',$_SESSION['gameID']);
  $s->execute();
  $encounterQuery  = $s->fetchAll();
  
}
catch (PDOException $e)
{
  $error = 'Error fetching game encounters: ' . $e->getMessage();
  include 'error.html.php';
  exit();
}

if (isset($_GET['deleteGEncounter'])){
  try{
    $delEncounterSql ='DELETE FROM gameEncounters WHERE gameEncounterID = :gameEncounterID';
    $s = $pdo->prepare($delEncounterSql);
    $s->bindValue(':gameEncounterID',$_POST['id']);
    $s->execute();

  }
  catch (PDOException $e){
    $error = 'Error deleting encounter ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }
  header('Location: gameView.php');
  exit();
}

if (isset($_GET['goBack'])){
  unset($_SESSION['gameID']);
  header ('Location: gamemasterView.php');
  exit();
}


?>

<html>
<head>
<title>Game Instance View</title>
<style>
table,th,td
{
border:1px solid black;
padding:5px;
}
</style>
</head>
<body> 

    <?php foreach ($gameQuery as $game): ?>
    <p><h1><u><?php echo $game['campaignName']; ?> </u></h1></p>
    <?php endforeach;?> 
    <h3>Party</h3>
   
    <table >
	<tr>
	<th style= "width:50px">Character Name</th>
	<th style= "width:50px">Total HP</th>
	<th style= "width:50px">Player</th>
  
	</tr>
    <?php foreach ($partyQuery as $partyMember): ?>
      <tr>
      <td> <?php echo $partyMember['charName']; ?> </td>
      <td style= "width:150px"> <?php echo $partyMember['totalHP']; ?> </td>
      <td style= "width:150px"> <?php echo $partyMember['createdBy']; ?> </td>
      </tr>
    <?php endforeach; ?>
    </table>
    
    <h3>Planned Encounters</h3>
   
    <table >
  <tr>
  <th style= "width:50px">Description</th>
  <th style= "width:50px">Total Experience</th>
  <th style= "width:50px">Delete</th>
  <th style= "width:50px">Battle</th>
  
  </tr>
    <?php foreach ($encounterQuery as $gEncounter): ?>
      <tr>
      <td> <?php echo $gEncounter['description']; ?> </td>
      <td style= "width:150px"> <?php echo $gEncounter['totalExp']; ?> </td>      
      <td>  
         <form action="?deleteGEncounter" method="post">
          <input type="hidden" name="id" value="<?php echo $gEncounter['gameEncounterID']; ?>">
         <input type="submit" value="Delete">
        </form>
      </td>
      <td>  
         <form action="trackBattle.php" method="post">
          <input type="hidden" name="gameEncounterID" value="<?php echo $gEncounter['gameEncounterID']; ?>">
         <input type="submit" value="Track Battle">
        </form>
      </td>
      </tr>
    <?php endforeach; ?>
    </table>
    <form action="addGameEncounter.php" method="post">
   <input type="submit" value="Prepare Encounters">
   </form><br><br>
   <form action="?goBack" method="post">
   <input type="submit" value="Back to Main Page">
   </form><br>
   <br><br>