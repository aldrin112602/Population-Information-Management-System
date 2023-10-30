<?php
if ( $_SERVER[ 'REQUEST_METHOD' ] === 'GET' && isset( $_GET[ 'update_username' ] ) ) {
    $username = htmlspecialchars( $_GET[ 'update_username' ] );
    $select_sql = 'SELECT * FROM accounts WHERE username = ?';
    $select_stmt = $conn->prepare( $select_sql );
    $select_stmt->bind_param( 's', $username );
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    if ( $result->num_rows === 0 ) {
        echo '
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Data not found",
                        icon: "error",
                        onClose: function() {
                            window.open("./admin_list.php", "_self");
                        }
                    });
                })
            </script>
        ';

    } else {
        // show modal
        echo '
            <script>
                $(document).ready(function() {
                    $("#updateAdmin").modal("show");
                })
            </script>
        ';

    }

    $select_stmt->close();
}

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset( $_GET[ 'update_username' ] ) && isset( $_POST[ 'update_btn' ] ) ) {
    $username = htmlspecialchars( $_GET[ 'update_username' ] );
    $select_sql = 'SELECT * FROM accounts WHERE username = ?';
    $select_stmt = $conn->prepare( $select_sql );
    $select_stmt->bind_param( 's', $username );
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    if ( $result->num_rows === 0 ) {
        echo '
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Data not found",
                        icon: "error",
                        onClose: function() {
                            window.open("./barangay_list.php", "_self");
                        }
                    });
                })
            </script>
        ';

    } else {
        $username = htmlspecialchars( $_GET[ 'update_username' ] );
        $newUsername = filter_and_implode( $_POST[ 'username' ] ?? '' );
        $password = ucwords( filter_and_implode( $_POST[ 'password' ] ?? '' ) );
        $municipality = ucwords( filter_and_implode( $_POST[ 'municipality' ] ?? '' ) );
        $province = ucwords( filter_and_implode( $_POST[ 'province' ] ?? '' ) );
        $barangay = ucwords( filter_and_implode( $_POST[ 'barangay' ] ?? '' ) );
        $unique_id = trim($_POST['unique_id']);
        // Check if the new username already exists in the database
        $check_sql = 'SELECT * FROM accounts WHERE username = ?';
        $check_stmt = $conn->prepare( $check_sql );
        $check_stmt->bind_param( 's', $newUsername );
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        if ( $check_result->num_rows > 0 && $username != $newUsername) {
            echo '
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "Error!",
                        text: "The new username is already taken",
                        icon: "error",
                        onClose: function() {
                            window.open("./admin_list.php", "_self");
                        }
                    });
                })
            </script>
        ';
        } else {
            // The new username is available, proceed with the update operation
            $sql = "UPDATE accounts SET unique_id = '$unique_id', username = '$newUsername', password = '$password', municipality = '$municipality', province = '$province', barangay = '$barangay' WHERE username = '$username'";

            if ( mysqli_query( $conn, $sql ) ) {
                echo '
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: "Success!",
                            text: "Account updated successfully",
                            icon: "success",
                            onClose: function() {
                                window.open("./admin_list.php", "_self");
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
                            text: "Something went wrong",
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

        $check_stmt->close();
        $select_stmt->close();
    }
}

?>