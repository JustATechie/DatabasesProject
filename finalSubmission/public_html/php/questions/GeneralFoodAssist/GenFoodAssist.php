<!--Q1: How have enrollment numbers in Food Assistance programs varied over the years by state?-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Food Assistance Data</title>
</head>

<body>
<!-- Global variables -->
<?php
GLOBAL $selectedState;
GLOBAL $selectedYear;
?>

<!------------------ Get data for charts ------------------>
<!-- Get the list of states in our database. -->
<?php $stateNamesList = include 'Chart1/getStates.php' ?>

<!-- Get the list of years in our database. -->
<?php $yearList = include 'Chart2/getYears.php'; ?>

<!-- Parse lists into dropdown selection boxs. -->
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
        
        <label>Select Year:</label>
        <select class="form-control" name="yearFilter">
            <?php
            foreach($yearList as $row){
                $year = $row['Year'];

                if($year == $_POST['yearFilter']){
                    $isSelected = ' selected="selected"'; // if the option submitted in form is as same as this row we add the selected tag
                    $selectedYear = $year;
                } else {
                    $isSelected = ''; // else we remove any tag
                }
                echo "<option value='".$row['Year']."'".$isSelected.">$year</option>";
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

<!-- Call filter file and get data on the specified state. (chart 1) -->
<?php
$data1 = include 'Chart1/filter.php';

if(($data1) && ($data1->num_rows < 1)){
    // error handling for this is already handled!
} else {
    $dataPoints1 = array();
    
    foreach($data1 as $row) {
        array_push($dataPoints1, $row);
    }
}
?>

<!-- Call filter file and get data on the specified year. (chart 2) -->
<?php
$data2 = include 'Chart2/filter.php';

if(($data2) && ($data2->num_rows < 1)){
    // error handling for this is already handled!
} else {
    $dataPoints2 = array();

    foreach($data2 as $row) {
        array_push($dataPoints2, $row);
    }
}

?>
<!-- Free list objects. -->
<?php
if($data1->num_rows > 1){
    $data1->free_result();
}

if($data2->num_rows > 1){
    $data2->free_result();
}
?>

<!------------------ End data for charts ------------------>


<!------------------ Graph Drawing Section ------------------>

<!-- Include template file for chart section. -->
<?php include('../../templates/questions/chartArea.php'); ?>

<div id="chartContainer1" style="width: 49%; height: 300px;display: inline-block;"></div>
<div id="chartContainer2" style="width: 49%; height: 300px;display: inline-block;"></div>

<!-- Chart 1 (line) -->
<script type="text/javascript">
    if("<?php echo $dataPoints1; ?>".length < 1){
        //if not enough data, do not draw graph!
    } else {
        $(function () {
            var chart1 = new CanvasJS.Chart("chartContainer1", {
                theme: "light2",
                zoomEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Number of people enrolled in Food Assistance programs by year in " + "<?php echo $selectedState; ?>"
                },
                data: [
                    {
                        type: "line",
                        dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            chart1.render();
        });
    }
</script>

<!-- Chart 2 (pie) -->
<script type="text/javascript">
    if("<?php echo $dataPoints2; ?>".length < 1){
        //if not enough data, do not draw graph!
    } else {
        $(function () {
            var chart2 = new CanvasJS.Chart("chartContainer2", {
                title: {
                    text: "Percentage of people in each program in "  + "<?php echo $selectedYear; ?>" + " in " + "<?php echo $selectedState; ?>"
                },
                animationEnabled: true,
                legend: {
                    verticalAlign: "center",
                    horizontalAlign: "left",
                    fontSize: 20,
                    fontFamily: "Helvetica"
                },
                theme: "light2",
                data: [
                    {
                        type: "pie",
                        indexLabelFontFamily: "Garamond",
                        indexLabelFontSize: 20,
                        indexLabel: "{label} {y}%",
                        startAngle: -20,
                        showInLegend: true,
                        toolTipContent: "{legendText} {y}%",
                        dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            chart2.render();
        });
    }
    
</script>

<!-- Free list objects. -->
<?php
if($dataPoints1->num_rows > 1){
    $dataPoints1->free_result();
}

if($dataPoints2->num_rows > 1){
    $dataPoints2->free_result();
}
?>

<?php $conn->close(); ?>

<!-- Closing opening body tag from PageSetup.php -->
</body>