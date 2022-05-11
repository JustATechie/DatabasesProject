<?php

if(ISSET($_POST['getStats'])){
    $sf = $_POST['sfFilter'];
    if ($stmt = $conn->prepare("
    Select Year as label, COUNT(Year) as y
    FROM (SELECT State, minStudents, minStudentsYear as Year, minYearAvgIncome
            FROM
            (SELECT State, minStudents, minStudentsYear, AvgIncome as 'minYearAvgIncome', maxStudents, maxStudentsYear
            FROM
                    (SELECT State, minStudents, Year as minStudentsYear, maxStudents, maxStudentsYear
                    FROM
                            (SELECT State, maxStudents, Year AS maxStudentsYear, minStudents
                            FROM
                                    (SELECT State, MAX(numStudents) as 'maxStudents', MIN(numStudents) as 'minStudents'
                                    FROM
                                            (SELECT *
                                            FROM SchoolFoodPrograms
                                            WHERE Name = '$sf') as NSLPStats
                                            NATURAL JOIN 
                                            Location
                                    GROUP BY State) studentCounts
                                            JOIN
                                    SchoolFoodPrograms
                                    ON studentCounts.maxStudents = SchoolFoodPrograms.numStudents) as maxStudents
                                JOIN
                            SchoolFoodPrograms
                            ON maxStudents.minStudents = SchoolFoodPrograms.numStudents) as schoolProgramCounts
                     JOIN
                     AvgHousehold
                     ON schoolProgramCounts.minStudentsYear = AvgHousehold.Year) AS minAvgIncome
            JOIN
            AvgHousehold
            ON minAvgIncome.maxStudentsYear = AvgHousehold.Year) as selection      
    GROUP BY Year;
    
    ")) {
        if ($stmt->execute()) {
            //Store result set generated by the prepared statement
            $result = $stmt->get_result();

            if($result->num_rows < 1){
                echo "<br>ERROR: Unable to get data for minimum enrollment years!<br>";
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
