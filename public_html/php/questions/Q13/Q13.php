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
    echo "<h5>". $maxYear. " was the year with the highest number of people enrolled in Food Assistance Programs federally. ". $maxEnroll." people were enrolled in food assistance programs this year.</h5>";
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
    echo "<h5>". $minYear. " was the year with the lowest number of people enrolled in Food Assistance Programs federally. ". $minEnroll." people were enrolled in food assistance programs this year.</h5>";
} 
?>



<!------------------ Graph Drawing Section ------------------>

<!-- Include template file for chart section. -->
<?php include('../../templates/questions/chartArea.php'); ?>

<div id="chartContainer1" style="width: 49%; height: 300px;display: inline-block;"></div>
<div id="chartContainer2" style="width: 49%; height: 300px;display: inline-block;"></div>
