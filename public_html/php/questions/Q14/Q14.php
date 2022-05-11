<!--Q#:-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Heart Disease and Consumption</title>
</head>
<body>
<br>

<!-- Global variables -->
<?php
GLOBAL $ex;
?>

<h4>In 2013 in California, for adults (18+), which gender had the greater ratio of sugar to produce intake and what was the rate of heart disease for each gender by county? </h4>

<form method="POST" action="">
    <div class="form-inline">
        <button class="btn btn-primary" name="getInfo">Submit</button>
    </div>
</form>

<br>
<br>

<!-- Get general info! -->
<?php
$Object = include 'getMaxGender.php';
// $dataPoints = array();
if($Object->num_rows > 0){
	$maxGenderDataPoints = array();
	foreach($Object as $row){
	    array_push($maxGenderDataPoints, $row);
	    $maxGender=$row['Gender'];
    }
    echo "<h5>In the 2013 Adult (18+) population in California, the ".$maxGender." gender had the highest ratio of sugar to produce intake.</h5>";
} 
?>


<!-- Get specific data! -->
<?php

$femaleResults = include 'getFemaleData.php';

if($femaleResults->num_rows > 0){
    $femaleDataPoints = array();

    foreach($femaleResults as $row) {
        array_push($femaleDataPoints, $row);
    }

    #echo "<br> got data!";

}

?>

<?php

$maleResults = include 'getMaleData.php';

if($maleResults->num_rows > 0){
    $maleDataPoints = array();

    foreach($maleResults as $row) {
        array_push($maleDataPoints, $row);
    }

    #echo "<br> got data!";

}
?>


<!------------------ Graph Drawing Section ------------------>

<!-- Include template file for chart section. -->
<script type="text/javascript">
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Heart Disease Rates by County and Gender in 2013 Adult Population in California"
	},
	axisY: {
		title: "County"
	},
	legend: {
		cursor:"pointer",
		itemclick : toggleDataSeries
	},
	toolTip: {
		shared: true,
		content: toolTipFormatter
	},
	data: [
	{
		type: "bar",
		showInLegend: true,
		name: "Female",
		color: "red",
		dataPoints: <?php echo json_encode($femaleDataPoints, JSON_NUMERIC_CHECK); ?>
	},
	{
		type: "bar",
		showInLegend: true,
		name: "Male",
		color: "blue",
		dataPoints: <?php echo json_encode($maleDataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

function toolTipFormatter(e) {
	var str = "";
	var total = 0 ;
	var str3;
	var str2 ;
	for (var i = 0; i < e.entries.length; i++){
		var str1 = "<span style= \"color:"+e.entries[i].dataSeries.color + "\">" + e.entries[i].dataSeries.name + "</span>: <strong>"+  e.entries[i].dataPoint.y + "</strong> <br/>" ;
		total = e.entries[i].dataPoint.y + total;
		str = str.concat(str1);
	}
	str2 = "<strong>" + e.entries[0].dataPoint.label + "</strong> <br/>";
	str3 = "<span style = \"color:Tomato\">Total: </span><strong>" + total + "</strong><br/>";
	return (str2.concat(str)).concat(str3);
}

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else {
		e.dataSeries.visible = true;
	}
	chart.render();
}

}
</script>

<body>
<?php echo "<br><br><br>" ?>
<div style="center" id="chartContainer" style="height: 500px; width: 50%;padding:20px;"></div>
</body>

<?php $conn->close(); ?>
