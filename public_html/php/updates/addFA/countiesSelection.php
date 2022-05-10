<form>
    <div class="form-inline">
        <label>Select County Name:</label>
        <select class="form-control" name="countyFilter">
            <?php
            foreach($countyNamesList as $row){
                $countyName = $row['County'];

                if($countyName == $_POST['countyFilter'] || $countyName == $selectedCounty){
                    $isSelected = ' selected="selected"'; // if the option submitted in form is as same as this row we add the selected tag
                    $selectedCounty = $countyName;
                } else {
                    $isSelected = ''; // else we remove any tag
                }
                echo "<option value='".$countyName."'".$isSelected.">$countyName</option>";
            }
            ?>
        </select>
        <button class="btn btn-primary" name="">Continue with this county</button>

</form>