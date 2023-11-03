<?php 
    require_once '../config.php';
    require_once '../global.php';

    if(isset($_SESSION['role'])) {
        if($_SESSION['role'] == 'super_admin') {
            header('location: ../super_admin');
        } else {
            // header('location: /admin');
        }
    } else {
        header('location: ../index.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Print report - PIMS | Population Information Monitoring System</title>
    <link rel="stylesheet" href="../src/bootstrap.min.css" />
    <!-- Favicon -->
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />

    <!-- For mobile devices -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/pims logo.png" />
    <meta name="msapplication-TileImage" content="img/pims logo.png" />
    <meta name="msapplication-TileColor" content="#ffffff" />

    <!-- Poppins font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

    <!-- google icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">

    <!-- custom styles -->
    <style>
    * {
        font-family: "Poppins", sans-serif;
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        transition: all 0.5s;
    }

    main.hidden {
        display: none;
    }
    </style>
</head>

<body>
    <main>

        <div class="table-responsive mt-3">
            <h3>Religion of the Couple and Single</h3>
            <?php 
                $sql = "SELECT DISTINCT religion FROM ( 
                    SELECT DISTINCT religion FROM survey_form_records_children WHERE unique_id = '{$_SESSION['unique_id']}'
                    UNION SELECT DISTINCT religion FROM survey_form_records_husband WHERE unique_id = '{$_SESSION['unique_id']}'
                    UNION SELECT DISTINCT religion FROM survey_form_records_wife WHERE unique_id = '{$_SESSION['unique_id']}' ) AS distinct_religion;";
                
                $result = mysqli_query($conn, $sql);
                
            
            ?>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col fw-bold">RELIGION</th>
                        <th scope="col fw-bold">COUPLE</th>
                        <th scope="col fw-bold">SINGLE CHILDREN</th>
                    </tr>
                </thead>
                <tbody>
                <?php
while ($row = mysqli_fetch_assoc($result)) {
    $religion = $row['religion'];

    // Count rows in survey_form_records_husband and survey_form_records_wife
    $queryHusbandWife = "
        SELECT 'Husband/Wife' AS source, COUNT(*) AS count
        FROM survey_form_records_husband
        WHERE religion = '$religion'
        UNION ALL
        SELECT 'Children' AS source, COUNT(*) AS count
        FROM survey_form_records_children
        WHERE religion = '$religion'
    ";
    $resultHusbandWife = mysqli_query($conn, $queryHusbandWife);

    // Process the results
    $counts = array();
    while ($countRow = mysqli_fetch_assoc($resultHusbandWife)) {
        $counts[$countRow['source']] = $countRow['count'];
    }

    ?>
    <tr>
        <td>
            <?php echo $religion; ?>
        </td>
        <td>
            <?php echo isset($counts['Husband/Wife']) ? $counts['Husband/Wife'] : 0; ?>
        </td>
        <td>
            <?php echo isset($counts['Children']) ? $counts['Children'] : 0; ?>
        </td>
    </tr>
    <?php
}

                ?>
                </tbody>

            </table>

        </div>
    </main>
    <script>
    window.onload = function() {
        // printPage()
    }

    let main = document.querySelector('main');
    // main.classList.add('hidden');

    function printPage() {
        main.classList.remove('hidden');
        window.print();

        window.addEventListener('afterprint', function() {
            main.classList.add('hidden');
        });
    }
    </script>
</body>

</html>