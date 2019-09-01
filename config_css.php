<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Alegreya|Josefin+Slab" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<style>
    * {
        font-family: Josefin Slab;
    }

    /* Create four equal columns that floats next to each other */
    .column1 {
        float: left;
        width: 150px;
        padding: 10px;

    }

    .column2 {
        float: left;
        width: 400px;
        padding: 10px;

    }

    .column3 {
        float: left;
        width: 700px;
        padding: 10px;

    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        padding: 16px;
        background-color: #f1f1f1;
        width: 700px;
    }

    .pw {
        width: 1200px;
        background-color: #555;
        overflow: auto;
    }


    /* ***************************** FORM ***************************** */

    input[type=text]{
        width: 275px;
        padding: 6px 10px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid cornflowerblue;
        border-radius: 4px;
        font-size: medium;
        font-family: 'Josefin Slab', serif;
        box-sizing: border-box;
        color: cornflowerblue;

    }

    input[type=password]{
        width: 275px;
        padding: 6px 10px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: medium;
        font-family: 'Josefin Slab', serif;
        box-sizing: border-box;

    }


    input[type=checkbox] {
        padding: 6px 10px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: medium;
        font-family: 'Josefin Slab', serif;
        box-sizing: border-box;
        color: cornflowerblue;

    }

    select {
        padding: 6px 10px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: medium;
        font-family: 'Josefin Slab', serif;
        box-sizing: border-box;

    }

    input[type=password], select {
        color: cornflowerblue;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-family: 'Josefin Slab', serif;
        box-sizing: border-box;
    }

    .float-right {
        float: right;
        padding-right: 200px;
    }

    .float-left {
        float: left;
        padding-left: 200px;
    }

    .center {
        text-align: center;
    }

    ::placeholder {
        color:cornflowerblue;
    }

    .star:hover {
        color:gold;
    }

    a {
        color: cornflowerblue;
    }
</style>
