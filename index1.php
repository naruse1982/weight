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
             { echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 記錄已成功寫入</div>'; }
        else { echo '<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 還未寫入任何記錄</div>';}
    } 
    else { echo '<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 還未寫入任何記錄</div>';}
?>



    <?php // 寫入.csv file
        if (!empty($_GET["weight"]) and !empty($_GET["bodyfat"]) and !empty($_GET["BMR"]))
        {
            if (is_numeric($_GET["weight"]) and is_numeric($_GET["bodyfat"]) and is_numeric($_GET["BMR"]))
            {
                $list    = array("","","","");
                $list[0] = date("Y-m-d H:i:s", time() + (8 * 60 * 60)); //+8 hours
                $list[1] = $_GET["weight"];
                $list[2] = $_GET["bodyfat"];
                $list[3] = $_GET["BMR"];
                $fp = fopen('weight.csv', 'a');
                fputcsv($fp, $list);
                fclose($fp);
            } else { echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> 輸入的資訊或格式有誤</div>';}
        }
    ?>


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