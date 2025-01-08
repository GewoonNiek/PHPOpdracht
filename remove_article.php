<?php
include("config.php");

if (isset($_POST['remove']) && isset($_POST['artikel_ID'])) {
    try {
        $artikel_ID = intval($_POST['artikel_ID']);
        
        $stmt = $db->prepare("DELETE FROM artikel WHERE artikel_ID = :artikel_ID");
        $stmt->bindParam(':artikel_ID', $artikel_ID, PDO::PARAM_INT);
        $stmt->execute();
        
        header("Location: admin.php");
        exit;
    } catch (PDOException $e) {
        echo "Fout bij het verwijderen van artikel: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "Invalid request.";
}
?>