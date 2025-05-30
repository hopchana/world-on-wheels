<?php

require_once "Controller.php";

class RouteController extends Controller
{
    public function generateCards($userID = null) {
        if ($userID) {
            $routesId = $this->model->getRoutesID('where user_id = ' . $userID);
        } else {
            $routesId = $this->model->getRoutesID('JOIN route_views ON route.id = route_views.route_id order by views desc');
        }
        foreach ($routesId as $routeId) {
            $routeData = $this->model->getCardRouteData($routeId);
            $this->view->generateCard($routeData);
        }
        if ($likedRoutesID = $this->model->getLikedRoutesID()) {
            $this->view->addLikedClassToButtons($likedRoutesID);
        }
    }

    public function generateFavoriteCards() {
        $likedRoutesID = $this->model->getLikedRoutesID();
        if ($likedRoutesID) {
            foreach ($likedRoutesID as $routeId) {
                $routeData = $this->model->getCardRouteData($routeId);
                $this->view->generateCard($routeData);
            }
            $this->view->addLikedClassToButtons($likedRoutesID);
        } else {
            $this->view->nothingIsHere();
        }
    }

    public function generateMoreInfo($id) {
        if ($routeData = $this->model->getRouteData($id)) {
            $this->model->addView($id);
            $this->view->showInfo($routeData);
        } else {
            header("Location: 404.php");
        }
    }
    public function generateForm() {
        $this->view->showForm();
    }

    public function submitForm() {
        $data = $this->model->validate();
        // Check if there are any errors
        if (empty($data['errors'])) {
            // Display success message
            echo "Form submitted successfully!";
            // Process the data
            $this->model->toDatabase($data['data']);
        } else {
            // Display errors
            foreach ($data['errors'] as $error) {
                echo "<p><b>Error:</b> $error</p>";
            }
        }
    }

    function generateTop3Routes()
    {
        $top3RoutesName = [];
        $top3RoutesID = $this->model->getTop3RoutesID();
        foreach ($top3RoutesID as $topRouteID) {
            $routeName = $this->model->getRouteName($topRouteID);
            $top3RoutesName[] = $routeName;
        }
        return $this->view->showTop3Routes($top3RoutesID, $top3RoutesName);
    }

    function generateTop3RoutesCards()
    {
        $top3RoutesID = $this->model->getTop3RoutesID();
        foreach ($top3RoutesID as $routeID) {
            $routeData = $this->model->getCardRouteData($routeID);
            $this->view->generateCard($routeData);
        }
        if ($likedRoutesID = $this->model->getLikedRoutesID()) {
            $this->view->addLikedClassToButtons($likedRoutesID);
        }
    }

    function likeRoute($routeID, $userID)
    {
        $this->model->likeRoute($routeID, $userID);
    }

    function deleteRoute($id)
    {
        $this->model->deleteRoute($id);
    }

}