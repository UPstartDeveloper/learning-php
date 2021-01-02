<?php

// Prayer Times Calculator, Sample Usage
// By: Hamid Zarrabi-Zadeh
// Edited by Zain Raza in December 2020 - added $month and $day as inputs
// Inputs : $method, $year, $latitude, $longitude, $timeZone, $month, $day

include('PrayTime.php');

// default values for the form
if (!isset($method) || !isset($year))
	list($method, $year, $latitude, $longitude, $timeZone, $month, $day) = (array(
		0, 2021, 42.2167, -71.5328, -5,
		1, 1
	));

?>

<?php

$prayTime = new PrayTime($method);

// get the prayer times for just the month, day, and year specified
$date = strtotime($year . "-$month-$day");
$times = $prayTime->getPrayerTimes($date, $latitude, $longitude, $timeZone);
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

		<h1> Prayer Timetable </h1>		

		<!-- Prayer Times in 2 Columns -->
		<table>
			<tbody>
				<?php 
					// loop through the prayers and their times
					foreach($prayerTimes as $prayer=>$time) {
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