<!--Q9:-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Metabolic Rates and School Enrollment Rates</title>
</head>
<body>
<br>

<!-- Global variables -->
<?php
GLOBAL $ex;
?>

<h4></h4>

<form method="POST" action="">
    <div class="form-inline">
        <button class="btn btn-primary" name="getInfo">Submit</button>
    </div>
</form>

<br>
<br>

<!-- Get general info! -->
<?php
echo "testing";
$Object = include 'getData.php';
if($Object->num_rows > 0){
    foreach($Object as $row){
	echo "".$row["State"]."<br>";
    }
}
echo "got the data!";
?>

<!-- Get specific data! -->
<?php

$Results = include '';

if($Results->num_rows > 0){
    $DataPoints = array();

    foreach($Results as $row) {
        array_push($DataPoints, $row);
    }

    #echo "<br> got data!";

}

?>
