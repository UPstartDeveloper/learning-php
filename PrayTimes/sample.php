<?php
	
	// Prayer Times Calculator, Sample Usage
	// By: Hamid Zarrabi-Zadeh
	// Edited by Zain Raza in December 2020 - added $month and $day as inputs
	// Inputs : $method, $year, $latitude, $longitude, $timeZone, $month, $day
	
	include('PrayTime.php');

	// default values for the form
	if (!isset($method) || !isset($year) )
		list($method, $year, $latitude, $longitude, $timeZone, $month, $day) = (
			array(0, 2020, 43, -80, -5,
				 12, 15 
			)
		);
	
?>
<html>
<head>
	<title>Prayer Timetable</title>
</head>
<style>
	pre {font-family: courier, serif, size: 10pt; margin: 0px 8px;}
</style>

<body>

<h1> Prayer Timetable </h1>
<form name="form" method="post" action="<?php echo $PHP_SELF ?>">
<div style="padding:10px; background-color: #F8F7F4; border: 1px dashed #EAE9CD;">

	Latitude: <input type="text" value="<?php echo $latitude ?>" name="latitude" size="4">
	Longitude: <input type="text" value="<?php echo $longitude ?>" name="longitude" size="4">
	Time Zone: <input type="text" value="<?php echo $timeZone ?>" name="timeZone" size="2"> 
	Year: <input type="text" value="<?php echo $year ?>" name="year" size="4"> <br>
	Method: 
	<select id="method" name="method" size="1" onchange="document.form.submit()">
		<option value="0">Shia Ithna-Ashari</option>
    </select>	
	<input type="submit" value="Make Timetable">

</div>
</form>

<pre>
 Date   Fajr   Sunrise  Dhuhr    Asr   Sunset  Maghrib  Isha 
-------------------------------------------------------------
<?php

	$prayTime = new PrayTime($method);

	// get the prayer times for just the month, day, and year specified
	$date = strtotime($year . "-$month-$day");
	// set the end date so only the times for one day appears
	$endDay = $day + 1;
	$endDate = strtotime($year . "-$month-$endDay");

	while ($date < $endDate)
	{
		$times = $prayTime->getPrayerTimes($date, $latitude, $longitude, $timeZone);
		$day = date('M d', $date);
		print $day. "\t". implode("\t", $times). "\n";
		$date += 24* 60* 60;  // next day
	}

?>
</pre>

<script type="text/javascript">
	
	var method = <?php echo $method ?>;
	document.getElementById('method').selectedIndex = Math.min(method, 6);

</script>

</body>
</html>



