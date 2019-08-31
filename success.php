<?php
require('config_css.php');
require('config_db.php');
require('header.php');

?>

<style>
    h1, h2 {
        text-align: center;
    }

    h2 {
        color: cornflowerblue;
    }

    a {
        color: salmon;
    }

    img {
        height:40%;
        width: 30%;
        margin-left: auto;
        margin-right: auto;
        display: block;
    }

</style>

<img src="images/slice.png">
<h1>Your recipe has successfully been uploaded!</h1>
<h2>Click <a href="my_recipes.php">HERE</a> to return to your recipes.</h2>

<style>
    .footer {
        left: 0;
        bottom: 0;
        width: 100%;
        height: 100px;
        background-color: salmon;
        color: white;
        text-align: center;
        padding-top: 10px;
        padding-bottom: 10px;
        position: absolute;
    }

</style>

<div id="container">
    <div class="footer">
        <h2 style="color:white;">Footer</h2>
        <h4>Original Artwork by Su Min Kim</h4>
    </div>
</div>
