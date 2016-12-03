<?php
try
{
  $pdo = new PDO('mysql:host=localhost;dbname=Our_DB_Name', 'Our_DB_UserName', 'Our_DB_password');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
  $error = 'Unable to connect to the database server.';
  include 'error.html.php';
  exit();
}
