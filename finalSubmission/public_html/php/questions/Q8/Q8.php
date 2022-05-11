<!--Q8: Did the county as a whole during recent years shift wealth further down or up? If up, did states respond by passing more food legislation bills in the following years?-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Income Shifts</title>
</head>
<body>
<br>

<!-- Global variables -->
<?php
GLOBAL $minYear;
GLOBAL $maxYear;
?>

<h4>Did the county as a whole during recent years shift wealth further down or up? If up, did states respond by passing more food legislation bills in the following years?</h4>
<h6>Note: Year data is limited to data we have available in the Food Legislation data.</h6>

<?php $yearList = include 'getYear.php'?>

<form method="POST" action="">
    <div class="form-inline">
        <label>Select Minimum Year:</label>
        <select class="form-control" name="minYearFilter">
            <?php
            foreach($yearList as $row){
                $year = $row['Year'];

                if($year == $_POST['minYearFilter']){
                    $isSelected = ' selected="selected"'; // if the option submitted in form is as same as this row we add the selected tag
                    $minYear = $year;
                } else {
                    $isSelected = ''; // else we remove any tag
                }
                echo "<option value='".$row['Year']."'".$isSelected.">$year</option>";
            }
            ?>
        </select>

        <label>Select Maximum Year:</label>
        <select class="form-control" name="maxYearFilter">
            <?php
            foreach($yearList as $row){
                $year = $row['Year'];

                if($year == $_POST['maxYearFilter']){
                    $isSelected = ' selected="selected"'; // if the option submitted in form is as same as this row we add the selected tag
                    $maxYear = $year;
                } else {
                    $isSelected = ''; // else we remove any tag
                }
                echo "<option value='".$row['Year']."'".$isSelected.">$year</option>";
            }
            ?>
        </select>

        <button class="btn btn-primary" name="getInfo">Submit</button>
    </div>
</form>

<br>
<br>

<!-- Get Income200kAbove data! -->
<?php

$Results = include 'getIncomeLevels/200kAbove.php';

if($Results->num_rows > 0){
    $DataPoints1 = array();

    foreach($Results as $row) {
        array_push($DataPoints1, $row);
    }

    #echo "<br> got data!";

}

?>
<!-- Get Income150kTo200k data! -->
<?php

$Results = include 'getIncomeLevels/150kTo200k.php';

if($Results->num_rows > 0){
    $DataPoints2 = array();

    foreach($Results as $row) {
        array_push($DataPoints2, $row);
    }

    #echo "<br> got data!";

}

?>

<!-- Get Income100kTo150k data! -->
<?php

$Results = include 'getIncomeLevels/100kTo150k.php';

if($Results->num_rows > 0){
    $DataPoints3 = array();

    foreach($Results as $row) {
        array_push($DataPoints3, $row);
    }

    #echo "<br> got data!";

}

?>

<!-- Get Income75kTo100k data! -->
<?php

$Results = include 'getIncomeLevels/75kTo100k.php';

if($Results->num_rows > 0){
    $DataPoints4 = array();

    foreach($Results as $row) {
        array_push($DataPoints4, $row);
    }

    #echo "<br> got data!";

}

?>

<!-- Get Income50kTo75k data! -->
<?php

$Results = include 'getIncomeLevels/50kTo75k.php';

if($Results->num_rows > 0){
    $DataPoints5 = array();

    foreach($Results as $row) {
        array_push($DataPoints5, $row);
    }

    #echo "<br> got data!";

}

?>

<!-- Get Income35kTo50k data! -->
<?php

$Results = include 'getIncomeLevels/35kTo50k.php';

if($Results->num_rows > 0){
    $DataPoints6 = array();

    foreach($Results as $row) {
        array_push($DataPoints6, $row);
    }

    #echo "<br> got data!";

}

?>

<!-- Get Income25kTo35k data! -->
<?php

$Results = include 'getIncomeLevels/25kTo35k.php';

if($Results->num_rows > 0){
    $DataPoints7 = array();

    foreach($Results as $row) {
        array_push($DataPoints7, $row);
    }

    #echo "<br> got data!";

}

?>

<!-- Get Income15kTo25k data! -->
<?php

$Results = include 'getIncomeLevels/15kTo25k.php';

if($Results->num_rows > 0){
    $DataPoints8 = array();

    foreach($Results as $row) {
        array_push($DataPoints8, $row);
    }

    #echo "<br> got data!";

}

?>

<!-- Get IncomeUnder15k data! -->
<?php

$Results = include 'getIncomeLevels/Under15k.php';

if($Results->num_rows > 0){
    $DataPoints9 = array();

    foreach($Results as $row) {
        array_push($DataPoints9, $row);
    }

    #echo "<br> got data!";

}

?>

<!-- Get Legislation data! -->
<?php

$Results = include 'getBillNums.php';

if($Results->num_rows > 0){
    $DataPoints10 = array();

    foreach($Results as $row) {
        array_push($DataPoints10, $row);
    }

    #echo "<br> got data!";

}

?>


<!------------------ Graph Drawing Section ------------------>

<!-- Include template file for chart section. -->
<?php include('../../templates/questions/chartArea.php'); ?>

<div id="chartContainer1" style="width: 100%; height: 500px;"></div>
<br><br>
<div id="chartContainer2" style="width: 100%; height: 300px;"></div>

<!-- Chart 1 (line) -->
<script type="text/javascript">
    if("<?php echo $DataPoints1; ?>".length < 1){
        //if not enough data, do not draw graph!
    } else {
        $(function () {
            var chart1 = new CanvasJS.Chart("chartContainer1", {
                theme: "light2",
                zoomEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Income Level shifts by bracket and year"
                },
                axisX: {
                    valueFormatString: "####",
                    title: "Year"
                },
                axisY: {
                    title: "Percentage of population"
                },
                toolTip: {
                    valueFormatString: "####",
                    shared: true
                },
                legend: {
                    cursor: "pointer",
                    verticalAlign: "bottom",
                    horizontalAlign: "center",
                    fontSize: 8,
                    dockInsidePlotArea: true
                    //itemclick: toogleDataSeries
                },
                data: [
                    {
                        type:"line",
                        name: "Income200kAbove",
                        showInLegend: true,
                        markerSize: 0,

                        dataPoints: <?php echo json_encode($DataPoints1, JSON_NUMERIC_CHECK); ?>
                    },{
                        type:"line",
                        name: "Income150kTo200k",
                        showInLegend: true,
                        markerSize: 0,

                        dataPoints: <?php echo json_encode($DataPoints2, JSON_NUMERIC_CHECK); ?>
                    },{
                        type:"line",
                        name: "Income100kTo150k",
                        showInLegend: true,
                        markerSize: 0,

                        dataPoints: <?php echo json_encode($DataPoints3, JSON_NUMERIC_CHECK); ?>
                    },{
                        type:"line",
                        name: "Income75kTo100k",
                        showInLegend: true,
                        markerSize: 0,

                        dataPoints: <?php echo json_encode($DataPoints4, JSON_NUMERIC_CHECK); ?>
                    },{
                        type:"line",
                        name: "Income50kTo75k",
                        showInLegend: true,
                        markerSize: 0,

                        dataPoints: <?php echo json_encode($DataPoints5, JSON_NUMERIC_CHECK); ?>
                    },{
                        type:"line",
                        name: "Income35kTo50k",
                        showInLegend: true,
                        markerSize: 0,

                        dataPoints: <?php echo json_encode($DataPoints6, JSON_NUMERIC_CHECK); ?>
                    },{
                        type:"line",
                        name: "Income25kTo35k",
                        showInLegend: true,
                        markerSize: 0,

                        dataPoints: <?php echo json_encode($DataPoints7, JSON_NUMERIC_CHECK); ?>
                    },{
                        type:"line",
                        name: "Income15kTo25k",
                        showInLegend: true,
                        markerSize: 0,

                        dataPoints: <?php echo json_encode($DataPoints8, JSON_NUMERIC_CHECK); ?>
                    },{
                        type:"line",
                        name: "IncomeUnder15k",
                        showInLegend: true,
                        markerSize: 0,

                        dataPoints: <?php echo json_encode($DataPoints9, JSON_NUMERIC_CHECK); ?>
                    }

                ]
            });
            chart1.render();
        });
    }
</script>


<script type="text/javascript">
    if("<?php echo $DataPoints10; ?>".length < 1){
        //if not enough data, do not draw graph!
    } else {
        $(function () {
            var chart2 = new CanvasJS.Chart("chartContainer2", {
                theme: "light2",
                animationEnabled: true,
                title: {
                    text: "Number of Bills Passed Related to Food, Health and Nutrition in the Years After (Nationwide)."
                },
                axisX: {
                    valueFormatString: "####",
                    title: "Year"
                },
                axisY: {
                    title: "Number of bills passed"
                },
                data: [
                    {
                        type: "line",
                        dataPoints: <?php echo json_encode($DataPoints10, JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            chart2.render();
        });
    }
</script>