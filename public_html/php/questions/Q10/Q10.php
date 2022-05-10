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

<!-- Get obesity data by year -->
<!-- Get general info! -->
<?php

$Object = include 'obesityData.php';

if($Object->num_rows > 0){
        $obesityData = array();
        foreach($Object as $row){
            array_push($obesityData, $row);
    }}
?>

<?php include('../../templates/questions/chartArea.php'); ?>

<div class="center" id="chartContainer1" style="width: 40%; margin: auto;height: 300px;"></div>
<div class="center" id="chartContainer2" style="width: 80%; height: 300px;margin: auto;padding:10px;"></div>

<script type="text/javascript">
    $(function () {
        if ("<?php echo $minMaxData; ?>".length > 1) {
            var chart1 = new CanvasJS.Chart("chartContainer1", {
                animationEnabled: true,
                theme: "light1", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Minimum and Maximum Childhood Obesity Rates in  " + "<?php echo $selectedState ?>",
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
                        {y: parseFloat("<?php echo $minObesity ?>"), label: "Minimum Rate (" + "<?php echo $minYear ?>" + ")"},
                        {y: parseFloat("<?php echo $maxObesity ?>"), label: "Maximum Rate (" + "<?php echo $maxYear ?>" + ")"}
                    ]
                }]
            });

            chart1.render();
        }
    });


</script>

<script>
    $(function () {
        if ("<?php echo $obesityData; ?>".length > 1) {
            var chart2 = new CanvasJS.Chart("chartContainer2", {
                animationEnabled: true,
                title: {
                    text: "Childhood Obesity Rate by Year following start of No Kid Hungry Movement in 2010 in " + "<?php echo $selectedState ?>"
                },
                axisY: {
                    title: "Obesity Rate (%)",
                    stripLines: [{
                        value: parseFloat("<?php echo $avgObesity ?>"),
                        label: "Average"
                    }]
                },
                data: [{
                    xValueFormatString: "YYYY",
                    type: "spline",
                    dataPoints: <?php echo json_encode($obesityData, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart2.render();
        }
    });

</script>


</body>

<?php $conn->close(); ?>


