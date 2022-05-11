<!--Q11:-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>School Food Program Enrollment and Average Annual Income</title>
</head>
<body>
<br>

<!-- Global variables -->
<?php
GLOBAL $selectedSF;
?>

<h4>What is the distribution of states where the selected school food program helped the most and least students and what was the average income for households in these years? </h4>

<?php $SFList = include '../Q12/getSF.php' ?>

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
        <button class="btn btn-primary" name="getStats">Submit</button>
    </div>
</form>

<?php
if($SFList->num_rows > 1){
    $SFList->free_result();
}
?>

<br>
<br>


<?php

$maxResults = include 'getMaxData.php';

if($maxResults->num_rows > 0){
    $maxDataPoints = array();

    foreach($maxResults as $row) {
        array_push($maxDataPoints, $row);
    }

}

?>

<?php

$minResults = include 'getMinData.php';

if($minResults->num_rows > 0){
    $minDataPoints = array();

    foreach($minResults as $row) {
        array_push($minDataPoints, $row);
    }

}

?>

<?php

$incomeResults = include 'getAvgIncomeData.php';

if($incomeResults->num_rows > 0){
    $incomeDataPoints = array();

    foreach($incomeResults as $row) {
        array_push($incomeDataPoints, $row);
    }

}

?>

<?php include('../../templates/questions/chartArea.php'); ?>

<div class="center" id="chartContainer1" style="width: 40%; margin: auto;height: 300px;"></div>
<div class="center" id="chartContainer2" style="width: 80%; height: 300px;margin: auto;padding:10px;"></div>


<script>
$(function () {
    var chart = new CanvasJS.Chart("chartContainer", {
        exportEnabled: true,
        animationEnabled: true,
        title:{
            text: "Number of states with minimum and maximum enrollment for the " + "<?php echo $selectedSF ?>" + " program by year",
        },
        subtitles: [{
            text: "Click Legend to Hide or Unhide Data Series"
        }], 
        axisX: {
            title: "Year"
        },
        axisY: {
            title: "Number of States",
            //titleFontColor: "#4F81BC",
            //lineColor: "#4F81BC",
            //labelFontColor: "#4F81BC",
            //tickColor: "#4F81BC",
            includeZero: true
        },
        toolTip: {
            shared: true
        },
        legend: {
            cursor: "pointer",
            itemclick: toggleDataSeries
        },
        data: [{
            type: "column",
            name: "Maximum Enrollment",
            showInLegend: true,      
            // yValueFormatString: "#,##0.# Units",
            dataPoints: <?php echo json_encode($maxDataPoints, JSON_NUMERIC_CHECK); ?>
        },
        {
            type: "column",
            name: "Minimum Enrollment",
            axisYType: "secondary",
            showInLegend: true,
            // yValueFormatString: "#,##0.# Units",
            dataPoints: <?php echo json_encode($minDataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    })
});
</script>

<script>
$(function () {

    var chart = new CanvasJS.Chart("chartContainer", {
        exportEnabled: true,
        animationEnabled: true,
        title:{
            text: "Car Parts Sold in Different States"
        },
        subtitles: [{
            text: "Click Legend to Hide or Unhide Data Series"
        }], 
        axisX: {
            title: "States"
        },
        axisY: {
            title: "Oil Filter - Units",
            titleFontColor: "#4F81BC",
            lineColor: "#4F81BC",
            labelFontColor: "#4F81BC",
            tickColor: "#4F81BC",
            includeZero: true
        },
        axisY2: {
            title: "Clutch - Units",
            titleFontColor: "#C0504E",
            lineColor: "#C0504E",
            labelFontColor: "#C0504E",
            tickColor: "#C0504E",
            includeZero: true
        },
        toolTip: {
            shared: true
        },
        legend: {
            cursor: "pointer",
            itemclick: toggleDataSeries
        },
        data: [{
            type: "column",
            name: "Oil Filter",
            showInLegend: true,      
            yValueFormatString: "#,##0.# Units",
            dataPoints: <?php echo json_encode($maxDataPoints, JSON_NUMERIC_CHECK); ?>
        },
        {
            type: "column",
            name: "Clutch",
            axisYType: "secondary",
            showInLegend: true,
            yValueFormatString: "#,##0.# Units",
            dataPoints: <?php echo json_encode($minDataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();

    function toggleDataSeries(e) {
        if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else {
            e.dataSeries.visible = true;
        }
        e.chart.render();
    }

});
</script>

</body>

<?php $conn->close(); ?>
