<?php
    include("functions.php");
    include("views/header.php");
    $ti = "Recent Tweets";
    $t = "public";
    $tw=1;
    if (array_key_exists("page", $_GET)) {
        if ($x) {
            if ($_GET["page"] == "timeline") {
                $ti = "Tweets For You";
                $t = "private";}
            else if ($_GET["page"] == "yourtweets") {
                $ti = "Your Tweets";
                $t = "your";}
            else if ($_GET["page"] == "search") {
                $ti = "Tweets with ".$_GET["q"];
                $t = "search";}
            else if ($_GET["page"] == "publicprofiles") {
                $tw=0;
                $ti = "Public profiles";}
            else if ($_GET["page"] == "profile") {
                $tw=1;
                $ti = $_GET["email"]."'s tweets";
                $t=$_GET["email"];}
        } else { ?>
            <script>
                window.location.assign("http://localhost/twitter.com/MVC");
            </script>
<?php   }
    }
    include("views/home.php");
    include("views/footer.php"); 
?>