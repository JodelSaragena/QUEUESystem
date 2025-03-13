<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $created_by = $_SESSION["username"];
    
    $uploadDir = "uploads/"; // Ensure this folder exists with proper permissions
    $fileName = basename($_FILES["file"]["name"]);
    $filePath = $uploadDir . time() . "_" . $fileName; // Prevent overwriting

    $allowedExtensions = ["pdf", "doc", "docx", "xlsx"];
    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

    if (!in_array($fileExt, $allowedExtensions)) {
        $_SESSION['error_message'] = "Invalid file type! Only PDF, DOC, DOCX, XLSX allowed.";
        header("Location: tellerdocumentationdashboard.php");
        exit();
    }

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $filePath)) {
        $stmt = $conn->prepare("INSERT INTO documents (title, description, file_path, created_by) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $description, $filePath, $created_by);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Document uploaded successfully!";
        } else {
            $_SESSION['error_message'] = "Database error.";
        }
    } else {
        $_SESSION['error_message'] = "Error uploading file.";
    }
    header("Location: tellerdocumentationdashboard.php");
    exit();
}
?>
