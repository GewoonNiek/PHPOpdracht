<?php
include("config.php");

if (isset($_GET['artikel_ID'])) {
    try {
        $id = intval($_GET['artikel_ID']);
        
        $stmt = $db->prepare("SELECT artikel_IMG FROM artikel WHERE artikel_ID = :artikel_ID");
        $stmt->bindParam(':artikel_ID', $id, PDO::PARAM_INT);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($article && !empty($article['artikel_IMG'])) {
            header("Content-Type: image/jpeg");
            echo $article['artikel_IMG'];
        } else {
            echo "Image not found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "No image ID provided.";
}
?>
