<?php
if ( $_SERVER[ 'REQUEST_METHOD' ] === 'GET' && isset( $_GET[ 'unique_id' ] ) ) {
    $unique_id = htmlspecialchars( $_GET[ 'unique_id' ] );
    $select_sql = 'SELECT * FROM barangay WHERE unique_id = ?';
    $select_stmt = $conn->prepare( $select_sql );
    $select_stmt->bind_param( 's', $unique_id );
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
        $delete_sql = 'DELETE FROM barangay WHERE unique_id = ?';
        $stmt = $conn->prepare( $delete_sql );
        $stmt->bind_param( 's', $unique_id );

        if ( $stmt->execute() ) {
            echo '
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: "Success!",
                            text: "Barangay removed successfully",
                            icon: "success",
                            onClose: function() {
                                window.open("./barangay_list.php", "_self");
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
                            window.open("./barangay_list.php", "_self");
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
