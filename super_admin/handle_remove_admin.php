<?php
if ( $_SERVER[ 'REQUEST_METHOD' ] === 'GET' && isset( $_GET[ 'username' ] ) ) {
    $username = htmlspecialchars( $_GET[ 'username' ] );
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
        $delete_sql = 'DELETE FROM accounts WHERE username = ?';
        $stmt = $conn->prepare( $delete_sql );
        $stmt->bind_param( 's', $username );

        if ( $stmt->execute() ) {
            echo '
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: "Success!",
                            text: "Accounts removed successfully",
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
        $stmt->close();
    }

    $select_stmt->close();
}

?>
