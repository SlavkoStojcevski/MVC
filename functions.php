<?php session_start();
$x = isset(($_SESSION["id"])) ? true : false;
$server = "localhost";
$user = "root";
$pass = "";
$db = "twitter";
$link = mysqli_connect($server, $user, $pass, $db);
if (mysqli_connect_errno()) {
    print_r(mysqli_connect_error());
    exit();}
function pull($query){
    global $link;
    $result = mysqli_query($link, $query);
    return mysqli_fetch_array($result)[0];}
function login($email,$stay){
    $_SESSION["email"] = $email;
    $_SESSION["id"] = pull("SELECT id FROM users WHERE email='" . $email . "'");
    $_SESSION["follows"] = json_decode(pull("SELECT follows FROM users WHERE email='" . $email . "'"), true);
    if ($stay==1) {
        setcookie("email", $email, time() + (60 * 60 * 24));
    }
    if ($_SESSION["email"] == $email) {
        $_GET["login"] = "1";
    }}
function tweets($type){
    global $x, $link,$z;
    $ntweet=0;
    $query = "SELECT * FROM tweets ORDER BY `datetime` DESC";
    $result = mysqli_query($link, $query);
    if ($x) {
        $follows = $_SESSION["follows"];
    }
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        $id = $row["userid"];
        $class = "btn-success";
        $name = "'>follow";
        if ($x) {
            if (array_key_exists($id, $follows)) {
                $class = "btn-danger";
                $name = "'>unfollow";
            }
        }
        $email=pull("SELECT email FROM users WHERE id=".$id);
        $direction=($x)?"href='?page=profile&email=".$email."'":$z;
        $tweet="<div class='text-light text-break rounded animate px-3 my-3 py-3'>
                <span class='text-secondary'>" . $row['datetime'] . "</span>
                <div class='email mb-3'>
                    <a class='text-decoration-none'$direction
                    ><b>".$email."</b></a> says:
                </div>
                <p class='text-light'>".$row["tweet"]."</p>
                <button class='btn ms-sm-2 follow $class'data-userid='$id$name</button>
            </div>";
        if(filter_var($type, FILTER_VALIDATE_EMAIL)){
            if($type==$email){
                echo $tweet;$ntweet++;
            }
        } else {
            if ($type == "public") {
                echo $tweet;$ntweet++;
            } else if($type=="private") {
                if (array_key_exists($id, $follows)) {
                    echo $tweet;$ntweet++;
                }
            } else if($type=="your") {
                if ($id==$_SESSION["id"]) {
                    echo $tweet;$ntweet++;
                }
            } else if($type=="search") {
                if(preg_match('/[A-Z]/', $_GET["q"])){
                    $tought=$row["tweet"];
                } else {
                    $tought=strtolower($row["tweet"]);
                }
                if(strpos($tought,$_GET["q"])!=""){
                    echo $tweet;$ntweet++;
                }
            }
        }
    }
    if($ntweet==0){
        echo '<p class="alert alert-info fw-bold fs-4 animate my-3">Nothing here.</p>';
    }}
function search(){
    global $x,$z;
    $y=($x)?'button id="search"type="submit"':"a ".$z;
    $end=($x)?'button':'a';
    echo '<form class="d-flex mx-3 form-inline">
            <input type="hidden"name="page"value="search">
            <input type="search"name="q"class="form-control bg-transparent text-light me-2"id="browse"placeholder="Search tweets"aria-label="Search">
            <'.$y.'class="btn btn-outline-success">Search</'.$end.'>
        </form>';}
function newtweet(){
    global $x;
    $newtweet = '<div class="shadow-sm animate my-5 py-4 px-3 rounded"><div id="poet"class="form-floating"><textarea class="form-control mb-4 bg-transparent text-light"
        placeholder="t"id="tweet"style="height:200px"></textarea><label class="text-primary pb-5"for="tweet"><h5>New Tweet</h5></label><button class="btn mx-5 btn-primary"
        id="newtweet">Post tweet</button></div></div>';
    if ($x) {
        echo $newtweet;
    }}
function profiles(){
    global $link;
    $result = mysqli_query($link,"SELECT email FROM users");
    echo "<br>";
    while($row=mysqli_fetch_array($result)){
        echo "<p class='rounded py-2 animate'><a class='text-decoration-none'href='?page=profile&email=".$row[0]."'><b>".$row[0]."</b></a></p>";
    }}
function deleteuser(){
    echo "<button id='deleteuser' class='my-5 btn btn-danger'>delete user</button>
    <div class='animate rounded-3 py-4' id='delete'>
        <p class='text-danger fw-bold fs-3'>Are you sure?</p>
        <button id='no' class='mx-3 btn btn-success'>No</button>
        <button id='yes' class='mx-3 btn btn-danger'>Yes</button></div>";}
if (array_key_exists("login", $_GET)) {
    if ($_GET["login"] == "0") {
        session_destroy();
        header("Location: index.php");
    }}
