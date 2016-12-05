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

//sql statement to retrieve all characters to be displayed in table 
//tried to include where clause that would retrieve only those made by UserName
try
{
  $sql = 'SELECT * FROM characters WHERE createdBy = :userName';
  $s = $pdo->prepare($sql);
  $s->bindValue(':userName',$_POST["userName"]);
  $s->execute();
  $result = $s->fetchAll();
}
catch (PDOException $e)
{
  $error = 'Error fetching departments: ' . $e->getMessage();
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
<title>List of Departments</title>
<style>
table,th,td
{
border:1px solid black;
padding:5px;
}
</style>
</head>
<body>

    <p><a href="?addDepartment">Add a department</a></p><br>
    <p>Your User Name is: <?php echo $userName?></p>	<br>
    <p>Here are all the existing characters:</p>
   
   
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
         <input type="submit" value="delete">
        </form>
      </td>
      </tr>
    <?php endforeach; ?>
    </table>
	
   <form action="createNewCharacter.php" method="post">
   <input type="submit" value="Create New Character">
   </form><br>
   
	<form action="index.php" method="post">
   <input type="submit" value="Log Out">
   </form><br>
	
   
  </body>
</html>
