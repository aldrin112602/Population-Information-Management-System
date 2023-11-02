<?php

require_once( '../config.php' );
require_once( '../global.php' );
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    // Validate or sanitize the table name to avoid SQL injection
    $table_name = mysqli_real_escape_string( $conn, $_POST[ 'table_name' ] );

    $update_qry = 'UPDATE ' . $table_name . ' SET ';

    $updates = array();
    foreach ( $_POST as $key => $value ) {
        if ( in_array( $key, [ 'id', 'table_name' ] ) ) {
            continue;
        }
        $value = mysqli_real_escape_string( $conn, $value );
        $updates[] = $key . " = '" . $value . "'";
    }

    $update_qry .= implode( ', ', $updates ) . ' WHERE id = ' . ( int )$_POST[ 'id' ];

    if ( mysqli_query( $conn, $update_qry ) ) {
        echo 'Record updated successfully!';
    } else {
        echo 'Error: ' . mysqli_error( $conn );
    }
}

?>