<?php
include("config.php");

try {
    $con = $db->prepare("SELECT * FROM artikel");
    $con->execute();
    $articles = $con->fetchAll(PDO::FETCH_ASSOC);

    echo "<button onclick=\"window.location.href='logout.php'\">Logout</button>" . 
    "<button onclick=\"window.location.href='addProduct.php'\">Add product</button>" . "<br>";

    if (empty($articles)) {
        echo "<p>Er zijn momenteel geen artikelen beschikbaar.</p>";
    } else {
        foreach ($articles as $article) {
            ?>
            <div style="border:1px solid #ddd; height:200px; width:500px; margin:5px; padding:10px; float:left;">
                <h2 style="border:1px solid #ddd; background:pink; font-size: 14px; font-family: Verdana;">
                    <?php echo htmlspecialchars($article["artikel_Name"] . " - ", ENT_QUOTES, 'UTF-8'); ?>
                    <?php echo htmlspecialchars("Stock: " . $article["amount"], ENT_QUOTES, 'UTF-8'); ?>
                    <div style="float: right;">
                        <?php echo htmlspecialchars("Price: " . $article["price"] . "€", ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                </h2>
                <br>
                <?php if (!empty($article['artikel_IMG'])) { ?>
                <img src="<?php echo htmlspecialchars($article['artikel_IMG'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image"
                style="width:100%; height:100%; max-width:100px; max-height:100px; object-fit:cover;">
                <?php } else { ?>
                <p>No image available.</p>
                <?php } ?>

                <form action="remove_article.php" method="POST" style="float: right;">
                    <input type="hidden" name="artikel_ID" value="<?php echo intval($article['artikel_ID']); ?>">
                    <button type="submit" name="remove" style="border:1px solid #ddd; background: red; color:white;">
                        Remove
                    </button>
                </form>
            </div>
            <?php
        }
    }
} catch (PDOException $e) {
    echo "Error fetching articles: " . htmlspecialchars($e->getMessage());
}
?>
