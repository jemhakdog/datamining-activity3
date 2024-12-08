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

        // Determine sorting
        $sort = $_GET['sort'] ?? 'FirstName';  // Default sort column
        $order = $_GET['order'] ?? 'ASC';     // Default sort order
        $newOrder = ($order === 'ASC') ? 'DESC' : 'ASC';  // Toggle order

        // Ensure the sort column is a valid field
        $allowedSortFields = ['EmployeeID', 'FirstName', 'LastName', 'Department', 'Position', 'HireDate', 'Salary', 'City', 'Status'];
        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'LastName';
        }

        // Query with dynamic ORDER BY
        $query = "SELECT * FROM employee ORDER BY $sort $order";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "<table role='grid'>";
            echo "<thead><tr>
                    <th><a href='?sort=EmployeeID&order=$newOrder'>EmployeeID</a></th>
                    <th><a href='?sort=FirstName&order=$newOrder'>First Name</a></th>
                    <th><a href='?sort=LastName&order=$newOrder'>Last Name</a></th>
                    <th><a href='?sort=Department&order=$newOrder'>Department</a></th>
                    <th><a href='?sort=Position&order=$newOrder'>Position</a></th>
                    <th><a href='?sort=HireDate&order=$newOrder'>Hire Date</a></th>
                    <th><a href='?sort=Salary&order=$newOrder'>Salary</a></th>
                    <th><a href='?sort=City&order=$newOrder'>City</a></th>
                    <th><a href='?sort=Status&order=$newOrder'>Status</a></th>
                  </tr></thead><tbody>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['EmployeeID']}</td>
                        <td>{$row['FirstName']}</td>
                        <td>{$row['LastName']}</td>
                        <td>{$row['Department']}</td>
                        <td>{$row['Position']}</td>
                        <td>{$row['HireDate']}</td>
                        <td>{$row['Salary']}</td>
                        <td>{$row['City']}</td>
                        <td>{$row['Status']}</td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No records found.</p>";
        }

        $conn->close();
        ?>
		
		<a href="index.php" role="button" class="secondary outline">Home</a>
    </main>
</body>
</html>
