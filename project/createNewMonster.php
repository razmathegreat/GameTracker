<?php 
session_start();
$userName = $_SESSION['userName'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Monster Creation:</title>
  </head>
  <body>
    <form action="processNewMonster.php" method="post">
	  <div><label for="monsterName">Monster Name:
        <input type="text" name="monsterName" id="monsterName"></label>
      </div>
	  <div><label for="TotalHP">Total HP:
        <input type="text" name="TotalHP" id="TotalHP"></label>
      </div>
      <div><label for="Experience">Experience granted:
        <input type="text" name="Experience" id="Experience"></label>
      </div>
      <div>Share with all GMs?:</div>
        <input type="radio" name="isShared"  value="true">Yes
        <input type="radio" name="isShared"  value="false">No
     
      <div><input type="submit" value="Create"></div>
    </form>
     <br />
    <form action="gamemasterview.php" method="post">
      <input type="submit" value = "Go Back">
    </form>
  </body>
</html>
