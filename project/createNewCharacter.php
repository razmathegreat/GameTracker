<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Character Creation:</title>
  </head>
  <body>
    <form action="processNewCharacter.php" method="post">
	  <div><label for="charName">Character Name:
        <input type="text" name="charName" id="charName"></label>
      </div>
	  <div><label for="totalHP">Total HP:
        <input type="text" name="totalHP" id="totalHP"></label>
      </div>
      <div><label for="strength">Strength:
        <input type="text" name="strength" id="strength"></label>
      </div>
      <div><label for="dexterity">Dexterity:
        <input type="text" name="dexterity" id="dexterity"></label>
      </div>
      <div><label for="wisdom">Wisdom:
        <input type="text" name="wisdom" id="wisdom"></label>
      </div>
      <div><label for="constitution">Constitution:
        <input type="text" name="constitution" id="constitution"></label>
      </div>
      <div><label for="intelligence">Intelligence:
        <input type="text" name="intelligence" id="intelligence"></label>
      </div>
      <div><label for="charisma">Charisma:
        <input type="text" name="charisma" id="charisma"></label>
      </div>
      <div><input type="submit" value="Create"></div>
    </form>
  </body>
</html>
