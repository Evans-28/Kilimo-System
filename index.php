<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lipa na M-Pesa</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Custom CSS -->
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap");

      body {
        background-color: #333;
        font-family: "Rubik", sans-serif;
        color: #fff;
      }

      .card {
        width: 100%;
        max-width: 400px;
        border: none;
        border-radius: 15px;
        background-color: #444;
        margin-top: 5%;
      }

      .btn-green {
        background-color: #008000;
        border-color: #008000;
        color: #fff;
      }

      .btn-green:hover {
        background-color: #006400;
        border-color: #006400;
      }

      .btn-green:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 128, 0, 0.5);
      }

      .media img {
        border-radius: 15px;
      }

      .media-body h6 {
        font-size: 15px;
      }

      .form-label {
        color: #ccc;
      }

      .form-control {
        background-color: #555;
        border: 1px solid #666;
        color: #fff;
      }

      .form-control::placeholder {
        color: #999;
      }
    </style>
</head>
<body oncontextmenu="return false" class="snippet-body">
  <div class="container d-flex justify-content-center">
    <div class="card px-3 py-4">
      <div class="d-flex flex-row justify-content-around mb-4">
        <div class="btn-green p-2 rounded"><span>Mpesa</span></div>
      </div>
      <div class="media mb-4">
        <img src="1200px-M-PESA_LOGO-01.svg.png" class="mr-3" height="75" />
        <div class="media-body">
          <h6 class="mt-1">Enter Amount & Number</h6>
        </div>
      </div>
      <div>
        <form class="row g-3" action="./stk_initiate.php" method="POST">
          <div class="col-12">
            <label for="amount" class="form-label">Amount</label>
            <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Amount">
          </div>
          <div class="col-12">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number">
          </div>
          <div class="col-12 d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-green" name="submit" value="submit">Pay</button>
            <a href="../Home.php" class="btn btn-green">Home</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
