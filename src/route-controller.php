<?php

require_once "classes/Database.php";

$db = new Database("localhost", "hopchana", "World-On-Wheels1703!", "world-on-wheels");

require_once "classes/controllers/RouteController.php";
require_once "classes/models/RouteModel.php";
require_once "classes/views/RouteView.php";

$routeModel = new RouteModel($db);
$routeView = new RouteView();
global $routeController;
$routeController = new RouteController($routeModel, $routeView);