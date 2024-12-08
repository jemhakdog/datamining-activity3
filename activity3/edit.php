
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
$employeeID = $firstName = $lastName = $middleName = $department = $position = $salary = $city = $status = $hireDate = $age = $email = '';
$employeeIDError = $firstNameError = $lastNameError = $middleNameError = $departmentError = $positionError = $salaryError = $cityError = $statusError = $hireDateError = $ageError = $emailError = '';
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
}

// Update employee record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form inputs
    if (empty($_POST['EmployeeID'])) {
        $employeeIDError = "Employee ID is required";
    } else {
        $employeeID = $_POST['EmployeeID'];
    }

    $fields = [
        'FirstName' => &$firstName,
        'LastName' => &$lastName,
        'MiddleName' => &$middleName,
        'Department' => &$department,
        'Position' => &$position,
        'Salary' => &$salary,
        'City' => &$city,
        'Status' => &$status,
        'HireDate' => &$hireDate,
        'Age' => &$age,
        'Email' => &$email,
    ];

    $errors = [
        'FirstName' => &$firstNameError,
        'LastName' => &$lastNameError,
        'MiddleName' => &$middleNameError,
        'Department' => &$departmentError,
        'Position' => &$positionError,
        'Salary' => &$salaryError,
        'City' => &$cityError,
        'Status' => &$statusError,
        'HireDate' => &$hireDateError,
        'Age' => &$ageError,
        'Email' => &$emailError,
    ];

    foreach ($fields as $field => &$value) {
        if (empty($_POST[$field])) {
            $errors[$field] = "$field is required";
        } else {
            $value = $_POST[$field];
        }
    }

    if (empty($employeeIDError) && empty($firstNameError) && empty($lastNameError) && empty($middleNameError) && empty($departmentError) && empty($positionError) && empty($salaryError) && empty($cityError) && empty($statusError) && empty($hireDateError) && empty($ageError) && empty($emailError)) {
        $updateQuery = "UPDATE employee SET FirstName=?, LastName=?, MiddleName=?, Department=?, Position=?, Salary=?, City=?, Status=?, HireDate=?, Age=?, Email=? WHERE EmployeeID=?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param(
            "ssssssdssssi",
            $firstName,
            $lastName,
            $middleName,
            $department,
            $position,
            $salary,
            $city,
            $status,
            $hireDate,
            $age,
            $email,
            $employeeID
        );
        ob_start();

        // Execute update
        if ($updateStmt->execute()) {
            ob_clean(); // Clear buffer before redirecting
            $successMessage = "Employee updated successfully";
            header("Location: index.php?success=" . urlencode($successMessage));
            exit();
        } else {
            $errorMessage = "Error updating employee: " . $conn->error;
            echo  $errorMessage;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.*/css/pico.min.css">
</head>
<body>
    <main class="container">
        <h1>Edit Employee</h1>
        <?php if ($successMessage): ?>
            <p class="success"><?php echo $successMessage; ?></p>
        <?php endif; ?>
        <?php if ($errorMessage): ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <form method="POST">
            <label>Employee ID:</label>
            <input type="text" name="EmployeeID" value="<?php echo htmlspecialchars($employee['EmployeeID']); ?>" required readonly>
            <span class="error"><?php echo $employeeIDError; ?></span>
            <br>
            <label>First Name:</label>
            <input type="text" name="FirstName" value="<?php echo htmlspecialchars($employee['FirstName']); ?>" required>
            <span class="error"><?php echo $firstNameError; ?></span>
            <br>
            <label>Last Name:</label>
            <input type="text" name="LastName" value="<?php echo htmlspecialchars($employee['LastName']); ?>" required>
            <span class="error"><?php echo $lastNameError; ?></span>
            <br>
            <label>Middle Name:</label>
            <input type="text" name="MiddleName" value="<?php echo htmlspecialchars($employee['MiddleName']); ?>" required>
            <span class="error"><?php echo $middleNameError; ?></span>
            <br>
            <label>Department:</label>
            <select name="Department" required>
                <option value="">Select Department</option>
                <?php
                // Fetch all available departments from the database
                $departmentsQuery = "SELECT DISTINCT Department FROM employee";
                $departmentsResult = $conn->query($departmentsQuery);
                if ($departmentsResult->num_rows > 0):
                    while ($row = $departmentsResult->fetch_assoc()):
                ?>
                    <option value="<?php echo htmlspecialchars($row['Department']); ?>"
                        <?php echo (isset($employee['Department']) && $employee['Department'] === $row['Department']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['Department']); ?>
                    </option>
                <?php
                    endwhile;
                endif;
                ?>
            </select>
            <span class="error"><?php echo $departmentError; ?></span>
            <br>
            <label>Position:</label>
            <select name="Position" required>
                <option value="">Select Position</option>
                <?php
                // Fetch all available positions from the database
                $positionsQuery = "SELECT DISTINCT Position FROM employee";
                $positionsResult = $conn->query($positionsQuery);
                if ($positionsResult->num_rows > 0):
                    while ($row = $positionsResult->fetch_assoc()):
                ?>
                    <option value="<?php echo htmlspecialchars($row['Position']); ?>"
                        <?php echo (isset($employee['Position']) && $employee['Position'] === $row['Position']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['Position']); ?>
                    </option>
                <?php
                    endwhile;
                endif;
                ?>
            </select>
            <span class="error"><?php echo $positionError; ?></span>
            <br>
            <label>Salary:</label>
            <input type="number" name="Salary" value="<?php echo htmlspecialchars($employee['Salary']); ?>" required>
            <span class="error"><?php echo $salaryError; ?></span>
            <br>
            <label>Hire Date:</label>
            <input type="date" name="HireDate" value="<?php echo htmlspecialchars($employee['HireDate']); ?>" required>
            <span class="error"><?php echo $hireDateError; ?></span>
            <br>
            <label>Age:</label>
            <input type="number" name="Age" value="<?php echo htmlspecialchars($employee['Age']); ?>" required>
            <span class="error"><?php echo $ageError; ?></span>
            <br>
            <label>City:</label>
            <input type="text" name="City" value="<?php echo htmlspecialchars($employee['City']); ?>" required>
            <span class="error"><?php echo $cityError; ?></span>
            <br>
            <label>Email:</label>
            <input type="email" name="Email" value="<?php echo htmlspecialchars($employee['Email']); ?>" required>
            <span class="error"><?php echo $emailError; ?></span>
            <br>
            <label>Status:</label>
            <select name="Status" required>
                <option value="Active" <?php echo $employee['Status'] === 'Active' ? 'selected' : ''; ?>>Active</option>
                <option value="Inactive" <?php echo $employee['Status'] === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
            </select>
            <span class="error"><?php echo $statusError; ?></span>
            <br>
        <button type="submit" onclick="return confirm('Are you sure you want to update this employee record?');">Update</button>
    </form>
    <a href="index.php">Cancel</a>
</main>
</body>
</html>