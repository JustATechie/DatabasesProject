<!--Q4: In the year with the highest number of people enrolled in Food assistance programs, how many students were enrolled in the school food programs in that same year?-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title></title>
</head>
<body>
<br>
<!-- Global variables -->
<?php
GLOBAL $Q4Year;
GLOBAL $Q4State;
GLOBAL $Q4FA;
GLOBAL $Q4SFP;
?>

<h4>In the year with the highest number of people enrolled in Food assistance programs, how many students were enrolled in the school food programs in that same year?</h4>

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
        $Q4Year=$row['Year'];
        $Q4State=$row['State'];
        $Q4FA=$row['FA'];
        $Q4SFP=$row['SFP'];

    }

    echo "<h5>" . $Q4State . " had the highest number of people enrolled in Food Assistance programs in " . $Q4Year . ". In this year, the total number of people enrolled in food assistance programs is " . $Q4FA . ". In this same year, " . $Q4SFP .
        " students were enrolled in school food programs." . "</h5>";

}
?>