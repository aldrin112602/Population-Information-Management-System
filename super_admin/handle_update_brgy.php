<?php
require_once './audit_trails.php';
if ( $_SERVER[ 'REQUEST_METHOD' ] === 'GET' && isset( $_GET[ 'update_id' ] ) ) {
    $unique_id = htmlspecialchars( $_GET[ 'update_id' ] );
    $select_sql = 'SELECT * FROM barangay WHERE unique_id = ?';
    $select_stmt = $conn->prepare( $select_sql );
    $select_stmt->bind_param( 's', $unique_id );
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    if ( $result->num_rows === 0 ) {
        logUser($_SESSION[ 'username' ], 'Trying to update, barangay not found!');
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
        // show modal
        echo '
            <script>
                $(document).ready(function() {
                    $("#updateBrgy").modal("show");
                })
            </script>
        ';
        
    }

    $select_stmt->close();
}

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset( $_GET[ 'update_id' ] ) && isset($_POST[ 'update_btn' ]) ) {
    $unique_id = htmlspecialchars( $_GET[ 'update_id' ] );
    $select_sql = 'SELECT * FROM barangay WHERE unique_id = ?';
    $select_stmt = $conn->prepare( $select_sql );
    $select_stmt->bind_param( 's', $unique_id );
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    if ( $result->num_rows === 0 ) {
        logUser($_SESSION[ 'username' ], 'Trying to update, barangay not found!');
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
        $barangay = ucwords(filter_and_implode( $_POST[ 'barangay' ] ?? '' ));
        $unique_id = htmlspecialchars( $_GET[ 'update_id' ] );
        $sql = "UPDATE barangay SET barangay = '$barangay' WHERE unique_id = '$unique_id'";
        

        if ( mysqli_query( $conn, $sql ) ) {
            logUser($_SESSION[ 'username' ], 'Barangay updated successfully!');
            echo '
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: "Success!",
                            text: "Barangay updated successfully",
                            icon: "success",
                            onClose: function() {
                                window.open("./barangay_list.php", "_self");
                            }
                        });
                    })
                </script>
            ';

        } else {
            logUser($_SESSION[ 'username' ], 'Error: Updating barangay!');
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
        
    }

    $select_stmt->close();
}


?>