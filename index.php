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
            <div style="border:1px solid #ddd; height:200px; width:500px; margin:5px; padding:10px; float:left;">
                <h2 style="border:1px solid #ddd; background:pink; font-size: 14px; font-family: Verdana;">
                    <?php echo htmlspecialchars($article["artikel_Name"] . " - ", ENT_QUOTES,'UTF-8'); ?>
                    <?php echo htmlspecialchars("Stock: ". $article["amount"], ENT_QUOTES, 'UTF-8'); ?>
                </h2>
                <?php if (!empty($article["artikel_IMG"])) { ?>
                    <img src="<?php echo htmlspecialchars($article["artikel_IMG"], ENT_QUOTES, 'UTF-8'); ?>" 
                         alt="Image" style="max-width:100%; max-height:100px;">
                <?php } else { ?>
                    <p>No image available.</p>
                <?php } ?>
            </div>
            <?php
        }
    }
} catch (PDOException $e) {
    echo "Fout bij het ophalen van artikelen: " . htmlspecialchars($e->getMessage());
}
?>
