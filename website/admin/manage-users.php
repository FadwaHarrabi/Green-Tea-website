<?php
include '../components/connection.php';
session_start();

// Getting users data
$getUsersQuery = "SELECT * FROM users";
$runUsersQuery = $conn->query($getUsersQuery);

if (!$runUsersQuery) {
    // Handle the error if the query fails
    echo "Error: " . $conn->error;
} else {
    // Proceed with fetching and displaying user data
    unset($_POST['submit']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../styles/admin-basic.css">
    <link rel="stylesheet" href="../styles/admin-manage-users.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="side-bar">
        <a href="dashboard.php" class="logo"><img src="../img/logo.jpg" alt=""></a>
        
        <ul>
                <li onclick="location.href='dashboard.php'">Dashboard</li>
                <li onclick="location.href='manage-products.php'">Manage Products</li>
                <li onclick="location.href='manage-users.php'">Manage Users</li>
                <li onclick="location.href='manage-orders.php'">Manage Orders</li>
                <li onclick="location.href='manage-contact.php'">Manage Contact</li>
                <li onclick="location.href='chart.php'">chart</li>
                <li onclick="location.href='../home.php'">Logout</li>
            </ul>
    </div>
        <div class="users-container">
            <h1>Manage Users</h1>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($rowUser = $runUsersQuery->fetch(PDO::FETCH_ASSOC)) {
                        $userName = $rowUser['name'];
                        $userEmail = $rowUser['email'];
                        $userType = $rowUser['user_type'];
                    ?>
                    <tr>
                        <td><?php echo $userName; ?></td>
                        <td><?php echo $userEmail; ?></td>
                        <td><?php echo $userType; ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../scripts/admin.js"></script>
</body>
</html>


<?php
}
?>
