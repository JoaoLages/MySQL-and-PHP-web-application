<?php session_start(); ?>
<html>
<body>
<?php

$host = "db.tecnico.ulisboa.pt";
$user = "ist175286";
$pass = "hgku5049";
$dsn = "mysql:host=$host;dbname=$user";
try
{
        $connection = new PDO($dsn, $user, $pass);
}
catch(PDOException $exception)
{
        echo("<p>Error: ");
        echo($exception->getMessage());
        echo("</p>");
        exit();
}

if($_SESSION['previous']!='patient' && $_SESSION['previous']!='appointment' && $_SESSION['previous']!='new_patient')
{
	echo('Error: page not available.');
	exit();
}
$_SESSION['previous']='select_patient_name';

$patient_name = $_REQUEST['patient_name'];
$sql = "SELECT * FROM patient WHERE name LIKE '%$patient_name%'";
$result = $connection->query($sql);

if ($result == FALSE)
{
  $info = $connection->errorInfo();
  echo("<p>Error: {$info[2]}</p>");
  exit();
}

if($result->rowCount()>0){
echo("<p>Patient(s) with <b><i>$patient_name</b></i> in his/her name is/are:</p>");
echo('<form action="appointment.php" method="post">'); 
echo('<table border=\"1\">'); 
echo("<tr><td>patient_id</td><td>name</td><td>birthday</td><td>address</td><td>button</td></tr>"); 
foreach($result as $row) {
  $id=$row['patient_id'];
  echo("<tr><td>");
  echo($row['patient_id']);
  echo("</td><td>");
  echo($row['name']);
  echo("</td><td>");
  echo($row['birthday']);
  echo("</td><td>");
  echo($row['address']);
  echo("</td>");
  echo("<td><a href='appointment.php?id=$id'>Select</a></td>");
  //echo("<td><input value='Select' type='submit'/><input type='hidden' name='id' value=$id /></td>");
  echo("</tr>");
}}else{echo("<p>We could not find any patient with <i><b>$patient_name</b></i> in his/her name</p>");}

echo("</table>");
echo("</form>");

$connection = null

?>

<form action="newpatient.php" method="post">
<p><input value="Create new patient" type="submit"/></p>
</form>

<form action="patient.php" method="post">
<h3> </h3>
<p><input value="Go back" type="submit"></p>
</form>	


</body>
</html>

