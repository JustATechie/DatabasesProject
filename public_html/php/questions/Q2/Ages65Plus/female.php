<?php
GLOBAL $Q2MaxYear;
GLOBAL $Q2MinYear;
GLOBAL $Q2State;

if(ISSET($_POST['getInfo'])){

    if ($stmt = $conn->prepare("select Year as x, AVG(HeartDisease) as y from MetabolicDisease left join Location on (MetabolicDisease.LocationID = Location.LocationID) where State='$Q2State' and (Year Between '$Q2MinYear' and '$Q2MaxYear') and (AgeRange='Ages 65+ years') and Gender='Female' group by Year,AgeRange,Gender;")) {
        if ($stmt->execute()) {
            //Store result set generated by the prepared statement
            $result = $stmt->get_result();

            if($result->num_rows < 1){

                echo "<br>ERROR: No data for females in age range: Ages 65+ years! In state: ".$Q2State."<br>";
            } else {
                $stmt->close();
                return $result;
            }
            $result->free_result();
        } else {
            //Call to execute failed, e.g. because server is no longer reachable,
            //or because supplied values are of the wrong type
            echo "<br>ERROR: Execute failed.<br>";
        }
    } else {

        //A problem occurred when preparing the statement; check for syntax errors
        //and misspelled attribute names in the statement string.

        echo "<br>ERROR: Prepare failed.<br>" . $conn->errno . ' ' . $conn->error;
    }

    $stmt->close();
}
