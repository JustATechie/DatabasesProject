<!--Q#:-->
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

<!-- Get general info! -->
<?php

$Object = include 'getData.php';

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
