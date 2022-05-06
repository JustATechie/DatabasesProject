<!--Q1: How have enrollment numbers in Food Assistance programs varied over the years by state?-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Food Assistance Data</title>
</head>

<body>

<?php $stateNamesList = $conn->query("select distinct State from Location;"); ?>

<form method="POST" action="">
    <div class="form-inline">
        <label>Select State Name:</label>
        <select class="form-control" name="stateFilter">
            <?php
            foreach($stateNamesList as $row){
                $stateName = $row['State'];
                echo "<option value =$stateName>$stateName</option>";
            }
            ?>
        </select>
        <button class="btn btn-primary" name="getStats">Submit</button>
    </div>
</form>

<?php $stateNamesList->free_result(); ?>

<?php
$data = include'filter.php';

$dataPoints = array();

foreach($data as $row) {
    array_push($dataPoints, $row);
}
?>

<?php include('../../templates/questions/chartArea.php'); ?>


<div id="chartContainer1"></div>

<script type="text/javascript">
    $(function () {
        var chart = new CanvasJS.Chart("chartContainer1", {
            theme: "light2",
            zoomEnabled: true,
            animationEnabled: true,
            title: {
                text: "Line Chart with Data-Points from DataBase"
            },
            data: [
                {
                    type: "line",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }
            ]
        });
        chart.render();
    });
</script>





<br><br>

<!--<div class="col-md-6 well">
    <div class="col-md-8">

        <?php /*$resultSet = $conn->query("select distinct State from Location;"); */?>
        <form method="POST" action="">
            <div class="form-inline">
                <label>Category:</label>
                <select class="form-control" name="category">
                    <?php
/*                    while($rows = $resultSet-> fetch_assoc()){
                        $stateName = $rows['State'];
                        echo "<option value =$stateName>$stateName</option>";
                    }
                    */?>
                </select>
                <button class="btn btn-primary" name="filter">Filter</button>
                <button class="btn btn-success" name="reset">Reset</button>
            </div>
        </form>
        <br /><br />
        <table class="table table-bordered">
            <thead class="alert-info">
            <th>Name</th>
            <th>Brand</th>
            </thead>
            <thead>
            <?php
/*            $data = include'filter.php';

            foreach($data as $row) {
                echo "<tr>";
                echo "<td>" . $row["x"] . "</td>";
                echo "<td>" . $row["y"] . "</td>";
                echo "</tr>";
            }
            */?>
            </thead>
        </table>
    </div>
</div>-->

<?php 
/*$data = include'filter.php'*/
?>



<?php

$dataPoints = array();
if ($stmt = $conn->prepare("select Year as x, numStudents as y from SchoolFoodPrograms where LocationID=5 group by Year")) {

    //Attach the ? in prepared statements to variables (even if those variables
    //don't hold the values we want yet).  First parameter is a list of types of
    //the variables that follow: 's' means string, 'i' means integer, 'd' means
    //double. E.g., for a statment with 3 ?'s, where middle parameter is an integer
    //and the other two are strings, the first argument included should be "sis".
    #$stmt->bind_param("i", $LocationID);

    //Run the actual query
    if ($stmt->execute()) {

        //Store result set generated by the prepared statement
        $result = $stmt->get_result();

        if($result->num_rows < 1){
            echo "ERROR: could not obtain data from database!";
            echo "<br><br>";
        } else {
            //Create table to display results
            echo "<table border=\"1px solid black\">";
            echo "<tr><th>x</th><th>y</th></tr>";

            //Report result set by visiting each row in it
            foreach($result as $row) {
                echo "<tr>";
                echo "<td>" . $row["x"] . "</td>";
                echo "<td>" . $row["y"] . "</td>";
                echo "</tr>";
            }

            /*while ($row = mysqli_fetch_array($data, MYSQL_ASSOC)) {
                array_push($dataPoints, $row);
            }*/

            foreach($result as $row){
                array_push($dataPoints, $row);
            }


            echo "</table>";
        }
        //We are done with the result set returned above, so free it
        $result->free_result();

    } else {

        //Call to execute failed, e.g. because server is no longer reachable,
        //or because supplied values are of the wrong type
        echo "Execute failed.<br>";
    }

    //Close down the prepared statement
    $stmt->close();

} else {

    //A problem occurred when preparing the statement; check for syntax errors
    //and misspelled attribute names in the statement string.
    echo "Prepare failed.<br>";
    $error = $conn->errno . ' ' . $conn->error;
    echo $error;
}

$conn->close();

?>




<!-- Closing opening body tag from PageSetup.php -->
</body>