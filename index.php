<?php
    include_once 'PRIVATE.php';

    require __DIR__ . '/vendor/autoload.php';

    $api = new RestClient([
        'base_url' => "https://api.teller.io",
        'headers' => ['Authorization' => 'Bearer '.$api_key],
    ]);

    $pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $username, $password);
    $fluent = new FluentPDO($pdo);
?>

<html>
<head>
  <title>Home</title>
  <link href="assets/css/styles.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto+Slab" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#"><h1>buffr</h1></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarNavAltMarkup">
      <div class="navbar-nav ml-auto">
        <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
        <a class="nav-item nav-link" href="settings.html">Settings</a>
        <a class="nav-item nav-link" href="#"><i class="far fa-user-circle"></i> Profile</a>
      </div>
    </div>
  </nav>

  <div class="container" style="margin-top: 5%">
    <div class="row" style="border-bottom: 1px solid #01579b;">
      <div class="col-md-6">
        <p class="balance">
          <?php
            $request = $api->get('/accounts/'.$account_info);
            echo "&pound;".floor($request["balance"]);
          ?>
        </p>
        <p><b>Current account</b> 40-47-42</p>
      </div>
      <div class="col-md-6">
        <div id="chart_div"></div>
        </div>
      </div>
    <br>
    <div class="row nopadding module-space">
      <div class="col-md-5 nopadding">
        <div class="card nopadding">
          <div class="card-header">
            <div class="row">
              <div class="col-9"><h3>Previous</h3></div>

            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <?php
                  $result = $api->get('/accounts/'.$account_info.'/transactions');

                  foreach ($result as $key => $value) {
                    echo ($value->type == "credit" || $value->type == "transfer") ? '<div class="col-3 monthlys-positive">' : '<div class="col-3 monthlys-negative">';

                    echo ($value->amount > 0) ? '+&pound;' : '-&pound;';
                    echo floor(abs($value->amount));
                    echo "</div>";

                    echo '<div class="col-6">'.$value->counterparty.'</div>';

                    echo '<div class="col-3">'.$value->date.'</div>';

                    echo '<div class="w-100"></div>';
                  }
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2" style="height=200px"><br></div>
      <div class="col-md-5 nopadding">
        <div class="card nopadding" >
          <div class="card-header">
            <div class="row">
              <div class="col-9"><h3>Upcoming</h3></div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <?php
                $upcoming = $fluent->from('upcoming');

                foreach ($upcoming as $row) {
                  $bool = $row['amount'] > 0;
                  ?>

                  <div class="col-3 <?= $bool ? 'monthlys-positive' : 'monthlys-negative' ?>">
                    <?= $bool ? '+&pound;'<?= abs($row['amount']) : '-&pound;'.abs($row['amount']); ?>
                  </div>

                  <div class="col-5"> <?= $row['description']?> </div>
                  <div class="col-4"> <?= $row['date']?> </div>

                  <div class="w-100"></div>
                <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
  google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'X');
      data.addColumn('number', '$$$');

      data.addRows([
        [0, 0],   [1, 10],  [2, 23],  [3, 17],  [4, 18],  [5, 9],
        [6, 11],  [7, 27],  [8, 33],  [9, 40],  [10, 32], [11, 35],
        [12, 30], [13, 40], [14, 42], [15, 47], [16, 44], [17, 48],
        [18, 52], [19, 54], [20, 42], [21, 55], [22, 56], [23, 57],
        [24, 60], [25, 50], [26, 52], [27, 51], [28, 49], [29, 53],
        [30, 55], [31, 60], [32, 61], [33, 59], [34, 62], [35, 65],
        [36, 62], [37, 58], [38, 55], [39, 61], [40, 64], [41, 65],
        [42, 63], [43, 66], [44, 67], [45, 69], [46, 69], [47, 70],
        [48, 72], [49, 68], [50, 66], [51, 65], [52, 67], [53, 70],
        [54, 71], [55, 72], [56, 73], [57, 75], [58, 70], [59, 68],
        [60, 64], [61, 60], [62, 65], [63, 67], [64, 68], [65, 69],
        [66, 70], [67, 72], [68, 75], [69, 80]
      ]);

      var options = {

      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
    </script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>
