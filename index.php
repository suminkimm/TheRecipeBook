<?php
require('config_db.php');
require('config_css.php');

session_start();

?>

<style>
    h1 {
        text-align: center;
    }


    body, html {
        height: 100%;
        margin: 0px;
    }

    button {
        background-color: transparent;
        border: solid 2px white;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 20px;
        padding-right: 20px;
        color: white;
        font-size: 25px;
    }

    .login:hover {
        background:salmon;
        color:white;
    }

    .signup:hover {
        background-color: cornflowerblue;
        color:white;
    }

    /* The hero image */
    .hero-image {
        /* Use "linear-gradient" to add a darken background effect to the image (photographer.jpg). This will make the text easier to read */
        background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url("/images/teatime.jpg");

        /* Set a specific height */
        height: 100%;
        width: 100%;

        /* Position and center the image to scale nicely on all screens */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
    }

    /* Place text in the middle of the image */
    .hero-text {
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 25px;
    }

    .log-in-button {

        background-color: salmon;
        border: solid 2px white;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 20px;
        padding-right: 20px;
        color: white;
        font-size: 25px;
        width: 100%;

    }

    .sign-up-button {
        background-color: cornflowerblue;
        border: solid 2px white;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 20px;
        padding-right: 20px;
        color: white;
        font-size: 25px;
        width: 100%;
    }

    input[type=text], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }


    /* Center the image and position the close button */
    .imgcontainer {
        text-align: center;
        margin: 20px 0 12px 0;
        position: relative;
        /*padding-top: 10px;*/
    }

    .x-top {
        text-align: center;
        margin: 24px 0 12px 0;
        position: relative;
        padding-top: 20px;
    }

    img.avatar {
        width: 40%;
        border-radius: 50%;
    }

    .container {
        padding: 16px;

    }

    span.psw {
        float: right;
        padding-top: 16px;
    }

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        align: center;
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        padding-top: 60px;
    }

    /* Modal Content/Box */
    .modal-content {
        background-color: #fefefe;
        margin: 2% auto 10% auto; /* 5% from the top, 15% from the bottom and centered */
        border: 1px solid #888;
        width: 40%; /* Could be more or less, depending on screen size */
        height: 80%;
        padding: 5px;
    }

    /* The Close Button (x) */
    .close, .signup-close {
        position: absolute;
        right: 25px;
        top: 0;
        color: #000;
        font-size: 35px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: red;
        cursor: pointer;
    }
    
    .signup-close:hover,
    .signup-close:focus {
        color: blue;
        cursor: pointer;
    }

</style>


<div class="hero-image">
    <div class="hero-text">
        <h1>The Recipe Book</h1>
        <p>Discover your favorite recipe</p>
        <button class="login" onclick="signIn()">Log In</button>
        <button class="signup" onclick="signUp()">Sign Up</button>

    </div>
</div>

<div id="id01" class="modal">

    <form class="modal-content animate" method="post" action="index.php">
        <div class="x-top">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
        </div>
        <div class="imgcontainer">
            <img src="/images/login.png" alt="Avatar" class="avatar">
        </div>

        <div class="container">

            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Email" name="email" required style="color:salmon;"><br><br>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required style="color:salmon;"><br><br>

            <button class=log-in-button type="submit" name="logIn">Log In</button>

<!--            <a href="" style="color:salmon; font-size: 20px;">New? Sign Up</a>-->
        </div>

    </form>
</div>

    <!-- The Modal (contains the Sign Up form) -->
    <div id="id02" class="modal">
        <form class="modal-content" method="post" action="index.php">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id02').style.display='none'" class="signup-close" title="Close Modal">&times;</span>
            </div>
            <div class="container">
                <h1>Sign Up</h1>
                <p style="text-align: center;">Please fill in this form to create an account.</p>
                <hr>
                <br>
                <input type="text" placeholder="First Name" name="firstname" required style="width:49%;">
                <input type="text" placeholder="Last Name" name="lastname" required style="width:49%;"><br><br>

                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" required>
                <br><br>
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>
                <br><br>
                <label for="psw-repeat"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="password-repeat" required><br><br>
                <button type="submit" name="signUp" class="sign-up-button">Sign Up</button>
            </div>
        </form>
    </div>

<script type="text/javascript">
    function signIn() {
        document.getElementById('id01').style.display='block';
    }

    function signUp() {
        document.getElementById('id02').style.display='block';
    }
</script>

<?php

if (isset($_POST['logIn'])) {
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = mysqli_real_escape_string($link, $_POST['password']);

    $check_pwd = mysqli_query($link, "SELECT * FROM stuff.users WHERE email = '$email'");

    if (mysqli_num_rows($check_pwd) != 0) {
        while($row = $check_pwd->fetch_assoc()) {
            $hashed_pwd = $row['password'];
            $user_id = $row['user_id'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
        }

        if (password_verify($password, $hashed_pwd)) {


            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['valid'] = 1;

            echo "<script>window.location='main.php'</script>";

        }

        else {
            echo "<script>alert(\"Incorrect email or password. Please try again.\")</script>";
        }

    }
    else {
        echo "<script>alert(\"You have not created an account. Please sign up.\")</script>";
    }
}

elseif (isset($_POST['signUp'])) {

    $first_name = mysqli_real_escape_string($link, $_POST['firstname']);
    $last_name = mysqli_real_escape_string($link, $_POST['lastname']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $password_repeat = mysqli_real_escape_string($link, $_POST['password-repeat']);

    $fail = 0;

    if ($password != $password_repeat) {
        $fail = 1;
        echo "<script>alert(\"Your passwords do not match. Please try again.\");</script>";
        echo "<script>console.log('error');</script>";
    }

    // make sure user doesn't already exist
    $check = mysqli_query($link, "SELECT * FROM stuff.users WHERE email = '$email'");
    if (mysqli_num_rows($check) != 0) {
        $fail = 1;
        echo "<script>alert(\"You already have an existing account. Please sign in instead.\")</script>";
    }

    if ($fail == 0) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO stuff.users (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";
        $result = mysqli_query($link, $sql);

        if ($result) {
            $sql = mysqli_query($link, "SELECT MAX(user_id) as user_id FROM stuff.users");
            while ($row = $sql->fetch_assoc()) {
                $user_id = $row['user_id'];
            }

            echo "<script>alert('You have successfully created your account! Please log in through the portal.'); window.location='index.php'</script>";
        }

        else {
            echo mysqli_error($link);
            echo "<script>alert(\"Sorry, there was an error creating your account.\")</script>";
        }
    }
}