<!--Q5: Is there a significant trend between childhood metabolic rates and number of students enrolled in SchoolFoodPrograms?  - (Specifically in CA)-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Metabolic Rates and SFP</title>
</head>
<body>
<br>

<!-- Global variables -->
<?php
?>

<h4>Is there a significant trend between childhood metabolic rates and number of students enrolled in SchoolFoodPrograms?  - (Specifically in CA)</h4>

<form method="POST" action="">
    <div class="form-inline">
        <button class="btn btn-primary" name="getInfo">Submit</button>
    </div>
</form>

<br>
<br>

<!-- Get specific data! -->
<?php

$ObesityResults = include 'getObesityData.php';

if($ObesityResults->num_rows > 0){
    $ObesityDataPoints = array();

    foreach($ObesityResults as $row) {
        echo $row['x'] . " ";
        echo $row['y'] . "<br>";
        array_push($ObesityDataPoints, $row);
    }

    echo "<br> got data!";

}

?>

<div id="chartContainer1" style="width: 49%; height: 300px;display: inline-block;"></div>

<script type="text/javascript">
    if("<?php echo $ObesityDataPoints; ?>".length < 1){
        //if not enough data, do not draw graph!
    } else {
        $(function () {
            var chart1 = new CanvasJS.Chart("chartContainer1", {
                theme: "light2",
                zoomEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Number of people enrolled in Food Assistance programs by year in "
                },
                data: [
                    {
                        type: "line",
                        dataPoints: <?php echo json_encode($ObesityDataPoints, JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            chart1.render();
        });
    }
</script>


</body>

<?php $conn->close(); ?>