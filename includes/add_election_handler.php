<?php

session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $electionName = htmlspecialchars($_POST["election_name"]);
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];
    $startTime = $_POST["start_time"];
    $endTime = $_POST["end_time"];
    $adminID = $_SESSION["admin"]["id"];

    // Convert dates to timestamps for date-only comparison
    $startTimestamp = strtotime($startDate);
    $endTimestamp = strtotime($endDate);

    // Error handling array
    $errors = [];

    if (empty($electionName)) {
        $errors["name_error"] = "Provide election name";
    }

    if (empty($startTimestamp)) {
        $errors["start_date_error"] = "Choose election start date";
    }

    if (empty($endTimestamp)) {
        $errors["end_date_error"] = "Choose election end date";
    } elseif (strtotime($endDate) < strtotime($startDate)) {
        $errors["end_date_error"] = "End date cannot be before the start date.";
    }

    if (strtotime($startDate) === strtotime($endDate)) {
        if (empty($startTime)) {
            $errors["start_time_error"] = "Choose election start time";
        }

        if (empty($endTime)) {
            $errors["end_time_error"] = "Choose election end time";
        } elseif (strtotime($endTime) < strtotime($startTime)) {
            $errors["end_time_error"] = "End time cannot be before the start time on the same day.";
        }
    }
    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        $_SESSION["data"] = $_POST;
        header("Location: ../admin/dashboard.php");
        exit();
    } else {
        require_once "dbconn.php";
        $sql = "INSERT INTO elections (adminID, election_name, start_date, start_time, end_date, end_time) VALUES (:adminID, :election_name, :start_date, :start_time, :end_date, :end_time);";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":adminID", $adminID);
        $stmt->bindParam(":election_name", $electionName);
        $stmt->bindParam(":start_date", $startDate);
        $stmt->bindParam(":start_time", $startTime);
        $stmt->bindParam(":end_date", $endDate);
        $stmt->bindParam(":end_time", $endTime);
        $stmt->execute();

        $pdo = null;
        $stmt = null;

        header("location: admin/elections.php?election=added");
    }
} else {
    header("location: ../admin/dashboard.php");
}
