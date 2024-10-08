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

    $sql = "SELECT * FROM accounts WHERE username = '{$_SESSION['username']}' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $profile = !empty($row['profile']) ? $row['profile'] : 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Circle-icons-profile.svg/1200px-Circle-icons-profile.svg.png';
    $username = $row['username'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Records - PIMS | Population Information Monitoring System</title>
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
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="../assets/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">

    <script src="../src/jquery.min.js"></script>
    <script src="../src/sweetalert2/sweetalert2.all.min.js"></script>

    <!-- w3JS -->
    <script src="https://www.w3schools.com/lib/w3.js"></script>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <!-- custom styles -->
    <style>
    * {
        font-family: "Poppins", sans-serif;
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    table th[contenteditable="true"]:hover {
        cursor: pointer;
    }

    table th[contenteditable="true"]:focus {
        cursor: default;
    }

    .resize_th {
        overflow: auto;
        resize: both;
        cursor: none;
    }

    .modal {
        z-index: 1050;
        /* Adjust this value as needed */
    }

    .modal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    </style>
</head>

<body>
    <?php require_once './handle_params.php' ?>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div>
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar bg-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-item text-center">
                                <img src="../img/pims logo.png" alt="pims logo" class="img-fluid" width="200px">
                            </li>
                            <li class="nav-item text-center my-4">
                                <img src="<?php echo $profile ?>" alt="Profile avatar" class="img-fluid rounded-circle"
                                    width="100px"><br>
                                <h3 class="text-white py-2"><?php echo $username ?></h3>
                            </li>
                            <li class="nav-item my-1">
                                <a href="./index.php"
                                    class="text-center text-white d-flex align-items-center justify-content-start gap-2 ml-4 fs-6">
                                    <span class="material-symbols-outlined">dashboard</span>
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item my-1 current-page">
                                <a href=""
                                    class="text-center text-white d-flex align-items-center justify-content-start gap-2 ml-4 fs-6">
                                    <span class="material-symbols-outlined">bar_chart_4_bars</span>
                                    Records
                                </a>
                            </li>
                            <!-- <li class="nav-item my-1">
                                <a href="./print_report.php"
                                    class="text-center text-white d-flex align-items-center justify-content-start gap-2 ml-4 fs-6">
                                    <span class="material-symbols-outlined">print</span>
                                    Print report
                                </a>
                            </li> -->
                            <li class="nav-item my-1">
                                <a href="setting.php"
                                    class="text-center text-white d-flex align-items-center justify-content-start gap-2 ml-4 fs-6">
                                    <span class="material-symbols-outlined">settings</span>
                                    Settings
                                </a>
                            </li>
                            <li class="nav-item mt-3">
                                <a href="../logout.php"
                                    class="text-center text-white d-flex align-items-center justify-content-start gap-2 ml-4 fs-6">
                                    <span class="material-symbols-outlined">logout</span>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <div class="row justify-content-between">
                                    <h2 class="pageheader-title font-weight-bold col-12 col-md-6">Records</h2>
                                    <form action="javascript:void(0)"
                                        class="col-12 col-md-6 d-flex align-items-center justify-content-between gap-2 mb-3">
                                        <div class="position-relative" style="width: 100%; ">

                                            <span class="material-symbols-outlined position-absolute" style="top: 50%;
                                                         left: 13px;
                                                         transform: translateY(-50%);">search</span>
                                            <input oninput="w3.filterHTML('#tbl', 'tr', this.value);" type="text"
                                                placeholder="Search here" id="searchInput"
                                                class="form-control form-control-lg" style="
                                                border-radius: 50px;
                                                padding-left: 40px;">

                                            </span>
                                        </div>
                                        <?php 
                                         $household_id = uniqid();
                                        ?>
                                        <a role="button"
                                            href="./add_record.php?household_id=<?php echo $household_id ?>"
                                            class="btn text-white btn-lg" style="
                                            background-color: #1D5B79;
                                            border-radius: 50px;
                                        ">+ Add Record</a>
                                    </form>
                                </div>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">Records</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Home</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container mt-5 mx-0 px-0">
                        <div class="input-group mb-3 gap-2 mx-0">
                            <div class="input-group-prepend">
                                <button data-btns="1" id="btns"
                                    class="btn border btn-light shadow border-primary">Household</button>
                            </div>
                            <div class="input-group-prepend">
                                <button data-btns="2" id="btns"
                                    class="btn border btn-light shadow border-primary">Families</button>
                            </div>
                            <div class="input-group-prepend">
                                <button data-btns="3" id="btns"
                                    class="btn border btn-light shadow border-primary">Husband</button>
                            </div>
                            <div class="input-group-prepend">
                                <button data-btns="4" id="btns"
                                    class="btn border btn-light shadow border-primary">Wife</button>
                            </div>
                            <div class="input-group-prepend">
                                <button data-btns="5" id="btns"
                                    class="btn border btn-light shadow border-primary">Children</button>
                            </div>
                            <div class="input-group-prepend">
                                <button data-btns="6" id="btns"
                                    class="btn border btn-light shadow border-primary">Other-Household</button>
                            </div>
                            <div class="input-group-prepend">
                                <button data-btns="7" id="btns"
                                    class="btn border btn-light shadow border-primary">All</button>
                            </div>
                        </div>
                        <script>
                        $(document).ready(function() {
                            // Hide all tables except the first one
                            $('.table-responsive:gt(0)').hide();

                            // Function to show/hide tables
                            function toggleTable(containerNumber) {
                                $('.table-responsive').hide();
                                $('#container' + containerNumber).show();
                                $('button#btns').removeClass('active');
                                $('button#btns[data-btns="' + containerNumber + '"]').addClass('active');
                                localStorage.setItem("tabs", containerNumber);
                                if (containerNumber == 7) {
                                    $(".table-responsive").show();
                                }
                                $("#tbl-last").show();
                            }

                            // Click event handler for buttons
                            $('button#btns').on('click', function() {
                                let containerNumber = $(this).attr('data-btns');
                                toggleTable(containerNumber);
                            });

                            // Initialize based on localStorage
                            if (!localStorage.getItem("tabs")) {
                                localStorage.setItem("tabs", 1);
                            }

                            const initialTab = localStorage.getItem("tabs");
                            toggleTable(initialTab);
                        });
                        </script>

                        <div class="p-0 py-4 d-flex justify-content-between px-0" style="width: 100%;">
                            <div class="d-flex align-items-center">

                            </div>

                            <div class="ms-auto d-flex gap-4">
                                <a class="btn text-white btn-sm d-flex gap-2 align-items-center justify-content-between"
                                    style="background-color: #1D5B79;" href="./print_report.php">
                                    <span class="material-symbols-outlined">print</span> Print Report
                                </a>

                                <a class="btn text-white btn-sm d-flex gap-2 align-items-center justify-content-between"
                                    style="background-color: #1D5B79;" href="./save_pdf_report.php">
                                    <span class="material-symbols-outlined">picture_as_pdf</span> Export Report
                                </a>


                            </div>
                        </div>



                        <script>
                        $(document).ready(function() {
                            $('#filter_by').on('change', function(ev) {
                                location.href = '?filter_by=' + ev.target.value;
                            });
                        });
                        </script>

                    </div>
                    <div class="table-responsive mt-3" style="display: none;" id="container1">

                        <h5 class="fw-bold text-primary">Household data:</h5>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col fw-bold">ID</th>
                                    <th scope="col fw-bold">Name</th>
                                    <th scope="col fw-bold">Household number</th>
                                    <th scope="col fw-bold">Household</th>
                                    <th scope="col fw-bold">Sex</th>
                                    <th scope="col fw-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tbl">
                                <?php
    $household_page_number = (int) ($_GET['household_page'] ?? 1);
    $limit = 5;
    $initial_page = ($household_page_number - 1) * $limit;

    $query = "unique_id = '{$_SESSION['unique_id']}' AND (belongs_to IS NULL OR belongs_to = '')  ORDER BY name ASC LIMIT $initial_page, $limit";

    $data = getRows($query, 'survey_form_records_husband');

    $rows_count = 1;
    foreach ($data as $row) {
    ?>
                                <tr>
                                    <th scope="row" spellcheck="false">
                                        <?php echo $row['id'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['name']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_husband')">
                                        <?php echo $row['name'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['household_id'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_husband')">
                                        <?php echo $row['household_id'] ?>
                                    </th>


                                    <!-- household -->
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['household']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_husband')">
                                        <?php echo $row['household'] ?>
                                    </th>

                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['sex'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'sex', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'sex', 'survey_form_records_husband')">
                                        <?php echo $row['sex']  ?>
                                    </th>



                                    <td class="d-flex align-items-center justify-content-start gap-2">
                                        <button data-type="husband" data-action="remove" style="height: 33px"
                                            data-id="<?php echo $row['id'] ?>" id="action_btn"
                                            class="btn btn-danger btn-sm fs-6 d-flex align-items-center justify-content-center">
                                            <span class="material-symbols-outlined fs-6">
                                                close
                                            </span></button>
                                        <a href="./update_form.php?household_id=<?php echo $row['household_id'] ?>" class="btn btn-sm btn-primary">View more</a>



                                    </td>
                                </tr>
                                <?php
                                    $rows_count++;
                                 }
                                ?>
                            </tbody>
                        </table>
                        <nav class="d-flex align-items-center justify-content-end py-3">
                            <ul class="pagination gap-0">
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary" href="?household_page=<?php 
            if ($household_page_number > 1) {
                $household_page_number--;
            }
            echo $household_page_number;
            ?>">Previous</a>
                                </li>
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary"
                                        href="?household_page=<?php echo $household_page_number; ?>">
                                        <?php echo $_GET['household_page'] ?? $household_page_number ?>
                                    </a>
                                </li>
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary" href="?household_page=<?php 
            $household_page_number++;
            echo $household_page_number;
            ?>">Next</a>
                                </li>
                            </ul>
                        </nav>

                    </div>
                    <div class="table-responsive mt-3" style="display: none;" id="container2">

                        <h5 class="fw-bold text-primary">Families data:</h5>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col fw-bold">ID</th>
                                    <th scope="col fw-bold">Name</th>
                                    <th scope="col fw-bold">Household number</th>
                                    <th scope="col fw-bold">Household</th>
                                    <th scope="col fw-bold">Sex</th>
                                    <th scope="col fw-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tbl">
                                <?php
$families_page_number = (int) ($_GET['families_page'] ?? 1);
$limit = 5;
$initial_page = ($families_page_number - 1) * $limit;

$query = "unique_id = '{$_SESSION['unique_id']}' ORDER BY name ASC LIMIT $initial_page, $limit"; // Default query without filter

$data = getRows($query, 'survey_form_records_husband');

$rows_count = 1;
foreach ($data as $row) {
    // Your code to handle the retrieved data

?>

                                <tr>
                                    <th scope="row" spellcheck="false">
                                        <?php echo $row['id'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['name']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_husband')">
                                        <?php echo $row['name'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['household_id'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_husband')">
                                        <?php echo $row['household_id'] ?>
                                    </th>


                                    <!-- household -->
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['household']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_husband')">
                                        <?php echo $row['household'] ?>
                                    </th>

                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['sex'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'sex', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'sex', 'survey_form_records_husband')">
                                        <?php echo $row['sex']  ?>
                                    </th>



                                    <td class="d-flex align-items-center justify-content-start gap-2">
                                        <button data-type="husband" data-action="remove" style="height: 33px"
                                            data-id="<?php echo $row['id'] ?>" id="action_btn"
                                            class="btn btn-danger btn-sm fs-6 d-flex align-items-center justify-content-center">
                                            <span class="material-symbols-outlined fs-6">
                                                close
                                            </span></button>
                                        <button class="btn btn-sm btn-primary"
                                            onclick="showMoreData(<?php echo $row['id'] ?>, 'survey_form_records_husband')">View
                                            more</button>

                                    </td>
                                </tr>
                                <?php
                                    $rows_count++;
                                 }
                                ?>
                            </tbody>
                        </table>
                        <nav class="d-flex align-items-center justify-content-end py-3">
                            <ul class="pagination gap-0">
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary" href="?families_page=<?php 
                                    if ($families_page_number > 1) {
                                        $families_page_number--;
                                    }
                                    echo $families_page_number;
                                    ?>">Previous</a>
                                </li>
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary"
                                        href="?families_page=<?php echo $families_page_number; ?>">
                                        <?php echo $_GET['families_page'] ?? $families_page_number ?>
                                    </a>
                                </li>
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary" href="?families_page=<?php 
                                    $families_page_number++;
                                    echo $families_page_number;
                                    ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="table-responsive mt-3" style="display: none;" id="container3">
                        <!-- Bootstrap Modal -->
                        <div class="modal fade" id="husbandModal" tabindex="-1" role="dialog"
                            aria-labelledby="husbandModalLabel" aria-hidden="true">
                            <!-- Modal content -->
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="husbandModalLabel">Husband Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div id="husbandData"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                        function openHusbandModal(rowId) {
                            // Ajax call to retrieve data based on rowId
                            $.ajax({
                                url: 'retrieve_husband_data.php', // Replace with your PHP file to fetch husband data
                                method: 'POST',
                                data: {
                                    id: rowId
                                },
                                success: function(response) {
                                    // Update the modal content with the retrieved data
                                    $('#husbandData').html(response);
                                    $('#husbandModal').modal('show'); // Show the modal
                                },
                                error: function(xhr, status, error) {
                                    console.error(error);
                                }
                            });
                        }
                        </script>
                        <h5 class="fw-bold text-primary">Husband data:</h5>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col fw-bold">ID</th>
                                    <th scope="col fw-bold">Name</th>
                                    <th scope="col fw-bold">Household number</th>
                                    <th scope="col fw-bold">Household</th>
                                    <th scope="col fw-bold">Sex</th>
                                    <th scope="col fw-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tbl">
                                <?php
$husband_page_number = (int) ($_GET['husband_page'] ?? 1);
$limit = 5;
$initial_page = ($husband_page_number - 1) * $limit;

$query = "unique_id = '{$_SESSION['unique_id']}' ORDER BY name ASC LIMIT $initial_page, $limit"; // Default query without filter

$data = getRows($query, 'survey_form_records_husband');

foreach ($data as $row) {
    // Your code to handle the retrieved data

?>
                                <tr>
                                    <th scope="row" spellcheck="false">
                                        <?php echo $row['id'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['name']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_husband')">
                                        <?php echo $row['name'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['household_id'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_husband')">
                                        <?php echo $row['household_id'] ?>
                                    </th>


                                    <!-- household -->
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['household']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_husband')">
                                        <?php echo $row['household'] ?>
                                    </th>

                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['sex'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'sex', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'sex', 'survey_form_records_husband')">
                                        <?php echo $row['sex']  ?>
                                    </th>



                                    <td class="d-flex align-items-center justify-content-start gap-2">
                                        <button data-type="husband" data-action="remove" style="height: 33px"
                                            data-id="<?php echo $row['id'] ?>" id="action_btn"
                                            class="btn btn-danger btn-sm fs-6 d-flex align-items-center justify-content-center">
                                            <span class="material-symbols-outlined fs-6">
                                                close
                                            </span></button>
                                        <button class="btn btn-sm btn-primary"
                                            onclick="showMoreData(<?php echo $row['id'] ?>, 'survey_form_records_husband')">View
                                            more</button>

                                    </td>
                                </tr>
                                <?php
                                    $rows_count++;
                                 }
                                ?>
                            </tbody>
                        </table>
                        <nav class="d-flex align-items-center justify-content-end py-3">
                            <ul class="pagination gap-0">
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary" href="?husband_page=<?php 
                                    if ($husband_page_number > 1) {
                                        $husband_page_number--;
                                    }
                                    echo $husband_page_number;
                                    ?>">Previous</a>
                                </li>
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary"
                                        href="?husband_page=<?php echo $husband_page_number; ?>">
                                        <?php echo $_GET['husband_page'] ?? $husband_page_number ?>
                                    </a>
                                </li>
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary" href="?husband_page=<?php 
                                    $husband_page_number++;
                                    echo $husband_page_number;
                                    ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="table-responsive mt-3" style="display: none;" id="container4">
                        <h5 class="fw-bold text-primary">Wife data:</h5>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col fw-bold">ID</th>
                                    <th scope="col fw-bold">Name</th>
                                    <th scope="col fw-bold">Household number</th>
                                    <th scope="col fw-bold">Household</th>
                                    <th scope="col fw-bold">Sex</th>
                                    <th scope="col fw-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tbl">
                                <?php
// Other existing code remains unchanged...

$wife_page_number = (int)($_GET['wife_page'] ?? 1);
$limit = 5;
$initial_page = ($wife_page_number - 1) * $limit;

// Construct the basic query without the filter condition
$query = "unique_id = '{$_SESSION['unique_id']}' ORDER BY name ASC LIMIT $initial_page, $limit";

// Fetch data without applying any filter condition
$data = getRows($query, 'survey_form_records_wife');

// Display the fetched data
foreach($data as $row) {
    // Display data rows here

?>

                                <tr>
                                    <th scope="row" spellcheck="false">
                                        <?php echo $row['id'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['name']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_wife')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_wife')">
                                        <?php echo $row['name'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['household_id'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_wife')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_wife')">
                                        <?php echo $row['household_id'] ?>
                                    </th>


                                    <!-- household -->
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['household']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_wife')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_wife')">
                                        <?php echo $row['household'] ?>
                                    </th>

                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['sex'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'sex', 'survey_form_records_wife')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'sex', 'survey_form_records_wife')">
                                        <?php echo $row['sex']  ?>
                                    </th>



                                    <td class="d-flex align-items-center justify-content-start gap-2">
                                        <button data-type="wife" data-action="remove" style="height: 33px"
                                            data-id="<?php echo $row['id'] ?>" id="action_btn"
                                            class="btn btn-danger btn-sm d-flex align-items-center justify-content-center">
                                            <span class="material-symbols-outlined fs-6">
                                                close
                                            </span></button>
                                        <button class="btn btn-primary btn-sm"
                                            onclick="showMoreData(<?php echo $row['id'] ?>, 'survey_form_records_wife')">View
                                            more</button>

                                    </td>
                                </tr>
                                <?php
                                $rows_count++;
}
                                ?>

                            </tbody>
                        </table>
                        <nav class="d-flex align-items-center justify-content-end py-3">
                            <ul class="pagination gap-0">
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary" href="?wife_page=<?php 
                                    if ($wife_page_number > 1) {
                                        $wife_page_number--;
                                    }
                                    echo $wife_page_number;
                                    ?>">Previous</a>
                                </li>
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary" href="?wife_page=<?php echo $wife_page_number; ?>">
                                        <?php echo $_GET['wife_page'] ?? $wife_page_number ?>
                                    </a>
                                </li>
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary" href="?wife_page=<?php 
                                    $wife_page_number++;
                                    echo $wife_page_number;
                                    ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="table-responsive mt-3" style="display: none;" id="container5">
                        <h5 class="fw-bold text-primary">Children data:</h5>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col fw-bold">ID</th>
                                    <th scope="col fw-bold">Name</th>
                                    <th scope="col fw-bold">Household number</th>
                                    <th scope="col fw-bold">Household</th>
                                    <th scope="col fw-bold">Sex</th>
                                    <th scope="col fw-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tbl">
                                <?php
// Other existing code remains unchanged...

$children_page_number = (int)($_GET['children_page'] ?? 1);
$limit = 5;
$initial_page = ($children_page_number - 1) * $limit;

// Construct the basic query without the filter condition
$query = "unique_id = '{$_SESSION['unique_id']}' ORDER by name ASC LIMIT $initial_page, $limit";

// Fetch data without applying any filter condition
$data = getRows($query, 'survey_form_records_children');

// Display the fetched data

foreach($data as $row) {
    // Display data rows here

?>

                                <tr>
                                    <th scope="row" spellcheck="false">
                                        <?php echo $row['id'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['name']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_children')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_children')">
                                        <?php echo $row['name'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['household_id'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_children')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_children')">
                                        <?php echo $row['household_id'] ?>
                                    </th>


                                    <!-- household -->
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['household']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_children')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_children')">
                                        <?php echo $row['household'] ?>
                                    </th>

                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['sex'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'sex', 'survey_form_records_children')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'sex', 'survey_form_records_children')">
                                        <?php echo $row['sex']  ?>
                                    </th>



                                    <td class="d-flex align-items-center justify-content-start gap-2">
                                        <button data-type="children" data-action="remove" style="height: 33px"
                                            data-id="<?php echo $row['id'] ?>" id="action_btn"
                                            class="btn btn-danger btn-sm fs-6 d-flex align-items-center justify-content-center">
                                            <span class="material-symbols-outlined fs-6">
                                                close
                                            </span></button>
                                        <button class="btn btn-sm btn-primary"
                                            onclick="showMoreData(<?php echo $row['id'] ?>, 'survey_form_records_children')">View
                                            more</button>

                                    </td>
                                </tr>
                                <?php
                                $rows_count++;
                                 }
                                ?>
                            </tbody>
                        </table>
                        <nav class="d-flex align-items-center justify-content-end py-3">
                            <ul class="pagination gap-0">
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary" href="?children_page=<?php 
                                    if ($children_page_number > 1) {
                                        $children_page_number--;
                                    }
                                    echo $children_page_number;
                                    ?>">Previous</a>
                                </li>
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary"
                                        href="?children_page=<?php echo $children_page_number; ?>">
                                        <?php echo $_GET['children_page'] ?? $children_page_number ?>
                                    </a>
                                </li>
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary" href="?children_page=<?php 
                                    $children_page_number++;
                                    echo $children_page_number;
                                    ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="table-responsive mt-3" style="display: none;" id="container6">
                        <h5 class="fw-bold text-primary">Other household data:</h5>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col fw-bold">ID</th>
                                    <th scope="col fw-bold">Name</th>
                                    <th scope="col fw-bold">Household number</th>
                                    <th scope="col fw-bold">Household</th>
                                    <th scope="col fw-bold">Sex</th>
                                    <th scope="col fw-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tbl">
                                <?php
// Other existing code remains unchanged...

$otherhousehold_page_number = (int)($_GET['otherhousehold_page'] ?? 1);
$limit = 5;
$initial_page = ($otherhousehold_page_number - 1) * $limit;

// Construct the basic query without the filter condition
$query = "unique_id = '{$_SESSION['unique_id']}' ORDER by name ASC LIMIT $initial_page, $limit";

// Fetch data without applying any filter condition
$data = getRows($query, 'survey_form_records_household_member');

// Display the fetched data
$rows_count = 1;
foreach($data as $row) {
    // Display data rows here

?>
                                <tr>
                                    <th scope="row" spellcheck="false">
                                        <?php echo $row['id'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['name']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_household')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_household')">
                                        <?php echo $row['name'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['household_id'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_household')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_household')">
                                        <?php echo $row['household_id'] ?>
                                    </th>


                                    <!-- household -->
                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['household']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_household')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_household')">
                                        <?php echo $row['household'] ?>
                                    </th>

                                    <th scope="row" spellcheck="false" contenteditable="false" title="Click to edit"
                                        data-original-value="<?php echo $row['sex'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'sex', 'survey_form_records_household')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'sex', 'survey_form_records_household')">
                                        <?php echo $row['sex']  ?>
                                    </th>



                                    <td class="d-flex align-items-center justify-content-start gap-2">
                                        <button data-type="household" data-action="remove" style="height: 33px"
                                            data-id="<?php echo $row['id'] ?>" id="action_btn"
                                            class="btn btn-danger btn-sm fs-6 d-flex align-items-center justify-content-center">
                                            <span class="material-symbols-outlined fs-6">
                                                close
                                            </span></button>
                                        <button class="btn btn-sm btn-primary"
                                            onclick="showMoreData(<?php echo $row['id'] ?>, 'survey_form_records_household_member')">View
                                            more</button>

                                    </td>
                                </tr>
                                <?php
                                $rows_count++;
                                 }
                                ?>
                            </tbody>
                        </table>
                        <nav class="d-flex align-items-center justify-content-end py-3">
                            <ul class="pagination gap-0">
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary" href="?otherhousehold_page=<?php 
                                    if ($otherhousehold_page_number > 1) {
                                        $otherhousehold_page_number--;
                                    }
                                    echo $otherhousehold_page_number;
                                    ?>">Previous</a>
                                </li>
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary"
                                        href="?otherhousehold_page=<?php echo $otherhousehold_page_number; ?>">
                                        <?php echo $_GET['otherhousehold_page'] ?? $otherhousehold_page_number ?>
                                    </a>
                                </li>
                                <li class="page-item p-2 bg-light">
                                    <a class="page-link bg-primary" href="?otherhousehold_page=<?php 
                                    $otherhousehold_page_number++;
                                    echo $otherhousehold_page_number;
                                    ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div id="tbl-last" style="display: none;" class="mt-4 table-responsive">
                        <h5 class="fw-bold text-primary">Survey form records</h5>
                        <table class="table table-hover table-striped" style="min-width: 1000vw;">
                            <thead>
                                <tr>
                                    <th scope="col fw-bold">ID</th>
                                    <th scope="col" class="fw-bold">Purok</th>
                                    <th scope="col" class="fw-bold">Barangay</th>
                                    <th scope="col" class="fw-bold">Municipality</th>
                                    <th scope="col" class="fw-bold">Province</th>
                                    <th scope="col" class="fw-bold">Artificial Family Planning Method</th>
                                    <th scope="col" class="fw-bold">Permanent Family Planning Method</th>
                                    <th scope="col" class="fw-bold">Natural Family Planning Method</th>
                                    <th scope="col" class="fw-bold">Attended Responsible Parenting Movement Class</th>
                                    <th scope="col" class="fw-bold">Type of Housing Unit Occupied</th>
                                    <th scope="col" class="fw-bold">Subtype of Housing Unit Occupied</th>
                                    <th scope="col" class="fw-bold">Type of House Light Used</th>
                                    <th scope="col" class="fw-bold">Type of Water Supply</th>
                                    <th scope="col" class="fw-bold">Type of Toilet</th>
                                    <th scope="col" class="fw-bold">Type of Garbage Disposal</th>
                                    <th scope="col" class="fw-bold">Communication Facility</th>
                                    <th scope="col" class="fw-bold">Transport Facility</th>
                                    <th scope="col" class="fw-bold">Agricultural Product</th>
                                    <th scope="col" class="fw-bold">Poultry Number of Heads (Chicken)</th>
                                    <th scope="col" class="fw-bold">Poultry Number of Heads (Duck)</th>
                                    <th scope="col" class="fw-bold">Poultry Number of Heads (Geese)</th>
                                    <th scope="col" class="fw-bold">Poultry Number of Heads (Turkey)</th>
                                    <th scope="col" class="fw-bold">Poultry Others</th>
                                    <th scope="col" class="fw-bold">Poultry Number of Heads (Others)</th>
                                    <th scope="col" class="fw-bold">Livestock Number (Pig)</th>
                                    <th scope="col" class="fw-bold">Livestock Number (Goat)</th>
                                    <th scope="col" class="fw-bold">Livestock Number (Sheep)</th>
                                    <th scope="col" class="fw-bold">Livestock Number (Coat)</th>
                                    <th scope="col" class="fw-bold">Livestock Number (Carabao)</th>
                                    <th scope="col" class="fw-bold">Livestock Number (Horse)</th>
                                    <th scope="col" class="fw-bold">Others Livestock</th>
                                    <th scope="col" class="fw-bold">Livestock Number (Others)</th>
                                    <th scope="col" class="fw-bold">Other Source of Income</th>
                                    <th scope="col" class="fw-bold">Fishpond Owned</th>
                                    <th scope="col" class="fw-bold">Fishpond Owned Area</th>
                                    <th scope="col" class="fw-bold">Land Owned</th>
                                    <th scope="col" class="fw-bold">Land Owned (Rice Field Area)</th>
                                    <th scope="col" class="fw-bold">Land Owned (Corn Field Area)</th>
                                    <th scope="col" class="fw-bold">Land</th>
                                    <th scope="col" class="fw-bold">Caretaker (Rice Area)</th>
                                    <th scope="col" class="fw-bold">Caretaker (Corn Area)</th>
                                    <th scope="col" class="fw-bold">Caretaker (Others Land Owned)</th>
                                    <th scope="col" class="fw-bold">Monthly Average Family Income</th>
                                    <th scope="col" class="fw-bold">Action</th>

                                </tr>
                            </thead>
                            <tbody id="tbl">
                                <?php
                                 // Get the selected filter value from the URL parameter
                                $selectedFilter = $_GET['filter_by'] ?? '';
                                $filterConditions = [
                                    'January to June' => "MONTH(filter_month) BETWEEN 1 AND 6",
                                    'July to December' => "MONTH(filter_month) BETWEEN 7 AND 12",
                                ];

                                $sqlCondition = '';

                                if (array_key_exists($selectedFilter, $filterConditions)) {
                                    $sqlCondition = $filterConditions[$selectedFilter];
                                }

                                $query = "unique_id = '{$_SESSION['unique_id']}'";
                                if (!empty($sqlCondition)) {
                                    $query .= " AND $sqlCondition";
                                }

                                $data = getRows($query, 'survey_form_records');
                                 
                                 $rows_count = 1;
                                 foreach($data as $row) {
                                    ?>
                                <tr>
                                    <th scope="row">
                                        <?php echo $rows_count ?>
                                    </th>

                                    <th scope="row"><?php echo $row['purok']; ?></th>
                                    <th scope="row"><?php echo $row['barangay']; ?></th>
                                    <th scope="row"><?php echo $row['municipality']; ?></th>
                                    <th scope="row"><?php echo $row['province']; ?></th>
                                    <th scope="row"><?php echo $row['artificialFamilyPlanningMethod']; ?></th>
                                    <th scope="row"><?php echo $row['permanentFamilyPlanningMethod']; ?></th>
                                    <th scope="row"><?php echo $row['naturalFamilyPlanningMethod']; ?></th>
                                    <th scope="row"><?php echo $row['attendedResponsibleParentingMovementClass']; ?>
                                    </th>
                                    <th scope="row"><?php echo $row['typeOfHousingUnitOccupied']; ?></th>
                                    <th scope="row"><?php echo $row['subTypeOfHousingUnitOccupied']; ?></th>
                                    <th scope="row"><?php echo $row['typeOfHouseLightUsed']; ?></th>
                                    <th scope="row"><?php echo $row['typeOfWaterSupply']; ?></th>
                                    <th scope="row"><?php echo $row['typeOfToilet']; ?></th>
                                    <th scope="row"><?php echo $row['typeOfGarbageDisposal']; ?></th>
                                    <th scope="row"><?php echo $row['communicationFacility']; ?></th>
                                    <th scope="row"><?php echo $row['transportFacility']; ?></th>
                                    <th scope="row"><?php echo $row['agriculturalProduct']; ?></th>
                                    <th scope="row"><?php echo $row['poultryNumberOfHeadsChicken']; ?></th>
                                    <th scope="row"><?php echo $row['poultryNumberOfHeadsDuck']; ?></th>
                                    <th scope="row"><?php echo $row['poultryNumberOfHeadsGeese']; ?></th>
                                    <th scope="row"><?php echo $row['poultryNumberOfHeadsTurkey']; ?></th>
                                    <th scope="row"><?php echo $row['poultryOthers']; ?></th>
                                    <th scope="row"><?php echo $row['poultryNumberOfHeadsOthers']; ?></th>
                                    <th scope="row"><?php echo $row['livestockNumberPig']; ?></th>
                                    <th scope="row"><?php echo $row['livestockNumberGoat']; ?></th>
                                    <th scope="row"><?php echo $row['livestockNumberSheep']; ?></th>
                                    <th scope="row"><?php echo $row['livestockNumberCoat']; ?></th>
                                    <th scope="row"><?php echo $row['livestockNumberCarabao']; ?></th>
                                    <th scope="row"><?php echo $row['livestockNumberHorse']; ?></th>
                                    <th scope="row"><?php echo $row['othersLivestock']; ?></th>
                                    <th scope="row"><?php echo $row['livestockNumberOthers']; ?></th>
                                    <th scope="row"><?php echo $row['otherSourceOfIncome']; ?></th>
                                    <th scope="row"><?php echo $row['fishpondOwned']; ?></th>
                                    <th scope="row"><?php echo $row['fishpondOwnedArea']; ?></th>
                                    <th scope="row"><?php echo $row['landOwned']; ?></th>
                                    <th scope="row"><?php echo $row['landOwnedRiceFieldArea']; ?></th>
                                    <th scope="row"><?php echo $row['landOwnedCornFieldArea']; ?></th>
                                    <th scope="row"><?php echo $row['land']; ?></th>
                                    <th scope="row"><?php echo $row['caretakerRiceArea']; ?></th>
                                    <th scope="row"><?php echo $row['caretakerCornArea']; ?></th>
                                    <th scope="row"><?php echo $row['caretakerOthersLandOwned']; ?></th>
                                    <th scope="row"><?php echo $row['monthlyAverageFamilyIncome']; ?></th>

                                    <td class="d-flex align-items-center justify-content-start gap-2">
                                        <button data-type="survey_form_records" data-action="remove"
                                            style="height: 33px" data-id="<?php echo $row['id'] ?>" id="action_btn"
                                            class="btn btn-danger btn-sm fs-6 d-flex align-items-center justify-content-center">
                                            <span class="material-symbols-outlined fs-6">
                                                close
                                            </span></button>
                                    </td>
                                </tr>
                                <?php
                                $rows_count++;
                                 }
                                ?>
                            </tbody>
                        </table>
                    </div>


                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->

                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->

    <script>
    'use strict'

    $('.edit_details').click(function() {
        uni_modal("Manage Details", "edit_details.php?id=" + $(this).attr('data-id'), "mid-large")

    })

    function expandCamelCase(input) {
        return input.replace(/([A-Z])/g, ' $1')
            .replace(/^./, function(str) {
                return str.toUpperCase();
            })
            .trim();
    }
    <?php
                $purokquery = "SELECT puroks AS purok_counter FROM barangay WHERE unique_id = '{$_SESSION['unique_id']}'";
                $resulta = mysqli_query($conn, $purokquery);
                $rowa = mysqli_fetch_assoc($resulta);
                $purokCounter = $rowa['purok_counter'];
            ?>

    function showMoreData(id, table_name) {
        fetchDatabaseData(id, table_name).then((data) => {
            if (data.length == 0) return
            let keyPairs = Object.entries(data[0])
            let form_template = `<form id="editForm" class="swal2-form text-left" style="width: 100%;">
            <h5 class="fs-4 text-center">More details</h5>
            <input type="hidden" name="table_name" value="${table_name}">
            <input type="hidden" name="id" value="${id}">`;

            const readOnlyFields = ['barangay', 'municipality', 'province', 'household_id'];
            for (const [k, v] of keyPairs) {
                if (!v || k === 'id' || k === 'unique_id') continue;

                const readonlyAttribute = readOnlyFields.includes(k.toLowerCase()) ? 'readonly' : '';

                let isDropdown = false;
                let options = [];

                switch (k) {
                    case 'status':
                        isDropdown = true;
                        options = ['Single', 'Married', 'Divorced', 'Widowed'];
                        break;

                    case 'educationalAttainment':
                        isDropdown = true;
                        options = ['High School Graduate', 'Bachelor\'s Degree', 'Master\'s Degree',
                            'Doctorate', 'Other'
                        ];
                        break;

                    case 'sex':
                        isDropdown = true;
                        options = ['Male', 'Female', 'Other'];
                        break;

                    case 'occupation':
                        isDropdown = true;
                        options = ['Government Employee', 'Private Employee', 'Farmer', 'Fisherfolks',
                            'Housekeeper', 'Driver', 'Entrepreneur', 'Daily Wager', 'Student', 'None'
                        ];
                        break;

                    case 'placeOfWork':
                        isDropdown = true;
                        options = ['Within the Philippines', 'Abroad'];
                        break;

                    case 'religion':
                        isDropdown = true;
                        options = ['Christianity', 'Islam', 'Buddhism', 'Hinduism', 'Other'];
                        break;

                    case 'ethnicGroup':
                        isDropdown = true;
                        options = ['Bicolano', 'Ibanag', 'Ilocano', 'Other'];
                        break;
                    case 'purok':
                        isDropdown = true;
                        // Generate 'PUROK' options based on the 'purokCounter' value
                        options = [];
                        for (let i = 1; i <= parseInt('<?php echo $purokCounter; ?>'); i++) {
                            options.push(i.toString());
                        }
                        break;

                    default:
                        if (k === 'dateOfBirth') {
                            form_template +=
                                `
                            <div style="width: 100%;">
                                <label class="text-left mt-2 fw-bold">${expandCamelCase(k)}</label>
                                <input id="${k}" value="${v}" name="${k}" type="date" class="swal2-input my-0" ${readonlyAttribute} style="width: 100%;">`;
                        } else {
                            form_template +=
                                `
                            <div style="width: 100%;">
                                <label class="text-left mt-2 fw-bold">${expandCamelCase(k)}</label>
                                <input id="${k}" value="${v}" name="${k}" type="text" class="swal2-input my-0" ${readonlyAttribute} style="width: 100%;">`;
                        }
                        break;
                }

                if (isDropdown) {
                    form_template += `
                    <div style="width: 100%;">
                        <label class="text-left mt-2 fw-bold">${expandCamelCase(k)}</label>
                        <select id="${k}" name="${k}" type="text" class="swal2-input my-0 styled-dropdown" style="width: 100%;">
                            ${options.map(option => `
                                <option value="${option}" ${v.toLowerCase() === option.toLowerCase() ? 'selected' : ''}>${option}</option>
                            `).join('')}
                        </select>`;
                }
                form_template += `</div>`;
            }

            form_template += `</form>`;
            Swal.fire({
                html: form_template,
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                showConfirmButton: true,
                confirmButtonText: 'Save',
                focusConfirm: false,
                preConfirm: () => {
                    const data = $('#editForm').serialize()
                    $.ajax({
                        url: './update_data.php',
                        method: 'POST',
                        data,
                        success: function(data) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter',
                                        Swal.stopTimer)
                                    toast.addEventListener('mouseleave',
                                        Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                title: 'Record updated successfully!'
                            })

                            setTimeout(() => {
                                location.reload()
                            }, 2000);
                        },
                        error: function(error) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter',
                                        Swal.stopTimer)
                                    toast.addEventListener('mouseleave',
                                        Swal.resumeTimer)
                                }
                            })


                            Toast.fire({
                                icon: 'error',
                                title: "Something went wrong, please try again!"
                            })
                        }
                    });
                }
            });


        });
    }



    function fetchDatabaseData(id, table_name) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: './show_more_data.php',
                method: 'POST',
                data: {
                    id,
                    table_name
                },
                success: function(data) {
                    resolve(data);
                },
                error: function(error) {
                    reject(error);
                }
            });
        });
    }





    !(function e() {
        let n = document.getElementById("searchInput"),
            t = document.getElementById("startButton");
        if ("webkitSpeechRecognition" in window)
            var r = new webkitSpeechRecognition();
        else if (!("SpeechRecognition" in window)) return;
        else var r = new SpeechRecognition();
        (r.continuous = !1),
        (r.interimResults = !1),
        (r.lang = "en-US"),
        (r.onresult = function(e) {
            let t = e.results[0][0].transcript;
            n.value = t;
            w3.filterHTML("#tbl", "tr", t);
        }),
        (r.onerror = function(e) {
            console.error("Speech recognition error:", e.error);
        }),
        t.addEventListener("click", function() {
            r.start();
        });
    });

    function updateContent(cell, id, column, tableName) {
        const newValue = cell.innerText.trim(),
            originalValue = cell.getAttribute("data-original-value").trim();
        if (newValue && newValue != originalValue) {
            fetch("./update_script.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: `id=${id}&column=${column}&value=${encodeURIComponent(
        newValue
      )}&table=${tableName}`,
                })
                .then((response) => {
                    if (response.ok) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener("mouseenter", Swal.stopTimer);
                                toast.addEventListener("mouseleave", Swal.resumeTimer);
                            },
                        });

                        Toast.fire({
                            icon: "success",
                            title: "Updated successfully",
                        });
                        cell.setAttribute("data-original-value", newValue);
                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener("mouseenter", Swal.stopTimer);
                                toast.addEventListener("mouseleave", Swal.resumeTimer);
                            },
                        });

                        Toast.fire({
                            icon: "error",
                            title: "Sorry, failed to update content",
                        });
                    }
                })
                .catch((error) => {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener("mouseenter", Swal.stopTimer);
                            toast.addEventListener("mouseleave", Swal.resumeTimer);
                        },
                    });

                    Toast.fire({
                        icon: "error",
                        title: error,
                    });
                });
        }
    }

    function handleKeyPress(event, cell, id, column, tableName) {
        if (event.key === "Enter") {
            event.preventDefault();
            updateContent(cell, id, column, tableName);
            cell.blur();
        }
    }

    function showConfirmation(id, type, action) {
        (action.trim() != "update" &&
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, proceed!",
                cancelButtonText: "Cancel",
                onclose: function() {
                    window.open(`./records.php`, "_self");
                },
                reverseButtons: true,
            }).then(
                (result) =>
                result.isConfirmed &&
                window.open(`?id=${id}&type=${type}&action=${action}`, "_self")
            )) ||
        window.open(`?id=${id}&type=${type}&action=${action}`, "_self");
    }

    $(document).ready(function() {
        $('button[id="action_btn"]').on("click", function() {
            let id = $(this).attr("data-id");
            let type = $(this).attr("data-type");
            let action = $(this).attr("data-action");
            showConfirmation(id, type, action);
        });

        $('th[contenteditable="true"]')
            .on("focus", function() {
                $(this).addClass("resize_th form-control");
            })
            .on("blur", function() {
                $(this).removeClass("resize_th form-control");
            });
    });
    </script>


    <!-- <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="../assets/libs/js/main-js.js"></script>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>