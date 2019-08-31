<?php
session_start();

require('config_css.php');
require('config_db.php');
require('header.php');

$recipe_id = $_GET['recipe_id'];

if($_SESSION['valid'] == 1) {
    $sql = "SELECT * FROM stuff.recipes WHERE recipe_id='$recipe_id'";
    $result = mysqli_query($link, $sql);

    while($row=$result->fetch_assoc()) {
        $recipe_name = $row['recipe_name'];
        $description = $row['description'];
        $date_edited = $row['date_edited'];

        $ingredients = $row['ingredients'];
        $ingredients = explode("; ", $ingredients);

        $instructions = $row['instructions'];
        $instructions = explode(" % ", $instructions);

        $prep_time = $row['prep_time'];
        $prep_time = explode(" ", $prep_time);

        $time = $prep_time[0];
        $units = $prep_time[1];

        $num_servings = $row['num_servings'];
        $image = $row['image'];
    }

    $sql = "SELECT * FROM stuff.rel_category_recipes WHERE recipe_id='$recipe_id'";
    $result = mysqli_query($link, $sql);

    $categories = array();
    if (mysqli_num_rows($result) != 0) {
        while($row=$result->fetch_assoc()) {
            array_push($categories, $row['category_id']);
        }
    }

    ?>
    <style>
        td {
            padding: 20px;
            color: cornflowerblue;
            font-size: 20px;
        }

        button {
            font-size: 15px;
            color: cornflowerblue;
            border: none;
            background: transparent;
        }

        .submit-button {
            font-size: 30px;
            color: salmon;
            align: center;
            border: 4px cornflowerblue;
            padding: 10px;
        }

    </style>

    <h1>Edit Recipe</h1>

    <form action="edit_recipe.php" method="post" enctype="multipart/form-data">
        <table align="center">
            <tr>
                <td>
                    <input type="text" name="recipe-name" placeholder="Recipe Name" value="<?php echo $recipe_name; ?>" required>
                </td>
                <td>
                    Preparation Time:
                    <input type="text" name="prep-time" placeholder="#" value="<?php echo $time; ?>" style="width: 12%" required>
                    <select name="prep-time-unit" required>
                        <option value="minute(s)" <?php if ($units == "minute(s)") echo "selected='selected'"; ?>>minutes</option>
                        <option value="hour(s)" <?php if ($units == "hour(s)") echo "selected='selected'"; ?>>hours</option>
                        <option value="day(s)" <?php if ($units == "day(s)") echo "selected='selected'"; ?>>days</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Number of Servings:
                    <select name="num-servings" required>
                        <?php
                        $i = 1;
                        while($i <= 30) { ?>
                            <option value="<?php echo $i; ?>" <?php if ($num_servings==$i) echo "selected='selected'"; ?>><?php echo $i; ?></option>
                            <?php
                            $i++;
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Category (if any apply):
                </td>

                <td>
                    <?php
                    $sql = "SELECT * FROM stuff.category";
                    $result = mysqli_query($link, $sql);
                    while ($row=$result->fetch_assoc()) { ?>

                        <input type='checkbox' name='category[]' value='<?php echo $row['category_id']; ?>' <?php if (in_array($row['category_id'], $categories)) echo "checked='checked'"; ?>> <?php echo $row['description']; ?><br>
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="text" name="description" placeholder="Recipe Description" value="<?php echo $description; ?>" style="width:100%;">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    Ingredients
                </td>
            </tr>

            <tbody class="field_wrapper">

            <?php

            $count = 1;
            foreach($ingredients as $ingredient) {
                $exploded = explode(" ! ", $ingredient);
                    echo "<tr>";
                        echo "<td>";
                            echo "<input type='text' name='ingredients[]' placeholder='Ingredient Name' value='$exploded[1]'>";
                        echo "</td>";
                        echo "<td>";
                            echo "<input type='text' name='ing-amt[]' placeholder='Amount Needed (i.e. 200 grams)' value='$exploded[0]'>";
                        echo "</td>";
                        echo "<td>";
                            if ($count == 1) {
                                echo "<button type='button' class='add' id='add'><i class='fas fa-plus-circle'></i></button>";
                            }
                            else {
                                echo "<button type='button' class='add' id='add'><i class='fas fa-minus-circle'></i></button>";
                            }
                        echo "</td>";
                    echo "</tr>";

                    $count++;

            }
            ?>
            </tbody>

            <tr>
                <td colspan="2" style="text-align: center;">
                    Instructions
                </td>
            </tr>

            <tbody class="instructions_wrapper">
            <?php
            $step = 1;

            foreach($instructions as $instruction) {
                echo "<tr>";
                    echo "<td colspan='2'>";
                        echo "<input type='text' name='instructions[]' placeholder='Step " .$step. "' value='" .$instruction. "' style='width:100%;'>";
                    echo "</td>";
                    echo "<td>";
                        if ($step == 1) {
                            echo "<button type=\"button\" class=\"add_instructions\" id=\"add_instructions\"><i class=\"fas fa-plus-circle\"></i></button>";
                        }
                        else {
                            echo "<button type=\"button\" class=\"remove_input_button\" id=\"remove_input_button\"><i class=\"fas fa-minus-circle\"></i></button>";
                        }
                    echo "</td>";
                    echo "<input type=\"hidden\" class=\"step\" value='" .$step. "'>";
                echo "</tr>";
                $step++;
            }
            echo "</tbody>";


            ?>


            <tr>
                <td colspan="2">
                    Upload Image (optional):
                    <input type="file" name="fileToUpload" id="fileToUpload" onchange='fileValidation(this)' style="display:inline">
                </td>
            </tr>

            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type=submit class="submit-button" name="submit" value="Edit Recipe">
                </td>
            </tr>
        </table>
        <input type="hidden" name="date-edited" value="<?php echo $date_edited; ?>">
        <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
    </form>

<?php
    include('footer.php');

    ?>

    <script type="text/javascript">

        // FOR INGREDIENTS
        $(document).ready(function(){
            var max_fields = 20;
            var add_input_button = $('.add');
            var field_wrapper = $('.field_wrapper');
            var new_field_html =
                '                <tr class=ingredient>\n' +
                '                    <td>\n' +
                '                        <input type="text" name="ingredients[]" placeholder="Ingredient Name">\n' +
                '                    </td>\n' +
                '                    <td>\n' +
                '                        <input type="text" name="ing-amt[]" placeholder="Amount Needed (i.e. 200 grams)">\n' +
                '                    </td>\n' +
                '<td>' +
                '<button type="button" class="remove_input_button" id="remove_input_button"><i class="fas fa-minus-circle"></i></button>' +
                '</td>' +
                '                </tr>\n'
            var input_count = 1;

            // Add button dynamically
            $(add_input_button).click(function(){

                if(input_count < max_fields){
                    input_count++;
                    $(field_wrapper).append(new_field_html);
                }
            });
            // Remove dynamically added button
            $(field_wrapper).on('click', '.remove_input_button', function(e){
                e.preventDefault();
                $(this).parent().parent().remove();
                input_count--;
            });
        });


        // FOR INSTRUCTIONS
        $(document).ready(function(){
            var max_fields = 20;
            var add_input_button = $('.add_instructions');
            var field_wrapper = $('.instructions_wrapper');
            var input_count = 1;

            // Add button dynamically
            $(add_input_button).click(function(){
                var step = parseInt($('.step').last().val())+1;
                console.log(step);

                var new_field_html =
                    '               <tr>\n' +
                    '                <td colspan="2">\n' +
                    '                    <input type="text" name="instructions[]" placeholder="Step ' + step + '" style="width:100%;">' +
                    '                </td>\n' +
                    '                <td>' +
                    '                <button type="button" class="remove_input_button" id="remove_input_button"><i class="fas fa-minus-circle"></i></button>' +
                    '                </td>' +
                    '                <input type="hidden" class="step" value="' + step + '">' +
                    '               </tr>'
                if(input_count < max_fields){
                    input_count++;
                    $(field_wrapper).append(new_field_html);
                }
            });
            // Remove dynamically added button
            $(field_wrapper).on('click', '.remove_input_button', function(e){
                e.preventDefault();
                $(this).parent().parent().remove();
                input_count--;
            });
        });


        function fileValidation(file) {
            var validFileExtensions = [".png", ".jpg", ".jpeg"];
            var filePath = file.value;

            var valid = 0;

            for (var j = 0; j < validFileExtensions.length; j ++) {
                if(filePath.includes(validFileExtensions[j]) == true){
                    valid = 1;
                }
            }

            if (valid == 0){
                alert('Please upload file having extensions .png/.jpg/.jpeg only.');
                file.value = '';
            }
        }

    </script>

    <?php

    if (isset($_POST['submit'])) {

        $recipe_id = $_POST['recipe_id'];
        $recipe_name = $_POST['recipe-name'];
        $prep_time = $_POST['prep-time'];
        $prep_time_unit = $_POST['prep-time-unit'];
        $total_prep_time = $prep_time." ".$prep_time_unit;
        $num_servings = $_POST['num-servings'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $ingredients = $_POST['ingredients'];
        $ing_amt = $_POST['ing-amt'];
        $instructions = implode(" % ", $_POST['instructions']);
        $date_edited = $_POST['date_edited']; // date last edited

        date_default_timezone_set('US/Eastern');
        $curr_date = date('Y-m-d H:i:s', time());

        $final_ingredients_list = array();
        for($i = 0; $i < count($ingredients); $i ++) {
            $ing = $ing_amt[$i]." ! ".$ingredients[$i];
            array_push($final_ingredients_list, $ing);
        }

        $final_ingredients_list = implode("; ", $final_ingredients_list);


        // Update database
        $user_id = $_SESSION['user_id'];

        $error = 0;

        if (basename($_FILES["fileToUpload"]["name"]) != null) {

            $image = basename($_FILES["fileToUpload"]["name"]);
            $sql = "UPDATE stuff.recipes 
            SET recipe_name='$recipe_name', description='$description', date_edited='$curr_date', ingredients='$final_ingredients_list', 
            instructions='$instructions', prep_time='$total_prep_time', num_servings='$num_servings', image='$image' 
            WHERE recipe_id='$recipe_id'";

            $result = mysqli_query($link, $sql);

            if (!$result) {
                $error = 1;
                echo "Error editing recipe: ". mysqli_error($link);
            }

            // IMAGE
            if(!is_dir("images/". $recipe_id ."/")) { // if doesn't exist in directory
                mkdir("images/". $recipe_id ."/"); // make it
            }

            $target_dir = "images/". $recipe_id . "/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

            $file_name = basename($_FILES["fileToUpload"]["name"]);
            $file_name = $_FILES["fileToUpload"]["name"];

            if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

            }
            else {
                $error = 1;
                echo "Error uploading the image.";
            }
        }

        else { // just keep the old image
            $sql = "UPDATE stuff.recipes 
            SET recipe_name='$recipe_name', description='$description', date_edited='$curr_date', ingredients='$final_ingredients_list', 
            instructions='$instructions', prep_time='$total_prep_time', num_servings='$num_servings'
            WHERE recipe_id='$recipe_id'";

            echo "sql: ".$sql;

            $result = mysqli_query($link, $sql);

            if (!$result) {
                $error = 1;
                echo "Error editing recipe: ". mysqli_error($link);
            }

        }


        // Update rel category

        $sql = "SELECT category_id FROM stuff.rel_category_recipes WHERE recipe_id='$recipe_id'";
        $check_cat = mysqli_query($link, $sql);

        if(mysqli_num_rows($check_cat) == 0) {
            foreach($category as $cat) {
                $sql = "INSERT INTO stuff.rel_category_recipes (recipe_id, category_id) VALUES ('$recipe_id', '$cat')";
                $result = mysqli_query($link, $sql);

                if(!$result) {
                    $error = 1;
                }
            }
        }

        else {
            $prev_cat = array();
            while($row = $check_cat->fetch_assoc()) {
                array_push($prev_cat, $row['category_id']);
            }

            foreach($category as $cat) {
                if (!in_array($cat, $prev_cat)) {
                    $sql = "INSERT INTO stuff.rel_category_recipes (recipe_id, category_id) VALUES ('$recipe_id', '$cat')";
                    $result = mysqli_query($link, $sql);

                    if(!$result) {
                        $error = 1;
                    }
                }
            }

            foreach($prev_cat as $prev) {
                if (!in_array($prev, $category)) {
                    $sql = "DELETE FROM stuff.rel_category_recipes WHERE recipe_id='$recipe_id' AND category_id='$prev'";
                    $result=mysqli_query($link, $sql);

                    if(!$result) {
                        $error = 1;
                    }
                }
            }
        }

        if($error != 1) {
            echo "<script>window.location='success.php'</script>";
        }

    }
}
else {
    include('error.php');
}
?>




