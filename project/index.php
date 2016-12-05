<?php 
include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; 
include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/magicquotes.inc.php';
	

if (isset($_GET['newUser']))
{
  include 'newUser.php';
  exit();
}

if (isset($_GET['signUpNewUser']))
{
  include 'signUpNewUser.php';
  exit();
}

if (isset($_GET['processNewUser']))
{
  include 'login.html';
  exit();
}


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

?>
	
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login or Not</title>
    <style>
    table {
      border-collapse: collapse;
    }
    td, th {
      border: 1px solid black;
    }
    </style>
  </head>
  <body>
  
    <p><strong>Hello, what would you like to do today?</strong></p><br>
 
	
	<p>Login as a Player here:</p><br>
	<form action="playerView.php" method="post">
      <div><label for="userName">User Name:
        <input type="text" name="userName" id="userName"></label>
      </div>
      <div><label for="pwdHash">Password:
        <input type="text" name="pwdHash" id="pwdHash"></label>
      </div>
      <div><input type="submit" value="Login"></div>
    </form><br>
	
	<p>Login as a Game Master here:</p><br>
	<form action="gamemasterView.php" method="post">
      <div><label for="userName">User Name:
        <input type="text" name="userName" id="userName"></label>
      </div>
      <div><label for="pwdHash">Password:
        <input type="text" name="pwdHash" id="pwdHash"></label>
      </div>
      <div><input type="submit" value="Login"></div>
    </form><br>
	
	<p><a href="?signUpNewUser">New User? Sign up here!</a></p>
   
  </body>
</html>
