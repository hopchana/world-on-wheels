<?php
require_once "View.php";

class UserView extends View
{
    function showSignUpForm() {
        echo "
        <div class='wrapper capsule'>
        <div class='title center'><span>SIGN UP</span></div>
        <form  id='signup-form' action='signup.php' method='post'>
        <div class='row'>
                <input type='text' name='username' placeholder='Username' required />
            </div>
            <div class='row'>
                <input type='text' name='full_name' placeholder='Full name' required />
            </div>
            <div class='row'>
                <input type='text' name='email' placeholder='Email' required />
            </div>
            <div class='row'>

                <input type='password' name='password' placeholder='Password' required />
            </div>
            <div class='row'>
                <input type='password' name='passwordConfirm' placeholder='Confirm password' required />
            </div>
            <br>
            <label for='accept'><input type='checkbox' name='accept' id='accept' required> I accept the Terms of Use & Privacy Policy</label>


            <input id='signup-btn' name='submit' type='submit' value='Sign up' />
            <div id='errors'></div>

            <div class='signup-link'>Already have an account? <a href='login.php'>Log in</a></div>
        </form>
        </div>
    
        ";
    }

    function showLogInForm() {
        echo "
        
        <div class='wrapper capsule'>
        <div class='title center'><span>LOG IN</span></div>
        <form id='login-form' action='login.php' method='post'>
        <div class='row'>
                <input type='text' name='username' placeholder='Username' required />
            </div>
            <div class='row'>
                <input type='password' name='password' placeholder='Password' required />
            </div>

            <input id='login-btn' name='submit' type='submit' value='Log In' />
            <div id='errors'></div>

            <div class='signup-link'>Not a member? <a href='signup.php'>Sign up</a></div>
        </form>
    </div>";
    }

    function accountDetails($username, $fullName, $email)
    {
        echo "
        <div class='wrapper'>
        
        <form id='update-form' action='my-account.php?page=account-details' method='post'>
        <div class='field-name'>Username</div>
        <div class='row'>
                <input type='text' name='username' value='$username' required />
            </div>
            <div class='field-name'>Full name</div>
            <div class='row'>
                <input type='text' name='full_name' value='$fullName' required />
            </div>
            <div class='field-name'>Email</div>
            <div class='row'>
                <input type='text' name='email' value='$email' required />
            </div>
            <div class='field-name'>Change password</div>
            <div class='row'>
                <input type='password' name='password' placeholder='New password' />
            </div>
            <div class='row'>
                <input type='password' name='passwordConfirm' placeholder='Confirm password' />
            </div>
            <br>


            <input id='signup-btn' name='submit' type='submit' value='Update' />
            <input id='signup-btn' name='submit' type='submit' value='Delete account' />
            <div id='errors'></div>
        </form>
        </div>
    
        ";
    }

    function myPosts($id)
    {
        echo" <div class='center'><input id='new-post-btn' name='submit' type='submit' value='+ New post'></div>";
        echo "<script type='text/javascript'>
                document.getElementById('new-post-btn').onclick = function () {
                    location.href = 'write-for-us.php';
                };</script>";
        require "route-controller.php";
        global $routeController;
        $routeController->generateCards($id);


    }


    function showStatistics($statistics)
    {
        echo "<div class='wrapper'><div class='field-name'><b>Posts statistic</b></div>
            <form action='my-account.php?page=dashboard' method='post'>";
        foreach ($statistics as $postName => $postStat) {
            $likes = $postStat['likes'];
            $views = $postStat['views'];
            $comments = $postStat['comments'];
            $post_id = $postStat['post_id'];
            echo "<div class='field-name'>
                <label for='delete_$post_id'>
                    <input type='checkbox' name='delete[]' id='delete_$post_id' value='$post_id'> <b>$postName</b>
                </label>
              </div>";

            echo "Post was liked <b>$likes</b>";
            if ($likes==1) echo " time<br>";
            else echo " times<br>";
            echo "Post was viewed <b>$views</b>";
            if ($views==1) echo " time<br>";
            else echo " times<br>";
            echo "Post was commented <b>$comments</b>";
            if ($comments==1) echo " time<br>";
            else echo " times<br>";
        }

        echo "<input id='signup-btn' name='submit' type='submit' value='Delete posts' />
        </form></div>";
    }

    function showCommentsStat($comments)
    {
        echo "<div class='wrapper'><div class='field-name'><b>Comments</b></div>
            <form action='my-account.php?page=dashboard' method='post'>";
        foreach ($comments as $postName => $commentsData) {
            echo "<div class='field-name'><b>$postName</b></div>";
            foreach ($commentsData as $commentID => $text) {
                // Ensure each checkbox has a unique id
                echo "
                <label for='delete_comment_$commentID'>
                    <input type='checkbox' name='delete_comment[]' id='delete_comment_$commentID' value='$commentID'> 
                    $text";
                echo "<br>";
            }
        }

        echo "<input id='signup-btn' name='submit' type='submit' value='Delete comments' />
        </form></div>";
    }

    function showMyComments($comments)
    {
        echo "<div class='wrapper'><div class='field-name'><b>Your comments</b></div>
            <form action='my-account.php?page=dashboard' method='post'>";
        foreach ($comments as $commentID => $data) {
            $text = $data['text'];
            $route_name= $data['route_name'];

            echo "
                <label for='delete_comment_$commentID'>
                    <input type='checkbox' name='delete_comment[]' id='delete_comment_$commentID' value='$commentID'> 
                    <b>$text</b>
                </label><br>
              ";

            echo "Route: $route_name<br>";
            echo "<br>";
        }

        echo "<input id='signup-btn' name='submit' type='submit' value='Delete comments' />
        </form></div>";
    }

    function showAllComments($comments)
    {
        echo "<div class='wrapper'><h3><b>COMMENTS</b></h3>
            <form action='my-account.php?page=dashboard' method='post'>";
        foreach ($comments as $commentID => $data) {
            $date= $data['date'];
            $text = $data['text'];
            $username = $data['username'];
            $route_name= $data['route_name'];

            echo "
                <label for='delete_comment_$commentID'>
                    <input type='checkbox' name='delete_comment[]' id='delete_comment_$commentID' value='$commentID'> 
                    <b>$text</b>
                </label><br>
              ";

            echo "Route: $route_name<br>";
            echo "User: $username<br>";
            echo "Date: $date<br>";
            echo "<br>";
        }

        echo "<input id='signup-btn' name='submit' type='submit' value='Delete comments' />
        </form></div>";
    }

    function showAllStatistics($statistics)
    {
        echo "<div class='wrapper'><h3><b>POSTS</b></h3>
            <form action='my-account.php?page=dashboard' method='post'>
        ";
        foreach ($statistics as $postName => $postStat) {
            $id = $postStat['id'];
            $likes = $postStat['likes'];
            $views = $postStat['views'];
            $date = $postStat["date"];
            $publisher = $postStat["publisher"];
            $comments= $postStat['comments'];

            // Ensure each checkbox has a unique id
            echo "<div class='field-name'>
                <label for='delete_$id'>
                    <input type='checkbox' name='delete[]' id='delete_$id' value='$id'> <b>$postName</b>
                </label>
              </div>";
            echo "Date of publication: $date<br>";
            echo "Publisher: $publisher<br>";
            echo "Comments: $comments<br>";
            echo "Views: $views<br>";
            echo "Likes: $likes<br>";
        }

        echo "<input id='signup-btn' name='submit' type='submit' value='Delete posts' />
        </form></div>";
    }

    function showMenu($page, $username)
    {
        echo "<div class='detail'>
        <h2 class='page-title'>Hello $username!</h2>
    </div>
    <div id='menu'>
        <div id='nav'>";

        switch ($page) {
            case 'dashboard':
                echo "
                    <a href='?page=dashboard' class='active'>Dashboard</a>
                    <a href='?page=my-posts'>My Posts</a>
                    <a href='?page=account-details'>Account Details</a>";
                break;
            case 'my-posts':
                echo "
                    <a href='?page=dashboard' >Dashboard</a>
                    <a href='?page=my-posts' class='active'>My Posts</a>
                    <a href='?page=account-details'>Account Details</a>";
                break;
            case 'account-details':
                echo "
                    <a href='?page=dashboard' >Dashboard</a>
                    <a href='?page=my-posts'>My Posts</a>
                    <a href='?page=account-details' class='active'>Account Details</a>";
                break;
        }
            echo "
        </div>
        <div id='logout'>
            <a href='?page=logout'>Logout</a>
        </div>
    </div><br>
    ";
    }

    function showComments($comments, $routeID)
    {
        echo "<section>
            <br><h2 class='center'>Comments</h2>
            <div class='comment-session'>
            <div class='post-comment'>
                <div class='comment-box'>
                    <div class='user'>
                        <div class='name'>Your comment</div>
                    </div>
                    <form action='new-comment.php' method='post'>
                        <textarea name='comment' id='' rows='3' placeholder='Your Message'></textarea>
                        <button id='comment-submit-btn' name = 'routeID' value='$routeID'>Comment</button>
                    </form>
                    <div id='errors'></div>
                </div>";
        if(!empty($comments)) {
            foreach ($comments as $id => $data) {
                $text = $data['text'];
                $date = $data['date'];
                $username = $data['username'];
                echo "
                <div class='list'>
                    <div class='user'>
                        <div class='user-meta'>
                            <div class='name'>$username</div>
                            <div class='date'>$date</div>
                        </div>
                    </div>
                    <div class='comment-post'>$text
                    </div>
                </div>";
            }
        }

        echo "
            </div>
        </div></section>";
    }

}