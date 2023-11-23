<?php   
require_once './send_OTP.php';
require_once './config.php';
require_once './global.php';

$username = $password = $err_msg = $success_msg = null;
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' && isset($_POST[ 'username' ])) {
    $post = validate_post_data( $_POST );
    $username = $post[ 'username' ];
    $password = $post[ 'password' ];

    $condition = "username = '$username' AND password = '$password'";
    if ( isDataExists( 'accounts', '*', $condition ) ) {
        foreach ( getRows( $condition, 'accounts' ) as $row ) {
            $token = random_int(100000, 999999);
            $body = '
                    <!DOCTYPE html>
                    <html>
                        <head>
                            <title>Verification Code for PIMS - Tanay, Rizal</title>
                        </head>
                        <body>
                            <p>Dear '. $row['email'] .',</p>
                            <p>We received a verification code request for your account. If you did not initiate this request, please ignore this email, please enter the following verification code:</p>
                            <h2 style="text-align:center; font-size:32px;">'. $token .'</h2>
                            <p>This code is valid for <b>10 minutes</b>, so please enter it as soon as possible.</p>
                            <p>If you have any trouble entering the code, please don\'t hesitate to contact us at <a href="mailto:cabaleroaldrin02@gmail.com">cabaleroaldrin02@gmail.com</a>.</p>
                        </body>
                    </html>';

            if($row['enable2FA'] == 'true') {
                if(send_mail($row['email'], $body)) {
                    $_SESSION['validate_otp'] = $token;
                }
            } else {
                $_SESSION[ 'login' ] = true;
                $_SESSION[ 'role' ] = $row[ 'role' ];
                $_SESSION[ 'username' ] = $row[ 'username' ];
                $_SESSION[ 'barangay' ] = $row[ 'barangay' ];
                $_SESSION[ 'municipality' ] = $row[ 'municipality' ];
                $_SESSION[ 'province' ] = $row[ 'province' ];
                $_SESSION[ 'unique_id' ] = $row[ 'unique_id' ];

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
            }
        }

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