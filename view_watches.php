<?php
    require('dbinit.php');
    
    if (!empty($_GET['WatchID'])) {
        $watchID = $_GET['WatchID'];

        $deleteQuery = "DELETE FROM watches WHERE WatchID = ?";
        $stmt = mysqli_prepare($dbc, $deleteQuery);
        mysqli_stmt_bind_param($stmt, 'i', $watchID);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: view_watches.php");
            exit();
        } else {
            echo "Error deleting record.";
        }
    }

    $query = 'SELECT * FROM watches';
    $results = mysqli_query($dbc, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Watches</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <Header>
        <h1>Watch Inventory Management Portal</h1>
    </Header>
    <nav>
        <a href="insert_watch.php">Add new Watch</a>
        <a href="view_watches.php">View Watch Inventory</a>
    </nav>
    <table>
        <thead>
            <tr>
                <th>Watch ID</th>
                <th>Watch Name</th>
                <th>Watch Description</th>
                <th>Watch Category</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Product Added By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while ($row = mysqli_fetch_assoc($results)) {
                    echo "<tr>
                        <td>{$row['WatchID']}</td>
                        <td>{$row['WatchName']}</td>
                        <td>{$row['WatchDescription']}</td>
                        <td>{$row['WatchCategory']}</td>
                        <td>{$row['QuantityAvailable']}</td>
                        <td>{$row['Price']}</td>
                        <td>{$row['ProductAddedBy']}</td>
                        <td>
                            <a href='edit_watch.php?WatchID={$row['WatchID']}'>Edit</a> |
                            <a href='view_watches.php?WatchID={$row['WatchID']}'>Delete</a>
                        </td>
                    </tr>";
                }
            ?>
        </tbody>
    </table>
    
</body>
</html>
