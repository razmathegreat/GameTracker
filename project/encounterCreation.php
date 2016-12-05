<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Encounter Creation:</title>
  </head>
  <body>
    <form action="gmView.php" method="post">
	  <div><label for="encounterName">Encounter Name:
        <input type="text" name="encounterName" id="encounterName"></label>
      </div>
      <input type="radio" name="isShared" id ="isShared"
<?php if (isset($isShared) && $isShared=="True") ;?>
value="true">True
<input type="radio" name="isShared"
<?php if (isset($isShared) && $isShared=="False") ;?>
value="false">False
      <div><input type="submit" value="Create"></div>
    </form>
  </body>
</html>


	  <!--If isSet($encounterID)
    Make a for loop to generate all monsters available
    prepare -> SELECT MonsterID, MonsterName, TotalHP, Experience FROM Monsters 
    WHERE isShared = 'True' or createdBy = &THIS USER& 

    Genereate table based off of above query with Text box for creature count and an ADD button
    INSERT INTO EncounterMonsters (monsterID, encounterID, monsterCount) values (?monsterID, ?encounterID, ?monsterCount)--> 
     
