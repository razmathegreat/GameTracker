<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>New User creation</title>
  </head>
  <body>
    <form action="processNewUser.php" method="post">
	  <div><label for="firstName">First Name:
        <input type="text" name="firstName" id="firstName"></label>
      </div>
	  <div><label for="lastName">Last Name:
        <input type="text" name="lastName" id="lastName"></label>
      </div>
	  <div><label for="userName">User Name:
        <input type="text" name="userName" id="userName"></label>
      </div>  
      <div><label for="pword">Password:
        <input type="text" name="pword" id="pword"></label>
      </div>
      <div><label for="gmTools	">Should this user have GM Tools?
        <input type="radio" name="gmTools"  value="1">Yes
        <input type="radio" name="gmTools"  value="0">No
      </div>	  
      <div><input type="submit" value="Sign Up!"></div>
    </form>
	<form action="index.php" method="post">
   <input type="submit" value="Back to User Login">
   </form><br>
  </body>
</html>
