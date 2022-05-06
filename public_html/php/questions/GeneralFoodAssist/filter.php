<?php
require '../../open.php';
if(ISSET($_POST['getStats'])){
    $name=$_POST['stateFilter'];

    $query=mysqli_query($conn, "SELECT Year as x, SUM(numStudents) as y FROM SchoolFoodPrograms left join Location on SchoolFoodPrograms.locationID=Location.locationID WHERE State='$name' group by year") or die(mysqli_error());
    return $query;
}else{
    $query=mysqli_query($conn, "SELECT Year as x, SUM(numStudents) as y FROM SchoolFoodPrograms left join Location on SchoolFoodPrograms.locationID=Location.locationID WHERE State='Alabama' group by year") or die(mysqli_error());
    return $query;
}
