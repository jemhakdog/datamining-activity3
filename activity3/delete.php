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
    $query = "SELECT * FROM employee WHERE EmployeeID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Employee</title>
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.*/css/pico.min.css">
</head>
<body>
    <main class="container">
        <h1>Delete Employee</h1>
        <p>Are you sure you want to delete the following employee?</p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($employee['FirstName'] . ' ' . $employee['LastName']); ?></p>
        <p><strong>Department:</strong> <?php echo htmlspecialchars($employee['Department']); ?></p>
        
        <form method="POST" action="delete_confirm.php?id=<?php echo $id; ?>">
            <button type="submit" onclick="return confirm('Are you sure you want to delete this employee?');">Yes, Delete</button>
        </form>
        <a href="index.php">Cancel</a>
    </main>
</body>
</html>