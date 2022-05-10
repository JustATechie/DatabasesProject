<?php
GLOBAL $selectedLocationID;

if(ISSET($_POST['addInfo'])){
    $givenName = $_POST['givenName'];
    $givenYear = $_POST['givenYear'];
    $givenNumStudents = $_POST['givenNumEnrolled'];
    $givenID = 1;

    #echo $selectedLocationID;

    //state cannot be empty when inserting data. We will tolerate not having counties for special zones like reservations
    if($selectedLocationID == null || $givenName ==null || $givenYear == null || $givenNumStudents ==null){
        echo "<br>ERROR: Please complete all required fields!<br>";
    } else if((! ctype_digit(strval($givenYear))) ||(! ctype_digit(strval($givenNumStudents)))){
        echo "<br>ERROR: Please make sure the Year and Student number fields are integers!<br>";
    } else if($stmt = $conn->prepare("SELECT * FROM FoodAssistance WHERE LocationID = ? AND Name = ? AND Year = ? AND numEnrolled = ?;")){

        #echo "<br>INFO: Adding data!<br>";

        $stmt->bind_param('isii', $selectedLocationID, $givenName, $givenYear, $givenNumStudents);

        if ($stmt->execute()) {

            #echo "<br>INFO: executed!<br>";

            //Store result set generated by the prepared statement
            $result = $stmt->get_result();

            if($result->num_rows > 0) {
                $stmt->close();
                $result->free_result();
                echo "<br>ERROR: That Food Assistance data already exists!<br>";
            } else {
                $stmt->close();
                $result->free_result();
                #echo "<br>INFO: That location does not exist!<br>";


                if ($stmt = $conn->prepare("INSERT INTO FoodAssistance (LocationID, TypeID, Name, Year, numEnrolled) VALUES ('$selectedLocationID', 1, '$givenName', '$givenYear', '$givenNumStudents');
")) {

                    #$stmt->bind_param('isii', $selectedLocationID, $givenName, $givenYear, $givenNumStudents);

                    if ($stmt->execute()) {
                        //Store result set generated by the prepared statement
                        $result = $stmt->get_result();

                        if($result->num_rows != 0){
                            $result->free_result();
                            $stmt->close();

                            echo "<br>ERROR: Data insert failed! That Food Assistance data might already exist or is too long!<br>";
                        } else {
                            $stmt->close();
                            echo "<br>Food Assistance data added successfully!<br>";
                        }

                    } else {
                        //Call to execute failed, e.g. because server is no longer reachable,
                        //or because supplied values are of the wrong type
                        $stmt->close();
                        echo "<br>ERROR: Execute failed.<br>";
                    }

                } else {

                    //A problem occurred when preparing the statement; check for syntax errors
                    //and misspelled attribute names in the statement string.
                    $stmt->close();
                    echo "<br>ERROR: Prepare failed.<br>" . $conn->errno . ' ' . $conn->error;
                }


            }
        }



    }  else {

        //A problem occurred when preparing the statement; check for syntax errors
        //and misspelled attribute names in the statement string.
        $stmt->close();
        echo "<br>ERROR: Prepare failed.<br>" . $conn->errno . ' ' . $conn->error;
    }


}
