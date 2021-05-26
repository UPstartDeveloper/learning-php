<?php

// Prayer Times Calculator, Sample Usage
// By: Hamid Zarrabi-Zadeh
// Edited by Zain Raza in December 2020 - added $month and $day as inputs
// Inputs : $year, $month

include('PrayTime.php');

// use values from the previous form submission
if (isset($_GET["year"])  && isset($_GET["month"])) {
	// use values from the previous form submission
	list($method, $year, $month, $latitude, $longitude, $timeZone) = (array(
		0, $_GET["year"], $_GET["month"], 43, -80, -5
	));
// otherwise set default values for the form
} else {
	list($method, $year, $month, $latitude, $longitude, $timeZone) = (array(
		0, 2020, 1, 43, -80, -5
	));
}

?>

<?php

$prayTime = new PrayTime($method);

// set the start date
$date = strtotime($year . "-$month-1");
// set the end date
if ($month == 12) {
	// edge case for December
	$endDate = strtotime(($year) . "-12-31");
} else {
	// handle all other months by going forward 1 month
	$endMonth = $month + 1;
	$endDate = strtotime(($year) . "-$endMonth-1");
	// go back to the last day of the given month
	$endDate -= 24 * 60 * 60;
}

// make an array of the times we need for each day
$prayerNames = [
	"Fajr", "Sunrise", "Dhuhr", "Asr", "Sunset", "Maghrib", "Isa"
];

// map each day to another map of prayer times for that specific day
while ($date <= $endDate) {
	// get times for the current day
	$times = $prayTime->getPrayerTimes($date, $latitude, $longitude, $timeZone);
	// $times = $prayTime->getDatePrayerTimes($year, $month, $day, 42.2167, -71.5328, -5);
	$day = date('M d', $date);
	// map the name of each time to it's specific timing
	foreach ($times as $index => $time) {
		$prayerName = $prayerNames[$index];
		$prayerTimes[$prayerName] = "$time";
	}
	// map the day to its times
	$dayToPrayerTimes[$day] = $prayerTimes;
	// move to the next day
	$date += 24 * 60 * 60;  
}

?>
<html>

<head>
	<title>Prayer Timetable</title>
</head>

<style>
	pre {
		font-family: courier, serif;
		size: 10pt;
		margin: 0px 8px;
	}
</style>

<body>

	<h1> Prayer Timetable</h1>
	<form name="form" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div style="padding:10px; background-color: #F8F7F4; border: 1px dashed #EAE9CD;">

			Year: <input type="text" value="<?php echo $year ?>" name="year" size="4"> <br>
			Month: <input type="text" value="<?php echo $month ?>" name="month" size="2"> <br>
			Method:
			<select id="method" name="method" size="1" onchange="document.form.submit()">
				<option value="0">Shia Ithna-Ashari</option>
			</select>
			<input type="submit" value="Make Timetable">

		</div>
	</form>


	<!-- Prayer Times in 2 Columns -->
	<table>
		<tbody>
			<?php
			// loop through all the days
			foreach ($dayToPrayerTimes as $day => $prayerTimes) {
				echo "
						<thead>
							<td><strong>{$day}<strong/></td>
						</thead>
					";
				// start a row for the 7 prayer times
				echo "
					<tr>
						<th>Fajr</th>
						<th>Sunrise</th>
						<th>Dhuhr</th>
						<th>Asr</th>
						<th>Sunset</th>
						<th>Maghrib</th>
						<th>Isa</th>
					</tr>
					<tr>
					";
				// loop through the prayer times for this day, on the next row
				foreach ($prayerTimes as $prayer => $time) {
					echo "
						<td>{$time}</td>
					";
				}
				// end the row
				echo "</tr>";
			}
			?>
		</tbody>
	</table>

	<script type="text/javascript">
		var method = <?php echo $method ?>;
		document.getElementById('method').selectedIndex = Math.min(method, 6);
	</script>

</body>

</html>