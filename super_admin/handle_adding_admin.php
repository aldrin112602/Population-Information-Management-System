<?php

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset( $_POST[ 'add_admin' ] ) ) {

    $barangay = ucwords( filter_and_implode( $_POST[ 'barangay' ] ?? '' ) );
    $unique_id =  $_POST[ 'unique_id' ] ?? null;
    $username =  trim( filter_and_implode( $_POST[ 'username' ] ?? '' ) );
    $email =  trim( filter_and_implode( $_POST[ 'email' ] ?? '' ) );
    $password =  md5(trim( $_POST[ 'password' ] ?? '' ));
    $barangay =  ucwords( filter_and_implode( $_POST[ 'barangay' ] ?? '' ) );
    $municipality =  ucwords( filter_and_implode( $_POST[ 'municipality' ] ?? '' ) );
    $province =  ucwords( filter_and_implode( $_POST[ 'province' ] ?? '' ) );

    $select_sql = 'SELECT * FROM accounts WHERE username = ?';
    $select_stmt = $conn->prepare( $select_sql );
    $select_stmt->bind_param( 's', $username );
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    if ( $result->num_rows === 0 ) {
        $sql = "INSERT INTO accounts (unique_id, email, barangay, username, password, municipality, province, role)
            VALUES ('$unique_id', '$email', '$barangay', '$username', '$password', '$municipality', '$province', 'admin')";

        if ( mysqli_query( $conn, $sql ) ) {
            logUser($_SESSION[ 'username' ], 'Admin added successfully!');
            echo '
            <script>
                $(document).ready(function() {  
                    Swal.fire({
                        title: "Success!",
                        text: "Admin added successfully",
                        icon: "success",
                        onClose: function() {
                            window.open("./admin_list.php", "_self");
                        }
                    });
                })
            </script>
        ';

        } else {
            logUser($_SESSION[ 'username' ], 'Error: Failed to save Admin account!');
            echo '
            <script>
                $(document).ready(function() {
                    Swal.fire(
                        "Error!",
                        "Something went wrong",
                        "error"
                    );
                })
            </script>
        ';
        }

    } else {
        logUser($_SESSION[ 'username' ], 'Error: Trying to save admin account, username already exists!');
        echo '
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Username already exist",
                        icon: "error",
                        onClose: function() {
                            window.open("./admin_list.php", "_self");
                        }
                    });
                })
            </script>
        ';

    }

}

?>

