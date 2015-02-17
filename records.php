<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<!--     <link rel="icon" href="../../favicon.ico"> -->
    <title>My Weight Watcher</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
  </head>

    <style type="text/css">
    body {
         padding-top: 70px;
         background-image: url('footer_lodyas.png')
        } 
    </style>
  </head>
  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Weight Watcher</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="records.php">Record</a></li>
            <li><a href="analysis.php">Analysis</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>



    <div class="container">
    <div class="panel panel-default">
      <div class="panel-body">

          <table class="table table-striped">
            <thead>
              <tr>
                  <th class="col-sm-6">time</th>
                  <th class="col-sm-2">kg</th>
                  <th class="col-sm-2">bodyfat</th>
                  <th class="col-sm-2">BMR</th>
              </tr>
            </thead>
            <tbody>

<?php
    $link = mysqli_connect("192.241.228.62", "eddy", "eddypassword", "weight");

    /* check connection */
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();}

    $sql = "SELECT * FROM weight.main ORDER BY date DESC limit 40"; 

    if ($result = mysqli_query($link, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".date_format(date_create($row["date"]), 'm-d H:i')."</td>";
            echo "<td>".$row["weight"]."</td>";
            echo "<td>".$row["bodyfat"]."</td>";
            echo "<td>".$row["bmr"]."</td>";
            echo "</tr>";
        }
        mysqli_free_result($result);
    }
?>


            </tbody>
          </table>


      </div>
    </div>
    </div><!-- container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
