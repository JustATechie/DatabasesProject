<!--Q3: In the year with the highest sugar intake, how many people were enrolled in FoodAssistance programs?-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Sugar Rates and Food Assistance Programs</title>
</head>
<body>
<br>
<!-- Global variables -->
<?php
GLOBAL $Q3State;
GLOBAL $Q3Year;
GLOBAL $Q3Sugar;
GLOBAL $Q3Enroll;
?>

<h4> In the year with the highest sugar intake, how many people were enrolled in Food Assistance programs? </h4>

<form method="POST" action="">
    <div class="form-inline">
        <button class="btn btn-primary" name="getInfo">Submit</button>
    </div>
</form>

<br>
<br>

<!-- Get general info! -->
<?php

$Object = include 'getData.php';

if($Object->num_rows > 0){
    foreach($Object as $row){
        $Q3State=$row['State'];
        $Q3Year=$row['Year'];
        $Q3Sugar=$row['SugarIntake'];
        $Q3Enroll=$row['EnrollNum'];

    }

    if(empty($Q3State) || empty($Q3Year) || empty($Q3Sugar) || empty($Q3Enroll)){
        echo "<br> No data available for sugar intake at this time!";
    } else {
        echo "<h5>" . $Q3State . " had the highest sugar intake across all genders and ages in " . $Q3Year . ". In this year, the average person consumed " . $Q3Sugar . " sugary drinks per day. In this same year, " . $Q3Enroll . " people were enrolled in Food Assistance programs." . "</h5>";
    }


}
?>


