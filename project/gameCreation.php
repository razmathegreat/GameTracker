<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Game Creation:</title>
  </head>
  <body>
    <form action="gmView.php" method="post">

      <form action="gmView.php" method="post">
    <div><label for="campaignName">Campaign Name:
        <input type="text" name="campaignName" id="campaignName"></label>
      </div>
       <div><input type="submit" value="Create"></div>
    </form>
  </body>
</html>


      <!--

      If isset(gameId) and isSet(create) 
    Make a for loop to generate all encounters available
    prepare -> SELECT EncounterID, totalEXP FROM Encounters 
    WHERE isShared = 'True' or createdBy = &THIS USER& 
    
    For each encounter
    |?EncounterID|?totalExp|Add Button|

    INSERT INTO GameEncounters (EncounterID, GameID) values (:EncounterID,&This.GAME)

   
   SELECT CampaignName, EncounterID from GameEncounters GE JOIN Games G ON G.gameID = GE.gameID Where G.runBy = &THIS USER&
  
  for each encounterID
   |?CampaignName|?EncounterID|Battle button|


    -->

     
	  