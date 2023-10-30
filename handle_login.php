<?php
require_once './config.php';
require_once './global.php';

$username = $password = $err_msg = $success_msg = null;
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    $post = validate_post_data( $_POST );
    $username = $post[ 'username' ];
    $password = $post[ 'password' ];

    $condition = "username = '$username' AND password = '$password'";
    if ( isDataExists( 'accounts', '*', $condition ) ) {
        foreach ( getRows( $condition, 'accounts' ) as $row ) {
            $_SESSION[ 'login' ] = true;
            $_SESSION[ 'role' ] = $row[ 'role' ];
            $_SESSION[ 'username' ] = $row[ 'username' ];
            $_SESSION[ 'barangay' ] = $row[ 'barangay' ];
            $_SESSION[ 'municipality' ] = $row[ 'municipality' ];
            $_SESSION[ 'province' ] = $row[ 'province' ];
            $_SESSION[ 'unique_id' ] = $row[ 'unique_id' ];

        }

        echo '
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "Congratulations!",
                        text: "Logged in successfully",
                        icon: "success",
                        onClose: function() {
                            window.open("./login.php", "_self");
                        }
                    });
                })
            </script>
        ';
    } else {
        echo '
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Invalid username or password!",
                        icon: "error",
                        onClose: function() {
                            window.open("./login.php", "_self");
                        }
                    });
                })
            </script>
        ';
    }

} else {
    if ( isset( $_SESSION[ 'role' ] ) ) {
        if ( $_SESSION[ 'role' ] == 'super_admin' ) {
            header( 'location: ./super_admin/' );
        } else {
            header( 'location: ./admin/' );
        }
    }
}