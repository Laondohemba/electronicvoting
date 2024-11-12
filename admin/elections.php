<?php
session_start();
if (isset($_SESSION["admin"])) {
    $admin = $_SESSION["admin"] ?? [];

    require_once "../includes/dbconn.php";

    $sql = "SELECT * FROM elections WHERE adminID = :adminID ORDER BY id DESC;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":adminID", $admin["id"]);
    $stmt->execute();

    $elections = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("location: login.php");
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
    if (isset($_GET['election']) && ($_GET['election'] == "added")) {
    ?>
        <script>
            // Display the Toastr alert when the document is ready
            $(document).ready(function() {
                toastr.success("Election polls created successfully");
            });
        </script>
    <?php
    }

    if (isset($_GET['election']) && ($_GET['election'] == "edited")) {
    ?>
        <script>
            // Display the Toastr alert when the document is ready
            $(document).ready(function() {
                toastr.success("Election edited successfully");
            });
        </script>
    <?php
    }
    ?>

    <!-- nav bar -->
    <nav class="navbar navbar-expand-md navbar-dark head sticky-top" aria-label="Fourth navbar example">
        <div class="container-fluid px-md-5">
            <a class="navbar-brand mx-5" href="dashboard.php"><?php echo ucwords($admin["username"]) ?? ''; ?> Dashboard</a>
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
    <div class="whole_page" style="min-height: 100vh;">
        <div class="container-fluid">
            <div class="row">
                <strong class="text-center text-light display-6 my-2"><?php echo ucwords($admin["username"]) . "'s" ?? ''; ?> Elections</strong>
                <!-- loop out elections -->
                <?php
                    if(empty($elections)){?>
                        <div class="col-7 text-light my-3 mx-auto text-center">
                            <strong class="h4">You have not created any polls yet</strong>
                        </div>
                  <?php  }else{
                        foreach ($elections as $election) { ?>
                            <div id="sidebarMenu" class="col-7 bg-light my-3 mx-auto py-4">
                                <div class="card">
                                    <div class="card-header h3">
        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="flex-item">
                                                <?php echo $election["election_name"] ?? ''; ?>
                                            </div>
                                            <div class="flex-item">
                                                <div class="dropdown">
                                                    <!-- Dropdown toggle button with vertical dots -->
                                                    <button class="btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <strong style="font-size: 20px;">&#8942;</strong>
                                                    </button>
        
                                                    <!-- Dropdown menu -->
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li><a class="dropdown-item py-2" href="#">Add Voters</a></li>
                                                        <li><a class="dropdown-item py-2" href="#">Add Contestants</a></li>
                                                        <li><a class="dropdown-item py-2" href="#">Voters</a></li>
                                                        <li><a class="dropdown-item py-2" href="#">Contestants</a></li>
                                                        <li><a class="dropdown-item py-2" href="#">Results</a></li>
                                                        <li><a class="dropdown-item py-2" href="#">Messages</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5 class="card-title">Start</h5>
                                                <p>
                                                    <strong>Date:</strong>
                                                    <span>
                                                        <?php echo $election["start_date"] ?? ''; ?>
                                                    </span>
                                                </p>
                                                <p>
                                                    <strong>Time:</strong>
                                                    <span>
                                                        <?php echo $election["start_time"] ?? ''; ?>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="card-title">Finish</h5>
                                                <p>
                                                    <strong>Date:</strong>
                                                    <span>
                                                        <?php echo $election["end_date"] ?? ''; ?>
                                                    </span>
                                                </p>
                                                <p>
                                                    <strong>Time:</strong>
                                                    <span>
                                                        <?php echo $election["end_time"] ?? ''; ?>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <a href="editelection.php?id=<?php echo $election["id"]; ?>" class="btn btn-primary w-100">Edit</a>
                                            </div>
                                            <div class="col-md-6 my-2">
                                                <a href="#" class="btn btn-danger w-100">Cancel</a>
                                            </div>
                                        </div>
        
                                    </div>
                                </div>
                            </div>
                        <?php  }
                    }

                ?>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="js/dashboard.js"></script>
</body>

</html>