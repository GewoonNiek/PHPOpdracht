<?php
include("config.php");

$con1 = $db->prepare("insert into song set SongName=?");
$con2 = $db->prepare("insert into artist set artist_name=?");

if ($_POST) {
    $product_name = htmlspecialchars($_POST["product_name"], ENT_QUOTES);

    $artist = htmlspecialchars($_POST["artist"], ENT_QUOTES);
    $song = htmlspecialchars($_POST["address"], ENT_QUOTES);


    if (!$product_name || !$artist || !$song) {
        echo "All fields must be filled in...";
    } else {
        $x = $con1->execute(array($song));
        $x2 = $con1->execute(array($artist));


        if ($x && $x2) {
            echo "Product added! U are being sent to the main page";
            header("refresh:5; url=index.php");
        }
    }
}
?>

<form method="post" action="">
    <table>
        <tr>
            <td>Product name:</td>
            <td><input type="text" name="product_name"></td>
        </tr>
        <tr>
            <td>Artist:</td>
            <td><input type="text" name="artist"></td>
        </tr>
        <tr>
            <td>Song:</td>
            <td><input type="text" name="song"></td>
        </tr>
        <tr>
            <td><input type="submit" value="Submit"></td>
            <td><button type="button" onclick="Javascript:window.location.href = 'index.php';">Submit</button></td>
        </tr>
    </table>
</form>