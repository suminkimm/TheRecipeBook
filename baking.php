<?php

session_start();

require('config_css.php');
require('config_db.php');
require('header.php');
?>

<style>

    img {
        height: 200px;
        width: 225px;
        align: center;
    }


    h2, h3 {
        color: salmon;
    }

    p {
        color:cornflowerblue;
    }

    td {
        padding-left: 20px;
        padding-right: 20px;
    }

    button {
        font-size: 20px;
        color: cornflowerblue;
        border: none;
        background: transparent;
    }

    input {
        color: cornflowerblue;
    }


    /*.outer-card {*/
    /*    padding-top: 30px;*/
    /*    height: 340px;*/
    /*    width: 280px;*/
    /*    background: white;*/
    /*    text-align: center;*/
    /*}*/

    .card {
        padding-top: 30px;
        height: 340px;
        width: 280px;
        background: white;
        text-align: center;
    }

    .card:hover {
        background-color: lightgoldenrodyellow;
    }

    .container-card {
        padding: 30px;
        float: left;
        align-content: center;
    }
    .row {
        margin-left: 160px;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }


</style>

<?php if ($_SESSION['valid'] == 1) { ?>
    <br><br><br>
    <div class="center">
        <h1 style="display: inline;">Baking Recipes</h1>
    </div>

    <br><br>

    <form action="#" method="post">
        <div class="center">
            <table align="center">
                <td>
                    <h3 style="display:inline; color:cornflowerblue; ">Sort By: </h3>
                    <select name="sort-by">
                        <option value="0" <?php if ($_POST['sort-by'] == 0) echo "selected='selected'"; ?>>Choose an option</option>
                        <option value="1" <?php if ($_POST['sort-by'] == 1) echo "selected='selected'"; ?>>A-Z</option>
                        <option value="2" <?php if ($_POST['sort-by'] == 2) echo "selected='selected'"; ?>>Z-A</option>
                        <option value="3" <?php if ($_POST['sort-by'] == 3) echo "selected='selected'"; ?>>Most Recent</option>
                    </select>
                </td>
                <td>
                    <h3 style="display:inline; color:cornflowerblue; ">Filter By: </h3>
                    <select name="filter-by">
                        <option value="0">Choose an option</option>

                        <?php
                        $sql = "SELECT * FROM stuff.category WHERE category_id != 1 AND category_id != 2";
                        $result = mysqli_query($link, $sql);

                        while($row=$result->fetch_assoc()) { ?>
                            <option value="<?php echo $row['category_id']; ?>" <?php if ($_POST['filter-by'] == $row['category_id']) echo "selected='selected'"; ?>><?php echo $row['description']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <input type="submit" name="submit" value="Submit">
                </td>
            </table>
        </div>
    </form>


    <?php
// only baking

    if(isset($_POST['submit'])) {

        $category = $_POST['filter-by'];
        $sortby = $_POST['sort-by'];

        if ($category != "0") {

            $filtered = "SELECT T1.recipe_id
        FROM rel_category_recipes T1
        JOIN rel_category_recipes T2 ON T1.recipe_id = T2.recipe_id AND T2.category_id = '$category'
        WHERE T1.category_id = '1'";

            $result = mysqli_query($link, $filtered);
            $filtered_ids = array();
            while ($row=$result->fetch_assoc()) {
                array_push($filtered_ids, $row['recipe_id']);
            }
            $filtered_ids = implode(", ", $filtered_ids);

            $sql = "SELECT * FROM stuff.recipes WHERE recipe_id IN ($filtered_ids)";
            if ($sortby == 1) {
                $sql .= " ORDER BY recipe_name";
            }
            elseif ($sortby == 2) {
                $sql .= " ORDER BY recipe_name desc";
            }
            else {
                $sql .= " ORDER BY date_created desc";
            }

        }

        if($sortby != "0" AND $category == "0") {

            $sql = "SELECT * FROM stuff.recipes r
        INNER JOIN stuff.rel_category_recipes rcr
        ON rcr.recipe_id = r.recipe_id
        WHERE rcr.category_id = 1";

            if ($sortby == 1) {
                $sql .= " ORDER BY recipe_name";
            }
            elseif ($sortby == 2) {
                $sql .= " ORDER BY recipe_name desc";
            }
            else {
                $sql .= " ORDER BY date_created desc";
            }
        }

    }

    else {
        $sql = "SELECT * FROM stuff.recipes r
    INNER JOIN stuff.rel_category_recipes rcr
    ON rcr.recipe_id = r.recipe_id
    WHERE rcr.category_id = 1
    ORDER BY recipe_name";
    }

    $result = mysqli_query($link, $sql);
    $total = mysqli_num_rows($result);
    $count = 0;

    if ($total == 0) {
        echo "<img src=images/slice.png style='margin-left: auto; margin-right: auto; display: block;'>";
        echo "<h2 style='text-align: center;'>No results were found.</h2>";
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
                position: absolute;
            }

        </style>

        <div class="footer">
            <h2>Footer</h2>
            <h4>Original Artwork by Su Min Kim</h4>
        </div>
        <?php
    }

    else {
        while ($row=$result->fetch_assoc()) {
            $recipe_id = $row['recipe_id'];
            $recipe_name = $row['recipe_name'];
            $prep_time = $row['prep_time'];
            $num_servings = $row['num_servings'];
            $img = $row['image'];

            $count++;

            ?>

            <?php if ($count % 3 == 1) { echo "<div class=\"row\">"; } ?>
            <div class="container-card">
                <div class="card" onclick="toIndivRecipe(event, <?php echo $recipe_id; ?>)" >
                    <?php if ($img == null) {
                        echo "<img src=images/slice.png>";
                    }
                    else {
                        echo "<img src=images/" .$recipe_id. "/" .$img. ">";
                    }
                    ?>
                    <h3><?php echo $recipe_name; ?></h3>
                    <p>Prep time: <?php echo $prep_time; ?></p>
                    <p>Servings: <?php echo $num_servings; ?></p>
                    <?php

                    $check = "SELECT * FROM stuff.rel_users_fav_recipes WHERE user_id=".$_SESSION['user_id']." AND recipe_id = '$recipe_id'";
                    $check2 = mysqli_query($link, $check);

                    ?>
                    <button style="
                            <?php
                            if (mysqli_num_rows($check2) == 0) {
                                echo "float:right;";
                            }
                            else {
                                echo "float:right; color:gold;";
                            }
                            ?>
                            " id="<?php echo $recipe_id;?>" class="star" onclick="favorited( <?php echo $recipe_id; ?>, <?php echo $_SESSION['user_id'];?> )">
                        <i class="fas fa-star"></i></button>
                </div>
            </div>
            <?php if ($count % 3 == 0 || $count==$total) { echo "</div>"; } ?>



            <?php

        }
        echo "<br><br><br><br>";
        include('footer.php');
    }
    ?>

    <script type="text/javascript">
        function toIndivRecipe(e, recipe_id) {
            var target = e.target;

            if(!target.className.match('.star')) {

                window.location = 'indiv_recipe.php?id=' + recipe_id;
            }
        }

        function favorited(recipe_id, user_id) {
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
?>
