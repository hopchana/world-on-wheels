<?php

require_once "classes/Database.php";

$db = new Database("localhost", "hopchana", "World-On-Wheels1703!", "world-on-wheels");

require_once "classes/controllers/UserController.php";
require_once "classes/models/UserModel.php";
require_once "classes/views/UserView.php";

$userModel = new UserModel($db);
$userView = new UserView();
$userController = new UserController($userModel, $userView);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['routeID']) && isset($_POST['comment'])) {
    $routeID = filter_input(INPUT_POST, 'routeID', FILTER_VALIDATE_INT);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_SPECIAL_CHARS);
    if ($userController->isUserLoggedIn())
    {
        $userID = $userController->getUserID();
        $userController->addComment($routeID, $userID, $comment);
        echo "<script type='text/javascript'>
                    window.location.href = document.referrer;
                </script>";
    }
}