<?php
session_start();

if (isset($_SESSION["errors"])) {
    $errors = $_SESSION["errors"] ?? [];
    unset($_SESSION["errors"]);
}
if (isset($_SESSION["user"])) {
    session_unset();  // Unset all session variables
    session_destroy(); // Destroy the session
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Electronic Voting | Login</title>

    <link rel="stylesheet" href="../css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">



    <!-- Custom styles for this template -->
    <!-- <link href="css/signin.css" rel="stylesheet"> -->
</head>

<body>

    <div class="whole_page py-5" style="min-height: 100vh;">

        <div class="container">
            <div class="row">
                <div class="col-8 col-md-6 form-signin mx-auto bg-light p-5">
                    <form class="text-center" method="POST" action="../includes/login_handler.php">
                        <h3>Welcome back</h3>
                        <strong>Please sign in</strong>

                        <div class="form-floating my-2">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username">
                            <label for="floatingInput">Username</label>
                            <p class="text-danger"><?php echo $errors["username"] ?? ''; ?></p>
                        </div>
                        <div class="form-floating my-2">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                            <label for="floatingPassword">Password</label>
                            <p class="text-danger"><?php echo $errors["password"] ?? ''; ?></p>
                        </div>
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>

                        <p class="mt-5">Don't have an account?
                            <a href="signup.php" class="text-decoration-none">Sign Up</a>
                        </p>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>