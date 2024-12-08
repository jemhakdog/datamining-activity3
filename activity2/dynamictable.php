
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

        // Set records per page and calculate offset
        $recordsPerPage = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $recordsPerPage;

        // Determine sorting
        $sort = $_GET['sort'] ?? 'EmployeeID';
        $order = $_GET['order'] ?? 'ASC';
        $newOrder = ($order === 'ASC') ? 'DESC' : 'ASC';

        // Query with dynamic ORDER BY and LIMIT
        $query = "SELECT * FROM employee ORDER BY $sort $order LIMIT $recordsPerPage OFFSET $offset";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            echo "<table role='grid'>";
            echo "<thead><tr>
                    <th><a href='?sort=EmployeeID&order=$newOrder&page=$page'>EmployeeID</a></th>
                    <th><a href='?sort=FirstName&order=$newOrder&page=$page'>First Name</a></th>
                    <th><a href='?sort=LastName&order=$newOrder&page=$page'>Last Name</a></th>
                    <th><a href='?sort=Department&order=$newOrder&page=$page'>Department</a></th>
                    <th><a href='?sort=Position&order=$newOrder&page=$page'>Position</a></th>
                    <th><a href='?sort=HireDate&order=$newOrder&page=$page'>Hire Date</a></th>
                    <th><a href='?sort=Salary&order=$newOrder&page=$page'>Salary</a></th>
                    <th><a href='?sort=City&order=$newOrder&page=$page'>City</a></th>
                    <th><a href='?sort=Status&order=$newOrder&page=$page'>Status</a></th>
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

            // Get total number of records
            $totalQuery = "SELECT COUNT(*) AS total FROM employee";
            $totalResult = $conn->query($totalQuery);
            $totalRows = $totalResult->fetch_assoc()['total'];
            $totalPages = ceil($totalRows / $recordsPerPage);

            // Pagination controls
            echo "<nav><ul class='pagination'>";
            if ($page > 1) {
                echo "<li><a href='?page=" . ($page - 1) . "&sort=$sort&order=$order'>&laquo; Previous</a></li>";
            }
            if ($page < $totalPages) {
                echo "<li><a href='?page=" . ($page + 1) . "&sort=$sort&order=$order'>Next &raquo;</a></li>";
            }
            echo "</ul></nav>";
        } else {
            echo "<p>No records found.</p>";
        }

        $conn->close();
        ?>
		
		<p>Member 1 Mary Jane F.Dalas BSIT 3B<br>
        Member 2 Melisa ilumin Berdolaga BSIT 3B<br>
        Member 3 larry C. langadan BSIT 3B</p>
                
		
		
		<a href="index.php" role="button" class="secondary outline">Home</a>
    </main>
</body>
</html>
