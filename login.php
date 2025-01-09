<?php
session_start();
include("config.php");

if ($_POST) {
    $con = $db->prepare("SELECT * FROM user WHERE user_name = ? AND password = ?");

    $username = $_POST['username'];
    $password = md5(addslashes($_POST['password']));

    $con->execute(array($username, $password));
    $x = $con->fetch(PDO::FETCH_ASSOC);

    $d = $con->rowCount();
    if ($d) {
        $_SESSION['user_name'] = $x['user_name'];
        $_SESSION['user_ID'] = $x['user_ID'];
        $_SESSION['adminKey'] = $x['adminKey'];

        if ($_SESSION) {
            $sql = "SELECT shoppingcart_ID FROM shoppingcart WHERE UserID = ?";
            $con = $db->prepare($sql);
            $con->execute(array($_SESSION['user_ID']));
            $x = $con->fetch(PDO::FETCH_ASSOC);

            if (empty($x)) {
                $sql = "INSERT INTO shoppingcart (UserID, Date) VALUES (?, NOW())";
                $con = $db->prepare($sql);
                $con->execute(array($_SESSION['user_ID']));
            }

            echo "Welcome " . $_SESSION['user_name'] . "<br>" .
                "<button onclick=\"window.location.href='logout.php'\">Logout</button> " .
                "<button onclick=\"window.location.href='changeUserdata.php?user_ID=" . $_SESSION['user_ID'] . "'\">Change user information</button> " .
                "<button onclick=\"window.location.href='index.php?user_ID=" . $_SESSION['user_ID'] . "'\">Products</button>";

            if ($_SESSION['adminKey'] == 1) {
                echo "<button onclick=\"window.location.href='admin.php'\">Admin Panel</button>";
            }
        }
    } else {
        echo 'Incorrect password or username!';
        header("refresh:1");
    }
} else {
    echo '<form method="post" action="">
    <div>
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
            <td><button type="button" onclick="window.location.href=\'register.php\';">Register</button></td>
        </tr>
    </table>
    </div>
</form>';
}
?>