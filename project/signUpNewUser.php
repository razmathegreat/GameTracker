<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>New User creation</title>
  </head>
  <body>
    <form action="index.php" method="post">
	  <div><label for="firstName">First Name:
        <input type="text" name="firstName" id="firstName"></label>
      </div>
	  <div><label for="lastName">Last Name:
        <input type="text" name="LastName" id="LastName"></label>
      </div>
      <div><label for="userName">User Name:
        <input type="text" name="userName" id="userName"></label>
      </div>
      <div><label for="pwdHash">Password:
        <input type="text" name="pwdHash" id="pwdHash"></label>
      </div>
      <div><input type="submit" value="Sign Up!"></div>
    </form>
  </body>
</html>
