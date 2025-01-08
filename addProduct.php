<?php
include("config.php");

if (isset($_POST['add'])) {
    try {
        $artikel_Name = htmlspecialchars($_POST['artikel_Name'], ENT_QUOTES, 'UTF-8');
        $amount = (int)$_POST['amount'];
        $price = (float)$_POST['price'];
        $artist_ID = (int)$_POST['artist_ID'];

        $artikel_IMG = null;

        if (isset($_FILES['artikel_IMG']) && $_FILES['artikel_IMG']['error'] == 0) {
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $targetFile = $targetDir . basename($_FILES["artikel_IMG"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if (getimagesize($_FILES["artikel_IMG"]["tmp_name"])) {
                if ($_FILES["artikel_IMG"]["size"] <= 5000000) {
                    if (move_uploaded_file($_FILES["artikel_IMG"]["tmp_name"], $targetFile)) {
                        $artikel_IMG = $targetFile;
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    echo "Sorry, your file is too large. Max size is 5MB.";
                }
            } else {
                echo "The uploaded file is not a valid image.";
            }
        }

        $stmt = $db->prepare("INSERT INTO artikel (artikel_Name, amount, artikel_IMG, price, artist_ID) 
                              VALUES (:artikel_Name, :amount, :artikel_IMG, :price, :artist_ID)");
        $stmt->bindParam(':artikel_Name', $artikel_Name, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
        $stmt->bindParam(':artikel_IMG', $artikel_IMG, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':artist_ID', $artist_ID, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: admin.php");
        exit;
    } catch (PDOException $e) {
        echo "Error adding article: " . htmlspecialchars($e->getMessage());
    }
}
?>

<form action="" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td><label for="artikel_Name">Artikel Name:</label></td>
            <td><input type="text" name="artikel_Name" id="artikel_Name" required></td>
        </tr>
        <tr>
            <td><label for="amount">Amount:</label></td>
            <td><input type="number" name="amount" id="amount" required></td>
        </tr>
        <tr>
            <td><label for="price">Price:</label></td>
            <td><input type="number" name="price" id="price" step="0.01" required></td>
        </tr>
        <tr>
            <td><label for="artist_ID">Artist:</label></td>
            <td>
                <select name="artist_ID" id="artist_ID" required>
                    <?php
                    try {
                        $stmt = $db->prepare("SELECT artist_ID, artist_name FROM artist");
                        $stmt->execute();
                        $artists = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($artists as $artist) {
                            echo '<option value="' . htmlspecialchars($artist['artist_ID'], ENT_QUOTES, 'UTF-8') . '">';
                            echo htmlspecialchars($artist['artist_name'], ENT_QUOTES, 'UTF-8');
                            echo '</option>';
                        }
                    } catch (PDOException $e) {
                        echo "Error fetching artists: " . htmlspecialchars($e->getMessage());
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="artikel_IMG">Artikel Image:</label></td>
            <td><input type="file" name="artikel_IMG" id="artikel_IMG"></td>
        </tr>
        <tr>
            <td><button type="submit" name="add">Add Artikel</button></td>
            <td><?php echo "<button onclick=\"window.location.href='admin.php'\">Return to admin</button> "?></td>
        </tr>
    </table>
</form>
