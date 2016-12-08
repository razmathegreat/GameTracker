<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Encounter Creation:</title>
  </head>
  <body>
    <form action="processNewEncounter.php" method="post">
	  <div><label for="description">Encounter Description:
        <input type="text" name="description" id="description"></label>
      </div>
      <div>Do you want to share this encounter with other GMs?:</div>
        <input type="radio" name="isShared"  value="1">Yes
        <input type="radio" name="isShared"  value="0">No
      <div><input type="submit" value="Create"></div>
    </form>
    <form action="gamemasterView.php" method="post">
   <input type="submit" value="Back to Main Page">
   </form><br>

  </body>
</html>


	  <!--If isSet($encounterID)
    Make a for loop to generate all monsters available
    prepare -> SELECT MonsterID, MonsterName, TotalHP, Experience FROM Monsters 
    WHERE isShared = 'True' or createdBy = &THIS USER& 

    Genereate table based off of above query with Text box for creature count and an ADD button
    INSERT INTO EncounterMonsters (monsterID, encounterID, monsterCount) values (?monsterID, ?encounterID, ?monsterCount)--> 
     
