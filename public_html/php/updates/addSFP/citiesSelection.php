<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="form-inline">
        <label>Select City Name:</label>
        <select class="form-control" name="cityFilter">
            <?php
            foreach($cityNamesList as $row){
                $cityName = $row['City'];

                if($cityName == $_POST['cityFilter'] || $cityName == $selectedCity){
                    $isSelected = ' selected="selected"'; // if the option submitted in form is as same as this row we add the selected tag
                    $selectedCity = $cityName;
                } else {
                    $isSelected = ''; // else we remove any tag
                }
                echo "<option value='".$cityName."'".$isSelected.">$cityName</option>";
            }
            ?>
        </select>
        <button class="btn btn-primary" name="">Continue with this city</button>

</form>