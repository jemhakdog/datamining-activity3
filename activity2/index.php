<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Records</title>
	<link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.*/css/pico.min.css">
</head>
<body>
    <main class="container">
        <h1>Employee Records</h1>

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



		echo "<h3>Active Employees</h3>";

        // Example Query
        $query = "SELECT * FROM employee WHERE Status='Active'";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "<table role='grid'>";
            echo "<thead><tr>
                    <th>EmployeeID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Hire Date</th>
                    <th>Salary</th>
                    <th>City</th>
                    <th>Status</th>
                  </tr></thead><tbody>";

            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['EmployeeID']}</td>
                        <td>{$row['FirstName']}</td>
                        <td>{$row['LastName']}</td>
                        <td>{$row['Department']}</td>
                        <td>{$row['Position']}</td>
                        <td>{$row['HireDate']}</td>
                        <td>{$row['Salary']}</td>
                        <td>{$row['City']}</td>
                        <td><ins>{$row['Status']}</ins></td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No records found.</p>";
        }
		
		
		 echo "<br/><br/><h3>Inactive Employees</h3>";
		 	
		
		
		// Example Query
        $query = "SELECT * FROM employee WHERE Status='Inactive'";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "<table role='grid'>";
            echo "<thead><tr>
                    <th>EmployeeID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Hire Date</th>
                    <th>Salary</th>
                    <th>City</th>
                    <th>Status</th>
                  </tr></thead><tbody>";

            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['EmployeeID']}</td>
                        <td>{$row['FirstName']}</td>
                        <td>{$row['LastName']}</td>
                        <td>{$row['Department']}</td>
                        <td>{$row['Position']}</td>
                        <td>{$row['HireDate']}</td>
                        <td>{$row['Salary']}</td>
                        <td>{$row['City']}</td>
                        <td><del>{$row['Status']}</del></td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No records found.</p>";
        }

        $conn->close();
        ?>
		
	<nav>
		<a href="filterbydepartment.php" role="button" class="outline">Filter by Department</a>
		<a href="sortbyfield.php" role="button" class="outline">Sort by Field</a>
		<a href="pagination.php" role="button" class="outline">Pagination</a>
		<a href="dynamictable.php" role="button" class="outline">Dynamic Table</a>
	</nav>
		
	
		
		
		
    </main>
</body>
</html>