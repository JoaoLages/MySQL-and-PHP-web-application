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

if($_SESSION['previous']!='select_patient_name' && $_SESSION['previous']!='verify')
{
	echo('Error: page not available.');
	exit();
}
$_SESSION['previous']='appointment';


$arr_id = array();
$arr_name = array();
$sql = "SELECT * FROM doctor";
$result = $connection->query($sql);
foreach($result as $row)
{
 $arr_name[]=$row['name'];
 $arr_id[] = $row['doctor_id'];
}

if(isset($_REQUEST['id']))
{  
  $patient_id = $_REQUEST['id'];
  if ( !preg_match('/\s/',$patient_id) )
  {
	echo('The patient has the following appointments already scheduled:');
	$sql = "SELECT doctor_id, date, office FROM appointment WHERE patient_id=$patient_id";
	$result = $connection->query($sql);
  }
}

if ($result == FALSE)
{
  $info = $connection->errorInfo();
  echo("<p>Error: {$info[2]}</p>");
  exit();
}
if($result->rowCount()>0){
echo("<table border=\"1\">");
echo("<tr><td>doctor_id</td><td>date</td><td>office</td></tr>");
foreach($result as $row)
{
  echo("<tr><td>");
  echo($row['doctor_id']);
  echo("</td><td>");
  echo($row['date']);
  echo("</td><td>");
  echo($row['office']);
  echo("</td><tr>");
}
echo("</table>");
}else{
echo("<p>The patient has no appointments scheduled</p>");
}
$file_included = false;
$connection = null

?>

<form action="verify.php" method="post">
<h3>Insert appointment info, please</h3>
<p>Doctor:
 <select required name="doctor_id">
  <option  name="doctor_id" value="">Doctor</option>
  <?php for ($i =0 ; $i < sizeof($arr_name); $i++) { ?>
        <option value="<?php echo $arr_id[$i]; ?>"><?php echo $arr_name[$i]." id=".$arr_id[$i]; ?></option>
        <?php } ?>
</select>






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
<p>Office: <input type="text" name="office" placeholder="Office" size="20" pattern="([ a-zA-Z\.\-0-9])+" oninvalid="setCustomValidity('Please enter a valid office')" onchange="try{setCustomValidity('')}catch(e){}" required /></p>
<p><input value="Submit" type="submit"/></p>
<p><input type='hidden' name='id' value='<?php echo "$patient_id";?>'/></p>
<p><input type='hidden' name='file_included' value='<?php echo "$file_included";?>'/></p>
</form>

</body>
</html>
