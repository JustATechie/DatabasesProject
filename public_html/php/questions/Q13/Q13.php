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

<!------------------ Graph Drawing Section ------------------>

<!-- Include template file for chart section. -->
<?php include('../../templates/questions/chartArea.php'); ?>

<div id="chartContainer1" style="width: 49%; height: 300px;display: inline-block;"></div>
<div id="chartContainer2" style="width: 49%; height: 300px;display: inline-block;"></div>
