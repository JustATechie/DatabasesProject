<!--Q#:-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>School Food and Food Assistance Program Enrollment</title>
</head>
<body>
<br>

<!-- Global variables -->
<?php
GLOBAL $selectedSF;
GLOBAL $selectedFA;
?>

<h4>In the state that on average had the most students enrolled in the chosen School Food program, what was the number of people enrolled in the chosen FoodAssistance Program by year?</h4>

<!-- Get the list of states in our database. -->
<?php $SFList = include 'getSF.php' ?>

<!-- Get the list of years in our database. -->
<?php $FAList = include 'getFA.php'; ?>

<!-- Parse lists into dropdown selection boxs. -->
<form method="POST" action="">
    <div class="form-inline">
        <label>Select School Food Program:</label>
        <select class="form-control" name="sfFilter">
            <?php
            foreach($SFList as $row){
                $sfName = $row['Name'];

                if($sfName == $_POST['sfFilter']){
                    $isSelected = ' selected="selected"'; // if the option submitted in form is as same as this row we add the selected tag
                    $selectedSF = $sfName;
                } else {
                    $isSelected = ''; // else we remove any tag
                }
                echo "<option value='".$sfName."'".$isSelected.">$sfName</option>";
            }
            ?>
        </select>
        
        <label>Select Food Assistance Program:</label>
        <select class="form-control" name="faFilter">
            <?php
            foreach($FAList as $row){
                $faName = $row['Name'];

                if($faName == $_POST['faFilter']){
                    $isSelected = ' selected="selected"'; // if the option submitted in form is as same as this row we add the selected tag
                    $selectedFA = $faName;
                } else {
                    $isSelected = ''; // else we remove any tag
                }
                echo "<option value='".$row['Name']."'".$isSelected.">$faName</option>";
            }
            ?>
        </select>
        <button class="btn btn-primary" name="getStats">Submit</button>
    </div>
</form>

<!-- Free list objects. -->
<?php
if($stateNamesList->num_rows > 1){
    $stateNamesList->free_result();
}

if($yearList->num_rows > 1){
    $yearList->free_result();
}
?>

<br>
<br>

<!-- Get general info! -->
<?php
$Object = include 'getMaxState.php';
// $dataPoints = array();
if($Object->num_rows > 0){
	$dataPoints = array();
	foreach($Object as $row){
	    array_push($dataPoints, $row);
	    $maxState=$row['State'];
    }
    echo "<h5>". $maxState. " is the state with the highest number of students enrolled in the ". $selectedSF." program on average (across all years).</h5>";
}
?>

<?php

$sfResults = include 'getSFData.php';

if($sfResults->num_rows > 0){
    $sfDataPoints = array();

    foreach($sfResults as $row) {
        array_push($sfDataPoints, $row);
    }

}

?>

<?php

$faResults = include 'getFAData.php';

if($faResults->num_rows > 0){
    $faDataPoints = array();

    foreach($faResults as $row) {
        array_push($faDataPoints, $row);
    }

}

?>



<script>
window.onload = function () {
if ("<?php echo $sfDataPoints; ?>".length > 1) {
var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Number of People enrolled in " + "<?php echo $selectedSF ?>" + " and " + "<?php echo $selectedFA ?>" + " in " + "<?php echo $maxState ?>"
	},
	axisX: {
		// valueFormatString: "YYYY",
		title: "Year"
	},
	axisY2: {
		title: "Number Enrolled",
	},
	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		verticalAlign: "top",
		horizontalAlign: "center",
		dockInsidePlotArea: false,
		itemclick: toogleDataSeries
	},
	data: [{
		type:"line",
		axisYType: "secondary",
		name: "FoodAssistance Program: " + "<?php echo $selectedFA ?>",
		showInLegend: true,
		markerSize: 10,
		// yValueFormatString: "$#,###k",
		dataPoints: <?php echo json_encode($faDataPoints, JSON_NUMERIC_CHECK); ?>
	},
	{
		type: "line",
		axisYType: "secondary",
		name: "School Food Program: " + "<?php echo $selectedSF ?>",
		showInLegend: true,
		markerSize: 10,
		// yValueFormatString: "$#,###k",
		dataPoints: <?php echo json_encode($sfDataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

function toogleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else{
		e.dataSeries.visible = true;
	}
	chart.render();
}

}
}
</script>

<body>
<div class="center" id="chartContainer" style="height: 370px; width: 50%;margin: auto; padding:10px;"></div>
</body>

<?php $conn->close(); ?>
