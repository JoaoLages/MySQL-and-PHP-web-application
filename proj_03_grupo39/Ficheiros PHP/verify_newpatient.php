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

if($_SESSION['previous']!='new_patient')
{
	echo('Error: page not available.');
	exit();
}
$_SESSION['previous']='verify_new_patient';

$name = $_REQUEST['patient_name'];
$birthday = $_REQUEST['year_b']."-".$_REQUEST['month_b']."-".$_REQUEST['day_b'];
$address = $_REQUEST['address'];
$doctor_id = $_REQUEST['doctor_id'];
$date = $_REQUEST['year']."-".$_REQUEST['month']."-".$_REQUEST['day']." ".$_REQUEST['hour'].":00";
$office = $_REQUEST['office'];
$file_included = true;
$_REQUEST['file_included']=true;

include "verify.php";

?>
</body>
</html>
