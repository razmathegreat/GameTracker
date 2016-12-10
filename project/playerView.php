<?php
/*
if (isset($_GET['createNewCharacter']))
{
  include 'createNewCharacter.php';
  exit();
}*/
if (!session_id()) {
    session_start();
  }
//if coming from the login page clear out any existing userNames.
if (isset($_POST['pwdHash'])){
 unset($_SESSION['userName']);
}
if (!isset($_SESSION['userName'])){
  $_SESSION['userName'] = $_POST["userName"];
}

$userName=$_SESSION['userName'];;
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


if (isset($_POST['pwdHash'])){
  $userlogin = $_POST['userName'];
  $userpwd = $_POST['pwdHash'];

  try
  {
    $pLoginSql = 'SELECT * FROM Users';
    $s = $pdo->prepare($pLoginSql);  
    $s->execute();
    $playerResults  = $s->fetchAll();
  }

  catch (PDOException $e)
  {
    $error = 'Error fetching passwords: ' . $e->getMessage();
     echo $error;
  }

  foreach ($playerResults as $user):
      if ($userlogin==$user['userName']){
        $userhash=$user['pword'];
      }   
  endforeach;
  
  if (password_verify($userpwd,$userhash)){
    }
    else {
      header('Location: index.php?badPassword');
      exit();
    }



}




if (isset($_GET['logOff'])){
  unset($_SESSION['userName']);
  header ('Location: index.php');
  exit();
}



//sql statement to retrieve all characters to be displayed in table 
//tried to include where clause that would retrieve only those made by UserName
try
{
  $sql = 'SELECT * FROM characters WHERE createdBy = :userName';
  $s = $pdo->prepare($sql);
  $s->bindValue(':userName',$_SESSION['userName']);
  $s->execute();
  $result = $s->fetchAll();
}
catch (PDOException $e)
{
  $error = 'Error fetching characters: ' . $e->getMessage();
  include 'error.html.php';
  exit();
}

//sql statement for when user wishes to delete a character
if (isset($_GET['deleteChar']))
{
  try
  {
    $sql = 'DELETE FROM characters WHERE characterID = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting department: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }

  header('Location: playerView.php');
  exit();
}
	
	
	
?>


<html>
<head>
<title>List of Characters</title>
<style>
table,th,td
{
border:1px solid black;
padding:5px;
}
</style>
</head>
<body>

    <p>Your User Name is: <?php echo $userName ?></p>	<br>
    <p>Here are all the existing characters: </p>
   
   
    <table >
	<tr>
	<th style= "width:50px">ID</th>
	<th style= "width:50px">Name</th>
	<th style= "width:50px">Total HP</th>
	<th style= "width:50px">Strength</th>
	<th style= "width:50px">Dexterity</th>
	<th style= "width:50px">Wisdom</th>
	<th style= "width:50px">Constitution</th>
	<th style= "width:50px">Intelligence</th>
	<th style= "width:50px">Charisma</th>
	<th style= "width:50px">Delete</th>
	</tr>
    <?php foreach ($result as $character): ?>
      <tr>
      <td> <?php echo $character['characterID']; ?> </td>
       <td style= "width:150px"> <?php echo $character['charName']; ?> </td>
        <td style= "width:50px"> <?php echo $character['totalHP']; ?> </td>
         <td style= "width:50px"> <?php echo $character['strength']; ?> </td>
         <td style= "width:50px"> <?php echo $character['dexterity']; ?> </td>
         <td style= "width:50px"> <?php echo $character['wisdom']; ?> </td>
         <td style= "width:50px"> <?php echo $character['constitution']; ?> </td>
         <td style= "width:50px"> <?php echo $character['intelligence']; ?> </td>
         <td style= "width:50px"> <?php echo $character['charisma']; ?> </td>
         <td>  
         <form action="?deleteChar" method="post">
          <input type="hidden" name="id" value="<?php echo $character['characterID']; ?>">
         <input type="submit" value="Delete">
        </form>
      </td>
      </tr>
    <?php endforeach; ?>
    </table>
	
   <form action="createNewCharacter.php" method="post">
   <input type="submit" value="Create New Character">
   </form><br>
   
	
	<form action="?logOff" method="post">
   <input type="submit" value="Log Out">
   </form><br>
   
  </body>
</html>
