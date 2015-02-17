<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="../../favicon.ico"> -->
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

    <script src="Chart.js"></script>
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
        <form action="index.php" method="get" class="form-horizontal">
          <div class="form-group">
            <label for="weight" class="col-sm-2 control-label">體重</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="weight" placeholder="輸入體重" name="weight">
            </div>
          </div>
          <div class="form-group">
            <label for="bodyfat" class="col-sm-2 control-label">體脂肪率</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="bodyfat" placeholder="輸入體脂肪率" name="bodyfat">
            </div>
          </div>
          <div class="form-group">
            <label for="BMR" class="col-sm-2 control-label">基礎代謝</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="BMR" placeholder="輸入基礎代謝" name="BMR">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">記錄</button>
            </div>
          </div>
        </form>
        <br>
        <?php 
            if (!empty($_GET["weight"]) and !empty($_GET["bodyfat"]) and !empty($_GET["BMR"]))
            {
                if (is_numeric($_GET["weight"]) and is_numeric($_GET["bodyfat"]) and is_numeric($_GET["BMR"]))
                {  

                    $link = mysqli_connect("192.241.228.62", "eddy", "eddypassword", "weight");
                    //$link = mysqli_connect($configs['host'], "eddy", "eddypassword", "weight");

                    /* check connection */
                    if (mysqli_connect_errno()) {
                      printf("Connect failed: %s\n", mysqli_connect_error());
                      exit();}

                    $d = date("Y-m-d H:i:s", time() + (8 * 60 * 60));
                    $w = $_GET["weight"];
                    $f = $_GET["bodyfat"];
                    $b = $_GET["BMR"];

                    $sql = "INSERT INTO `weight`.`main` (`id`, `date`, `weight`, `bodyfat`, `bmr`) VALUES (NULL, '".$d."', ".$w.", ".$f.", ". $b.")";
                    //$sql = printf('INSERT INTO weight.main (id, date, weight, bodyfat, bmr) VALUES (NULL, "%s", %f, %f, %f)', $d, $w, $f, $b);

                    if (mysqli_query($link, $sql)) {echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 記錄已成功寫入</div>';} 
                    else {echo "Error: " . $sql . "<br>" . mysqli_error($link);}

                }
                else { echo '<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 還未寫入任何記錄</div>';}
            } 
            else { echo '<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 還未寫入任何記錄</div>';}
        ?>
    </div>
    </div>

<?php
    $link = mysqli_connect("192.241.228.62", "eddy", "eddypassword", "weight");

    /* check connection */
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();}
?>


    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">體重</h3>
        </div>
        <div class="panel-body">
        <?php
            $r_count = 14;
            $sql = "select a.date, round(avg(a.weight),1) as weight
                    from (
                        SELECT date(date) as date, weight
                        FROM weight.main
                        where weight is not null) as a
                    group by a.date
                    order by a.date desc
                    limit ".$r_count; 

            $a_date = array($r_count);
            $a_row  = array($r_count);
            $i = 0;
            if ($result = mysqli_query($link, $sql)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $a_date[$i] = date_format(date_create($row["date"]), 'M-d');
                    $a_row[$i]  = $row["weight"];
                    $i++;
                }
                mysqli_free_result($result);
            }
        ?>
        <div style="width:100%">
            <div>
            <canvas id="canvas" height="100" width="160"></canvas>
            </div>
        </div>
        </div>
    </div>


    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">體脂</h3>
        </div>
        <div class="panel-body">
        <?php
            $r_count = 7;
            $sql = "select a.date, round(avg(a.bodyfat),1) as bodyfat
                    from (
                        SELECT date(date) as date, bodyfat
                        FROM weight.main
                        where bodyfat is not null) as a
                    group by a.date
                    order by a.date desc
                    limit ".$r_count; 

            $a_date1 = array($r_count);
            $a_row1  = array($r_count);
            $i = 0;
            if ($result = mysqli_query($link, $sql)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $a_date1[$i] = date_format(date_create($row["date"]), 'M-d');
                    $a_row1[$i]  = $row["bodyfat"];
                    $i++;
                }
                mysqli_free_result($result);
            }
        ?>
        <div style="width:100%">
            <div>
            <canvas id="canvas1" height="100" width="160"></canvas>
            </div>
        </div>
        </div>
    </div>


        <script>
            var lineChartData = {
                labels : [<?php echo '"'.implode('","', array_reverse($a_date)).'"'; ?>],
                datasets : [
                    {
                        label: "My First dataset",
                        fillColor: "rgba(255,128,0,0.5)",
                        strokeColor: "rgba(255,128,0,0.8)",
                        highlightFill: "rgba(255,128,0,0.75)",
                        highlightStroke: "rgba(255,128,0,1)",
                        data : [<?php echo '"'.implode('","', array_reverse($a_row)).'"'; ?>]
                    }
                ]
            }

            var lineChartData1 = {
                labels : [<?php echo '"'.implode('","', array_reverse($a_date1)).'"'; ?>],
                datasets : [
                    {
                        label: "My First dataset",
                        fillColor: "rgba(255,59,59,0.5)",
                        strokeColor: "rgba(255,59,59,0.8)",
                        highlightFill: "rgba(255,59,59,0.75)",
                        highlightStroke: "rgba(255,59,59,1)",
                        data : [<?php echo '"'.implode('","', array_reverse($a_row1)).'"'; ?>]
                    }
                ]
            }
        window.onload = function(){
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myLine = new Chart(ctx).Line(lineChartData, {
                responsive: true
            });

            var ctx1 = document.getElementById("canvas1").getContext("2d");
            window.myLine1 = new Chart(ctx1).Line(lineChartData1, {
                responsive: true
            });
        }
        </script>

<?php
    mysqli_close($link);
?>

</div><!-- container -->





    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
