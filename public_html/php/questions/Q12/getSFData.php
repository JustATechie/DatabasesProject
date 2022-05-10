<?php

if(ISSET($_POST['getStats'])){
	$sf = $_POST['sfFilter'];
	if ($stmt = $conn->prepare("
		SELECT Year as x, numStudents as y
		FROM SchoolFoodPrograms NATURAL JOIN Location
		WHERE State = '$maxState' AND Name = '$sf'
		ORDER BY Year ASC;
	")) {
        if ($stmt->execute()) {
            //Store result set generated by the prepared statement
            $result = $stmt->get_result();
            if($result->num_rows < 1){
                echo "<br>ERROR: Unable to get data for chosen School Food Program!<br>";
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
