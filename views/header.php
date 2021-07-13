<!doctype html>
<html class="nightsky"lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist
    /css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/
    FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"> -->
        <link rel="shortcut icon" href="views/tree.jpg" type="image/x-icon">
        <link href="views/styles.css?ver=<?php echo rand(111, 999) ?>" rel="stylesheet">
        <link href="views/bootstrap-5-beta/css/bootstrap.css?ver=<?php echo rand(111, 999) ?>" rel="stylesheet">
        <title>Twitter</title>
        <nav class="navbar navbar-expand-xxl blur fixed-top navbar-dark">
            <div class="container-fluid">
                <a class="rounded nav-link mx-3 fw-bolder fs-2 text-primary animate" href="http://localhost/twitter.com/MVC/">
                    Twitter
                </a>
                <strong class="text-success mx-3 d-inline"><h5>Welcome</h5><?php echo $y = ($x) ? " " . $_SESSION["email"] : ""; ?></strong>
                <?php 
                    $z = 'data-bs-toggle="modal"data-bs-target="#getinform"';
                    $h='<a class="nav-link rounded text-success my-1 fw-bold"';
                    search();?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#pages" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="pages">
                    <?php echo $h.$y=($x)?'href="#new_tweet"':$z;?>>New Tweet</a>
                    <?php echo $h . $y = ($x) ? 'href="?page=timeline"' : $z; ?>>Your timeline</a>
                    <?php echo $h . $y = ($x) ? 'href="?page=yourtweets"' : $z; ?>>Your tweets</a>
                    <?php echo $h . $y = ($x) ? 'href="?page=publicprofiles"' : $z; ?>>Public Profiles</a><?php 
                    $c = ($x) ? 'danger"' : 'success"';
                    $n = ($x) ? ">Logout" : "><strong>Login/Signup</strong>";
                    $l = ($x) ? 'href="index.php?login=0"' : $z;
                    echo'<a class="btn py-1 btn-outline-'.$c.$l.$n.'</a>';?>
                </div>
            </div>
        </nav>
    </head>
    <body class="bg-transparent">