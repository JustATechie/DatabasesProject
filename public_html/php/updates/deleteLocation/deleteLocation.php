<!--Q#:-->
<?php include "../../templates/questions/question.php" ?>
<!-------------------------- ONLY MAKE CHANGES BELOW THIS LINE -------------------------->
<head>
    <!-- Tab Title -->
    <title>Add Location</title>
</head>
<body>
<br>

<!-- Global variables -->
<?php

?>

<h4>Add a location below!</h4>

<h6>Fields marked with * are mandatory!</h6>
<p></p>
<p>Note: If you only give the State name, the entry of that state by itself will be deleted.</p>
<p>All data of that State name paired with Counties and Cities will remain.</p>

<form method="POST" action="">
    <div class="form-inline">

        <label> State*:
            <input type=text name="givenState">
        </label>

        <label> County:
            <input type=text name="givenCounty">
        </label>

        <label> City:
            <input type=text name="givenCity">
        </label>

        <button class="btn btn-primary" name="addInfo">Submit</button>
    </div>

</form>

<br>
<br>

<!-- Add info! -->
<?php

include 'deleteData.php';

?>