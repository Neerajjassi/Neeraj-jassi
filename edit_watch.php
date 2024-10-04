<?php
    require('dbinit.php');
    $categories = array("Automatic", "Quartz", "Smart", "Mechanical", "Hybrid");
    $errors = [];

    if (isset($_GET['WatchID'])) {
        $watchID = $_GET['WatchID'];
        $query = "SELECT * FROM watches WHERE WatchID = ?";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param('i', $watchID);
        $stmt->execute();
        $result = $stmt->get_result();
        $watch = $result->fetch_assoc();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $watchName = !empty($_POST['watchName']) ? $_POST['watchName'] : null;
            $watchDescription = !empty($_POST['watchDescription']) ? $_POST['watchDescription'] : null;
            $watchCategory = !empty($_POST['watchCategory']) ? $_POST['watchCategory'] : null;
            $quantityAvailable = !empty($_POST['quantityAvailable']) ? $_POST['quantityAvailable'] : null;
            $price = !empty($_POST['price']) ? $_POST['price'] : null;

            if (!$watchName || !$watchDescription || !$watchCategory || !$quantityAvailable || !$price) {
                $errors[] = "All fields are required!";
            }

            if (empty($errors)) {
                $stmt = $dbc->prepare("UPDATE watches SET WatchName=?, WatchDescription=?, WatchCategory=?, QuantityAvailable=?, Price=? WHERE WatchID=?");
                $stmt->bind_param('sssdis', $watchName, $watchDescription, $watchCategory, $quantityAvailable, $price, $watchID);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    header('Location: view_watches.php');
                } else {
                    echo "Error updating watch!";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Watch</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <Header>
        <h1>Watch Inventory Management Portal</h1>
    </Header>
    <form method="POST" action="edit_watch.php?WatchID=<?php echo $watchID; ?>">
        <label for="watchName">Watch Name:</label>
        <input type="text" id="watchName" name="watchName" value="<?php echo $watch['WatchName']; ?>" required><br>

        <label for="watchDescription">Watch Description:</label>
        <textarea id="watchDescription" name="watchDescription" required><?php echo $watch['WatchDescription']; ?></textarea><br>

        <label for="watchCategory">Watch Category:</label>
        <select id="watchCategory" name="watchCategory">
            <option value="<?php echo $watch['WatchCategory']; ?>" selected><?php echo $watch['WatchCategory']; ?></option>
            <?php
                foreach($categories as $category){
                    if ($category != $watch['WatchCategory']) {
                        echo "<option value='$category'>$category</option>";
                    }
                }
            ?>
        </select>
        <br>

<label for="quantityAvailable">Quantity Available:</label>
<input type="number" id="quantityAvailable" name="quantityAvailable" value="<?php echo $watch['QuantityAvailable']; ?>" required><br>

<label for="price">Price:</label>
<input type="number" step="0.01" id="price" name="price" value="<?php echo $watch['Price']; ?>" required><br>

<button type="submit">Update Watch</button>
</form>

<a href="view_watches.php">Back to Watch List</a>
</body>
</html>
