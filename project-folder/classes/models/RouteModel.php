<?php

require_once "Model.php";

class RouteModel extends Model
{

    function getRouteData($id)
    {
        if ($this->exist('route', 'id', $id)) {
            $cardData = $this->getCardRouteData($id);

            $long_description = $this->db->select('route', 'long_description', 'where id = ' . $id)[0];
            $author_name = $this->db->select('route', 'author_name', 'where id = ' . $id)[0];

            $user_id = $this->db->select('route', 'user_id', 'where id = ' . $id)[0];
            $date = $this->db->select('route', 'date', 'where id = ' . $id)[0];

            $gpx_path = $this->db->select('gpx', 'location_path', 'where route_id = ' . $id)[0];

            $img1_path = $this->db->select('route_image', 'location_path', 'where name=\'img1\' and route_id = ' . $id)[0];
            $img1_alt = $this->db->select('route_image', 'alt_text', 'where name=\'img1\' and route_id = ' . $id)[0];

            $img2_path = $this->db->select('route_image', 'location_path', 'where name=\'img2\' and route_id = ' . $id)[0];
            $img2_alt = $this->db->select('route_image', 'alt_text', 'where name=\'img2\' and route_id = ' . $id)[0];

            $img3_path = $this->db->select('route_image', 'location_path', 'where name=\'img3\' and route_id = ' . $id)[0];
            $img3_alt = $this->db->select('route_image', 'alt_text', 'where name=\'img3\' and route_id = ' . $id)[0];

            $img4_path = $this->db->select('route_image', 'location_path', 'where name=\'img4\' and route_id = ' . $id)[0];
            $img4_alt = $this->db->select('route_image', 'alt_text', 'where name=\'img4\' and route_id = ' . $id)[0];

            $img5_path = $this->db->select('route_image', 'location_path', 'where name=\'img5\' and route_id = ' . $id)[0];
            $img5_alt = $this->db->select('route_image', 'alt_text', 'where name=\'img5\' and route_id = ' . $id)[0];

            $img6_path = $this->db->select('route_image', 'location_path', 'where name=\'img6\' and route_id = ' . $id)[0];
            $img6_alt = $this->db->select('route_image', 'alt_text', 'where name=\'img6\' and route_id = ' . $id)[0];
            $markers_lat = $this->db->select('marker', 'latitude', 'where route_id = ' . $id);
            $markers_lon = $this->db->select('marker', 'longitude', 'where route_id = ' . $id);

            return $cardData + [
                'long_description' => $long_description,
                'author_name' => $author_name,
                'user_id' => $user_id,
                'date' => $date,
                'gpx_path' => $gpx_path,
                'img1_path' => $img1_path,
                'img1_alt' => $img1_alt,
                'img2_path' => $img2_path,
                'img2_alt' => $img2_alt,
                'img3_path' => $img3_path,
                'img3_alt' => $img3_alt,
                'img4_path' => $img4_path,
                'img4_alt' => $img4_alt,
                'img5_path' => $img5_path,
                'img5_alt' => $img5_alt,
                'img6_path' => $img6_path,
                'img6_alt' => $img6_alt,
                'markers_lat' => $markers_lat,
                'markers_lon' => $markers_lon,
                'route_id' => $id
            ];
        }
        return false;
    }

    function getCardRouteData($id)
    {
        if ($this->exist('route', 'id', $id)) {
            $title = $this->db->select('route', 'title', 'where id = ' . $id)[0];
            $start = $this->db->select('route', 'start', 'where id = ' . $id)[0];
            $end = $this->db->select('route', 'end', 'where id = ' . $id)[0];
            $distance = $this->db->select('route', 'distance', 'where id = ' . $id)[0];
            $distance_unit = $this->db->select('route', 'distance_unit', 'where id = ' . $id)[0];
            $short_description = $this->db->select('route', 'short_description', 'where id = ' . $id)[0];
            $main_img_path = $this->db->select('route_image', 'location_path', 'where name=\'main\' and route_id = ' . $id)[0];
            $main_img_alt = $this->db->select('route_image', 'alt_text', 'where name=\'main\' and route_id = ' . $id)[0];

            return [
                'id' => $id,
                'title' => $title,
                'start' => $start,
                'end' => $end,
                'distance' => $distance,
                'distance_unit' => $distance_unit,
                'short_description' => $short_description,
                'main_img_path' => $main_img_path,
                'main_img_alt' => $main_img_alt,
            ];
        }
        return false;
    }

    function getRoutesID($addition = '')
    {
        return $this->db->select('route', 'id', $addition);
    }

    function validate(): array
    {

        // Define the expected input fields
        $args = [
            'title' => FILTER_SANITIZE_STRING,
            'start' => FILTER_SANITIZE_STRING,
            'end' => FILTER_SANITIZE_STRING,
            'distance' => [
                'filter' => FILTER_VALIDATE_FLOAT,
                'flags' => FILTER_FLAG_ALLOW_FRACTION
            ],
            'unit' => FILTER_SANITIZE_STRING,
            'short-desc' => FILTER_SANITIZE_SPECIAL_CHARS ,
            'long-desc' => FILTER_SANITIZE_SPECIAL_CHARS ,
            'name' => FILTER_SANITIZE_STRING,
            'name-input' => FILTER_SANITIZE_STRING,
            'accept' => FILTER_VALIDATE_BOOLEAN,
            'main-alt' => FILTER_SANITIZE_STRING,
            'img1-alt' => FILTER_SANITIZE_STRING,
            'img2-alt' => FILTER_SANITIZE_STRING,
            'img3-alt' => FILTER_SANITIZE_STRING,
            'img4-alt' => FILTER_SANITIZE_STRING,
            'img5-alt' => FILTER_SANITIZE_STRING,
            'img6-alt' => FILTER_SANITIZE_STRING,
        ];

        // Get the input data
        $data = filter_input_array(INPUT_POST, $args);

        // Initialize an array to hold error messages
        $errors = [];

        // Validate required fields
        if (empty($data['title'])) {
            $errors[] = "Title is required.";
        }
        if (empty($data['start']) || strlen($data['start']) < 2) {
            $errors[] = "Start point must be at least 2 characters.";
        }
        if (empty($data['end']) || strlen($data['end']) < 2) {
            $errors[] = "End point must be at least 2 characters.";
        }
        if ($data['distance'] === false || $data['distance'] <= 0) {
            $errors[] = "Please provide a valid distance.";
        }
        if (empty($data['short-desc']) || strlen($data['short-desc']) < 100) {
            $errors[] = "Short description must be at least 100 characters.";
        } else if ($this->exist('route', 'short_description', $data['short-desc'])) {
            $errors[] = "Short description must not repeat any existing one.";
        }
        if (empty($data['long-desc']) || strlen($data['long-desc']) < 500) {
            $errors[] = "Long description must be at least 500 characters.";
        } else if ($this->exist('route', 'long_description', $data['long-desc'])) {
            $errors[] = "Long description must not repeat any existing one.";
        }
        if (empty($data['name'])) {
            $errors[] = "Please choose how you would like to be mentioned.";
        }
        if ($data['name']=='name' && empty($data['name-input'])) {
            $errors[] = "Please provide your name.";
        } else if ($data['name']=='name') {
            $data['name']=$data['name-input'];
        }
        if (!$data['accept']) {
            $errors[] = "You must accept the Terms of Use & Privacy Policy.";
        }

        if ($userID = $this->getUserID()) {
            $data['userID'] = $userID;
        } else {
            $errors[] = "You must be logged in.";
        }


        // Handle file uploads
        $uploads = [];
        $images = [
            'main', 'img1', 'img2', 'img3', 'img4', 'img5', 'img6',
        ];

        $gpxFile = 'gpx';

        foreach ($images as $image) {
            if (isset($_FILES[$image]) && $_FILES[$image]['error'] === UPLOAD_ERR_OK) {
                $uploads[$image] = $_FILES[$image];
                $fileType = pathinfo($uploads[$image]['name'], PATHINFO_EXTENSION);
                if (!in_array($fileType, ['jpg', 'jpeg', 'png'])) {
                    $errors[] = "Invalid file type for $image. Only .jpg, .jpeg and .png files are allowed.";
                }
            } else {
                $errors[] = "File upload for $image failed.";
            }
        }

        if (isset($_FILES[$gpxFile]) && $_FILES[$gpxFile]['error'] === UPLOAD_ERR_OK) {
            $uploads[$gpxFile] = $_FILES[$gpxFile];
            $fileType = pathinfo($uploads[$gpxFile]['name'], PATHINFO_EXTENSION);
            if ($fileType != 'gpx') {
                $errors[] = "Invalid file type for route file. Only .gpx files are allowed.";
            }
        } else {
            $errors[] = "File upload for $gpxFile failed.";
        }

        $markers = [];
        $markerCount = 0;
        while (isset($_POST["lat-marker" . ($markerCount + 1)]) && isset($_POST["lon-marker" . ($markerCount + 1)])) {
            $lat = filter_var($_POST["lat-marker" . ($markerCount + 1)], FILTER_VALIDATE_FLOAT);
            $lon = filter_var($_POST["lon-marker" . ($markerCount + 1)], FILTER_VALIDATE_FLOAT);

            if ($lat === false || $lon === false) {
                $errors[] = "Invalid coordinates for marker " . ($markerCount + 1) . ".";
            } else {
                $markers["marker" . ($markerCount + 1)] = [
                    'lat' => $lat,
                    'lon' => $lon
                ];
            }
            $markerCount++;
        }

        $data['markers'] = $markers;

        return [
            'data' => $data,
            'errors' => $errors
        ];
    }

    function toDatabase($data)
    {

        $route_values = "NULL,'".$data['title']."','".$data['start']."','".$data['end']."',".$data['distance'].",'".$data['unit']
            ."','".$data['short-desc']."','".$data['long-desc']."','".$data['name']."', '".$data['userID']."', NOW(), NULL";
        $this->db->insert('route', '', $route_values);
        $id = $this->db->select('route', 'MAX(id)', '')[0];
        $dir = "routes/$id/";
        $this->db->update('route', 'location_path = "'.$dir.'"', 'id = ' . $id);

        $images = [
            'main', 'img1', 'img2', 'img3', 'img4', 'img5', 'img6',
        ];


        if (!is_dir($dir)) {
            mkdir($dir, 0755, true); // Create the directory with appropriate permissions
        }

        foreach ($images as $image) {
            $exploded = explode(".", $_FILES[$image]["name"]);
            $ext = end($exploded);
            $img_upload_path = $dir . $image . '.' . $ext;
            $image_values = "$id, '$image', '$ext', '".$data[$image.'-alt']."', '$img_upload_path'";
            $this->db->insert('route_image', '', $image_values);
            move_uploaded_file($_FILES[$image]['tmp_name'], $img_upload_path);
        }


        $gpx_upload_path = $dir . $id . '.gpx';
        $this->db->insert('gpx', '', "$id, $id, 'gpx', '$gpx_upload_path'");
        move_uploaded_file($_FILES['gpx']['tmp_name'], $gpx_upload_path);

        foreach ($data['markers'] as $marker) {
            $this->db->insert('marker', '', "$id, ".$marker['lat'].", ".$marker['lon']);
        }
    }

    function getUserID(){
        if ( $this->is_session_started() === FALSE ) session_start();
        $sessID = session_id();
        if ($this->exist('logged_in_user', 'session_id', session_id())) {
            return $this->db->select('logged_in_user', 'user_id', "where session_id = '".$sessID."'")[0];
        }
        return false;
    }



    function updateLike($userID)
    {
        $routeID = $_POST['recordId'];
        $action = $_POST['action'];
        if ($action === 'add') {
            $this->db->insert('favorite_route', '', "$userID, $routeID");

        } elseif ($action === 'remove') {
            $this->db->delete('favorite_route', "user_id = $userID, route_id =  $routeID");
        }
    }

    function likeRoute($routeID, $userID)
    {
        if ($this->db->check('favorite_route', "user_id = $userID AND route_id = $routeID")) {
            $this->db->delete('favorite_route', "user_id = $userID AND route_id = $routeID");
        } else {
            $this->db->insert("favorite_route", '', "$userID, $routeID");
        }
    }

    function deleteRoute($id) {
        if ($this->exist('route', 'id', $id)) {

            $routeData = $this->getRouteData($id);
            $this->db->insert("deleted_route", '', "$id, '".$routeData['title']."', '".$routeData['start']."', '"
                .$routeData['end']."', ".$routeData['distance'].",'".$routeData['distance_unit']."', '"
                .$routeData['short_description']."', '".$routeData['long_description']."', '"
                .$routeData['author_name']."', ".$routeData['user_id'].", NOW()");

            unlink($routeData['main_img_path']);
            unlink($routeData['img1_path']);
            unlink($routeData['img2_path']);
            unlink($routeData['img3_path']);
            unlink($routeData['img4_path']);
            unlink($routeData['img5_path']);
            unlink($routeData['img6_path']);

            unlink($routeData['gpx_path']);

            $dir = $this->db->select('route', 'location_path', 'where id = ' . $id)[0];

            rmdir($dir);

            $this->db->delete("route", "id = $id");
        }
    }

    function getLoggedInUserID()
    {
        if ( $this->is_session_started() === FALSE ) session_start();
        if ($this->exist('logged_in_user', 'session_id', session_id())) {
            return $this->db->select('logged_in_user', 'user_id', "where session_id = '".session_id()."'")[0];
        } else return false;
    }

    function getLikedRoutesID()
    {
        if ($userID = $this->getLoggedInUserID()) {
            return $this->db->select('favorite_route', 'route_id', "where user_id = $userID");
        } return false;
    }

    function addView($id)
    {
        $table = 'route_views';
        if($this->exist($table, 'route_id', $id)) {
            $views = $this->db->select($table, 'views', "where route_id = $id")[0] + 1;
            $this->db->update($table, "views = $views", "route_id = $id");
        } else {
            $this->db->insert('route_views', '', "$id, 1");
        }

    }

    function getTop3RoutesID()
    {
        //SELECT route_id FROM route_views ORDER BY views DESC LIMIT 3
        return $this->db->select('route_views', 'route_id', "ORDER BY views DESC LIMIT 3");

    }

    function getRouteName($id)
    {
        if ($this->exist('route', 'id', $id)) {
            $title = $this->db->select('route', 'title', 'where id = ' . $id)[0];
            return $title;
        }
        return false;
    }


}