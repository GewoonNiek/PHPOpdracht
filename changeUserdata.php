<?php
include("config.php");
session_start();


$con = $db->prepare('select * from user where user_ID=?');
$con->execute(array($id));
$id = $_GET['user_ID'];

$x = $con->fetch(PDO::FETCH_ASSOC);

if ($_POST) {
    $username = htmlspecialchars($_POST['user_name'], ENT_QUOTES);
    $password = md5(addslashes($_POST['password']));
    $email = htmlspecialchars($_POST['user_email'], ENT_QUOTES);
    $zipcode = htmlspecialchars($_POST['user_zipcode'], ENT_QUOTES);
    $adress = htmlspecialchars($_POST['user_adress'], ENT_QUOTES);

    $query = $db->prepare('update user set user_name=?, password=?, user_email=?, user_adress=?, user_zipcode=? where user_ID=?');
    $z = $query->execute(array($username, $password, $email, $adress, $zipcode, $id));


    if ($z) {
        echo 'Changes made successfully! You will get redirected shortly...';
        header("refresh:2;url=index.php");
    } else {
        echo 'Something went wrong!';
    }
} else {
    if ($_SESSION['user_ID'] == $id) {
        echo '<form action="" method="post">
    <table>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="user_name" value="' . $x['user_name'] . '"></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" value="' . $x['password'] . '"></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="text" name="user_email" value="' . $x['user_email'] . '"></td>
        </tr>
        <tr>
            <td>Address:</td>
            <td><input type="text" name="user_adress" value="' . $x['user_adress'] . '"></td>
        </tr>
        <tr>
            <td>Zipcode:</td>
            <td><input type="text" name="user_zipcode" value="' . $x['user_zipcode'] . '"></td>
        </tr>
        <tr>
            <td><input type="submit" value="Update info"></td>
        </tr>

</form>';
    } else {
        echo 'Page not found!';
    }
}
?>