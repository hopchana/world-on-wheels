<?php

require_once "classes/Database.php";

$db = new Database("localhost", "hopchana", "World-On-Wheels1703!", "world-on-wheels");

require_once "classes/controllers/UserController.php";
require_once "classes/models/UserModel.php";
require_once "classes/views/UserView.php";

$userModel = new UserModel($db);
$userView = new UserView();
$userController = new UserController($userModel, $userView);
