<?php

// Prayer Times Calculator, Sample Usage
// By: Hamid Zarrabi-Zadeh
// Edited by Zain Raza in December 2020 - added $month and $day as inputs
// Inputs : $year, $month

include('PrayTime.php');

// use values from the previous form submission
if (isset($_GET["year"])  && isset($_GET["month"])) {
	// use values from the previous form submission
	list($method, $year, $month, $day) = (array(
		0, $_GET["year"], $_GET["month"], 1
	));
// otherwise set default values for the form
} else {
	list($method, $year, $month, $day) = (array(
		0, 2020, 1, 1
	));
}

?>

<?php

$prayTime = new PrayTime($method);

// get the prayer times for just the month, day, and year specified
$date = strtotime($year . "-$month-$day");
$times = $prayTime->getPrayerTimes($date, 42.2167, -71.5328, -5);
$day = date('M d', $date);

// make an array of the timings
$prayerNames = [
	"Fajr", "Sunrise", "Dhuhr", "Asr", "Sunset", "Maghrib", "Isa"
];

// map the name of each time to it's specific timing
foreach ($times as $index => $time) {
	$prayerName = $prayerNames[$index];
	$prayerTimes[$prayerName] = "$time";
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
			// loop through the prayers and their times
			foreach ($prayerTimes as $prayer => $time) {
				echo "
							<tr>
								<td>{$prayer}: {$time}</td>
							</tr>
						";
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