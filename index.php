<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Multiplication table</title>
    <style>
        tr:first-child, td:first-child {
            background-color: #ccc;
        }
        td {
            padding: 15px;
        }
    </style>
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <label for="number">Number</label> <br>
    <input title="number" type="text" name="number" size="20" >   <br>
    <input type="submit" name="table" value="get table">
</form>

<?php

use Helper\Table;

require_once 'helper/Table.php';
?>
<?php

/*
 * Initialize the Table class
 * pass $_POST request to be validated
 * pass html to trigger the right function
 */
$table = new Table();

if (isset($_POST['number'])) :
    echo $table->validation($_POST['number'], 'html');
endif;
?>
</body>
</html>