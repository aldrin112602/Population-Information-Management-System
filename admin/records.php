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
                            <li class="nav-item my-2">
                                <a href="./index.php"
                                    class="text-center text-white d-flex align-items-center justify-content-start gap-2 ml-4 fs-5">
                                    <span class="material-symbols-outlined">dashboard</span>
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item my-2 current-page">
                                <a href=""
                                    class="text-center text-white d-flex align-items-center justify-content-start gap-2 ml-4 fs-5">
                                    <span class="material-symbols-outlined">bar_chart_4_bars</span>
                                    Records
                                </a>
                            </li>
                            <!-- <li class="nav-item my-2">
                                <a href=""
                                    class="text-center text-white d-flex align-items-center justify-content-start gap-2 ml-4 fs-5">
                                    <span class="material-symbols-outlined">donut_large</span>
                                    Reports
                                </a>
                            </li> -->
                            <li class="nav-item my-2">
                                <a href="setting.php"
                                    class="text-center text-white d-flex align-items-center justify-content-start gap-2 ml-4 fs-5">
                                    <span class="material-symbols-outlined">settings</span>
                                    Settings
                                </a>
                            </li>
                            <li class="nav-item mt-3">
                                <a href="../logout.php"
                                    class="text-center text-white d-flex align-items-center justify-content-start gap-2 ml-4 fs-5">
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
                                            <!-- search icon -->
                                            <span class="material-symbols-outlined position-absolute" style="top: 50%;
                                                         left: 13px;
                                                         transform: translateY(-50%);">
                                                search
                                            </span>
                                            <input oninput="w3.filterHTML('#tbl', 'tr', this.value);" type="text"
                                                placeholder="Search here" id="searchInput"
                                                class="form-control form-control-lg" style="
                                                border-radius: 50px;
                                                padding-left: 40px;
                                            ">
                                            <!-- voice icon -->
                                            <span class="material-symbols-outlined position-absolute" id="startButton"
                                                style="top: 50%;
                                                         right: 13px;
                                                         transform: translateY(-50%);
                                                         cursor: pointer;">
                                                keyboard_voice
                                            </span>
                                        </div>
                                        <?php 
                                         $household_id = uniqid();
                                        ?>
                                        <a role="button" href="./add_record.php?household_id=<?php echo $household_id ?>" class="btn text-white btn-lg" style="
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
                                <button data-btn="1" id="btn" class="btn border btn-light shadow border-primary">Household</button>
                            </div>
                            <div class="input-group-prepend">
                                <button data-btn="2" id="btn" class="btn border btn-light shadow border-primary">Families</button>
                            </div>
                            <div class="input-group-prepend">
                                <button data-btn="3" id="btn" class="btn border btn-light shadow border-primary">Husband</button>
                            </div>
                            <div class="input-group-prepend">
                                <button data-btn="4" id="btn" class="btn border btn-light shadow border-primary">Wife</button>
                            </div>
                            <div class="input-group-prepend">
                                <button data-btn="5" id="btn"
                                    class="btn border btn-light shadow border-primary">Children</button>
                            </div>
                            <div class="input-group-prepend">
                                <button data-btn="6" id="btn"
                                    class="btn border btn-light shadow border-primary">Other-Household</button>
                            </div>
                            <div class="input-group-prepend">
                                <button data-btn="7" id="btn" class="btn border btn-light shadow border-primary">All</button>
                            </div>
                        </div>
                        <script>
                        $(document).ready(function() {
                            $('.table-responsive:gt(0)').hide();
                            $('button#btn').on('click', function() {
                                let containerNumber = $(this).attr('data-btn');
                                $('.table-responsive').hide();
                                $('#container' + containerNumber).show();
                                $('button#btn').removeClass('active');
                                $(this).addClass($(this).attr('data-btn') == containerNumber ?
                                    'active' : '');
                            })
                        });
                        </script>
                    </div>
                    <div class="alert alert-info alert-dismissible fade show py-3" role="alert">
                        <strong>
                            You can edit the content inline in this table
                        </strong>
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"
                            aria-label="Close"></button>
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
                                 $data = getRows("unique_id = '{$_SESSION['unique_id']}' AND belongs_to IS NULL OR belongs_to = ''", "survey_form_records_husband");
                                 
                                 $rows_count = 1;
                                 foreach($data as $row) {
                                    ?>
                                <tr>
                                    <th scope="row" spellcheck="false">
                                        <?php echo $row['id'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['name']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_husband')">
                                        <?php echo $row['name'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['household_id'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_husband')">
                                        <?php echo $row['household_id'] ?>
                                    </th>


                                    <!-- household -->
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['household']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_husband')">
                                        <?php echo $row['household'] ?>
                                    </th>
                                    
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
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
                                        <button class="btn btn-sm btn-primary">View more</button>

                                    </td>
                                </tr>
                                <?php
                                    $rows_count++;
                                 }
                                ?>
                            </tbody>
                        </table>
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
                                 $data = getRows("unique_id = '{$_SESSION['unique_id']}'", "survey_form_records_husband");
                                 
                                 $rows_count = 1;
                                 foreach($data as $row) {
                                    ?>
                                <tr>
                                    <th scope="row" spellcheck="false">
                                        <?php echo $row['id'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['name']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_husband')">
                                        <?php echo $row['name'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['household_id'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_husband')">
                                        <?php echo $row['household_id'] ?>
                                    </th>


                                    <!-- household -->
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['household']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_husband')">
                                        <?php echo $row['household'] ?>
                                    </th>
                                    
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
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
                                        <button class="btn btn-sm btn-primary">View more</button>

                                    </td>
                                </tr>
                                <?php
                                    $rows_count++;
                                 }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-3" style="display: none;" id="container3">

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
                                 $data = getRows("unique_id = '{$_SESSION['unique_id']}'", "survey_form_records_husband");
                                 
                                 $rows_count = 1;
                                 foreach($data as $row) {
                                    ?>
                                <tr>
                                    <th scope="row" spellcheck="false">
                                        <?php echo $row['id'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['name']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_husband')">
                                        <?php echo $row['name'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['household_id'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_husband')">
                                        <?php echo $row['household_id'] ?>
                                    </th>


                                    <!-- household -->
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['household']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_husband')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_husband')">
                                        <?php echo $row['household'] ?>
                                    </th>
                                    
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
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
                                        <button class="btn btn-sm btn-primary">View more</button>

                                    </td>
                                </tr>
                                <?php
                                    $rows_count++;
                                 }
                                ?>
                            </tbody>
                        </table>
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
                                 $data = getRows("unique_id = '{$_SESSION['unique_id']}'", "survey_form_records_wife");
                                 
                                 $rows_count = 1;
                                 foreach($data as $row) {
                                    ?>
                                <tr>
                                    <th scope="row" spellcheck="false">
                                        <?php echo $row['id'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['name']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_wife')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_wife')">
                                        <?php echo $row['name'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['household_id'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_wife')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_wife')">
                                        <?php echo $row['household_id'] ?>
                                    </th>


                                    <!-- household -->
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['household']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_wife')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_wife')">
                                        <?php echo $row['household'] ?>
                                    </th>
                                    
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
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
                                        <button class="btn btn-primary btn-sm">View more</button>

                                    </td>
                                </tr>
                                <?php
                                $rows_count++;
                                 }
                                ?>

                            </tbody>
                        </table>
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
                                 $data = getRows("unique_id = '{$_SESSION['unique_id']}'", "survey_form_records_children");
                                 
                                 $rows_count = 1;
                                 foreach($data as $row) {
                                    ?>
                                <tr>
                                    <th scope="row" spellcheck="false">
                                        <?php echo $row['id'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['name']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_children')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_children')">
                                        <?php echo $row['name'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['household_id'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_children')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_children')">
                                        <?php echo $row['household_id'] ?>
                                    </th>


                                    <!-- household -->
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['household']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_children')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_children')">
                                        <?php echo $row['household'] ?>
                                    </th>
                                    
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
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
                                        <button class="btn btn-sm btn-primary">View more</button>

                                    </td>
                                </tr>
                                <?php
                                $rows_count++;
                                 }
                                ?>
                            </tbody>
                        </table>
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
                                 $data = getRows("unique_id = '{$_SESSION['unique_id']}'", "survey_form_records_household_member");
                                 
                                 $rows_count = 1;
                                 foreach($data as $row) {
                                    ?>
                                <tr>
                                    <th scope="row" spellcheck="false">
                                        <?php echo $row['id'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['name']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_household')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'name', 'survey_form_records_household')">
                                        <?php echo $row['name'] ?>
                                    </th>
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['household_id'] ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_household')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household_id', 'survey_form_records_household')">
                                        <?php echo $row['household_id'] ?>
                                    </th>


                                    <!-- household -->
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
                                        data-original-value="<?php echo $row['household']  ?>"
                                        onblur="updateContent(this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_household')"
                                        onkeypress="handleKeyPress(event, this, <?php echo $row['id']; ?>, 'household', 'survey_form_records_household')">
                                        <?php echo $row['household'] ?>
                                    </th>
                                    
                                    <th scope="row" spellcheck="false" contenteditable="true" title="Click to edit"
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
                                        <button class="btn btn-sm btn-primary">View more</button>

                                    </td>
                                </tr>
                                <?php
                                $rows_count++;
                                 }
                                ?>
                            </tbody>
                        </table>
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
                                 $data = getRows("unique_id = '{$_SESSION['unique_id']}'", "survey_form_records");
                                 
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
                                        <button data-type="survey_form_records" data-action="remove" style="height: 33px"
                                            data-id="<?php echo $row['id'] ?>" id="action_btn"
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

    <script src="./main.js"></script>

    <!-- <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="../assets/libs/js/main-js.js"></script>
</body>

</html>