<?php 
session_destroy();
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

  $pdo = new PDO('mysql:host=localhost;dbname=gmtracker', 'sahmed18', 'adamantium6');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
  $error = 'Unable to connect to the database server.';
  include 'error.html.php';
  exit();
}

if(isset($_GET['badPassword'])){
  echo "Invalid Username or Password.  Please try again.";
}

if(isset($_GET['playerOnly'])){
  echo "Your account does not have access to Game Master Tools.";
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
	<form action="playerview.php" method="post">
      <div><label for="userName">User Name:
        <input type="text" name="userName" id="userName"></label>
      </div>
      <div><label for="pwdHash">Password:
        <input type="password" name="pwdHash" id="pwdHash"></label>
      </div>
      <div><input type="submit" value="Login"></div>
    </form><br>
	
	<p>Login as a Game Master here:</p><br>
	<form action="gamemasterView.php" method="post">
      <div><label for="userName">User Name:
        <input type="text" name="userName" id="userName"></label>
      </div>
      <div><label for="pwdHash">Password:
        <input type="password" name="pwdHash" id="pwdHash"></label>
      </div>
      <div><input type="submit" value="Login"></div>
    </form><br>
	
	<p><a href="?signUpNewUser">New User? Sign up here!</a></p>
   
  </body>
</html>
