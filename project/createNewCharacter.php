<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Character Creation:</title>
  </head>
  <body>
    <form action="playerView.php" method="post">
	  <div><label for="CharName">Character Name:
        <input type="text" name="CharName" id="CharName"></label>
      </div>
	  <div><label for="TotalHP">Total HP:
        <input type="text" name="TotalHP" id="TotalHP"></label>
      </div>
      <div><label for="Strength">Strength:
        <input type="text" name="Strength" id="Strength"></label>
      </div>
      <div><label for="Dexterity">Dexterity:
        <input type="text" name="Dexterity" id="Dexterity"></label>
      </div>
      <div><label for="Constitution">Constitution:
        <input type="text" name="Constitution" id="Constitution"></label>
      </div>
      <div><label for="Wisdom">Wisdom:
        <input type="text" name="Wisdom" id="Wisdom"></label>
      </div>
      <div><label for="Intelligence">Intelligence:
        <input type="text" name="Intelligence" id="Intelligence"></label>
      </div>
      <div><label for="Charisma">Charisma:
        <input type="text" name="Charisma" id="Charisma"></label>
      </div>
      <div><input type="submit" value="Create"></div>
    </form>
  </body>
</html>
