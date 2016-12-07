
<?php 
session_start();
$userName = $_SESSION['userName'];
$_SESSION['gameID'] = $_POST['gameID'];

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
	<th style= "width:50px">Campaign Details</th>
  <th style= "width:50px">Delete</th>
	</tr>
    <?php foreach ($gameQueryResult as $game): ?>
      <tr>
      <td> <?php echo $game['gameID']; ?> </td>
      <td style= "width:150px"> <?php echo $game['campaignName']; ?> </td>
      <td>  
         <form action="gameView.php" method="post">
          <input type="hidden" name="id" value="<?php echo $game['gameID']; ?>">
         <input type="submit" value="Access">
        </form>
      </td>
      <td>  
         <form action="?deleteGame" method="post">
          <input type="hidden" name="id" value="<?php echo $game['gameID']; ?>">
         <input type="submit" value="Delete">
        </form>
      </td>
      </tr>
    <?php endforeach; ?>
    </table>
	
   <form action="gameCreation.php" method="post">
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
         <input type="submit" value="Delete">
        </form>
      </td>
      </tr>
    <?php endforeach; ?>
    </table>
	
   <form action="encounterCreation.php" method="post">
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
         <input type="submit" value="Delete">
        </form>
      </td>
      </tr>
    <?php endforeach; ?>
    </table>
	
   <form action="createNewMonster.php" method="post">
   <input type="submit" value="Create New Monster">
   </form><br><br>
   
   
   
   
	<form action="?logOff" method="post">
   <input type="submit" value="Log Out">
   </form><br>
	
   
  </body>
</html>
