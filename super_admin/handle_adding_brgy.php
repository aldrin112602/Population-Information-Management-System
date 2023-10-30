<?php

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset($_POST[ 'barangay' ]) && isset($_POST[ 'add_btn' ])) {

    $barangay = ucwords(filter_and_implode( $_POST[ 'barangay' ] ?? '' ));
    $unique_id = uniqid();

    $sql = "INSERT INTO barangay (unique_id, barangay)
            VALUES ('$unique_id', '$barangay')";
    

    if ( mysqli_query( $conn, $sql ) ) {
        echo '
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "Success!",
                        text: "Barangay added successfully",
                        icon: "success",
                        onClose: function() {
                            
                        }
                    });
                })
            </script>
        ';

    } else {
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

}

?>

