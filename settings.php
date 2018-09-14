<?php
    include_once 'PRIVATE.php';

    require __DIR__ . '/vendor/autoload.php';

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
    <a class="navbar-brand ral" href="#"><h1>buffr</h1></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarNavAltMarkup">
      <div class="navbar-nav ml-auto">
        <a class="nav-item nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        <a class="nav-item nav-link active" href="#">Settings</a>
        <a class="nav-item nav-link" href="#"><i class="far fa-user-circle"></i> Profile</a>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col">
        <div class="card" style="max-width: 500px">
          <div class="card-header">
            <div class="row">
              <div class="col-9" style="margin-right: 20px;"><h3>Monthlies</h3></div>
              <div class="col-1"><i class="fas fa-plus-square fa-lg" data-toggle="modal" data-target="#addModal" style="position: relative;top: 12px;color: #0288d1;"></i></div>
              <div class="col-1"><i class="fas fa-edit fa-lg" onclick="showDelete()" style="position: relative;top: 10px;color: #0288d1;"></i></div>
            </div>
          </div>
          <div class="card-body">
            <?php
              $monthlies = $fluent->from('monthly');
              $i = 1;
              foreach ($monthlies as $row) { ?>
                <div class="row" id='<?='ac'.$i?>'>
                  <div class="col-2 <?= ($row['amount'] > 0) ? 'monthlies-positive' : 'monthlies-negative' ?>">
                    <?= (($row['amount'] > 0) ? '+&pound;' : '-&pound;').abs($row['amount']) ?>
                  </div>
                  <div class="col-6"><?= $row['description'] ?></div>
                  <div class="col-3"><?= $row['date'] ?></div>
                  <div class="col-1"><i class="delete far fa-minus-square" style="position: relative;top: 4px;color: red;" onclick="remAction('<?='ac'.$i?>')"></i></div>
                </div>
              <?php $i++;
              } ?>

            <div class="row" id='ac1'>
              <div class="col-2 monthlies-positive">+&pound;10</div>
              <div class="col-6">Salary</div>
              <div class="col-3">10/09/2018</div>
              <div class="col-1"><i class="delete far fa-minus-square" style="position: relative;top: 4px;color: red;" onclick="remAction('ac1')"></i></div>
            </div>
            <div class="row" id='ac2'>
              <div class="col-2 monthlies-negative">-&pound;50</div>
              <div class="col-6">Rent</div>
              <div class="col-3">06/09/2018</div>
              <div class="col-1"><i class="delete far fa-minus-square" style="position: relative;top: 4px;color: red;" onclick="remAction('ac2')"></i></div>
            </div>
          </div>
        </div>
    	</div>
  	</div>

    <!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new monthly payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="addMonthly.php" method="post">

      <div class="modal-body">
          <div class="form-group">
            <label for="formGroupExampleInput">Name</label>
            <input type="text" name="name" class="form-control" id="formName">
          </div>
          <div class="form-group">
            <label for="formAmount">Amount</label>
            <div class="input-group">
              <span class="input-group-addon"><i class="fas fa-pound-sign"  style="position: relative;top: 10px; margin-right: 5px;"></i></span>
              <input type="number" name="amount" class="form-control" id="formAmount">
            </div>
          </div>

          <div class="form-group">
            <label for="formDay">Day of monthly payment</label>
            <select multiple class="form-control" id="formDay" name="day">
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
              <option>6</option>
              <option>7</option>
              <option>8</option>
              <option>9</option>
              <option>10</option>
              <option>11</option>
              <option>12</option>
              <option>13</option>
              <option>14</option>
              <option>15</option>
              <option>16</option>
              <option>17</option>
              <option>18</option>
              <option>19</option>
              <option>20</option>
              <option>21</option>
              <option>22</option>
              <option>23</option>
              <option>24</option>
              <option>25</option>
              <option>26</option>
              <option>27</option>
              <option>28</option>
              <option>29</option>
              <option>30</option>
              <option>31</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary">
      </div>
    </form>
    </div>
  </div>
</div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="assets/js/scripts.js" type="text/javascript">

  </script>
</body>

</html>
