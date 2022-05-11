<?php include "../templates/pages/page.php"?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Updates</title>
</head>

<br>

<h2>Inserts!</h2>

<body>
<!-- (1) -->
<h4>Add a Location!</h4>
<form action="../updates/addLocation/addLocation.php" method="post">
    <div class="form-inline">
        <button class="btn btn-primary">Go!</button>
    </div>
</form>
<br /><br />

<!-- (2) -->
<h4>Add Food Assistance Data!</h4>
<form action="../updates/addFA/addFA.php" method="post">
    <div class="form-inline">
        <button class="btn btn-primary">Go!</button>
    </div>
</form>
<br /><br />

<!-- (3) -->
<h4>Add School Food Program Data!</h4>
<form action="../updates/addSFP/addSFP.php" method="post">
    <div class="form-inline">
        <button class="btn btn-primary">Go!</button>
    </div>
</form>
<br /><br />

<h2>Deletes!</h2>

<!-- (1) -->
<h4>Delete a Location!</h4>
<form action="../updates/deleteLocation/deleteLocation.php" method="post">
    <div class="form-inline">
        <button class="btn btn-primary">Go!</button>
    </div>
</form>
<br /><br />

<!-- (2) -->
<h4>Delete Food Assistance Data!</h4>
<form action="../updates/deleteFA/deleteFA.php" method="post">
    <div class="form-inline">
        <button class="btn btn-primary">Go!</button>
    </div>
</form>
<br /><br />

<!-- (3) -->
<h4>Delete School Food Program Data!</h4>
<form action="../updates/deleteSFP/deleteSFP.php" method="post">
    <div class="form-inline">
        <button class="btn btn-primary">Go!</button>
    </div>
</form>
<br /><br />

</body>
