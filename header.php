<?php
require('config_css.php');
require('config_db.php');

session_start();

?>

<style>

    body, html {
        background-color: floralwhite;
        margin: 0px;
    }
    h1 {
        color: salmon;
        text-align: center;
        padding-top: 20px;
    }

    /* Navbar container */
    .navbar {
        overflow: hidden;
        border-top: solid 2px salmon;
        border-bottom: solid 2px salmon;
        background-color: white;
    }

    /* Links inside the navbar */
    .navbar a {
        float: left;
        font-size: 18px;
        color: lightcoral;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    /* The dropdown container */
    .dropdown {
        float: left;
        overflow: hidden;
    }

    /* Dropdown button */
    .dropdown .dropbtn {
        font-size: 17.5px;
        border: none;
        outline: none;
        color: lightcoral;
        padding: 14px 16px;
        background-color: inherit;
        font-family: inherit; /* Important for vertical align on mobile phones */
        margin: 0; /* Important for vertical align on mobile phones */
    }

    /* Add a red background color to navbar links on hover */
    .navbar a:hover, .dropdown:hover .dropbtn {
        background-color: salmon;
        color: white;
    }

    /* Dropdown content (hidden by default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: lavenderblush;
        min-width: 155px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown-content-left {
        display: none;
        position: absolute;
        background-color: lavenderblush;
        min-width: 150px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        right:0;
    }

    /* Links inside the dropdown */
    .dropdown-content a, .dropdown-content-left a {
        float: none;
        color: cornflowerblue;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }

    /* Add a grey background color to dropdown links on hover */
    .dropdown-content a:hover, .dropdown-content-left a:hover {
        background-color: salmon;
    }

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropdown-content-left {
        display:block;
    }
</style>

<h1> ---- The Recipe Book ----</h1>
<div class="navbar">
    <a class="active" href="main.php">Home</a>
        <div class="dropdown">
            <button class="dropbtn">Browse Recipes
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <a href="baking.php">Baking</a>
                <a href="cooking.php">Cooking</a>
            </div>
        </div>
    <div class="dropdown">
        <button class="dropbtn">My Recipes
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <a href="/my_recipes.php">Personal Recipes</a>
            <a href="/favorited_recipes.php">Favorited Recipes</a>
        </div>
    </div>
    <div style="float:right;">
        <a href="create_recipe.php"><i class="fas fa-plus-circle" style="font-size: 15px;"></i> New Recipe</a>
        <div class="dropdown">
            <button class="dropbtn"><?php if ($_SESSION['valid'] == 1) echo $_SESSION['first_name']; else { echo "??????"; } ?>
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content-left">
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>