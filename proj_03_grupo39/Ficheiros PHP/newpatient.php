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

if($_SESSION['previous']!='select_patient_name')
{
	echo('Error: page not available.');
	exit();
}
$_SESSION['previous']='new_patient';

?>


<form action="verify_newpatient.php" method="post">
<h3>Insert patient info please</h3>
<p>Name: <input type="text" name="patient_name" placeholder="Patient's name" size="30" pattern="([ \u00c0-\u01ffa-zA-Z\-])+" oninvalid="setCustomValidity('Please enter a valid name')"
    onchange="try{setCustomValidity('')}catch(e){}" required/></p>
<p>Birthday: <select required name="year_b">
  <option  value="">Year</option>
  <?php for ($year_b = date('Y'); $year_b >= date('Y')-100; $year_b--) { ?>
        <option value="<?php echo $year_b; ?>"><?php echo $year_b; ?></option>
        <?php } ?>
</select>
<select required name="month_b">
        <option value="">Month</option>
        <?php for ($month_b = 1; $month_b <= 12; $month_b++) { ?>
        <option value="<?php echo strlen($month_b)==1 ? '0'.$month_b : $month_b; ?>"><?php echo strlen($month_b)==1 ? '0'.$month_b : $month_b; ?></option>
        <?php } ?>
</select>
<select required name="day_b">
  <option value="">Day</option>
        <?php for ($day_b = 1; $day_b <= 31; $day_b++) { ?>
        <option value="<?php echo strlen($day_b)==1 ? '0'.$day_b : $day_b; ?>"><?php echo strlen($day_b)==1 ? '0'.$day_b : $day_b; ?></option>
        <?php } ?>
</select>
</p>

<p>Address: <input type="text" name="address" placeholder="Patient's address" size="30" pattern="([ \u00c0-\u01ffa-zA-Z\.\-0-9])+" oninvalid="setCustomValidity('Please enter a valid address')"
    onchange="try{setCustomValidity('')}catch(e){}" required/></p>
<h3>Insert appointment info please</h3>


<?php
$arr_id = array();
$arr_name = array();
$sql = "SELECT * FROM doctor";
$result = $connection->query($sql);
foreach($result as $row)
{
 $arr_name[]=$row['name'];
 $arr_id[] = $row['doctor_id'];
}
?>
<p>Doctor: 
 <select required name="doctor_id">
  <option  name="doctor_id" value="">Doctor</option>
  <?php for ($i =0 ; $i < sizeof($arr_name); $i++) { ?>
        <option value="<?php echo $arr_id[$i]; ?>"><?php echo $arr_name[$i]." id=".$arr_id[$i]; ?></option>
        <?php } ?>
</select> </p>

<p>Date: <select required name="year">
  <option name="yy" value="">Year</option>
  <?php for ($year = date('Y'); $year <= date('Y')+4; $year++) { ?>
	<option value="<?php echo $year; ?>"><?php echo $year; ?></option>
	<?php } ?>
</select>
<select required name="month">
	<option name="mm" value="">Month</option>
	<?php for ($month = 1; $month <= 12; $month++) { ?>
	<option value="<?php echo strlen($month)==1 ? '0'.$month : $month; ?>"><?php echo strlen($month)==1 ? '0'.$month : $month; ?></option>
	<?php } ?>
</select>
<select required name="day">
  <option name="dd" value="">Day</option>
	<?php for ($day = 1; $day <= 31; $day++) { ?>
	<option value="<?php echo strlen($day)==1 ? '0'.$day : $day; ?>"><?php echo strlen($day)==1 ? '0'.$day : $day; ?></option>
	<?php } ?>
</select>
<select required name="hour">
  <option name="hh" value="">Hour</option>
        <?php for ($hour = 8; $hour <= 20; $hour++) { ?>
        <option value="<?php echo strlen($hour)==1 ? '0'.$hour.':00' : $hour.':00'; ?>"><?php echo strlen($hour)==1 ? '0'.$hour.':00' : $hour.':00'; ?></option>
        <?php } ?>
</select>
</p>
<p>Office: <input type="text" name="office" placeholder="Office" size="20" pattern="([ a-zA-Z\.\-0-9])+" oninvalid="setCustomValidity('Please enter a valid office')" onchange="try{setCustomValidity('')}catch(e){}" required/></p>
<p><input value="Submit" type="submit"/></p>
</form>

</body>
</html>
