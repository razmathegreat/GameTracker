<?php 
session_start();
$userName = $_SESSION['userName'];
$gameID = $_SESSION['gameID'];

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


try
{
  $getEncounterSql = 'SELECT * FROM encounter WHERE createdBy = :userName OR isShared like 1';
  $s = $pdo->prepare($getEncounterSql);
  $s->bindValue(':userName',$_SESSION['userName']);
  $s->execute();
  $getEncounterResults = $s->fetchAll();
}

catch (PDOException $e)
{
  $error = 'Error fetching encounters: ' . $e->getMessage();
  include 'error.html.php';
  exit();
}

if (isset($_GET['addEncounter'])){
	try
	{
	  $addGEncounterSql = 'INSERT INTO gameEncounters SET
	  encounterID = :encounterID,
	  gameID = :gameID';
	  $s = $pdo->prepare($addGEncounterSql);
	  $s->bindValue(':gameID',$_SESSION['gameID']);
	  $s->bindValue(':encounterID',$_POST['encounterID']);
	  $s->execute();
	  
	}

	catch (PDOException $e)
	{
	  $error = 'Error fetching encounters: ' . $e->getMessage();
	  include 'error.html.php';
	  exit();
	}
	echo "Encounter Added!";
}


?>



<html>
<head>
<title>Add Game Encounter</title>
<style>
table,th,td
{
border:1px solid black;
padding:5px;
}
</style>
</head>
<body> 

<h2>Available Encounters</h2>
   
    <table >
	<tr>
	<th style= "width:50px">ID</th>
	<th style= "width:50px">Description</th>
	<th style= "width:50px">Total Exp</th>
	<th style= "width:50px">Add</th>
  
	</tr>
    <?php foreach ($getEncounterResults as $encounter): ?>
      <tr>
      <td> <?php echo $encounter['encounterID']; ?> </td>
      <td style= "width:150px"> <?php echo $encounter['description']; ?> </td>
      <td style= "width:150px"> <?php echo $encounter['totalExp']; ?> </td>
      <td>  
         <form action="?addEncounter" method="post">
          <input type="hidden" name="encounterID" value="<?php echo $encounter['encounterID']; ?>">
         <input type="submit" value="Add">
        </form>
      </td>
      </tr>
    <?php endforeach; ?>
    </table>
    
    
   <form action="gameView.php" method="post">
   <input type="submit" value="Go Back">
   </form><br>
   <br><br>