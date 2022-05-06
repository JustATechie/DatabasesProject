<?php
require '../../open.php';
if(ISSET($_POST['filter'])){
    $category=$_POST['category'];

    $query=mysqli_query($conn, "SELECT Year as x, SUM(numStudents) as y FROM SchoolFoodPrograms left join Location on SchoolFoodPrograms.locationID=Location.locationID WHERE State='$category'") or die(mysqli_error());
    while($fetch=mysqli_fetch_array($query)){
        echo"<tr><td>".$fetch['x']."</td><td>".$fetch['y']."</td></tr>";
    }
}else if(ISSET($_POST['reset'])){
    $query=mysqli_query($conn, "SELECT * FROM SchoolFoodPrograms left join Location on SchoolFoodPrograms.locationID=Location.locationID WHERE State='Alabama'") or die(mysqli_error());
    while($fetch=mysqli_fetch_array($query)){
        echo"<tr><td>".$fetch['Name']."</td><td>".$fetch['numStudents']."</td></tr>";
    }
}else{
    $query=mysqli_query($conn, "SELECT * FROM SchoolFoodPrograms left join Location on SchoolFoodPrograms.locationID=Location.locationID WHERE State='Alabama'") or die(mysqli_error());
    while($fetch=mysqli_fetch_array($query)){
        echo"<tr><td>".$fetch['Name']."</td><td>".$fetch['numStudents']."</td></tr>";
    }
}
