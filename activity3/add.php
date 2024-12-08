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

// Fetch all departments and positions from the database
$departmentsQuery = "SELECT DISTINCT Department FROM employee";
$departmentsResult = $conn->query($departmentsQuery);

$positionsQuery = "SELECT DISTINCT Position FROM employee";
$positionsResult = $conn->query($positionsQuery);
// Initialize variables
$firstName = $lastName = $department = $position = $salary = $city = $status = '';
$firstNameError = $lastNameError = $departmentError = $positionError = $salaryError = $cityError = $statusError = '';
$successMessage = '';
$errorMessage = '';

// Insert employee record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['FirstName'])) {
        $firstNameError = "First Name is required";
    } else {
        $firstName = $_POST['FirstName'];
    }

    if (empty($_POST['LastName'])) {
        $lastNameError = "Last Name is required";
    } else {
        $lastName = $_POST['LastName'];
    }

    if (empty($_POST['Department'])) {
        $departmentError = "Department is required";
    } else {
        $department = $_POST['Department'];
    }

    if (empty($_POST['Position'])) {
        $positionError = "Position is required";
    } else {
        $position = $_POST['Position'];
    }

    if (empty($_POST['Salary'])) {
        $salaryError = "Salary is required";
    } else {
        $salary = $_POST['Salary'];
    }

    if (empty($_POST['City'])) {
        $cityError = "City is required";
    } else {
        $city = $_POST['City'];
    }

    if (empty($_POST['Status'])) {
        $statusError = "Status is required";
    } else {
        $status = $_POST['Status'];
    }

    if (empty($firstNameError) && empty($lastNameError) && empty($departmentError) && empty($positionError) && empty($salaryError) && empty($cityError) && empty($statusError)) {
        $insertQuery = "INSERT INTO employee (FirstName, LastName, Department, Position, Salary, City, Status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssssdss", $firstName, $lastName, $department, $position, $salary, $city, $status);
        if ($stmt->execute()) {
            $successMessage = "Employee added successfully";
            header("Location: index.php?success=" . urlencode($successMessage));
            exit();
        } else {
            $errorMessage = "Error adding employee: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.*/css/pico.min.css">
</head>
<body>
    <main class="container">
        <h1>Add Employee</h1>
        <?php if ($successMessage): ?>
            <p class="success"><?php echo $successMessage; ?></p>
        <?php endif; ?>
        <?php if ($errorMessage): ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <form method="POST">
            <label>First Name:</label>
            <input type="text" name="FirstName" value="<?php echo htmlspecialchars($firstName); ?>" required>
            <span class="error"><?php echo $firstNameError; ?></span>
            <br>
            <label>Last Name:</label>
            <input type="text" name="LastName" value="<?php echo htmlspecialchars($lastName); ?>" required>
            <span class="error"><?php echo $lastNameError; ?></span>
            <br>
            <label>Department:</label>
            <select name="Department" required>
                <option value="">Select Department</option>
                <?php while ($row = $departmentsResult->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($row['Department']); ?>" <?php echo ($department === $row['Department']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($row['Department']); ?></option>
                <?php endwhile; ?>
            </select>
            <span class="error"><?php echo $departmentError; ?></span>
            <br>
            <label>Position:</label>
            <select name="Position" required>
                <option value="">Select Position</option>
                <?php while ($row = $positionsResult->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($row['Position']); ?>" <?php echo ($position === $row['Position']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($row['Position']); ?></option>
                <?php endwhile; ?>
            </select>
            <span class="error"><?php echo $positionError; ?></span>
            <br>
            <label>Salary:</label>
            <input type="number" name="Salary" value="<?php echo htmlspecialchars($salary); ?>" required>
            <span class="error"><?php echo $salaryError; ?></span>
            <br>
            <label>City:</label>
            <input type="text" name="City" value="<?php echo htmlspecialchars($city); ?>" required>
            <span class="error"><?php echo $cityError; ?></span>
            <br>
            <label for="Status">Status:</label>
            <select name="Status" id="Status" required>
                <option value="active" <?php echo ($status === 'active') ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?php echo ($status === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
            </select>
            <span class="error"><?php echo $statusError; ?></span>
            <br>
            <button type="submit" onclick="return confirm('Are you sure you want to add this employee?');">Add Employee</button>
        </form>
        <a href="index.php">Cancel</a>
    </main>
</body>
</html>
