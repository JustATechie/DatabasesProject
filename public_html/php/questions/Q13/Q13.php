<!--Q#:-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Food Assistance and Income Distribution</title>
</head>
<body>
<br>

<!-- Global variables -->
<?php
GLOBAL $ex;
?>

<h4>In the years with the most and least people enrolled in school food programs in the whole country, what was the federal income 
  distributions and average incomes?</h4>

<form method="POST" action="">
    <div class="form-inline">
        <button class="btn btn-primary" name="getInfo">Submit</button>
    </div>
</form>

<br>
<br>

<!-- Get general info! -->
<?php
$Object = include 'getMaxYear.php';
// $dataPoints = array();
if($Object->num_rows > 0){
	$maxDataPoints = array();
	foreach($Object as $row){
	    array_push($maxDataPoints, $row);
	    $maxYear=$row['Year'];
        $maxEnroll=$row['totalEnrolled'];
    }
} 
?>

<?php
$Object = include 'getMinYear.php';
// $dataPoints = array();
if($Object->num_rows > 0){
	$minDataPoints = array();
	foreach($Object as $row){
	    array_push($minDataPoints, $row);
	    $minYear=$row['Year'];
        $minEnroll=$row['totalEnrolled'];
    }
} 
?>

<?php
$Object = include 'getMinIncomeData.php';
// $dataPoints = array();
if($Object->num_rows > 0){
	$minIncomeDataPoints = array();
	foreach($Object as $row){
	    array_push($minIncomeDataPoints, $row);
        $minIncomeUnder15k=$row['IncomeUnder15k'];
        $minIncome15kTo25k=$row['Income15kTo25k'];
        $minIncome25kTo35k=$row['Income25kTo35k'];
        $minIncome35kTo50k=$row['Income35kTo50k'];
        $minIncome50kTo75k=$row['Income50kTo75k'];
        $minIncome75kTo100k=$row['Income75kTo100k'];
        $minIncome100kTo150k=$row['Income100kTo150k'];
        $minIncome150kTo200k=$row['Income150kTo200k'];
        $minIncome200kAbove=$row['Income200kAbove'];
        $minAvg=$row['AvgIncome'];
    }
} 
?>

<?php
$Object = include 'getMaxIncomeData.php';
// $dataPoints = array();
if($Object->num_rows > 0){
	$maxIncomeDataPoints = array();
	foreach($Object as $row){
	    array_push($maxIncomeDataPoints, $row);
        $maxIncomeUnder15k=$row['IncomeUnder15k'];
        $maxIncome15kTo25k=$row['Income15kTo25k'];
        $maxIncome25kTo35k=$row['Income25kTo35k'];
        $maxIncome35kTo50k=$row['Income35kTo50k'];
        $maxIncome50kTo75k=$row['Income50kTo75k'];
        $maxIncome75kTo100k=$row['Income75kTo100k'];
        $maxIncome100kTo150k=$row['Income100kTo150k'];
        $maxIncome150kTo200k=$row['Income150kTo200k'];
        $maxIncome200kAbove=$row['Income200kAbove'];
        $maxAvg=$row['AvgIncome'];
    }
} 
?>

<?php
    echo "<h5>". $maxYear. " was the year with the highest number of people enrolled in Food Assistance Programs federally. ". $maxEnroll." people were enrolled in food assistance programs this year and the average income for the year was $".$maxAvg." .</h5>";
    echo "<br>";
    echo "<h5>". $minYear. " was the year with the lowest number of people enrolled in Food Assistance Programs federally. ". $minEnroll." people were enrolled in food assistance programs this year and the average income for the year was $".$minAvg." .</h5>";
?>

<?php
$Object = include 'getTotalEnrollmentData.php';
// $dataPoints = array();
if($Object->num_rows > 0){
	$totalEnrollmentDataPoints = array();
	foreach($Object as $row){
	    array_push($totalEnrollmentDataPoints, $row);
    }
} 
?>

<!------------------ Graph Drawing Section ------------------>

<!-- Include template file for chart section. -->
<?php include('../../templates/questions/chartArea.php'); ?>

<?php echo "<br><br>" ?>
<div id="chartContainer1" style="width: 49%; height: 300px;display: inline-block;padding:10px;"></div>
<div  id="chartContainer2" style="width: 49%; height: 300px;display: inline-block;padding:10px;"></div>
<div style="center" id="chartContainer3" style="width: 80%; height: 300px;padding:10px;"></div>

<script type="text/javascript">
    if("<?php echo $minIncomeDataPoints; ?>".length > 0) {

        $(function () {
            var chart1 = new CanvasJS.Chart("chartContainer1", {
	            animationEnabled: true,
                title: {
		    text: "Federal Income Distribution in " + "<?php echo $minYear ?>" + " (Min Enrollment)"
                },
                data: [{
                    type: "pie",
                    startAngle: 240,
                    // yValueFormatString: "##0.00\"%\"",
		    indexLabel: "{label}",
		    indexLabelFontSize: 10,
                    dataPoints: [
                        {y: parseFloat(<?php echo $minIncomeUnder15k ?>), label: "Under 15K"},
                        {y: parseFloat(<?php echo $minIncome15kTo25k ?>), label: "15K to 25K"},
                        {y: parseFloat(<?php echo $minIncome25kTo35k ?>), label: "25K to 35K"},
                        {y: parseFloat(<?php echo $minIncome35kTo50k ?>), label: "35K to 50K"},
                        {y: parseFloat(<?php echo $minIncome50kTo75k ?>), label: "50K to 75K"},
                        {y: parseFloat(<?php echo $minIncome75kTo100k ?>), label: "75K to 100K"},
                        {y: parseFloat(<?php echo $minIncome100kTo150k ?>), label: "100K to 150K"},
                        {y: parseFloat(<?php echo $minIncome150kTo200k ?>), label: "150K to 200K"},
                        {y: parseFloat(<?php echo $minIncome200kAbove ?>), label: "Above 200K"}
                    ]
                }]
            });
            chart1.render();
        });
    }
</script>

<script type="text/javascript">
    if("<?php echo $maxIncomeDataPoints; ?>".length > 0){
        $(function () {
            var chart2 = new CanvasJS.Chart("chartContainer2", {
	            animationEnabled: true,
                title: {
                    text: "Federal Income Distribution in " + "<?php echo $maxYear ?>" + " (Max Enrollment)"
                },
                data: [{
                    type: "pie",
                    startAngle: 240,
                    // yValueFormatString: "##0.00\"%\"",
		    indexLabel: "{label}",
		    indexLabelFontSize: 10,
                    dataPoints: [
                        {y: parseFloat(<?php echo $maxIncomeUnder15k ?>), label: "Under 15K"},
                        {y: parseFloat(<?php echo $maxIncome15kTo25k ?>), label: "15K to 25K"},
                        {y: parseFloat(<?php echo $maxIncome25kTo35k ?>), label: "25K to 35K"},
                        {y: parseFloat(<?php echo $maxIncome35kTo50k ?>), label: "35K to 50K"},
                        {y: parseFloat(<?php echo $maxIncome50kTo75k ?>), label: "50K to 75K"},
                        {y: parseFloat(<?php echo $maxIncome75kTo100k ?>), label: "75K to 100K"},
                        {y: parseFloat(<?php echo $maxIncome100kTo150k ?>), label: "100K to 150K"},
                        {y: parseFloat(<?php echo $maxIncome150kTo200k ?>), label: "150K to 200K"},
                        {y: parseFloat(<?php echo $maxIncome200kAbove ?>), label: "Above 200K"}
                    ]
                }]
            });
            chart2.render();

        });
    }
</script>

<script>
    if("<?php echo $totalEnrollmentDataPoints; ?>".length < 1){
        //if not enough data, do not draw graph!
    } else {
        $(function () {
            var chart23= new CanvasJS.Chart("chartContainer3", {
                theme: "light2",
                zoomEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Total Number of Enrollments in the US in Food Assistance Programs by Year"
                }, axisX: {
                    //valueFormatString: "#,###"
                    title: "Year"
                },
                axisY: {
                    title: "Number of People Enrolled",
                    prefix: "$"
                },
                data: [
                    {
                        type: "line",
                        dataPoints: <?php echo json_encode($totalEnrollmentDataPoints, JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            chart3.render();


        });
    }
</script>

<?php $conn->close(); ?>
