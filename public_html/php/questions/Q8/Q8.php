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

<!-- Get specific data! -->
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


<!------------------ Graph Drawing Section ------------------>

<!-- Include template file for chart section. -->
<?php include('../../templates/questions/chartArea.php'); ?>

<div id="chartContainer1" style="width: 49%; height: 300px;display: inline-block;"></div>
<div id="chartContainer2" style="width: 49%; height: 300px;display: inline-block;"></div>

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
                    text: "Number of people enrolled in Food Assistance programs by year in " + "<?php echo $selectedState; ?>"
                },
                data: [
                    {
                        type: "line",
                        dataPoints: <?php echo json_encode($DataPoints1, JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            chart1.render();
        });
    }
</script>
