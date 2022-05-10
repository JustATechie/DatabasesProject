<!--Q#:-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Delete FA</title>
</head>
<body>
<br>

<!-- Global variables -->
<?php
GLOBAL $selectedState;
GLOBAL $selectedLocationID;

?>

<h4>Delete Food Assistance data below!</h4>

<?php $stateNamesList = include 'getData/getStates.php' ?>

<?php $nameList = include 'getData/getNames.php' ?>

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

        <label>Select Name*:</label>
        <select class="form-control" name="nameFilter">
            <?php
            foreach($nameList as $row){
                $name = $row['Name'];

                if($name == $_POST['nameFilter']){
                    $isSelected = ' selected="selected"'; // if the option submitted in form is as same as this row we add the selected tag
                    $selectedName = $name;

                } else {
                    $isSelected = ''; // else we remove any tag
                }
                echo "<option value='".$name."'".$isSelected.">$name</option>";
            }
            ?>
        </select>

        <label> Year*:
            <input type=text name="givenYear">
        </label>


        <button class="btn btn-primary" name="addInfo">Submit</button>
    </div>
</form>



<br>
<br>

<!-- Add info! -->
<?php

include 'deleteData.php';

?>