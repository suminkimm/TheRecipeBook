<?php
session_start();

require('config_db.php');
require('config_css.php');
require('header.php');

if($_GET['author_id'] != null) { // someone is viewing someone else's profile
    $user_id = $_GET['author_id'];
    $sql = "SELECT * FROM stuff.users WHERE user_id='$user_id'";
    $result = mysqli_query($link, $sql);
    while($row = $result->fetch_assoc()) {
        $firstname = $row['first_name'];
        $lastname = $row['last_name'];
        $email = $row['email'];
    }
}
else {
    $firstname = $_SESSION['first_name'];
    $lastname = $_SESSION['last_name'];
    $email = $_SESSION['email'];
}


?>

<style>
    h3 {
        color:cornflowerblue;
        text-align: center;
    }

    td {
        color:cornflowerblue;
        font-size: 25px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 10px;
    }
    img {
        width: 18%;
        border-radius: 50%;
        float:left;
        margin-left: 25%;
        padding:50px;
        /*margin-left: auto;*/
        /*margin-right: auto;*/
        /*display:block;*/
    }

    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

    button {
        background-color: transparent;
        border: none;
        font-size: 20px;
    }

    .go:hover {
        color:red;
    }
</style>

<?php

//echo "<div style='float:left; margin-left: 10%; display: inline-block;'>";
echo "<div class='clearfix'>";
    echo "<img src=/images/login.png>";
    echo "<h1 style='margin-right:25%; padding-top: 70px;'>".$firstname." ".$lastname."</h1>";
    echo "<h3 style='margin-right:25%;'>$email</h3>";
//echo "<div style='float:right; margin-right: 30%;'>";
echo "</div>";



$sql = "SELECT * FROM stuff.recipes WHERE user_id='$user_id' ORDER BY recipe_name asc";
$result = mysqli_query($link, $sql);

echo "<div style='clear:both'>";
echo "<h1>Recipes</h1>";
echo "<table align='center'>";
echo "<ul>";
while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td><li>" .$row['recipe_name']. "</li></td>";
    echo "<td>" .$row['prep_time']. "</td>";
    echo "<td>" .$row['num_servings']. " servings</td>";
    echo "<td><button class='go' style='color:salmon;' onclick=\"window.location='indiv_recipe.php?id=" .$row['recipe_id']. "'\"><i class='fas fa-arrow-circle-right'></i></button></td>";
    echo "</tr>";
}
echo "</ul>";
echo "</table>";
echo "</div>";
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
