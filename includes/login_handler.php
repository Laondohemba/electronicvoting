<?php

require_once "dbconn.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $errors = [];
    if (empty($username)) {
        $errors["username"] = "Provide username!";
    }
    if (empty($password)) {
        $errors["password"] = "Provide password!";
    }

    function get_admin($pdo, $username){
        $sql = "SELECT * FROM admins WHERE username = :username;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    $admin = get_admin($pdo, $username);
    if ($admin) {
        if (password_verify($password, $admin["pass_word"])) {
            $_SESSION["admin"] = $admin;
            header("Location: ../admin/dashboard.php?login=success");
            exit();
        } else {
            $errors["username"] = "Username or password error. Note that passwords are case sensitve!";
        }
    } else {
        $errors["username"] = "Username not found!";
    }

    if ($errors) {
        $_SESSION["errors"] = $errors;
        header("Location: ../admin/login.php");
        exit();
    }
} else {
    header("Location: ../admin/login.php");
}
