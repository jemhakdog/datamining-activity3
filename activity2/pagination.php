
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Records</title>
  <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.*/css/pico.min.css">
  <style>
    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 1rem;
    }
    .pagination a {
      padding: 5px 10px;
      border: 1px solid #ddd;
      margin-right: 5px;
      text-decoration: none;
    }
    .pagination a.active {
      background-color: #ddd;
    }
  </style>
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

      // Define variables for pagination
      $records_per_page = 10; // Number of records to show per page
      $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page from URL or set to 1
      $offset = ($current_page - 1) * $records_per_page; // Calculate offset for LIMIT clause

      // Example Query with LIMIT and OFFSET
      $query = "SELECT * FROM employee LIMIT $records_per_page OFFSET $offset";
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
                  <td>{$row['Status']}</td>
                </tr>";
        }
        echo "</tbody></table>";

        // Calculate total number of pages
        $total_records = $conn->query("SELECT COUNT(*) FROM employee")->fetch_assoc()['COUNT(*)']; // Count total records
        $total_pages = ceil($total_records / $records_per_page); // Calculate total pages

        // Display pagination links if there are more than one page
        if ($total_pages > 1) {
          echo "<div class='pagination'>";
          // Previous button
          if ($current_page > 1) {
            echo "<a href='?page=" . ($current_page - 1) . "'>Previous</a>";
          } else {
            echo "<a class='disabled'>Previous</a>";
          }
          // Next button
          if ($current_page < $total_pages) {
            echo "<a href='?page=" . ($current_page + 1) . "'>Next</a>";
          } else {
            echo "<a class='disabled'>Next</a>";
          }
          echo "</div>";
        }
      } else {
        echo "<p>No records found.</p>";
      }

      $conn->close();
    ?>
	
	<a href="index.php" role="button" class="secondary outline">Home</a>
  </main>
</body>
</html>