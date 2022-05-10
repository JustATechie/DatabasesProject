<?php include "../templates/pages/page.php"?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Updates</title>
</head>

<body>
<!-- (1) -->
<h5>Add a Location!</h5>
<form action="../updates/addLocation/addLocation.php" method="post">
    <div class="form-inline">
        <button class="btn btn-primary">Go!</button>
    </div>
</form>
<br /><br />

<!-- (2) -->
<h5>Add Food Assistance Data!</h5>
<form action="../updates/addFA/addFA.php" method="post">
    <div class="form-inline">
        <button class="btn btn-primary">Go!</button>
    </div>
</form>
<br /><br />

<!-- (3) -->
<h5>Add School Food Program Data!</h5>
<form action="../updates/addSFP/addSFP.php" method="post">
    <div class="form-inline">
        <button class="btn btn-primary">Go!</button>
    </div>
</form>
<br /><br />

<!-- (1) -->
<h5>Delete a Location!</h5>
<form action="../updates/deleteLocation/deleteLocation.php" method="post">
    <div class="form-inline">
        <button class="btn btn-primary">Go!</button>
    </div>
</form>
<br /><br />

<!-- (2) -->
<h5>Delete Food Assistance Data!</h5>
<form action="../updates/deleteFA/deleteFA.php" method="post">
    <div class="form-inline">
        <button class="btn btn-primary">Go!</button>
    </div>
</form>
<br /><br />

<!-- (3) -->
<h5>Delete School Food Program Data!</h5>
<form action="../updates/deleteSFP/deleteSFP.php" method="post">
    <div class="form-inline">
        <button class="btn btn-primary">Go!</button>
    </div>
</form>
<br /><br />

</body>
