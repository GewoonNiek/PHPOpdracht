<?php
session_start();
include("config.php");

if ($_POST) {
    $con = $db->prepare("select * from user where username=? and password=?");

    $username = $_POST['username'];
    $password = md5(addslashes($_POST['password']));

    $con->execute(array($username, $password));
    $x = $con->fetch(PDO::FETCH_ASSOC);

    $d = $con->rowCount();
    if ($d) {
        $_SESSION['username'] = $x['username'];
        $_SESSION['id'] = $x['id'];
        $_SESSION['role'] = $x['role'];
    } else {
        echo 'Incorrect password or username!';
    }

    if ($_SESSION) {
        echo "Welcome " . $_SESSION['username'] . " <a href='logout.php'>Logout</a>
        <a href='change.php?id=" . $_SESSION['id'] . "'>Change user information</a>";
        if ($_SESSION['role'] == 1) {
            echo " <a href='admin.php'>Admin Panel</a>";
        }
    }
} else {
    echo '<form method="post" action="">
    <table>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="username"></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <td><input type="submit" value="Login"></td>
        </tr>
    </table>
</form>';
}
?>