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

        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search..." />
            <button type="submit">Search</button>
        </form>

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

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchQuery = $search ? "WHERE EmployeeID LIKE '%$search%' OR FirstName LIKE '%$search%' OR LastName LIKE '%$search%' OR Department LIKE '%$search%' OR Position LIKE '%$search%'" : '';

// Query with dynamic ORDER BY, LIMIT, and search
$query = "SELECT * FROM employee $searchQuery ORDER BY $sort $order LIMIT $recordsPerPage OFFSET $offset";
$result = $conn->query($query);

$successMessage = isset($_GET['success']) ? $_GET['success'] : '';
$errorMessage = isset($_GET['error']) ? $_GET['error'] : '';

if ($successMessage) {
    echo "<script>
            alert('$successMessage');
            window.history.replaceState({}, document.title, window.location.pathname);
          </script>";
}
if ($errorMessage) {
    echo "<script>
            alert('$errorMessage');
            window.history.replaceState({}, document.title, window.location.pathname);
          </script>";
}


if ($result && $result->num_rows > 0) {
    echo "<table role='grid'>";
    echo "<thead><tr>
            <th><a href='?sort=EmployeeID&order=$newOrder&page=$page'>EmployeeID</a></th>
            <th><a href='?sort=FirstName&order=$newOrder&page=$page'>First Name</a></th>
            <th><a href='?sort=LastName&order=$newOrder&page=$page'>Last Name</a></th>
            <th><a href='?sort=Department&order=$newOrder&page=$page'>Department</a></th>
            <th><a href='?sort=Position&order=$newOrder&page=$page'>Position</a></th>
            <th><a href='?sort=Salary&order=$newOrder&page=$page'>Salary</a></th>
            <th><a href='?sort=Status&order=$newOrder&page=$page'>Status</a></th>
            <th>Actions</th>
          </tr></thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['EmployeeID']}</td>
                <td>{$row['FirstName']}</td>
                <td>{$row['LastName']}</td>
                <td>{$row['Department']}</td>
                <td>{$row['Position']}</td>
                <td>{$row['Salary']}</td>
                <td>";
                    if ($row['Status'] === 'Inactive') {
                        echo "<del>{$row['Status']}</del>";
                    } else {
                        echo "<ins>{$row['Status']}</ins>";
                    }
        echo    "</td>
                <td>
                        <a href='edit.php?id={$row['EmployeeID']}'>Edit</a>
                    <a href='delete.php?id={$row['EmployeeID']}'>Delete</a>
                </td>
              </tr>";
    }
    echo "</tbody></table>";

    // Get total number of records
    $totalQuery = "SELECT COUNT(*) AS total FROM employee $searchQuery";
    $totalResult = $conn->query($totalQuery);
    $totalRows = $totalResult->fetch_assoc()['total'];
    $totalPages = ceil($totalRows / $recordsPerPage);

    // Enhanced pagination controls
    echo "<nav><ul class='pagination' style='display: inline;'>";

    // Displaying 'Previous' button
    if ($page > 1) {
        echo "<li><a href='?page=" . ($page - 1) . "&sort=$sort&order=$order&search=$search'>&laquo; Previous</a></li>";
    }

    // Display links dynamically centered around the current page
    for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++) {
            if ($i === $page) {
                echo "<li><a href='#' class='active'>$i</a></li>";
            } else {
                echo "<li><a href='?page=$i&sort=$sort&order=$order&search=$search'>$i</a></li>";
            }
        }

    // Adding ellipses if there are pages outside the immediate range
    if ($page > 3) {
        echo "<li><span>...</span></li>";
    }
    if ($page < $totalPages - 2) {
        echo "<li><span>...</span></li>";
    }

    // Displaying 'Next' button
    if ($page < $totalPages) {
        echo "<li><a href='?page=" . ($page + 1) . "&sort=$sort&order=$order&search=$search'>Next &raquo;</a></li>";
    }
    echo "</ul>";

    // Jump to page functionality on the same line as pagination
    echo "<span style='margin-left: 15px;'>Jump to page: <select style='display: inline;' onchange='location = this.value;'>";
    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<option value='?page=$i&sort=$sort&order=$order&search=$search'" . ($i === $page ? " selected" : "") . ">$i</option>";
    }
    echo "</select></span></nav>";
} else {
    echo "<p>No records found.</p>";
}

$conn->close();
?>
        
        <p>
        <a href="add.php" role="button" class="secondary outline">Add New Employee</a>
        </p>
        <p>Member 1 Jem Carlo Austria<br>
        Member 2 Maryjane Dalas<br>
        Member 3 Trisha Billones<br>
        Member 4 Erika Mae Tamondong<br>
        Member 5 Joy Deguzman</p>
    </main>
</body>
</html>
