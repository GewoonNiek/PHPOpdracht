<?php include("config.php"); $con=$db->prepare("insert into user set username=?, password=?, email=?");

$con = $db->prepare("insert into user set user_name=?, user_email=?, user_adress=?, user_zipcode=?, password=?");

if ($_POST) {
    $username = htmlspecialchars($_POST["username"], ENT_QUOTES);
    $password = md5(addslashes($_POST["password"]));
    $email = htmlspecialchars($_POST["email"], ENT_QUOTES);
    $adress = htmlspecialchars($_POST["address"], ENT_QUOTES);
    $zipcode = htmlspecialchars($_POST["zipcode"], ENT_QUOTES);
    

    if (!$username || !$password || !$email || !$adress || !$zipcode) {
        echo "All fields must be filled in...";
    } else {
        $x = $con->execute(array($username, $password, $email, $adress, $zipcode));

        if ($x) {
            echo "Registration finished! U are being sent to the main page";
            header("refresh:5; url=index.php");
        }
    }
}
?>

<form method="post" action="">
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
            <td>Email:</td>
            <td><input type="text" name="email"></td>
        </tr>
        <tr>
            <td>Address:</td>
            <td><input type="text" name="address"></td>
        </tr>
        <tr>
            <td>Zipcode:</td>
            <td><input type="text" name="zipcode"></td>
        </tr>
        <tr>
            <td><input type="submit" value="Submit"></td>
            <td><button type="button" onclick="Javascript:window.location.href = 'login.php';">Return to Login</button></td>
        </tr>
    </table>
</form>