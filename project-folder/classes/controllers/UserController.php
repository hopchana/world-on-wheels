<?php


require_once "Controller.php";


class UserController extends Controller
{
    function generateForm($type)
    {
        if ($type=='signup') {
            $this->view->showSignUpForm();
        } else if ($type=='login') {
            $this->view->showLogInForm();
        } else {
            header("Location: 404.php");
            exit();
        }
    }

    public function submitForm($type) {
        $data = $this->model->validate($type);
        // Check if there are any errors
        if (empty($data['errors'])) {
            if ($type=='update') {
                $this->model->updateUser($data['data']);
                $this->view->alert("Account data was successfully updated", 'update_ok', "Ok");

                if (filter_input(INPUT_POST, 'update_ok',
                        FILTER_SANITIZE_FULL_SPECIAL_CHARS) && $_POST['update_ok'] == 'Ok') {
                    echo "<script>
                                window.location.href = window.location.href;
                                </script>";
                }

            } else {
                // Process the data
                if ($type == 'signup') {
                    $this->model->createUser($data['data']);
                }
                $this->model->login($data['data']['username'], $data['data']['password']);
                // Display success message
                echo "<script type='text/javascript'>
                window.location.href='my-account.php'
                </script>";
            }

        } else {
            $err = "";
            foreach ($data['errors'] as $error) {
                $err .= "<p><b>Error:</b> $error</p>";
            }
            echo "<script>
                let errorsElement = document.getElementById('errors');
                errorsElement.innerHTML = `$err`
                </script>
                
            ";
        }

    }

    function myAccount()
    {
        if ($this->isUserLoggedIn()) {
            $username = $this->model->getUsername();
            $status = $this->model->getStatus();
            if ($status!='admin') {
                if (filter_input(INPUT_GET, 'page',
                    FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {

                    $page = filter_input(INPUT_GET, 'page');
                    switch ($page) {
                        case 'dashboard':
                            $this->view->showMenu($page, $username);
                            $this->postsStatistic();
                            $this->commentsStatistic();
                            $this->myComments();
                            $this->processDelete();
                            break;
                        case 'my-posts':
                            $userID = $this->model->getUserID();
                            $this->view->showMenu($page, $username);
                            $this->view->myPosts($userID);
                            break;
                        case 'account-details':
                            $this->view->showMenu($page, $username);
                            $fullName = $this->model->getFullName();
                            $email = $this->model->getEmail();
                            $this->view->accountDetails($username, $fullName, $email);
                            if (filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                                if ($_POST['submit'] == 'Update') {
                                    $this->submitForm('update');
                                } else if ($_POST['submit'] == 'Delete account') {
                                    $this->view->confirm("Are you sure you want to permanently delete your account?", "confirm_delete", 'Yes');
                                }
                            }

                            if (filter_input(INPUT_POST, 'confirm_delete',
                                    FILTER_SANITIZE_FULL_SPECIAL_CHARS) && $_POST['confirm_delete'] == 'Yes') {
                                if ($this->model->deleteUser()) {
                                    $this->view->alert("Account was successfully deleted.", "delete_ok", 'Ok');
                                }
                            }

                            if (filter_input(INPUT_POST, 'delete_ok',
                                    FILTER_SANITIZE_FULL_SPECIAL_CHARS) && $_POST['delete_ok'] == 'Ok') {

                                $this->model->logout();
                                echo "<script>
                                window.location.reload();
                                </script>";
                            }
                            break;
                        case 'logout':
                            $this->model->logout();
                            echo "<script>
                        window.location.reload();
                        </script>";

                            break;
                        default:
                            $this->view->showMenu('dashboard', $username);
                            $this->postsStatistic();
                            $this->commentsStatistic();
                            $this->myComments();

                    }
                } else {
                    $this->view->showMenu('dashboard', $username);
                    $this->postsStatistic();
                    $this->commentsStatistic();
                    $this->myComments();
                }
            } else {
                $this->adminAccount($username);
            }
        }
    }

    function isUserLoggedIn(): bool
    {
        if (!$this->model->isUserLoggedIn()) {
            header("location:login.php");
            return false;
        } return true;
    }

    function getUserID()
    {
        return $this->model->getUserID();
    }

    function popup()
    {
        $this->view->popup();
        if (filter_input(INPUT_POST, 'submit',
                FILTER_SANITIZE_FULL_SPECIAL_CHARS) && $_POST['submit'] == 'Yes') {
            $this->model->deleteUser();
        }
    }

    function postsStatistic()
    {
        if ($this->model->hasPosts()) {
            $statistics = $this->model->getPostStatistic();
            $this->view->showStatistics($statistics);
        } else {
            echo "<div class='wrapper'><div class='field-name'>Here will be shown your post statistics.</div>";
        }
    }

    function commentsStatistic()
    {
        if ($this->model->hasComments()) {
            $statistics = $this->model->getCommentsStat();
            $this->view->showCommentsStat($statistics);
        } else {
            echo "<div class='wrapper'><div class='field-name'>Here will be shown comments to your posts.</div>";
        }
    }

    function myComments()
    {
        if ($this->model->hasMyComments()) {
            $statistics = $this->model->getMyComments();
            $this->view->showMyComments($statistics);
        } else {
            echo "<div class='wrapper'><div class='field-name'>Here will be shown your comments.</div>";
        }
    }

    private function adminAccount($username)
    {
        if (filter_input(INPUT_GET, 'page',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {

            $page = filter_input(INPUT_GET, 'page');
            switch ($page) {
                case 'dashboard':
                    $this->view->showMenu($page, $username);
                    $this->adminPanel();
                    break;
                case 'my-posts':
                    $userID = $this->model->getUserID();
                    $this->view->showMenu($page, $username);
                    $this->view->myPosts($userID);
                    break;
                case 'account-details':
                    $this->view->showMenu($page, $username);
                    $fullName = $this->model->getFullName();
                    $email = $this->model->getEmail();
                    $this->view->accountDetails($username, $fullName, $email);
                    if (filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
                        if ($_POST['submit'] == 'Update') {
                            $this->submitForm('update');
                        } else if ($_POST['submit'] == 'Delete account') {
                            $this->view->confirm("Are you sure you want to permanently delete your account?", "confirm_delete", 'Yes');
                        }
                    }

                    if (filter_input(INPUT_POST, 'confirm_delete',
                            FILTER_SANITIZE_FULL_SPECIAL_CHARS) && $_POST['confirm_delete'] == 'Yes') {
                        if ($this->model->deleteUser()) {
                            $this->view->alert("Account was successfully deleted.", "delete_ok", 'Ok');
                        }
                    }

                    if (filter_input(INPUT_POST, 'delete_ok',
                            FILTER_SANITIZE_FULL_SPECIAL_CHARS) && $_POST['delete_ok'] == 'Ok') {

                        $this->model->logout();
                        echo "<script>
                                window.location.reload();
                                </script>";
                    }
                    break;
                case 'logout':
                    $this->model->logout();
                    echo "<script>
                        window.location.reload();
                        </script>";

                    break;
                default:
                    $this->view->showMenu('dashboard', $username);
                    $this->adminPanel();
            }
        } else {
            $this->view->showMenu('dashboard', $username);
            $this->adminPanel();
        }
    }

    public function addComment($routeID, $userID, $comment)
    {
        $data = $this->model->validateComment($routeID, $userID, $comment);
        if (empty($data["error"])) {
            $comment = $data['data'];
            $this->model->addComment($comment['route_id'], $comment['user_id'], $comment['text']);
        }

    }

    function getComments($routeID)
    {
        $comments = $this->model->getComments($routeID);
        $this->view->showComments($comments, $routeID);
    }

    private function adminPanel()
    {
        $statistics = $this->model->getAllPostsStatistic();
        if (sizeof($statistics))
            $this->view->showAllStatistics($statistics);
        else echo "<br>No posts were created yet.";

        $comments= $this->model->getAllComments();
        if (sizeof($comments))
            $this->view->showAllComments($comments);
        else echo "<br>No comments were written yet.";

        $this->processDelete();

    }

    private function processDelete()
    {
        //posts delete
        if (filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
            // Check if any checkboxes were checked
            if (isset($_POST['delete']) && is_array($_POST['delete'])) {
                // Process the checked IDs
                foreach ($_POST['delete'] as $id) {
                    // Perform delete operation here
                    $_SESSION['delete'] = $_POST['delete'];
                    if (sizeof($_POST['delete'])>1)
                        $this->view->confirm("Are you sure you want to permanently delete selected posts?", "post_delete", 'Yes');
                    else
                        $this->view->confirm("Are you sure you want to permanently delete selected post?", "post_delete", 'Yes');
                }
            } else if (isset($_POST['delete_comment']) && is_array($_POST['delete_comment'])) {
                // Process the checked IDs
                foreach ($_POST['delete_comment'] as $id) {
                    // Perform delete operation here
                    $_SESSION['delete_comment'] = $_POST['delete_comment'];
                    if (sizeof($_POST['delete_comment'])>1)
                        $this->view->confirm("Are you sure you want to permanently delete selected comments?", "comment_delete", 'Yes');
                    else
                        $this->view->confirm("Are you sure you want to permanently delete selected comment?", "comment_delete", 'Yes');
                }
            } else {
                $this->view->alert("Nothing was selected for deletion.", "no_selection", 'Ok');
            }
        }

        if (filter_input(INPUT_POST, 'post_delete',
                FILTER_SANITIZE_FULL_SPECIAL_CHARS) && $_POST['post_delete'] == 'Yes') {
            foreach ($_SESSION['delete'] as $id) {
                require "route-controller.php";
                global $routeController;
                $routeController->deleteRoute($id);
            }

            if (sizeof($_SESSION['delete'])>1)
                $this->view->alert("Posts were successfully deleted.", "post_delete_ok", 'Ok');
            else
                $this->view->alert("Post was successfully deleted.", "post_delete_ok", 'Ok');

            unset($_SESSION['delete']);
        }


        // Comments delete

        if (filter_input(INPUT_POST, 'comment_delete',
                FILTER_SANITIZE_FULL_SPECIAL_CHARS) && $_POST['comment_delete'] == 'Yes') {
            foreach ($_SESSION['delete_comment'] as $id) {
                $this->model->deleteComment($id);
            }

            if (sizeof($_SESSION['delete_comment'])>1)
                $this->view->alert("Comments were successfully deleted.", "comment_delete_ok", 'Ok');
            else
                $this->view->alert("Comment was successfully deleted.", "comment_delete_ok", 'Ok');

            unset($_SESSION['delete_comment']);
        }
    }

}