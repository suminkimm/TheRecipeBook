<?php
session_start();

require('config_db.php');
require('config_css.php');
require('header.php');

$firstname = $_SESSION['first_name'];
$lastname = $_SESSION['last_name'];
$email = $_SESSION['email'];

?>

<style>
    h3 {
        color:cornflowerblue;
        text-align: center;
    }


    img {
        padding: 70px;
        width: 20%;
        border-radius: 50%;
        margin-left: auto;
        margin-right: auto;
        display:block;
    }
</style>

<?php

echo "<img src=/images/login.png>";
echo "<h1>".$firstname." ".$lastname."</h1>";
echo "<h3>$email</h3>";

?>

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
        margin-bottom: 0;
        margin-top: 10%;
    }

</style>

<div class="footer">
    <h2>Footer</h2>
    <h4>Original Artwork by Su Min Kim</h4>
</div>
