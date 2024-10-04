<?php
    require('dbinit.php');
    $categories = array("Automatic", "Quartz", "Smart", "Mechanical", "Hybrid");
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $watchName = !empty($_POST['watchName']) ? $_POST['watchName'] : null;
        $watchDescription = !empty($_POST['watchDescription']) ? $_POST['watchDescription'] : null;
        $watchCategory = !empty($_POST['watchCategory']) ? $_POST['watchCategory'] : null;
        $quantityAvailable = !empty($_POST['quantityAvailable']) ? $_POST['quantityAvailable'] : null;
        $price = !empty($_POST['price']) ? $_POST['price'] : null;
        $productAddedBy = "Neeraj jassi"; 

        if (!$watchName) {
            $errors[] = "<p>Watch Name is required!</p>";
        }
        if (!$watchDescription) {
            $errors[] = "<p>Watch Description is required!</p>";
        }
        if (!$watchCategory) {
            $errors[] = "<p>Watch Category is required!</p>";
        }
        if (!$quantityAvailable || !is_numeric($quantityAvailable)) {
            $errors[] = "<p>Quantity must be a valid number!</p>";
        }
        if (!$price || !is_numeric($price)) {
            $errors[] = "<p>Price must be a valid decimal number!</p>";
        }

        if (empty($errors)) {
            $stmt = $dbc->prepare("INSERT INTO watches (WatchName, WatchDescription, WatchCategory, QuantityAvailable, Price, ProductAddedBy)
                                   VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssdss', $watchName, $watchDescription, $watchCategory, $quantityAvailable, $price, $productAddedBy);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header('Location: view_watches.php');
            } else {
                echo "Error inserting watch!";
            }
        } else {
            foreach ($errors as $error) {
                echo $error;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Watch</title>
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
    <form method="POST" action="insert_watch.php">
        <label for="watchName">Watch Name:</label>
        <input type="text" id="watchName" name="watchName" required><br>

        <label for="watchDescription">Watch Description:</label>
        <textarea id="watchDescription" name="watchDescription" required></textarea><br>

        <label for="watchCategory">Watch Category:</label>
        <select id="watchCategory" name="watchCategory">
            <option value="" disabled selected>Select a category</option>
            <?php
                foreach($categories as $category){
                    echo "<option value='$category'>$category</option>";
                }
            ?>
        </select><br>

        <label for="quantityAvailable">Quantity Available:</label>
        <input type="number" id="quantityAvailable" name="quantityAvailable" required><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required><br>

        <button type="submit">Add Watch</button>
    </form>
    
</body>
</html>
