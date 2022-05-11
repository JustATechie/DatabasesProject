<!--Q9:-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Metabolic Rates and School Enrollment Rates</title>
</head>
<body>
<br>

<!-- Global variables -->
<?php
GLOBAL $selectedState;
?>

<?php $stateNamesList = include '../GeneralFoodAssist/Chart1/getStates.php' ?>

<h4>What is the prevalence of metabolic disease in kids for the year with highest and lowest school enrollment rate by State?</h4>

<form method="POST" action="">
    <div class="form-inline">
	<label>Select State Name:</label>
        <select class="form-control" name="stateFilter">
            <?php
            foreach($stateNamesList as $row){
                $stateName = $row['State'];

                if($stateName == $_POST['stateFilter']){
                    $isSelected = ' selected="selected"'; // if the option submitted in form is as same as this row we add the selected tag
                    $selectedState = $stateName;
                } else {
                    $isSelected = ''; // else we remove any tag
                }
                echo "<option value='".$stateName."'".$isSelected.">$stateName</option>";
            }
            ?>
        </select>
        <button class="btn btn-primary" name="getInfo">Submit</button>
    </div>
</form>

<br>
<br>

<?php
if($stateNamesList->num_rows > 1){
    $stateNamesList->free_result();
}
?>

<!-- Get general info! -->
<?php
$Object = include 'getData.php';
// $dataPoints = array();
if($Object->num_rows > 0){
	$dataPoints = array();
	foreach($Object as $row){
	    array_push($dataPoints, $row);
	    $minYear=$row['MinEnrolledYear'];
	    $maxYear=$row['MaxEnrolledYear'];
	    $maxObesity=$row['maxYearObesity'];
	    (!IS_NULL($row['minYearObesity'])) ? $minObesity=ROUND($row['minYearObesity'],2)."%" : $minObesity="not known (data not available)";
	    (!IS_NULL($row['maxYearObesity'])) ? $maxObesity=ROUND($row['maxYearObesity'],2)."%" : $maxObesity="not known (data not available)";
	    $minEnroll=$row['MinEnrolled'];
	    $maxEnroll=$row['MaxEnrolled'];
    }
    echo "<h5>In ". $selectedState. ", the year ". $minYear ." had the lowest school enrollment and childhood obesity rate was ". $minObesity .". ". "The year ". $maxYear ." had the highest school enrollment rate in this state and the state childhood obesity rate for that year was " . $maxObesity. ".</h5>";
}
?>

<script type="text/javascript">
	window.onload = function () {
		if ("<?php echo $dataPoints; ?>".length > 1) {
            		var chart = new CanvasJS.Chart("chartContainer", {
	    			animationEnabled: true,
				theme: "light2", // "light1", "light2", "dark1", "dark2"
				title:{
					text: "Minimum and Maximum School Enrollment Numbers in "  + "<?php echo $selectedState ?>"
    				},
				axisY: {
					title: "Number of Students Enrolled"
    				},
				axisX: {
					title: "Year"		
    				},
				data: [{        
				type: "column",  
				dataPoints: [      
					{ y: parseInt("<?php echo $minEnroll ?>"), label: "Minimum Enrollment (" + "<?php echo $minYear ?>" + ")"},
					{ y: parseInt("<?php echo $maxEnroll ?>"),  label:  "Maximum Enrollment (" + "<?php echo $maxYear ?>" + ")"}
				]
			}]
	    	});
            chart.render();
	}
     }
</script>

<body>
<div class="center" id="chartContainer" style="height: 370px; width: 60%; margin: auto; padding: 4px"></div>
</body>

<?php $conn->close(); ?>

