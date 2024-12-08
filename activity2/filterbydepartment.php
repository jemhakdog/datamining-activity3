<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Query Display</title>
  <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.*/css/pico.min.css">
</head>
<body>

    <header class="container">
        <h1>Employee Data Filtered by Department</h1>
    </header>

    <main class="container">
        <form method="POST">
            <label for="query">Department:</label>
            <select name="query" id="query" required>
			<option value="none">Choose</option>
                <option value="IT">IT</option>
                <option value="HR">HR</option>
                <option value="Finance">Finance</option>
                <option value="Marketing">Marketing</option>
                <option value="Logistics">Logistics</option>
                <option value="Operations">Operations</option>
            </select>
            <button type="submit">View</button>
        </form>

        <?php
        // Database connection
        $conn = new mysqli("localhost", "root", "", "datamining2024"); 
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $queryType = $_POST['query'];
            $sql = "";

            // Construct SQL based on query type
            switch ($queryType) {
                case 'IT':
                    $sql = "SELECT * FROM employee WHERE Department='IT'";
                    break;
                case 'HR':
                    $sql = "SELECT * FROM employee WHERE Department='HR'";
                    break;
                case 'Finance':
                    $sql = "SELECT * FROM employee WHERE Department='Finance'";
                    break;
                case 'Marketing':
                    $sql = "SELECT * FROM employee WHERE Department='Marketing'";
                    break;
                case 'Logistics':
                    $sql = "SELECT * FROM employee WHERE Department='Logistics'";
                    break;
                case 'Operations':
                    $sql = "SELECT * FROM employee WHERE Department='Operations'";
                    break;
                default:
                    echo "<p>Select a Department</p>";
                    exit;
            }

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                echo "<table>";
                echo "<thead><tr>
                        <th>EmployeeID</th>
                        <th>Employee Name</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Hire Date</th>
                        <th>Salary</th>
                        <th>Age</th>
                        <th>Email</th>
                        <th>Status</th>
                      </tr></thead>";
                echo "<tbody>";
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['EmployeeID'] . "</td>";
                    echo "<td>" . $row['FirstName'] ." ". $row['LastName'] ."</td>";
                    echo "<td>" . $row['Department'] . "</td>";
                    echo "<td>" . $row['Position'] . "</td>";
                    echo "<td>" . $row['HireDate'] . "</td>";
                    echo "<td>" . $row['Salary'] . "</td>";
                    echo "<td>" . $row['Age'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "</tr>";
                }
                
                echo "</tbody></table>";
            } else {
                echo "<p>No results found.</p>";
            }
            
            $result->free();
        }

        $conn->close();
        ?>
		
		<a href="index.php" role="button" class="secondary outline">Home</a>
    </main>
</body>
</html>