<?php

require_once "classes/Database.php";

$db = new Database("localhost", "hopchana", "World-On-Wheels1703!", "world-on-wheels");

require_once "classes/controllers/RouteController.php";
require_once "classes/models/RouteModel.php";
require_once "classes/views/RouteView.php";

$routeModel = new RouteModel($db);
$routeView = new RouteView();
$routeController = new RouteController($routeModel, $routeView);

require_once "classes/controllers/UserController.php";
require_once "classes/models/UserModel.php";
require_once "classes/views/UserView.php";

$userModel = new UserModel($db);
$userView = new UserView();
$userController = new UserController($userModel, $userView);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['routeID'])) {
    $routeID = filter_input(INPUT_POST, 'routeID', FILTER_VALIDATE_INT);
    if ($userController->isUserLoggedIn())
    {
        $userID = $userController->getUserID();
        $routeController->likeRoute($routeID, $userID);
        echo "<script type='text/javascript'>
                    window.location.href = document.referrer;
                </script>";
    }
}
