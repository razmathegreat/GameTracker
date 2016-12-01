<?php

if (isset($_GET['createNewCharacter']))
{
  include 'createNewCharacter.php';
  exit();
}
	

?>


<html>
<head>
<title>List of Departments</title>
<style>
table,th,td
{
border:1px solid black;
padding:5px;
}
</style>
</head>
<body>

    <p><a href="?addDepartment">Add a department</a></p>
    <p>Here are all the existing characters:</p>
   
    <table >
    <?php foreach ($result as $department): ?>
      <tr>
      <td> <?php echo $department['dnumber']; ?> </td>
       <td style= "width:150px"> <?php echo $department['dname']; ?> </td>
        <td> <?php echo $department['mgr_ssn']; ?> </td>
         <td> <?php echo $department['mgr_start']; ?> </td>
         <td>  
         <form action="?deleteDept" method="post">
          <input type="hidden" name="id" value="<?php echo $department['dnumber']; ?>">
         <input type="submit" value="delete">
        </form>
      </td>
      </tr>
    <?php endforeach; ?>
    </table>
	
	<p><a href="?createNewCharacter">Create New Character!</a></p>
   
  </body>
</html>
