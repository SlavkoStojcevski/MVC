<?php include("functions.php");
$message = "";
$stay=0;
if ($_GET["action"] == "getin") {
    if (array_key_exists("email", $_POST)) {
        if ($_POST["email"] == "") {
            $message .= "<p>Email field is empty!</p>";
        } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $message .= "<p>Invalid email format</p>";
        }
    }
    if (array_key_exists("password", $_POST)) {
        if ($_POST["password"] == "") {
            $message .= "<p>Password field is empty!</p>";
        }
    }
    if(array_key_exists("stay",$_POST)){
        if($_POST["stay"]!=""){
            if($_POST["stay"]=="1"){
                $stay=1;
            }
        }
    }
    if ($message == "") {
        $email = mysqli_real_escape_string($link, $_POST["email"]);
        $password = mysqli_real_escape_string($link, $_POST["password"]);
        $query = "SELECT * FROM `users` WHERE `email`='" . $email . "'";
        if ($result = mysqli_query($link, $query)) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                if (password_verify($password, $row["password"])) {
                    login($email,$stay);
                    $message = "";
                    echo "1";
                } else {
                    $message .= "<p>That email already exists, pick another email.<br>If 
                        the user is yours, you are entering a wrong password.</p>";
                }
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $empty = array();
                $query = "INSERT INTO `users`(`email`,`password`,`follows`)VALUES('" .
                    $email . "','" . $hash . "','" . json_encode($empty) . "')";
                if (mysqli_query($link, $query)) {
                    login($email,$stay);
                    $message = "";
                    echo "1";
                } else {
                    $message .= "<p>Experiencing some minor difficulties, please try again 
                        later.</p>";
                }
            }
        } else {
            $message .= "<p>Experiencing some minor difficulties right now, please try 
                again later.</p>";
        }
    }
    if ($message != "") {
        $message = '<div class="alert alert-danger" role="alert"><strong>There 
            were error(s) in your form:</strong><br><br>' . $message . '</div>';
    }
    echo $message;}
if ($_GET["action"] == "follow") {
    if ($x) {
        $state = "";
        $id = $_POST["id"];
        $follows = $_SESSION["follows"];
        if (array_key_exists($id, $follows)) {
            unset($follows[$id]);
            $_SESSION["follows"] = $follows;
            $state = "foolow";
        } else {
            $_SESSION["follows"][$id] = date("Y-m-d H:i:s");
            $state = "unfollow";
        }
        $query = "UPDATE`users`SET`follows`='" .
            json_encode($_SESSION['follows']) . "'WHERE`users`.`id`=" . $_SESSION['id'] . "";
        if (mysqli_query($link, $query)) {
            echo $state;
        } else {
            echo "Query error.";
        }
    } else {
        echo "unsigned";
    }}
if ($_GET["action"] == "newtweet") {
    if (array_key_exists("tweet", $_POST)) {
        if ($_POST["tweet"] != "") {
            $tweet = mysqli_real_escape_string($link, $_POST["tweet"]);
            $confirm = "";
            if (strlen($tweet) >= 500) {
                $confirm = "Tweet too long";
            } else {
                $query = "INSERT INTO`tweets`(`id`,`userid`,`tweet`,`datetime`)VALUES(NULL,'" .
                    $_SESSION['id'] . "','" . $tweet . "',NOW())";
                if (mysqli_query($link, $query)) {
                    $confirm = "1";
                } else {
                    $confirm = "Please try again later.";
                }
            }
        } else {
            $confirm = "Tweet is empty, write something.";
        }
    }
    echo $confirm;}
if ($_GET["action"] == "deleteuser") {
    $confirm = "";
    $deleteid=$_SESSION['id'];
    $query = "DELETE FROM `users` WHERE `users`.`id` = $deleteid";
    if (mysqli_query($link, $query)) {
        $query1 = "DELETE FROM `tweets` WHERE `tweets`.`userid` = $deleteid";
        if (mysqli_query($link, $query1)) {
            $confirm = "1";
        } else {
            $confirm = "Please try again later.";
        }
    } else {
        $confirm = "Please try again later.";
    }
    echo $confirm;}