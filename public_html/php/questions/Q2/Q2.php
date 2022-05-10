<!--Q2: Which state has worked to pass the most legislative bills related to food, health and nutrition and how have the rates of metabolic disease changed in this state over the years?-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Food Assistance Legislation and Metabolic Rates</title>
</head>
<body>
<!-- Global variables -->
<?php
GLOBAL $Q2MaxYear;
GLOBAL $Q2MinYear;
GLOBAL $Q2State;
?>

<h5>Which state has worked to pass the most legislative bills related to food, health and nutrition and how have the rates of metabolic disease changed in this state over the years?</h5>

<form method="POST" action="">
    <div class="form-inline">
        <button class="btn btn-primary" name="getInfo">Submit</button>
    </div>
</form>

<!-- Get State name! -->
<?php

$StateObject = include 'GetState.php';

if($StateObject->num_rows > 0){
    foreach($StateObject as $row){
        $Q2State=$row['State'];
    }

    echo $Q2State . " has the passed the most legislative bills related to food, health and nutrition!";
}
?>

<!-- Get Year data! -->
<?php

$YearResults = include 'GetYears.php';

if($YearResults->num_rows > 0){
    $State=-1;
    foreach($YearResults as $row){
        $Q2MinYear=$row['min'];
        $Q2MaxYear=$row['max'];
    }

    echo "Min year: " . $Q2MinYear . ", max year: " . $Q2MaxYear;
}

?>

<!-- Get female 65+ data! -->
<?php

$femaleResults = include 'Ages65Plus/female.php';

if($femaleResults->num_rows > 0){
    $female65PlusDataPoints = array();

    foreach($femaleResults as $row) {
        array_push($female65PlusDataPoints, $row);
    }

    echo "<br> got female data!";

}

?>

<!-- Get male 65+ data! -->
<?php

$maleResults = include 'Ages65Plus/female.php';

if($maleResults->num_rows > 0){
    $male65PlusDataPoints = array();

    foreach($maleResults as $row) {
        array_push($male65PlusDataPoints, $row);
    }

    echo "<br> got male data!";

}

?>

<script type="text/javascript">
    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Heart Disease Rates by Gender and Age in " + "<?php echo $Q2State ?>"
            },
            axisX: {
                //valueFormatString: "#,###"
                title: "Year"
            },
            axisY2: {
                title: "Diseased per 100,000"
            },
            toolTip: {
                shared: true
            },
            legend: {
                cursor: "pointer",
                verticalAlign: "top",
                horizontalAlign: "center",
                dockInsidePlotArea: true,
                itemclick: toogleDataSeries
            },
            data: [{
                type:"line",
                axisYType: "secondary",
                name: "Females ages 65+",
                showInLegend: true,
                markerSize: 0,
                dataPoints: <?php echo json_encode($female65PlusDataPoints, JSON_NUMERIC_CHECK); ?>
    }, {


                
            }





    ]
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
</script>

<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
</body>

<?php $conn->close(); ?>
