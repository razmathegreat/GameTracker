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
if (!isset($_SESSION['gameEncounterID'])){
  $_SESSION['gameEncounterID'] = $_POST["gameEncounterID"];
//Clear battles table for this gameEncounter
	try{
		$clearBattleSQL = 'DELETE FROM Battles WHERE gameEncounterID = :gameEncounterID';

		$s = $pdo->prepare($clearBattleSQL);
		$s->bindValue(':gameEncounterID', $_SESSION['gameEncounterID']);
		$s->execute();

	}
	catch (PDOException $e){
		$error = 'Unable to delete from battle table ' .$e->getMessage();
		include 'error.html.php';
	    exit();
	}
	//Add monsters & characters into battles table
	try{
		$prepMonSQL = 'SELECT monsterID, monsterCount, em.encounterID AS encounterID FROM encountermonsters em
		join gameencounters ge on ge.encounterID=em.encounterID
		where gameEncounterID = :gameEncounterID';

		$mPrep = $pdo->prepare($prepMonSQL);
		$mPrep->bindValue(':gameEncounterID', $_SESSION['gameEncounterID']);
		$mPrep->execute();
		$getMonResults = $mPrep->fetchAll();

		foreach ($getMonResults as $monster): 
			$count = $monster['monsterCount'];
			while ($count > 0){
				$insertMonSQL = 'INSERT INTO battles (ForMonsterID, creatureInstance, remainingHP, gameEncounterID) 
				SELECT monsterID, :creatureInstance, totalHP, :gameEncounterID FROM monsters WHERE monsterID IN (SELECT monsterID FROM encountermonsters WHERE encounterID = :encounterID AND monsterID = :monsterID)';

				$setMonSQL = $pdo->prepare($insertMonSQL);
				$setMonSQL->bindValue(':gameEncounterID', $_SESSION['gameEncounterID']);
				$setMonSQL->bindValue(':creatureInstance', $count);
				$setMonSQL->bindValue(':encounterID',$monster['encounterID']);
				$setMonSQL->bindValue(':monsterID',$monster['monsterID']);

				$setMonSQL->execute();
				$count--;
			}
		endforeach;	


		$insertCharSQL = 'INSERT INTO battles (ForCharacterID, remainingHP, gameEncounterID) 
		SELECT characterID, totalHP, :gameEncounterID FROM characters WHERE characterID IN (SELECT characterID FROM characterparty WHERE gameID = :gameID)';
		
			
	    $s = $pdo->prepare($insertCharSQL);
	    $s->bindValue(':gameEncounterID', $_SESSION['gameEncounterID']);    
	    $s->bindValue(':gameID', $_SESSION['gameID']);
	    
	    $s->execute();



	}
	catch (PDOException $e){
		$error = 'Unable to create battle ' .$e->getMessage();
		include 'error.html.php';
	    exit();
	}

}


if (isset($_GET['updateStats']))
{
  try
  {
    $updateStatsSql = 'UPDATE Battles SET 
    initiative = :initiative,
    remainingHp = :remainingHp 
    WHERE battleCreatureID = :battleCreatureID';
    $s = $pdo->prepare($updateStatsSql);
    $s->bindValue(':initiative', $_POST['initiative']);
    $s->bindValue(':remainingHp', $_POST['remainingHP']);
    $s->bindValue(':battleCreatureID', $_POST['battleCreatureID']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error updating statistics: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }

  header('Location: trackBattle.php');
  exit();
}



//select data from battles table
try{
	$selBattleSQL = 'SELECT battleCreatureID, charName, monsterName, creatureInstance, initiative, remainingHP FROM Battles b LEFT JOIN characters c on b.ForCharacterID = c.characterID Left JOIN monsters m ON b.ForMonsterID = m.monsterID WHERE gameEncounterID = :gameEncounterID ORDER BY initiative DESC' ;

	$s = $pdo->prepare($selBattleSQL);
	$s->bindValue(':gameEncounterID', $_SESSION['gameEncounterID']);
	$s->execute();

	$getBattleInfo = $s->fetchAll();

}
catch (PDOException $e){
	$error = 'Unable to select from battle table ' .$e->getMessage();
	include 'error.html.php';
    exit();
}

if (isset($_GET['goBack'])){
  unset($_SESSION['gameEncounterID']);
  header ('Location: gameView.php');
  exit();
}


?>


<html>
<head>
<title>Battle Tracker</title>
<style>
table,th,td
{
border:1px solid black;
padding:5px;
}
</style>
</head>
<body> 
    
    
  
   
    <table >
	<tr>
	<th style= "width:50px">Character Name</th>
	<th style= "width:50px">Monster Name</th>
	<th style= "width:50px">Monster Instance</th>
	<th style= "width:50px">Initiative</th>
	<th style= "width:50px">Remaining HP</th>
	<th style= "width:50px">Update</th>
  
	</tr>
    <?php foreach ($getBattleInfo as $battle): ?>
      <tr>
      <td style= "width:150px"> <?php echo $battle['charName']; ?> </td>
      <td style= "width:150px"> <?php echo $battle['monsterName']; ?> </td>
      <td > <?php echo $battle['creatureInstance']; ?> </td>
      <form action="?updateStats" method="post">
      <td > <input type="text" name="initiative" value="<?php echo $battle['initiative']?>"></td>
      <td > <input type="text" name="remainingHP" value="<?php echo $battle['remainingHP']?>"></td>
      <input type="hidden" name="battleCreatureID" value="<?php echo $battle['battleCreatureID']; ?>">
      <td> <input type="submit" value="Update"></td>
      </form>
      </tr>
    <?php endforeach; ?>
    </table>
    
   <form action="?goBack" method="post">
   <input type="submit" value="End Battle">
   </form><br>
   <br><br>