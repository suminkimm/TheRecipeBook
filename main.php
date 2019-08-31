<?php

session_start();

require('config_css.php');
require('config_db.php');
require('header.php');


if ($_SESSION['valid'] == 1) { ?>

    <style>
        h3 {
            color: cornflowerblue;
            text-align: center;
        }

        img {
            height:350px;
            width:450px;
        }

        ul {
            color:salmon;
            font-size: 20px;
        }

        li {
            margin: 10px;

        }

        /*.image-cropper {*/
        /*    !*width: 100px;*!*/
        /*    !*height: 100px;*!*/
        /*    position: relative;*/
        /*    overflow: hidden;*/
        /*    border-radius: 50%;*/
        /*}*/

        .card {
            height: 425px;
            width: 350px;
            background: white;
        }
    </style>


    <div class="center">
        <h1>Welcome to The Recipe Book</h1>
        <h3>An open space to create and share your personal recipes.</h3><br>
    </div>

    <!--<div class="float-left">-->
    <!--    <div class="image-cropper">-->
    <!--        <img src="images/teatime.png">-->
    <!--    </div>-->
    <!--</div>-->

    <div class="float-left">
        <br><br><br>
        <img src="/images/pies.png">
    </div>

    <div class="float-right">
        <div class="card">
            <h1>Lorem Ipsum Right</h1>
            <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.<br><br>
                A scelerisque purus semper eget duis. Sit amet commodo nulla facilisi nullam vehicula.</h3>

            <ul>
                <li>Lorem</li>
                <li>Ipsum</li>
                <li>Dolor</li>
            </ul>
        </div>
    </div>

    <div class="float-left" style="padding-top: 90px;">
        <div class="card">
            <h1>Lorem Ipsum Left</h1>
            <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.<br><br>
                A scelerisque purus semper eget duis. Sit amet commodo nulla facilisi nullam vehicula.</h3>

            <ul>
                <li>Lorem</li>
                <li>Ipsum</li>
                <li>Dolor</li>
            </ul>
        </div>
    </div>

    <div class="float-right"style="padding-top: 90px;">
        <!--    <br><br><br><br><br><br>-->
        <img src="/images/omelette.png" style="height:360px; width:400px;">

    </div>

    <style>

        .footer {
            margin-top: 1100px;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 100px;
            background-color: salmon;
            color: white;
            text-align: center;
            padding-top: 10px;
            padding-bottom: 10px;
        }

    </style>

    <div class="footer">
        <h2>Footer</h2>
        <h4>Original Artwork by Su Min Kim</h4>
    </div>


    <?php
}

else {
    include('error.php');
}
?>

