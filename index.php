<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Multiplication table</title>
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <input type="text" name="number" size="20" >   <br>
    <input type="submit" name="table" value="get table">
</form>

<?php include 'Table.php'; ?>
<?php

$table = new Table();
if( isset($_POST['number']) ):
    echo $table->validation($_POST['number'], 'html');


endif;
/*

if( isset($_POST['number']) ):
    if(empty( $_POST['number']) ) {
        echo 'Field can not be empty';
        return;
    }
    if ( !is_numeric( $_POST['number'])  ) {
        echo 'Input must be integer';
        return;
    }
    echo $Table->html_output_generator($_POST['number']);

endif;

*/



?>
</body>
</html>