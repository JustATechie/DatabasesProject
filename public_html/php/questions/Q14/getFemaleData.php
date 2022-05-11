<?php

if(ISSET($_POST['getInfo'])){

    if ($stmt = $conn->prepare("
        SELECT County as label, HeartDisease as y
        FROM MetabolicDisease NATURAL JOIN Location
        WHERE Year = '2013' AND Gender = 'Female' AND AgeRange = 'Ages 35-64 years' AND State = 'California'
        ORDER By HeartDisease DESC;
    ")) {
        if ($stmt->execute()) {
            //Store result set generated by the prepared statement
            $result = $stmt->get_result();

            if($result->num_rows < 1){
                echo "<br>ERROR: Could not obtain consumption data!<br>";
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
