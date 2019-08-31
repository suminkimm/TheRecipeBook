<?php

session_start();
require('config_css.php');
require('config_db.php');

if (isset($_POST['submit'])) {
    ob_start();
    header('Location: success.php');
    exit();
}

require('header.php');

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

<?php if ($_SESSION['valid'] == 1) { ?>
    <h1>Create a New Recipe</h1>

    <form action="create_recipe.php" method="post" enctype="multipart/form-data">
        <table align="center">
            <tr>
                <td>
                    <input type="text" name="recipe-name" placeholder="Recipe Name" required>
                </td>
                <td>
                    Preparation Time:
                    <input type="text" name="prep-time" placeholder="#" style="width: 12%" required>
                    <select name="prep-time-unit" required>
                        <option value="minute(s)">minutes</option>
                        <option value="hour(s)">hours</option>
                        <option value="day(s)">days</option>
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
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
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
                    while ($row=$result->fetch_assoc()) {

                        echo "<input type=checkbox name=category[] value=" .$row['category_id']. "> " .$row['description']. "<br>";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="text" name="description" placeholder="Recipe Description" style="width:100%;">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    Ingredients
                </td>
            </tr>

            <tbody class="field_wrapper">
            <tr>
                <td>
                    <input type="text" name="ingredients[]" placeholder="Ingredient Name">
                </td>
                <td>
                    <input type="text" name="ing-amt[]" placeholder="Amount Needed (i.e. 200 grams)">
                </td>
                <td>
                    <button type="button" class="add" id="add"><i class="fas fa-plus-circle"></i></button>
                </td>
            </tr>
            </tbody>

            <?php $step = 1; ?>
            <tr>
                <td colspan="2" style="text-align: center;">
                    Instructions
                </td>
            </tr>

            <tbody class="instructions_wrapper">
            <tr>
                <td colspan="2">
                    <input type="text" name="instructions[]" placeholder="Step <?php echo $step; ?>" style="width:100%;">
                </td>
                <td>
                    <button type="button" class="add_instructions" id="add_instructions"><i class="fas fa-plus-circle"></i></button>
                </td>
                <input type="hidden" class="step" value="<?php echo $step; ?>">
            </tr>
            </tbody>

            <tr>
                <td colspan="2">
                    Upload Image (optional):
                    <input type="file" name="fileToUpload" id="fileToUpload" onchange='fileValidation(this)' style="display:inline">
                </td>
            </tr>

            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type=submit class="submit-button" name="submit" value="Submit Recipe">
                </td>
            </tr>
        </table>

    </form>

    <?php include('footer.php'); ?>


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
        $image = $_POST['fileToUpload'];

        date_default_timezone_set('US/Eastern');
        $curr_date = date('Y-m-d H:i:s', time());

        $final_ingredients_list = array();
        for($i = 0; $i < count($ingredients); $i ++) {
            $ing = $ing_amt[$i]." ! ".$ingredients[$i];
            array_push($final_ingredients_list, $ing);
        }

        $final_ingredients_list = implode("; ", $final_ingredients_list);


        // Insert into database
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO stuff.recipes (recipe_name, description, date_created, ingredients, instructions, prep_time, num_servings, image, user_id) VALUES 
        ('$recipe_name', '$description', '$curr_date', '$final_ingredients_list', '$instructions', '$total_prep_time', '$num_servings', '$image', '$user_id')";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo "Error inserting new recipe: ". mysqli_error($link);
        }

        // get ID
        $sql = "SELECT recipe_id FROM stuff.recipes WHERE recipe_id=(SELECT MAX(recipe_id) FROM stuff.recipes)";
        $result = mysqli_query($link, $sql);
        if(!$result) {
            echo "Error fetching recipe id: ". mysqli_error($link);
        }
        while($row=$result->fetch_assoc()) {
            $recipe_id = $row['recipe_id'];
        }

        // Insert into rel category
        foreach($category as $cat) {
            $sql = "INSERT INTO stuff.rel_category_recipes (recipe_id, category_id) VALUES ('$recipe_id', '$cat')";
            $result = mysqli_query($link, $sql);
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
            echo "Error uploading the image.";
        }

    }

}
else {
    include('error.php');
}
