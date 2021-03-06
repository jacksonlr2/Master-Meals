<?php
session_start();
require_once('connection.php');

$username = $_POST['username'];
$password   = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmtselect = $conn->prepare($sql);
$result = $stmtselect->execute([$username]);

if($result){
    $user = $stmtselect->fetch(PDO::FETCH_ASSOC);
    $user_id = $user['user_id'];

    $sql3 = "SELECT * FROM users_viewer WHERE user_viewer_id = $user_id";
    $viewerselect = $conn->prepare($sql3);
    $result3 = $viewerselect->execute();

    if($viewerselect->rowCount() > 0 AND password_verify($password, $user['password'])){
        $_SESSION['userlogin'] = $user;
    }
    else{
        echo "The username/password you entered is incorrect.";
    }
}
else{
    echo "There were errors while connecting to the database.";
}