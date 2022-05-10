<!--Q#:-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Childhood Obesity and No Kid Hungry Initiative</title>
</head>
<body>
<br>

<!-- Global variables -->
<?php
GLOBAL $selectedState;
?>

<?php $stateNamesList = include '../GeneralFoodAssist/Chart1/getStates.php' ?>

<h4>What was the average, minimum, and maximum level of childhood obesity by state in the years after the intiation of the “No Kid Hungry” initiative?</h4>

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

<!-- Get general info! -->
<?php

$Object = include 'getData.php';

if($Object->num_rows > 0){
	$minMaxData = array();
	foreach($Object as $row){
	    array_push($minMaxData, $row);
	    $minYear=$row['minObesityYear'];
	    $maxYear=$row['maxObesityYear'];
	    $minObesity=$row['minObesity'];
	    $maxObesity=$row['maxObesity'];
	    $avgObesity=$row['avgObesity'];
    }}
?>

<script type="text/javascript">
	window.onload = function () {
		if ("<?php echo $minMaxData; ?>".length > 1) {
            		var chart = new CanvasJS.Chart("chartContainer", {
	    			animationEnabled: true,
				theme: "light1", // "light1", "light2", "dark1", "dark2"
				title:{
					text: "Minimum and Maximum Childhood Obesity Rates in  "  + "<?php echo $selectedState ?>",
					horizontalAlign: "center",
    				},
				axisY: {
					title: "Obesity Rate (%)",
					horizontalAlign: "center",
    				},
				axisX: {
					title: "Year",
					horizontalAlign: "center",
    				},
				data: [{
				type: "column",
				dataPoints: [
					{ y: parseFloat("<?php echo $minObesity ?>"), label: "Minimum Rate (" + "<?php echo $minYear ?>" + ")"},
					{ y: parseFloat("<?php echo $maxObesity ?>"),  label:  "Maximum Rate (" + "<?php echo $maxYear ?>" + ")"}
				]
			}]
	    	});
            chart.render();
	}
     }
</script>

<body>
<div class="center" id="chartContainer" style="height: 370px; width: 40%; margin: auto; padding: 4px"></div>
</body>

<?php $conn->close(); ?>


