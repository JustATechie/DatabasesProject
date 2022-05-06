<?php include('../templates/head.php'); ?>
</head>


<body>


<!-------------------- NavBar -------------------->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.html">
            <img src="../assets/seal.png" alt="" width="70" height="50" class="d-inline-block align-text-center">
            Databases Project
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../index.html">Home</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!--Please don't delete!-->
<!--<h3 id="DarkModetext">Dark Mode is OFF</h3>-->
<!--<button onclick="darkMode()">Darkmode</button>
<button onclick="lightMode()">LightMode</button>-->
<!-------------------- End NavBar -------------------->
<!--Top page label-->
<h2>Food Assistance Data</h2>



<!-- (1) -->
How have enrollment numbers in Food Assistance programs varied over the years by state?
<form action="../php/questions/Q1.php" method="post">
  <input type="submit" value="Go!"/>
</form>
<br /><br />

</body>

</html>