<!--Q1: How have enrollment numbers in Food Assistance programs varied over the years by state?-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Food Assistance Data</title>
</head>

<body>

<?php GLOBAL $selectedState ?>

<!-- Get the list of states in our database. -->
<?php $stateNamesList = include'getStates.php'?>

<!-- Parse list of states into dropdown selection box. -->
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
        <button class="btn btn-primary" name="getStats">Submit</button>
    </div>
</form>

<!-- Free states list object. -->
<?php
if($stateNamesList->num_rows > 1){
    $stateNamesList->free_result();
}
?>

<!-- Call filter file and get data on the specified state. -->
<?php
$data = include'filter.php';

if(($data) && ($data->num_rows < 1)){
    // error handling for this is already handled!
} else {
    $dataPoints = array();
    
    foreach($data as $row) {
        array_push($dataPoints, $row);
    }
}
?>

<!-- Include template file for chart section. -->
<?php include('../../templates/questions/chartArea.php'); ?>

<div id="chartContainer1"></div>

<script type="text/javascript">
    if("<?php echo $dataPoints; ?>".length < 1){
        //if not enough data, do not draw graph!
    } else {
        $(function () {
            var chart = new CanvasJS.Chart("chartContainer1", {
                theme: "light2",
                zoomEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Number of enrolled people in FA programs by Year in " + "<?php echo $selectedState; ?>"
                },
                data: [
                    {
                        type: "line",
                        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            chart.render();
        });
    }


</script>

<?php $conn->close(); ?>

<!-- Closing opening body tag from PageSetup.php -->
</body>