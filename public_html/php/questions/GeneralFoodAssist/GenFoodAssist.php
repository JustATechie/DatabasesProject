<!--Q1: How have enrollment numbers in Food Assistance programs varied over the years by state?-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Food Assistance Data</title>
</head>

<body>

<?php $stateNamesList = include'getStates.php'?>

<form method="POST" action="">
    <div class="form-inline">
        <label>Select State Name:</label>
        <select class="form-control" name="stateFilter">
            <?php
            foreach($stateNamesList as $row){
                $stateName = $row['State'];

                if($row['State'] == $_POST['stateFilter']){
                    $isSelected = ' selected="selected"'; // if the option submitted in form is as same as this row we add the selected tag
                } else {
                    $isSelected = ''; // else we remove any tag
                }
                echo "<option value='".$row['State']."'".$isSelected.">$stateName</option>";
            }
            ?>
        </select>
        <button class="btn btn-primary" name="getStats">Submit</button>
    </div>
</form>

<?php
if($stateNamesList->num_rows > 1){
    $stateNamesList->free_result();
}
?>

<?php
$data = include'filter.php';

if(($data) && ($data->num_rows < 1)){
//    echo "ERROR: could not obtain data from database!";
//    echo "<br><br>";
} else {
    $dataPoints = array();

    foreach($data as $row) {
        array_push($dataPoints, $row);
    }
}

?>

<?php include('../../templates/questions/chartArea.php'); ?>

<div id="chartContainer1"></div>

<script type="text/javascript">
    $(function () {
        var chart = new CanvasJS.Chart("chartContainer1", {
            theme: "light2",
            zoomEnabled: true,
            animationEnabled: true,
            title: {
                text: "Line Chart with Data-Points from DataBase"
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
</script>

<?php $conn->close(); ?>


<!-- Closing opening body tag from PageSetup.php -->
</body>