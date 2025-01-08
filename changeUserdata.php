<?php
include("config.php");
session_start();

$id = $_SESSION['user_ID'];
$con = $db->prepare('SELECT * FROM user WHERE user_ID = ?');
$con->execute(array($id));
$x = $con->fetch(PDO::FETCH_ASSOC);

if ($_POST) {
    $username = htmlspecialchars($_POST['user_name'], ENT_QUOTES);
    $email = htmlspecialchars($_POST['user_email'], ENT_QUOTES);
    $zipcode = htmlspecialchars($_POST['user_zipcode'], ENT_QUOTES);
    $adress = htmlspecialchars($_POST['user_adress'], ENT_QUOTES);

    if (!empty($_POST['password'])) {
        $password = md5(addslashes($_POST['password']));
    } else {
        $password = $x['password'];
    }

    if (empty($username) || empty($email) || empty($zipcode) || empty($adress)) {
        echo 'All fields except password are required! Please fill out all the required fields.';
    } else {
        $query = $db->prepare('UPDATE user SET user_name = ?, password = ?, user_email = ?, user_adress = ?, user_zipcode = ? WHERE user_ID = ?');
        $z = $query->execute(array($username, $password, $email, $adress, $zipcode, $id));

        if ($z) {
            echo 'Changes made successfully! You will get redirected shortly...';
            header("refresh:2;url=index.php");
            exit;
        } else {
            echo 'Something went wrong!';
        }
    }
}

if ($_SESSION['user_ID'] == $id) {
    echo '<form action="" method="post">
    <table>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="user_name" value="' . htmlspecialchars($x['user_name'], ENT_QUOTES) . '"></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password"></td>
            <td>leave empty to keep current password</td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="text" name="user_email" value="' . htmlspecialchars($x['user_email'], ENT_QUOTES) . '"></td>
        </tr>
        <tr>
            <td>Address:</td>
            <td><input type="text" name="user_adress" value="' . htmlspecialchars($x['user_adress'], ENT_QUOTES) . '"></td>
        </tr>
        <tr>
            <td>Zipcode:</td>
            <td><input type="text" name="user_zipcode" value="' . htmlspecialchars($x['user_zipcode'], ENT_QUOTES) . '"></td>
        </tr>
        <tr>
            <td><input type="submit" value="Update info"></td>
        </tr>
    </table>
</form>';
} else {
    echo 'Page not found!';
}
?>