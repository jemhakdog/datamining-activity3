<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datamining2024";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$successMessage = '';
$errorMessage = '';

// Check if ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $deleteQuery = "DELETE FROM employee WHERE EmployeeID = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $successMessage = "Employee deleted successfully";
        header("Location: index.php?success=" . urlencode($successMessage));
        exit();
    } else {
        $errorMessage = "Error deleting employee: " . $conn->error;
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
