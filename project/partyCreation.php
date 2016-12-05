<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Party Creation:</title>
  </head>
  <body>
    <form action="gmView.php" method="post">
      <!--SELECT gameID, campaignName FROM Games Where RunBy = &USER& 
    For each gameID{
    |RadioButton|?gameID|?CamaignName|
    }

    new table
    SELECT CharacterID, CharName From Characters;

    For each characterID{
    |RadioButton|?CharacterID|?CharacterName|
    }


    PREPARED INSERT on submit
    INSERT INTO CharacterParty (GameID,CharacterID) values (:GameID, :CharacterID);
    -->

      <div><input type="submit" value="Create"></div>
    </form>
  </body>
</html>


	  