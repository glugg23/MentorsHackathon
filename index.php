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
        <a class="nav-item nav-link" href="settings.php">Settings</a>
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
          <?php
            $result = $api->get('/accounts/'.$account_info.'/transactions');
            $array = array_slice(json_decode($result->response), 0, 20);
            $balance = array();
		        foreach ($array as $key => $value) {
              array_push($balance, floor($value->running_balance)); ?>
		          <div class="row payments">
              <div class="col-3 <?= ($value->type == "credit" || $value->type == "transfer") ? 'monthlies-positive' : 'monthlies-negative' ?>">
                <?= (($value->amount > 0) ? '+&pound;' : '-&pound;').floor(abs($value->amount)); ?>
              </div>
              <div class="col-6"><?= $value->counterparty ?></div>
              <div class="col-3"><?= $value->date ?></div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-md-2" style="height=200px"><br></div>
      <div class="col-md-5 nopadding">
        <div class="card nopadding" >
          <div class="card-header">
            <div class="row">
              <div class="col-9"><h3>Upcoming</h3></div>
              <div class="col-1"><i class="fas fa-plus-square fa-lg" data-toggle="modal" data-target="#addModal" style="position: relative;top: 2px;"></i></div>
            </div>
          </div>
          <div class="card-body">
              <?php
                $upcoming = $fluent->from('upcoming');

                foreach ($upcoming as $row) {
                  $bool = $row['amount'] > 0;
                  ?>
                <div class="row payments">
                  <div class="col-3 <?= $bool ? 'monthlies-positive' : 'monthlies-negative' ?>">
                    <?= ($bool ? '+&pound;' : '-&pound;').abs($row['amount']) ?>
                  </div>

                  <div class="col-5"> <?= $row['description']?> </div>
                  <div class="col-4"> <?= $row['date']?> </div>

                </div>
                <?php } ?>

                <?php
                  $monthlies = $fluent->from('monthly');

                  for ($i=0; $i < 6; $i++) {
                    foreach ($monthlies as $row) {
                      $bool = $row['amount'] > 0;
                      ?>
                    <div class="row payments">
                      <div class="col-3 <?= $bool ? 'monthlies-positive' : 'monthlies-negative' ?>">
                        <?= ($bool ? '+&pound;' : '-&pound;').abs($row['amount']) ?>
                      </div>

                      <div class="col-5"> <?= $row['description']?> </div>
                      <div class="col-4"> <?= '2018'.(9+$i).$row['date']?> </div>

                    </div>
                    <?php }
                  } ?>
          </div>
        </div>
      </div>

      <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add new monthly payment</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="addUpcoming.php" method="post">

            <div class="modal-body">
              <form>
                <div class="form-group">
                  <label for="formName">Name</label>
                  <input type="text" class="form-control" id="formName" name="description">
                </div>
                <div class="form-group">
                  <label for="formAmount">Amount</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-pound-sign"  style="position: relative;top: 10px; margin-right: 5px;"></i></span>
                    <input type="number" class="form-control" id="formAmount" name="amount">
                  </div>
                </div>
                <div class="form-group">
                  <label for="formDate">Date of Payment</label>
                  <input type="date" class="form-control" id="formDate" name="date">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Save Changes">
              </div>
            </form>
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
      var balance = [<?php echo '"'.implode('","', $balance).'"' ?>];
      var data = new google.visualization.DataTable();
      
      data.addColumn('number', 'X');
      data.addColumn('number', '$$$');
      
      var n = 0;
      for (var i = balance.length-1; i>=0; i--){
	var num = parseFloat(balance[i]);
      	data.addRow([n, num]);
        n++;
      }

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
