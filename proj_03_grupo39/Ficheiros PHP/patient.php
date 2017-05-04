<?php session_start();?>
<html>
<body>
<?php

$_SESSION['previous']='patient';

$date = date("Y-m-d");
$time = date("H:i:s");
echo("<p>Welcome to group's 39 HealthCare Centre. \n The current time is: $time, $date</p>\n");
?>
<form action="select_patient_name.php" method="post">
<h3>Insert your Patient Name please</h3>
<h5>(To search for all patients leave it blank)</h5>
<p><input type="text" name="patient_name" placeholder="Patient's name" size="30" pattern="([ \u00c0-\u01ffa-zA-Z\-])+" oninvalid="setCustomValidity('Please enter a valid name')"
    onchange="try{setCustomValidity('')}catch(e){}" /></p>
<p><input value="Submit" type="submit"/></p>
</form>


<img src="hc.png" alt="healthcare" style="width:604px;height:428px;">

</body>
</html>
