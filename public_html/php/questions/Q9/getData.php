<?php

if(ISSET($_POST['getInfo'])){
	$state = $_POST['stateFilter'];

	if ($stmt = $conn->prepare("
		SELECT *
		FROM
        		(SELECT State, MinEnrolled, MinEnrolledYear, minYearObesity, MaxEnrolled, MaxEnrolledYear, AVG(Obesity) as maxYearObesity
        			FROM
        			(SELECT State, MinEnrolled, MinEnrolledYear, MaxEnrolled, MaxEnrolledYear, AVG(Obesity) as minYearObesity
        				FROM
                		(SELECT State, MinEnrolled, PopulationStats.Year as 'MinEnrolledYear', MaxEnrolled, MaxEnrolledYear
                		FROM
                		(SELECT State, MaxEnrolled, PopulationStats.Year as 'MaxEnrolledYear', MinEnrolled
                		FROM
                        (SELECT State, Year, MAX(SchoolEnrollment) as 'MaxEnrolled', MIN(SchoolEnrollment) as 'MinEnrolled'
                        FROM Location NATURAL JOIN PopulationStats
                        WHERE Year <= '2022'
                        GROUP BY State) as maxMinEnrolled
                        JOIN PopulationStats
                        ON PopulationStats.SchoolEnrollment = maxMinEnrolled.MaxEnrolled AND PopulationStats.Year <= '2022') as maxEnrollments
                        JOIN PopulationStats
                        ON PopulationStats.SchoolEnrollment = maxEnrollments.MinEnrolled AND PopulationStats.Year <= '2022') enrollmentYears
                	LEFT JOIN
                	MetabolicDisease
                		ON AgeRange <> 'Ages 35-64 years' AND AgeRange <> 'Ages 65+ years' AND MetabolicDisease.Year = enrollmentYears.MinEnrolledYear
        		GROUP BY State
        		ORDER BY minYearObesity ASC) as minObesity
        		LEFT JOIN
        		MetabolicDisease
        		ON AgeRange <> 'Ages 35-64 years' AND AgeRange <> 'Ages 65+ years' AND MetabolicDisease.Year = minObesity.MaxEnrolledYear
        		GROUP BY State
        		ORDER BY minYearObesity DESC, maxYearObesity DESC, State ASC) as selection
		WHERE State = '$state';
	")) {
        if ($stmt->execute()) {
            //Store result set generated by the prepared statement
            $result = $stmt->get_result();

            if($result->num_rows < 1){
                echo "ERROR: No data available for this state!!<br>";
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
