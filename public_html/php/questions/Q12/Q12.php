<!--Q#:-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>School Food and Food Assistance Program Enrollment</title>
</head>
<body>
<br>

<!-- Global variables -->
<?php
GLOBAL $selectedSF;
GLOBAL $selectedFA;
?>

<h4>In the state that on average had the most students enrolled in the chosen School Food program, what was the number of people enrolled in the chosen FoodAssistance Program by year?</h4>

<!-- Get the list of states in our database. -->
<?php $SFList = include 'getSF.php' ?>

<!-- Get the list of years in our database. -->
<?php $FAList = include 'getFA.php'; ?>

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
        
        <label>Select Food Assistance Program:</label>
        <select class="form-control" name="faFilter">
            <?php
            foreach($FAList as $row){
                $faName = $row['Name'];

                if($faName == $_POST['faFilter']){
                    $isSelected = ' selected="selected"'; // if the option submitted in form is as same as this row we add the selected tag
                    $selectedFA = $faName;
                } else {
                    $isSelected = ''; // else we remove any tag
                }
                echo "<option value='".$row['Name']."'".$isSelected.">$faName</option>";
            }
            ?>
        </select>
        <button class="btn btn-primary" name="getStats">Submit</button>
    </div>
</form>

<!-- Free list objects. -->
<?php
if($stateNamesList->num_rows > 1){
    $stateNamesList->free_result();
}

if($yearList->num_rows > 1){
    $yearList->free_result();
}
?>

<br>
<br>

<!-- Get general info! -->
<?php

$Object = include '';

if($Object->num_rows > 0){
    foreach($Object as $row){
        $ex=$row['Ex'];

    }
}
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
