<!--Q#:-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Add FA</title>
</head>
<body>
<br>

<!-- Global variables -->
<?php
GLOBAL $selectedState;
GLOBAL $selectedLocationID;

?>

<h4>Add Food Assistance data below!</h4>

<?php $stateNamesList = include 'getData/getStates.php' ?>

<?php $typeList = include 'getData/getTypes.php' ?>

<h6>Fields marked with * are mandatory!</h6>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="form-inline">
        <label>Select State*:</label>
        <select class="form-control" name="stateFilter">
            <?php
            foreach($stateNamesList as $row){
                $stateName = $row['State'];

                if($stateName == $_POST['stateFilter']){
                    $isSelected = ' selected="selected"'; // if the option submitted in form is as same as this row we add the selected tag
                    $selectedState = $stateName;
                    $selectedLocationID = $row['LocationID'];
                } else {
                    $isSelected = ''; // else we remove any tag
                }
                echo "<option value='".$stateName."'".$isSelected.">$stateName</option>";
            }
            ?>
        </select>

        <label> Name*:
            <input type=text name="givenName">
        </label>

        <label> Year*:
            <input type=text name="givenYear">
        </label>

        <label> Number of Enrolled People*:
            <input type=text name="givenNumEnrolled">
        </label>


        <button class="btn btn-primary" name="addInfo">Submit</button>
    </div>
</form>







<br>
<br>
<br>
<br>




<br>
<br>

<!-- Add info! -->
<?php

include 'addData.php';

?>