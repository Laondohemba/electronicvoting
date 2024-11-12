<?php
session_start();
if(isset($_SESSION["admin"])){
  $admin = $_SESSION["admin"] ?? [];
}else{
  header("location: login.php");
}

if(isset($_SESSION["errors"])){
  $errors = $_SESSION["errors"] ?? [];
  $data = $_SESSION["data"] ?? [];
  unset($_SESSION["errors"]);
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title><?php echo ucwords($admin["username"]) ?? ''; ?> | Dashboard</title>

  <link rel="stylesheet" href="../css/style.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">


    <!-- Include jQuery and Toastr libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body>


    <?php
    // Checking if the 'message' parameter exists in the URL
    if (isset($_GET['signup']) && ($_GET['signup'] == "success")) {
    ?>
        <script>
            // Display the Toastr alert when the document is ready
            $(document).ready(function() {
                toastr.success("Sign up success");
            });
        </script>
    <?php
    }
    if (isset($_GET['login']) && ($_GET['login'] == "success")) {
      ?>
          <script>
              // Display the Toastr alert when the document is ready
              $(document).ready(function() {
                  toastr.success("Login success");
              });
          </script>
      <?php
      }
    ?>

  <!-- nav bar -->
  <nav class="navbar navbar-expand-md navbar-dark head sticky-top" aria-label="Fourth navbar example">
    <div class="container-fluid px-md-5">
      <a class="navbar-brand mx-5" href="dashboard.php"><?php echo ucwords($admin["username"]) ?? ''; ?>  Dashboard</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse mx-5" id="navbarsExample04">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="elections.php">Elections</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Messages</a>
          </li>
        </ul>
        <div class="navbar-nav">
          <div class="nav-item text-nowrap">
            <a class="nav-link px-3 text-light" href="../includes/logout.php">Sign out</a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- dashboard -->
  <div class="whole_page">
    <div class="container-fluid">
      <div class="row">
        <!-- add project -->
        <div id="sidebarMenu" class="col-7 bg-light my-5 mx-auto py-4">
          <form action="../includes/add_election_handler.php" method="POST" enctype="multipart/form-data" class="w-75 mx-auto text-center">
            <h2>Create New Election Polls</h2>
            <label for="name" class="form-label my-2">Election Name</label>
            <input type="text" name="election_name" placeholder="Election Name" class="form-control" value="<?php echo $data["election_name"] ?? ''; ?>">
            <p class="text-danger"><?php echo $errors["name_error"] ?? ''; ?></p>

            <label for="brief_description" class="form-label my-2">Start date</label>
            <input type="date" name="start_date" class="form-control my-2" value="<?php echo $data["start_date"] ?? ''; ?>">
            <p class="text-danger"><?php echo $errors["start_date_error"] ?? ''; ?></p>

            <label for="brief_description" class="form-label my-2">End date</label>
            <input type="date" name="end_date" class="form-control my-2" value="<?php echo $data["end_date"] ?? ''; ?>">
            <p class="text-danger"><?php echo $errors["end_date_error"] ?? ''; ?></p>
            

            <label for="full_description" class="form-label my-2">Start time</label>
            <input type="time" name="start_time" class="form-control" value="<?php echo $data["start_time"] ?? ''; ?>">
            <p class="text-danger"><?php echo $errors["start_time_error"] ?? ''; ?></p>
            

            <label for="full_description" class="form-label my-2">End time</label>
            <input type="time" name="end_time" class="form-control" value="<?php echo $data["end_time"] ?? ''; ?>">
            <p class="text-danger"><?php echo $errors["end_time_error"] ?? ''; ?></p>
            
            <button class="btn btn-primary my-2 w-100" type="submit">Add Election</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="js/dashboard.js"></script>
</body>

</html>