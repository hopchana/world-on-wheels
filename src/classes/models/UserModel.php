<?php

require_once "Model.php";

class UserModel extends Model
{
    function validate($type): array
    {
        $data = [];
        switch ($type) {
            case 'login': $data = $this->validateLogin(); break;
            case 'signup': $data = $this->validateSignup(); break;
            case'update': $data = $this->validateUpdate(); break;
        }
        return $data;
    }

    function createUser($data)
    {
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user_values = "NULL,'".$data['username']."','".$data['full_name']."','".$data['email']."','".$hashed_password
            ."', 'user'";
        $this->db->insert('user', '', $user_values);
    }

    function updateUser($data) {
        $table = 'user';

        $where = "";
        foreach ($data as $key => $value) {
            if ($value) {
                $where .= "$key = '$value' AND ";
            }
        }
        $where = substr_replace($where, '', -5);
        $id = $this->getUserID();
        $where .= " AND id = $id";


        $set = "";
        foreach ($data as $key => $value) {
            if ($value) {
                $set .= "$key = '$value',";
            }
        }
        $set = substr_replace($set, '', -1);

        if (!$this->db->check($table, $where)) {
            $where = "id = $id";
            $this->db->update($table, $set, $where);
        }
    }

    function deleteUser()
    {
        $id = $this->getUserID();
        $username = $this->getUsername();
        $full_name = $this->getFullName();
        $email = $this->getEmail();
        $status = $this->getStatus();

        $this->db->insert('deleted_user', '', "$id, '$username', '$full_name', '$email', '$status', NOW()");
        return $this->db->delete('user', 'id = '.$id);
    }

    function login($username, $password)
    {
        if ( $this->is_session_started() === FALSE ) session_start();
        $cols = "";
        $id = $this->db->select('user', 'id', "where username = '".$username."'")[0];

        //remove all records for user with the id
        $this->db->delete("logged_in_user", "user_id = $id");

        //get session id, add record to the logged_in_user table
        $sessID = session_id();
        $values = "'$sessID', '$id', NOW()";
        $this->db->insert("logged_in_user", $cols, $values);
    }

    function logout()
    {
        if ( $this->is_session_started() === FALSE ) session_start();
        $sessID = session_id();
        $table = "logged_in_user";
        $this->db->delete($table, "session_id = '$sessID'");
        if ( isset($_COOKIE[session_name()]) ) {
            setcookie(session_name(),'', time() - 42000, '/');
        }
        $_SESSION = [];
        session_destroy();

    }

    function validateLogin(): array
    {
        $args = [
            'username' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^(?=.{5,20}$)[a-zA-Z0-9._]+$/']
            ],
            'password' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,16}$/']
            ]
        ];

        $data = filter_input_array(INPUT_POST, $args);
        $errors = [];

        if ($this->exist('user', 'username', $data['username'])) {
            $hashed_password = $this->db->select('user', 'password', 'WHERE username = "'.$data['username'].'"')[0];
            if (!password_verify($data['password'], $hashed_password)) {
                $errors = ['Invalid username or password.'];
            }
        } else $errors = ['Invalid username or password.'];

        return [
            'data' => $data,
            'errors' => $errors
        ];
    }

    function validateSignup(): array
    {
        $args = [
            'username' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^(?=.{5,20}$)[a-zA-Z0-9._]+$/']
            ],
            'full_name' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^([A-Za-z]{3,16})([ -]{1})([A-Za-z]{3,16})?([ -]{1})?([A-Za-z]{3,16})?([ -]{1})?([A-Za-z]{3,16})$/']
            ],
            'email' => FILTER_VALIDATE_EMAIL,

            'password' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,16}$/']
            ],
            'passwordConfirm' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,16}$/']
            ],
            'accept' => FILTER_VALIDATE_BOOLEAN
        ];

        $data = filter_input_array(INPUT_POST, $args);
        $errors = [];

        if (empty($data['username'])) {
            $errors[] = "Username must be 5-20 characters long and contain only letters (English alphabet), numbers, underscores and dots.";
        } else if ($this->exist('user', 'username', $data['username'])) {
            $errors[] = "This username is already taken. Choose a different username.";
        }
        if (empty($data['password'])) {
            $errors[] = "Password must be 8-16 characters long and include at least one uppercase letter, one lowercase letter, and one number.";
        }

        if (empty($data['full_name'])) {
            $errors[] = "Full name must consist of 3-16 characters for each part, separated by spaces or hyphens.";
        }

        if (empty($data['email'])) {
            $errors[] = "Please enter a valid email address.";
        } else if ($this->exist('user', 'email', $data['email']) ) {
            $errors[] = "Account with this email already exists.";
        }

        if (empty($data['passwordConfirm'])) {
            $errors[] = "Password confirmation is required.";
        } elseif ($data['password'] !== $data['passwordConfirm']) {
            $errors[] = "Passwords have to match.";
        }

        if (empty($data['accept']) || $data['accept'] !== true) {
            $errors[] = "You have to accept the Terms of Use & Privacy Policy.";
        }

        return [
            'data' => $data,
            'errors' => $errors
        ];
    }

    function validateUpdate(): array
    {
        $args = [
            'username' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^(?=.{5,20}$)[a-zA-Z0-9._]+$/']
            ],
            'full_name' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^([A-Za-z]{3,16})([ -]{1})([A-Za-z]{3,16})?([ -]{1})?([A-Za-z]{3,16})?([ -]{1})?([A-Za-z]{3,16})$/']
            ],
            'email' => FILTER_VALIDATE_EMAIL,
            'password' => FILTER_SANITIZE_STRING,
            'passwordConfirm' => FILTER_SANITIZE_STRING
        ];

        $data = filter_input_array(INPUT_POST, $args);
        $errors = [];

        if (empty($data['username'])) {
            $errors[] = "Username must be 5-20 characters long and contain only letters (English alphabet), numbers, underscores and dots.";
        } else if ($this->exist('user', 'username', $data['username']) && $data['username'] != $this->getUsername()) {
            $errors[] = "This username is already taken. Choose a different username.";
        }


        if (empty($data['full_name'])) {
            $errors[] = "Full name must consist of 3-16 characters for each part, separated by spaces or hyphens.";
        }

        if (empty($data['email'])) {
            $errors[] = "Please enter a valid email address.";
        } else if ($this->exist('user', 'email', $data['email'])  && $data['email'] != $this->getEmail() ) {
            $errors[] = "Account with this email already exists.";
        }
        if ($data['password'] != "" && !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,16}$/', $data['password'])) {
                $errors[] = "Password must be 8-16 characters long and include at least one uppercase letter, one lowercase letter, and one number.";
        }

        if ($data['passwordConfirm'] == "" && $data['password'] != "") {
            $errors[] = "Password confirmation is required.";
        } elseif ($data['password'] !== $data['passwordConfirm']) {
            $errors[] = "Passwords have to match.";
        }

        if ($data['passwordConfirm'] == "" && $data['password'] == "") {
            $data['passwordConfirm'] = false;
            $data['password'] = false;
        }


        return [
            'data' => $data,
            'errors' => $errors
        ];
    }

    function hasPosts(): bool
    {
        return $this->exist('route', 'user_id', $this->getUserID());
    }


    function hasComments(): bool
    {
        if ($this->hasPosts()) {
            $userID = $this->getUserID();
            $routeIDs = $this->db->select('route', 'id', "where user_id = $userID");
            foreach ($routeIDs as $routeID) {
                if ($this->exist('comment', 'route_id', $routeID)) {
                    return true;
                }
            }

        }
        return false;
    }

    function hasMyComments(): bool
    {
        $userID = $this->getUserID();
        if ($this->exist('comment', 'user_id', $userID)) {
            return true;
        }
        return false;
    }

    function getPostStatistic(): array
    {
        $statistics = [];
        $userID = $this->getUserID();
        $posts = $this->db->select('route', 'id', "WHERE user_id = $userID");
        foreach ($posts as $post) {
            $postStat["likes"] = $this->db->select('favorite_route', 'COUNT(route_id)', "WHERE route_id = $post")[0];
            $postStat["views"] = $this->db->select('route_views', 'views', "WHERE route_id = $post");
            if (sizeof($postStat["views"])) {
                $postStat["views"] = $postStat["views"][0];
            } else {
                $postStat["views"] = 0;
            }
            $postStat["comments"] = $this->db->select('comment', 'COUNT(route_id)', "WHERE route_id = $post")[0];
            $postStat["post_id"] = $post;
            $postName = $this->db->select('route', 'title', 'WHERE id = ' . $post)[0];
            $statistics[$postName] = $postStat;
        }
        return $statistics;
    }

    function getCommentsStat(): array
    {
        //    select id from route where user_id = 1;
        //    select text from comment where route_id = 3;
        $comments = [];
        $userID = $this->getUserID();
        $routeIDs = $this->db->select('route', 'id', "where user_id = $userID");
        foreach ($routeIDs as $routeID) {
            $routeComments = [];
            $routeName = $this->db->select('route', 'title', 'WHERE id = ' . $routeID)[0];
            if ($this->exist('comment', 'route_id', $routeID)) {
                $texts = $this->db->select('comment', 'text', "WHERE route_id = $routeID");
                foreach ($texts as $text) {
                    $textES = $this->db->escapeString($text);
                    $commIDs = $this->db->select('comment', 'id', "WHERE text = '$textES'");
                    foreach ($commIDs as $commID) {
                        $routeComments += ["$commID" => $text];
                    }
                }
                $comments += [$routeName => $routeComments];
            }
        }
        return $comments;

    }



    function getMyComments(): array
    {
        $comments = [];
        $userID = $this->getUserID();
        $commIDs = $this->db->select('comment', 'id', "where user_id = $userID order by route_id desc");
        foreach ($commIDs as $commID) {
            $text = $this->db->select('comment', 'text', "WHERE id = $commID")[0];
            $routeID = $this->db->select('comment', 'route_id', 'WHERE id = ' . $commID)[0];
            $routeName = $this->db->select('route', 'title', 'WHERE id = ' . $routeID)[0];
            $comments["$commID"] = [
                'route_name' => $routeName,
                'text' => $text,
            ];
        }
        return $comments;

    }

    function getAllPostsStatistic(): array
    {
        $statistics = [];
        $posts = $this->db->select('route', 'id');
        foreach ($posts as $post) {
            $user_id = $this->db->select('route', 'user_id', 'WHERE id = ' . $post)[0];
            $postStat["id"]=$post;
            $postStat["date"]=$this->db->select('route', 'date', 'WHERE id = ' . $post)[0];
            $postStat["publisher"]=$this->db->select('user', 'username', 'WHERE id = ' . $user_id)[0];
            $postStat["likes"] = $this->db->select('favorite_route', 'COUNT(route_id)', "WHERE route_id = $post")[0];
            $postStat["comments"] = $this->db->select('comment', 'COUNT(route_id)', "WHERE route_id = $post")[0];
            $postStat["views"] = $this->db->select('route_views', 'views', "WHERE route_id = $post");
            if (sizeof($postStat["views"])) {
                $postStat["views"] = $postStat["views"][0];
            } else {
                $postStat["views"] = 0;
            }
            $postName = $this->db->select('route', 'title', 'WHERE id = ' . $post)[0];
            $statistics[$postName] = $postStat;
        }
        return $statistics;
    }

    function validateComment($routeID, $userID, $comment): array
    {
        $errors = [];
        // Validate required fields
        if (empty($comment) || $comment == "") {
            $errors[] = "Comment cannot be empty.";
        } else if (!$this->exist('user', 'id', $userID)) {
            $errors[] = "This user does not exist.";
        }
        if (empty($routeID)) {
            $errors[] = "Something went wrong.";
        } else if (!$this->exist('route', 'id', $routeID) ) {
            $errors[] = "This route does not exist.";
        }
        $data = [
            'text' => $comment,
            'route_id' => $routeID,
            'user_id' => $userID
        ];

        return [
        'data' => $data,
        'errors' => $errors
        ];
    }

    function addComment($routeID, $userID, $text): bool
    {
        if ($this->getUserID() == $userID) {
//            $text = $this->db->escapeString($text);
            $this->db->insert("comment", "", "NULL, $routeID, $userID, '$text', NOW()");
            $views = $this->db->select("route_views", 'views', "WHERE route_id = $routeID")[0];
            $this->db->update("route_views", 'views = ' . ($views - 1), "route_id = $routeID");
        } else return false;
        return true;
    }

    function getComments($routeID): array
    {
        $comments = [];
        if ($this->exist('comment', 'route_id', $routeID)) {
            $ids = $this->db->select('comment', 'id', 'WHERE route_id = ' . $routeID);
            foreach ($ids as $id) {
                $userID = $this->db->select('comment', 'user_id', 'WHERE id = ' . $id)[0];
                $username = $this->db->select('user', 'username', 'WHERE id = ' . $userID)[0];
                $text = $this->db->select('comment', 'text', 'WHERE id = ' . $id)[0];
                $date = $this->db->select('comment', 'date', 'WHERE id = ' . $id)[0];
                if ($userID && $username && $text && $date) {
                    $commentData = [
                        'text' => $text,
                        'date' => $date,
                        'username' => $username
                    ];

                    $comments += ["$id" => $commentData];
                }
            }
        }
        return $comments;
    }

    function getAllComments(): array
    {
        $statistics = [];
        $comments = $this->db->select('comment', 'id', 'order by date desc');
        foreach ($comments as $commentID) {
            $route_id = $this->db->select('comment', 'route_id', 'WHERE id = ' . $commentID)[0];
            $route = $this->db->select('route', 'title', 'WHERE id = ' . $route_id)[0];
            $userID = $this->db->select('comment', 'user_id', 'WHERE id = ' . $commentID)[0];
            $username = $this->db->select('user', 'username', 'WHERE id = ' . $userID)[0];
            $date=$this->db->select('comment', 'date', 'WHERE id = ' . $commentID)[0];
            $text=$this->db->select('comment', 'text', 'WHERE id = ' . $commentID)[0];
            if ($userID && $username && $text && $date && $route) {
                $commentData = [
                    'text' => $text,
                    'date' => $date,
                    'username' => $username,
                    'route_name' => $route,
                ];
                $statistics += ["$commentID" => $commentData];
            }
        }
        return $statistics;
    }

    function deleteComment($id)
    {
        if ($this->exist('comment', 'id', $id)) {
            $this->db->delete("comment", "id = $id");
        }
    }

    function isUserLoggedIn(): bool
    {
        if ( $this->is_session_started() === FALSE ) session_start();
        return $this->exist('logged_in_user', 'session_id', session_id());
    }

    function getUsername()
    {
        if ( $this->is_session_started() === FALSE ) session_start();
        $sessID = session_id();
        $id = $this->db->select('logged_in_user', 'user_id', "where session_id = '".$sessID."'")[0];
        return $this->db->select('user', 'username', "where id = '".$id."'")[0];
    }

    function getFullName(){
        if ( $this->is_session_started() === FALSE ) session_start();
        $sessID = session_id();
        $id = $this->db->select('logged_in_user', 'user_id', "where session_id = '".$sessID."'")[0];
        return $this->db->select('user', 'full_name', "where id = '".$id."'")[0];
    }

    function getEmail(){
        if ( $this->is_session_started() === FALSE ) session_start();
        $sessID = session_id();
        $id = $this->db->select('logged_in_user', 'user_id', "where session_id = '".$sessID."'")[0];
        return $this->db->select('user', 'email', "where id = '".$id."'")[0];
    }

    function getUserID(){
        if ( $this->is_session_started() === FALSE ) session_start();
        $sessID = session_id();
        return $this->db->select('logged_in_user', 'user_id', "where session_id = '".$sessID."'")[0];
    }

    function getStatus(){
        if ( $this->is_session_started() === FALSE ) session_start();
        $sessID = session_id();
        $id = $this->db->select('logged_in_user', 'user_id', "where session_id = '".$sessID."'")[0];
        return $this->db->select('user', 'status', "where id = '".$id."'")[0];
    }


}