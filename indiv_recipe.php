<?php

session_start();
require('config_css.php');
require('config_db.php');
require('header.php');

?>

<style>
    h3 {
        color:cornflowerblue;
        text-align: center;
    }

    h2 {
        color: salmon;
        text-align: center;
    }

    img {
        height: 300px;
        width; 330px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    td {
        padding: 10px;
        color: cornflowerblue;
        font-size: 20px;
        text-align: left;
    }

    .float-left {
        padding:0;
        margin-left: 10%;
        text-align: center;

    }

    .float-right {
        padding:0;
        margin-right: 10%;
        text-align: center;
        width: 40%;

    }

    .bottom {
        padding-bottom: 50%;
    }

    button {
        font-size: 20px;
        color: cornflowerblue;
        border: none;
        background: transparent;
    }

</style>


<?php

if ($_SESSION['valid'] == 1) {
    $recipe_id = $_GET['id'];

    $sql = "SELECT * FROM stuff.recipes r
    INNER JOIN stuff.users u
    ON r.user_id = u.user_id
    WHERE recipe_id = '$recipe_id'";
    $result = mysqli_query($link, $sql);

    while ($row=$result->fetch_assoc()) {
        $recipe_name = $row['recipe_name'];
        $description = $row['description'];

        $date_created = $row['date_created'];
        $date_created = new DateTime($date_created);
        $date_created = $date_created->format('Y-m-d');

        $date_edited = $row['date_edited'];
        $date_edited = new DateTime($date_edited);
        $date_edited = $date_edited->format('Y-m-d');

        $ingredients = explode("; ", $row['ingredients']);
        $instructions = explode(" % ", $row['instructions']);
        $prep_time = $row['prep_time'];
        $num_servings = $row['num_servings'];
        $image = $row['image'];

        $author_id = $row['user_id'];
        $author_firstname = $row['first_name'];
        $author_lastname = $row['last_name'];
    }

    $check = "SELECT * FROM stuff.rel_users_fav_recipes WHERE user_id=".$_SESSION['user_id']." AND recipe_id = '$recipe_id'";
    $check = mysqli_query($link, $check);

    echo "<div class=float-left>";
    if (mysqli_num_rows($check) != 0) {
        echo "<h1>".$recipe_name."<button id='$recipe_id' class='star' style='color:gold;' onclick='changeFavorited(" .$recipe_id. ", " .$_SESSION['user_id']. ")'><i class=\"fas fa-star\"></i></button></h1>";
    }
    else {
        echo "<h1>".$recipe_name."<button id='$recipe_id' class='star' onclick='changeFavorited(" .$recipe_id. ", " .$_SESSION['user_id']. ")'><i class=\"fas fa-star\"></i></button></h1>";
    }
    echo "<h3>$description</h3>";

    if ($image == null) {
        echo "<img src=images/slice.png>";
    }
    else {
        echo "<img src=images/" .$recipe_id. "/" .$image. ">";
    }

    echo "<div class=center>";
    echo "<h3>Servings: " .$num_servings. "</h3>";
    echo "<h3>Prep Time: " .$prep_time. "</h3>";
    echo "</div>";

    echo "<br>";
    echo "<h2>Ingredients</h2>";
    echo "<table>";
    $i = 1;
    foreach($ingredients as $ingredient) {
        $ingredient = str_replace(" ! ", " ", $ingredient);
        if ($i % 2 == 1) echo "<tr>";
        echo "<td><li>" .$ingredient. "</li></td>";
        if ( $i % 2 == 0 || $i == count($ingredients)) echo "</tr>";
        $i++;
    }
    echo "</table>";
    echo "</div>";

    echo "<div class=float-right>";
    echo "<br><br>";
    if ($date_edited == null) {
        echo "<h3 style='text-align:right;'>" .$date_created. "</h3>";
    }
    else {
        echo "<h3 style='text-align:right;'> Last Edited: " .$date_created. "</h3>";
    }

    if($author_id != $_SESSION['user_id']) {
        echo "<h3 style='text-align:right;'> By " .$author_firstname. " " .$author_lastname. "</h3>";
    }
    else { ?>
        <a href='edit_recipe.php?recipe_id=<?php echo $recipe_id; ?>' style="float:right; color:cornflowerblue;">Edit Recipe</a>

        <?php
    }
    echo "<br>";

    //    echo "<div class=ing-center>";

    echo "<h2>Instructions</h2>";
    echo "<ol>";
    echo "<table align='center'>";

    foreach($instructions as $step) {
        echo "<tr>";
        echo "<td></td>";
        echo "<td><li>" .$step. "</li></td>";
        echo "</tr>";
    }
    echo "</ol>";
    echo "</table>";
    //    echo "</div>";
    echo "</div>";
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
            padding-bottom: 10px;
            margin-top: 70%;
        }

    </style>

    <div class="footer">
        <h2>Footer</h2>
        <h4>Original Artwork by Su Min Kim</h4>
    </div>

    <script type="text/javascript">
        function changeFavorited(recipe_id, user_id) {
            var star = document.getElementById(recipe_id);

            if(star.style.color == "gold") {
                console.log("convert to blue");
                star.style.color = "cornflowerblue";
            }

            else {
                console.log("convert to gold");
                star.style.color="gold";

            }

            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET","changeFavorited.php?user="+user_id+"&recipe="+recipe_id,true);


            xmlhttp.onreadystatechange = function() { //Call a function when the state changes.
                if(this.readyState == 4 && this.status == 200) {
                    console.log(xmlhttp.responseText);
                }
            }
            xmlhttp.send();
        }
    </script>
<?php
}
else {
    include('error.php');
}







