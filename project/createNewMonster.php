<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Monster Creation:</title>
  </head>
  <body>
    <form action="gmView.php" method="post">
	  <div><label for="monsterName">Monster Name:
        <input type="text" name="monsterName" id="monsterName"></label>
      </div>
	  <div><label for="TotalHP">Total HP:
        <input type="text" name="TotalHP" id="TotalHP"></label>
      </div>
      <div><label for="Experience">Experience granted:
        <input type="text" name="Experience" id="Experience"></label>
      </div>
      
<input type="radio" name="isShared" id ="isShared"
<?php if (isset($isShared) && $isShared=="True") echo "checked";?>
value="true">True
<input type="radio" name="isShared"
<?php if (isset($isShared) && $isShared=="False") echo "checked";?>
value="false">False
     
      <div><input type="submit" value="Create"></div>
    </form>
  </body>
</html>
