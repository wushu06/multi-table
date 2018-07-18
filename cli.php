<?php include 'Table.php'; ?>

<?php

$table = new Table();
if( isset( $argv[1] )) :
    echo $table->validation($argv[1]);
endif;