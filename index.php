<?php
include("config.php");

try {
    $con = $db->prepare("SELECT * FROM artikel");
    $con->execute();
    $articles = $con->fetchAll(PDO::FETCH_ASSOC);

    if (empty($articles)) {
        echo "<p>Er zijn momenteel geen artikelen beschikbaar.</p>";
    } else {
        foreach ($articles as $article) {
            ?>
            <div style="border:1px solid #ddd; height:300px; width:500px; margin:5px; padding:10px; float:left;">
                <h2 style="border:1px solid #ddd; background:pink; font-size: 14px; font-family: Verdana;">
                    <?php echo htmlspecialchars($article["name"], ENT_QUOTES, 'UTF-8'); ?>
                </h2>
                <p>
                    <?php echo nl2br(htmlspecialchars($article["description"], ENT_QUOTES, 'UTF-8')); ?>
                </p>
                <br>
                <a onclick="return confirm('Weet u zeker dat u dit product wilt verwijderen?');" 
                   href="deleteItem.php?id=<?php echo urlencode($article['id']); ?>">Verwijder item!</a>
            </div>
            <?php
        }
    }
} catch (PDOException $e) {
    echo "Fout bij het ophalen van artikelen: " . htmlspecialchars($e->getMessage());
}
?>
