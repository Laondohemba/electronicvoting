<?php

session_start();
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $password = htmlspecialchars($_POST["password"]);
    $confirmPassword = htmlspecialchars($_POST["confirmpassword"]);

    require_once "dbconn.php";

    function get_admin($pdo, $username){
        $sql = "SELECT * FROM admins WHERE username = :username;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    // errors
    $errors = [];
    if(empty($username)){
        $errors["username"] = "Username is empty";
    }elseif(get_admin($pdo, $username)){
        $errors["username"] = "Username already taken!";
    }
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors["email"] = "Email error";
    }
    if(empty($phone)){
        $errors["phone"] = "Provide phone number";
    }
    // function to check valid password
    function isValidPassword($password) {
        if (preg_match('/[A-Z]/', $password) &&     // At least one uppercase letter
            preg_match('/[a-z]/', $password) &&     // At least one lowercase letter
            preg_match('/[0-9]/', $password) &&     // At least one digit
            preg_match('/[\W]/', $password) &&      // At least one special character
            strlen($password) >= 8) {               // At least 8 characters long
            return true;
        }
        return false;
    }


    if(empty($password)){
        $errors["password"] = "Password is empty";
    }
    elseif(!isValidPassword($password)){
        $errors["password"] = "Password must contain lower-case, upper-case, numeric and special character";
    }elseif($password != $confirmPassword){
        $errors["password"] = "Please confirm password";
    }

    if($errors){
        $_SESSION["errors"] = $errors;
        $_SESSION["data"] = $_POST;
        header("Location: ../admin/signup.php");
        exit();
    }else{
        $options = [
            12
        ];
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);

        function create_admin($pdo, $username, $email, $phone, $hashedPassword){
            $sql = "INSERT INTO admins (username, pass_word, email, phone) VALUES (:username, :pass_word, :email, :phone);";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":pass_word", $hashedPassword);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":phone", $phone);
            $stmt->execute();
            return $stmt;
        }

        create_admin($pdo, $username, $email, $phone, $hashedPassword);
        $_SESSION["admin"] = get_admin($pdo, $username);
        header("Location: ../admin/dashboard.php?signup=success");
        exit();

    }
}else{
    header("location: ../admin/signup.php");
}