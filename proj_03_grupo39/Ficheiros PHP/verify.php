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
$file_included = $_REQUEST['file_included'];

if(!$file_included){
	$patient_id = $_REQUEST['id'];
	$doctor_id = $_REQUEST['doctor_id'];
	$date = $_REQUEST['year']."-".$_REQUEST['month']."-".$_REQUEST['day']." ".$_REQUEST['hour'].":00";
	$office = $_REQUEST['office'];
	
	if($_SESSION['previous']!='appointment')
	{
	  echo('Error: page not available.');
	  exit();
	}
	$_SESSION['previous']='verify';
}
//echo $file_included ? 'true' : 'false';
$today = date("Y-m-d H:i:s");
$days_of_month=date("t", strtotime($date));
$day=date("d", strtotime($date));
$date_number=date("w", strtotime($date));
$sql = "SELECT * FROM appointment 
WHERE (doctor_id=$doctor_id and date ='$date' or office = '$office' and date ='$date')";
$result1 = $connection->query($sql);

$sql = "SELECT * FROM doctor 
WHERE doctor_id=$doctor_id ";
$result2 = $connection->query($sql);

if ($result1 == FALSE)
{
  $info = $connection->errorInfo();
  echo("<p>Error: {$info[2]}</p>");
  exit();
}
if ($result1->rowCount()==0 && $result2->rowCount()>0 && ($date_number!=6 && $date_number!=0) && $day<=$days_of_month && $date>$today)
{
	if($file_included){ //insert new patient
		$sql = "INSERT INTO patient values (default, '$name', '$birthday', '$address')";
		$result = $connection->query($sql);
		if ($result == FALSE)
		{
 			$info = $connection->errorInfo();
 			echo("<p>Error: {$info[2]}</p>");
 			exit();
		}

		$sql = "SELECT patient_id FROM patient group by patient_id having patient_id >= all(SELECT patient_id FROM patient group by patient_id)";
		$result = $connection->query($sql);

		if ($result == FALSE)
		{
 			$info = $connection->errorInfo();
 			echo("<p>Error: {$info[2]}</p>");
 			exit();
		}

		foreach($result as $row)
		{
			$patient_id = $row['patient_id'];
		}
	}
  $insert = "INSERT INTO appointment values ($patient_id, $doctor_id, '$date', '$office')";
  $insert_result = $connection->query($insert);
  if ($insert_result == FALSE)
  {
	$info = $connection->errorInfo();
	echo("<p>Error: {$info[2]}</p>");
	exit();
  }
  echo('Appointment successfully inserted!');
  $check = 0;
}else
 {
  echo("<p>Couldn't create the appointment</p>");
	$check = 1;
	if($file_included){
	$check = 2;
	}
}
$file_included=false;

?>
<?php if($check==0) : ?>
<p>Search for another Patient?</p>
<form action="patient.php" method="post">
<p><input value="Return" type="submit"/></p>
</form>
<?php endif; ?>

<?php if($check==1) : ?>
<form action="appointment.php" method="post">
<p><input value="Try again" type="submit"/></p>
<p><input type='hidden' name='id' value='<?php echo "$patient_id";?>'/></p>
</form>
<?php endif; ?>

<?php if($check==2) : ?>
<p>The registration of the patient was cancelled as well</p>
<form action="newpatient.php" method="post">
<p><input value="Try again" type="submit"/></p>
</form>
<?php endif; ?>

</body>
</html>
