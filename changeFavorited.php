<?php

session_start();

require('config_db.php');

$user_id = $_GET['user'];
$recipe_id = $_GET['recipe'];

// check if delete
$sql = "SELECT * FROM stuff.rel_users_fav_recipes WHERE user_id='$user_id' AND recipe_id='$recipe_id'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) != 0) { // delete
    $delete = mysqli_query($link, "DELETE FROM stuff.rel_users_fav_recipes WHERE user_id='$user_id' AND recipe_id='$recipe_id'");
}

else { // add into table
    $insert = mysqli_query($link, "INSERT INTO stuff.rel_users_fav_recipes (user_id, recipe_id) VALUES ('$user_id', '$recipe_id')");
}

