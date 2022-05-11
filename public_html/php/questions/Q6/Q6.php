<!--Q6: Does the state with the highest number of food bills passed have less people enrolled in Food assistance programs compared to states with less food bills?-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Food Bills and FA</title>
</head>
<body>
<br>

<!-- Global variables -->
<?php
GLOBAL $Year;
?>

<h4>Does the state with the highest number of food bills passed have less people enrolled in Food assistance programs compared to states with less food bills?</h4>

<form method="POST" action="">
    <div class="form-inline">
        <button class="btn btn-primary" name="getInfo">Submit</button>
    </div>
</form>

<br>
<br>

<!-- Get general info! -->
<?php

$Object = include 'getYear.php';

if($Object->num_rows > 0){
    foreach($Object as $row){
        $Year=$row['Year'];

    }
}
?>

<!-- Get Legislation data! -->
<?php

$Results = include 'getByBills.php';

if($Results->num_rows > 0){
    $DataPoints1 = array();

    foreach($Results as $row) {
        array_push($DataPoints1, $row);
    }

    #echo "<br> got data!";

}

?>

<!-- Get Legislation data! -->
<?php

$Results = include 'getByEnrolled.php';

if($Results->num_rows > 0){
    $DataPoints2 = array();

    foreach($Results as $row) {
        array_push($DataPoints2, $row);
    }

    #echo "<br> got data!";

}

?>


<!------------------ Graph Drawing Section ------------------>

<!-- Include template file for chart section. -->
<?php include('../../templates/questions/chartArea.php'); ?>

<div id="chartContainer1" style="width: 100%; height: 300px;display: inline-block;"></div>
<div id="chartContainer2" style="width: 100%; height: 300px;display: inline-block;"></div>

<script type="text/javascript">
    if("<?php echo $DataPoints1; ?>".length > 0) {

        $(function () {
            var chart1 = new CanvasJS.Chart("chartContainer1", {
                title: {
                    text: "Number of bills the top five states have passed by " + "<?php echo $Year?>"
                },
                subtitles: [
                    {
                        text: ""
                    }
                ],
                animationEnabled: true,
                legend: {
                    cursor: "pointer",
                    itemclick: function (e) {
                        if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                        } else {
                            e.dataSeries.visible = true;
                        }
                        chart.render();
                    }
                },
                axisY: {
                    title: "Number of bills passed related to food, nutrition, and health"
                },
                toolTip: {
                    shared: true,
                    content: function (e) {
                        var str = '';
                        var total = 0;
                        var str3;
                        var str2;
                        for (var i = 0; i < e.entries.length; i++) {
                            var str1 = "<span style= 'color:" + e.entries[i].dataSeries.color + "'> " + e.entries[i].dataSeries.name + "</span>: <strong>" + e.entries[i].dataPoint.y + "</strong> <br/>";
                            total = e.entries[i].dataPoint.y + total;
                            str = str.concat(str1);
                        }
                        str2 = "<span style = 'color:DodgerBlue; '><strong>" + e.entries[0].dataPoint.label + "</strong></span><br/>";


                        return (str2.concat(str));
                    }

                },
                data: [
                    {
                        type: "bar",
                        showInLegend: true,
                        name: "No. Bills",
                        color: "light-blue",
                        dataPoints: <?php echo json_encode($DataPoints1, JSON_NUMERIC_CHECK); ?>
                    }

                ]
            });

            chart1.render();
        });
    }

</script>

<script type="text/javascript">
    if("<?php echo $DataPoints2; ?>".length > 0){
        $(function () {

            var chart2 = new CanvasJS.Chart("chartContainer2", {
                title: {
                    text: "Number of people enrolled in Food Assistance programs in the top five states in " + "<?php echo $Year ?>"
                },
                subtitles: [
                    {
                        text: ""
                    }
                ],
                animationEnabled: true,
                legend: {
                    cursor: "pointer",
                    itemclick: function (e) {
                        if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                        } else {
                            e.dataSeries.visible = true;
                        }
                        chart.render();
                    }
                },
                axisY: {
                    title: "Number of people enrolled in Food Assistance programs"
                },
                toolTip: {
                    shared: true,
                    content: function (e) {
                        var str = '';
                        var total = 0;
                        var str3;
                        var str2;
                        for (var i = 0; i < e.entries.length; i++) {
                            var str1 = "<span style= 'color:" + e.entries[i].dataSeries.color + "'> " + e.entries[i].dataSeries.name + "</span>: <strong>" + e.entries[i].dataPoint.y + "</strong> <br/>";
                            total = e.entries[i].dataPoint.y + total;
                            str = str.concat(str1);
                        }
                        str2 = "<span style = 'color:DodgerBlue; '><strong>" + e.entries[0].dataPoint.label + "</strong></span><br/>";

                        return (str2.concat(str));
                    }

                },
                data: [
                    {
                        type: "bar",
                        showInLegend: true,
                        name: "No. people enrolled.",
                        color: "orange",
                        dataPoints: <?php echo json_encode($DataPoints2, JSON_NUMERIC_CHECK); ?>
                    }

                ]
            });

            chart2.render();
        });
    }
</script>
