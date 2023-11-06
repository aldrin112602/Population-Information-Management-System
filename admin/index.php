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
    <title>Dashboard - PIMS | Population Information Monitoring System</title>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- custom styles -->
    <style>
    * {
        font-family: "Poppins", sans-serif;
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        transition: all 0.5s;
    }
    </style>
</head>

<body>
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
                            <li class="nav-item my-1 current-page">
                                <a href="./index.php"
                                    class="text-center text-white d-flex align-items-center justify-content-start gap-2 ml-4 fs-6">
                                    <span class="material-symbols-outlined">dashboard</span>
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item my-1">
                                <a href="./records.php"
                                    class="text-center text-white d-flex align-items-center justify-content-start gap-2 ml-4 fs-6">
                                    <span class="material-symbols-outlined">bar_chart_4_bars</span>
                                    Records
                                </a>
                            </li>
                            <li class="nav-item my-1">
                                <a href="./print_report.php"
                                    class="text-center text-white d-flex align-items-center justify-content-start gap-2 ml-4 fs-6">
                                    <span class="material-symbols-outlined">print</span>
                                    Print report
                                </a>
                            </li>
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
                                <div>
                                    <h2 class="pageheader-title font-weight-bold">Dashboard</h2>
                                </div>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">Dashboard</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Home</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="alert alert-info alert-dismissible fade show py-3" role="alert">
                        <p>
                            Welcome <?php echo $_SESSION['username'] ?> to Barangay <strong
                                class="fw-bold"><?php echo $_SESSION['barangay'] ?>!</strong>
                        </p>
                    </div>
                    <h5>Populations as of <?php echo date("F d, Y") ?>: <strong><?php echo getPopulation() ?></strong>
                        people </h5>
                    <div class="my-3 d-flex align-items-center justify-content-end">
                        <a role="button" href="./output-csv.php?barangay=<?php echo $_SESSION['barangay'] ?>"
                            class="btn btn-primary d-flex align-items-center justify-content-start gap-2"><i
                                class="fa fa-download" aria-hidden="true"></i> Download data</a>
                    </div>
                    <?php
                        if(isset($_GET['download']) && isset($_GET['barangay']) && file_exists(trim(base64_decode($_GET['download'])))) {
                    ?>
                    <script>
                    (function() {
                        $(document).ready(function() {
                            let a = document.createElement('a');
                            a.setAttribute('href', '<?php echo base64_decode($_GET['download']) ?>');
                            a.setAttribute('download',
                                '<?php echo basename(base64_decode($_GET['download'])) ?>');
                            Swal.fire({
                                title: 'Continue download?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, proceed!',
                                cancelButtonText: 'Cancel',
                                reverseButtons: true,
                                onClose: function() {
                                    window.open('./?barangay=<?php echo $_GET['barangay'] ?>',
                                        '_self');
                                },
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    a.click();
                                }
                            });
                        })
                    })();
                    </script>
                    <?php
                        }
                    ?>
                    <div class="ecommerse-widget">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Families</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">
                                                <?php echo getCount('survey_form_records_husband') ?>
                                            </h1>
                                        </div>

                                    </div>
                                    <div id="sparkline-revenue"><canvas width="334" height="100"
                                            style="display: inline-block; width: 334.809px; height: 100px; vertical-align: top;"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Household</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">
                                                <?php echo getCount('survey_form_records_household_member') ?>
                                            </h1>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue2"><canvas width="334" height="100"
                                            style="display: inline-block; width: 334.809px; height: 100px; vertical-align: top;"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Female</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">
                                                <?php echo getCountRowsFemale() ?>
                                            </h1>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue3"><canvas width="334" height="100"
                                            style="display: inline-block; width: 334.809px; height: 100px; vertical-align: top;"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Male</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">
                                                <?php echo getCountRowsMale() ?>
                                            </h1>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue4"><canvas width="334" height="100"
                                            style="display: inline-block; width: 334.809px; height: 100px; vertical-align: top;"></canvas>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <h3 class="fw-bold text-muted">Ethnic Group</h3>
                        <div class="row">

                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <?php 
                            $percentages = getEthnicGroupPercentages("survey_form_records_husband");
                            $ethnicGroupCounts = getEthnicGroupCounts("survey_form_records_husband");
                            ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Ethnic Group (Husband)</h5>
                                        <div>
                                            <canvas id="myChart2"></canvas>
                                            <script>
                                            (function() {
                                                const ctx = document.getElementById('myChart2');
                                                let temp = <?php echo json_encode($percentages); ?>;
                                                console.log(temp)
                                                let labels = Object.keys(temp);
                                                let values = Object.values(temp);
                                                let percentages = Object.values(temp);
                                                                                               
                                                let backgroundColor = [];
                                                for (let i = 0; i < labels.length; i++) {
                                                    let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' +
                                                        Math
                                                        .floor(Math.random() * 256) + ', ' + Math.floor(Math
                                                            .random() *
                                                            256) + ', 0.7)';
                                                    backgroundColor.push(color);
                                                }
                                                const data = {
                                                    labels,
                                                    datasets: [{
                                                        label: 'Ethnic Group (Husband)',
                                                        data: percentages,
                                                        backgroundColor,
                                                        hoverOffset: 4
                                                    }]
                                                };

                                                const config = {
                                                    type: 'doughnut',
                                                    data,
                                                    options: {
                                                        plugins: {
                                                            tooltip: {
                                                                callbacks: {
                                                                    label: (context) => {
                                                                        let label = labels[context
                                                                            .dataIndex];
                                                                        let count = temp[
                                                                        label]; // Use the exact numerical count
                                                                        let percentage = percentages[context
                                                                            .dataIndex];
                                                                        return `${label}: ${count} (${percentage}%)`;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                };
                                                new Chart(ctx, config);
                                            })();
                                            </script>
                                            <?php
                                        foreach ($ethnicGroupCounts as $ethnicGroup => $count) {
                                            echo "<b>$ethnicGroup:</b> $count<br>";
                                        }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <?php 
                                    $percentages = getEthnicGroupPercentages("survey_form_records_wife");
                                    $ethnicGroupCounts = getEthnicGroupCounts("survey_form_records_wife");
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Ethnic Group (Wife)</h5>
                                        <div>
                                            <canvas id="myChart"></canvas>
                                            <script>
                                            (function() {
                                                const ctx = document.getElementById('myChart');
                                                let temp = <?php echo json_encode($percentages); ?>;
                                                let labels = Object.keys(temp);
                                                let values = Object.values(temp);

                                                let backgroundColor = [];
                                                for (let i = 0; i < labels.length; i++) {
                                                    let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' +
                                                        Math
                                                        .floor(Math.random() * 256) + ', ' + Math.floor(Math
                                                            .random() *
                                                            256) + ', 0.7)';
                                                    backgroundColor.push(color);
                                                }
                                                const data = {
                                                    labels,
                                                    datasets: [{
                                                        label: 'Ethnic Group (Wife)',
                                                        data: values,
                                                        backgroundColor,
                                                        hoverOffset: 4
                                                    }]
                                                };

                                                const config = {
                                                    type: 'doughnut',
                                                    data,
                                                };
                                                new Chart(ctx, config);
                                            })();
                                            </script>
                                        </div>
                                        <?php
                                        foreach ($ethnicGroupCounts as $ethnicGroup => $count) {
                                            echo "<b>$ethnicGroup:</b> $count<br>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <?php 
                                    $percentages = getEthnicGroupPercentages("survey_form_records_children");
                                    $ethnicGroupCounts = getEthnicGroupCounts("survey_form_records_children");
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Ethnic Group (Children)</h5>
                                        <div>
                                            <canvas id="myChart4"></canvas>
                                            <script>
                                            (function() {
                                                const ctx = document.getElementById('myChart4');
                                                let temp = <?php echo json_encode($percentages); ?>;
                                                let labels = Object.keys(temp);
                                                let values = Object.values(temp);
                                                let backgroundColor = [];
                                                for (let i = 0; i < labels.length; i++) {
                                                    let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' +
                                                        Math
                                                        .floor(Math.random() * 256) + ', ' + Math.floor(Math
                                                            .random() *
                                                            256) + ', 0.7)';
                                                    backgroundColor.push(color);
                                                }
                                                const data = {
                                                    labels,
                                                    datasets: [{
                                                        label: 'Ethnic Group (Other Household)',
                                                        data: values,
                                                        backgroundColor,
                                                        hoverOffset: 4
                                                    }]
                                                };

                                                const config = {
                                                    type: 'doughnut',
                                                    data,
                                                };
                                                new Chart(ctx, config);
                                            })();
                                            </script>
                                        </div>
                                        <?php
                                        foreach ($ethnicGroupCounts as $ethnicGroup => $count) {
                                            echo "<b>$ethnicGroup:</b> $count<br>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <?php 
                                    $percentages = getEthnicGroupPercentages("survey_form_records_household_member");
                                    $ethnicGroupCounts = getEthnicGroupCounts("survey_form_records_household_member");
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Ethnic Group (Other Household)</h5>
                                        <div>
                                            <canvas id="myChart3"></canvas>
                                            <script>
                                            (function() {
                                                const ctx = document.getElementById('myChart3');
                                                let temp = <?php echo json_encode($percentages); ?>;
                                                let labels = Object.keys(temp);
                                                let values = Object.values(temp);
                                                let backgroundColor = [];
                                                for (let i = 0; i < labels.length; i++) {
                                                    let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' +
                                                        Math
                                                        .floor(Math.random() * 256) + ', ' + Math.floor(Math
                                                            .random() *
                                                            256) + ', 0.7)';
                                                    backgroundColor.push(color);
                                                }
                                                const data = {
                                                    labels,
                                                    datasets: [{
                                                        label: 'Ethnic Group (Other Household)',
                                                        data: values,
                                                        backgroundColor,
                                                        hoverOffset: 4
                                                    }]
                                                };

                                                const config = {
                                                    type: 'doughnut',
                                                    data,
                                                };
                                                new Chart(ctx, config);
                                            })();
                                            </script>
                                        </div>
                                        <?php
                                        foreach ($ethnicGroupCounts as $ethnicGroup => $count) {
                                            echo "<b>$ethnicGroup:</b> $count<br>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="fw-bold text-muted">Civil Status </h3>
                        <div class="row">

                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <?php 
                                    $percentages = getCivilStatusPercentages("survey_form_records_husband");
                                   
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Civil status(Husband)</h5>
                                        <div>
                                            <canvas id="civil2"></canvas>
                                            <script>
                                            (function() {
                                                const ctx = document.getElementById('civil2');
                                                let temp = <?php echo json_encode($percentages); ?>;
                                                let labels = Object.keys(temp);
                                                let values = Object.values(temp);
                                                let backgroundColor = [];
                                                for (let i = 0; i < labels.length; i++) {
                                                    let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' +
                                                        Math
                                                        .floor(Math.random() * 256) + ', ' + Math.floor(Math
                                                            .random() *
                                                            256) + ', 0.7)';
                                                    backgroundColor.push(color);
                                                }
                                                const data = {
                                                    labels,
                                                    datasets: [{
                                                        label: 'Civil status(Husband)',
                                                        data: values,
                                                        backgroundColor,
                                                        hoverOffset: 4
                                                    }]
                                                };

                                                const config = {
                                                    type: 'pie',
                                                    data,
                                                };
                                                new Chart(ctx, config);
                                            })();
                                            </script>
                                        </div>
                                        <?php
                                        foreach (getCivilStatusCounts("survey_form_records_husband") as $key => $count) {
                                            echo "<b>$key:</b> $count<br>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <?php 
                            $percentages = getCivilStatusPercentages("survey_form_records_wife");
                            ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Civil status(Wife)</h5>
                                        <div>
                                            <canvas id="civil"></canvas>
                                            <script>
                                            (function() {
                                                const ctx = document.getElementById('civil');
                                                let temp = <?php echo json_encode($percentages); ?>;
                                                let labels = Object.keys(temp);
                                                let values = Object.values(temp);

                                                let backgroundColor = [];
                                                for (let i = 0; i < labels.length; i++) {
                                                    let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' +
                                                        Math
                                                        .floor(Math.random() * 256) + ', ' + Math.floor(Math
                                                            .random() *
                                                            256) + ', 0.7)';
                                                    backgroundColor.push(color);
                                                }
                                                const data = {
                                                    labels,
                                                    datasets: [{
                                                        label: 'Civil status(Wife)',
                                                        data: values,
                                                        backgroundColor,
                                                        hoverOffset: 4
                                                    }]
                                                };

                                                const config = {
                                                    type: 'pie',
                                                    data,
                                                };
                                                new Chart(ctx, config);
                                            })();
                                            </script>
                                        </div>
                                        <?php
                                        foreach (getCivilStatusCounts("survey_form_records_wife") as $key => $count) {
                                            echo "<b>$key:</b> $count<br>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <?php 
                            $percentages = getCivilStatusPercentages("survey_form_records_children");
                            ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Civil status(Children)</h5>
                                        <div>
                                            <canvas id="civil4"></canvas>
                                            <script>
                                            (function() {
                                                const ctx = document.getElementById('civil4');
                                                let temp = <?php echo json_encode($percentages); ?>;
                                                let labels = Object.keys(temp);
                                                let values = Object.values(temp);
                                                let backgroundColor = [];
                                                for (let i = 0; i < labels.length; i++) {
                                                    let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' +
                                                        Math
                                                        .floor(Math.random() * 256) + ', ' + Math.floor(Math
                                                            .random() *
                                                            256) + ', 0.7)';
                                                    backgroundColor.push(color);
                                                }
                                                const data = {
                                                    labels,
                                                    datasets: [{
                                                        label: 'Civil status(Other Household)',
                                                        data: values,
                                                        backgroundColor,
                                                        hoverOffset: 4
                                                    }]
                                                };

                                                const config = {
                                                    type: 'pie',
                                                    data,
                                                };
                                                new Chart(ctx, config);
                                            })();
                                            </script>
                                        </div>
                                        <?php
                                        foreach (getCivilStatusCounts("survey_form_records_children") as $key => $count) {
                                            echo "<b>$key:</b> $count<br>";
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <?php 
                            $percentages = getCivilStatusPercentages("survey_form_records_household_member");
                            ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Civil status(Other Household)</h5>
                                        <div>
                                            <canvas id="civil3"></canvas>
                                            <script>
                                            (function() {
                                                const ctx = document.getElementById('civil3');
                                                let temp = <?php echo json_encode($percentages); ?>;
                                                let labels = Object.keys(temp);
                                                let values = Object.values(temp);
                                                let backgroundColor = [];
                                                for (let i = 0; i < labels.length; i++) {
                                                    let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' +
                                                        Math
                                                        .floor(Math.random() * 256) + ', ' + Math.floor(Math
                                                            .random() *
                                                            256) + ', 0.7)';
                                                    backgroundColor.push(color);
                                                }
                                                const data = {
                                                    labels,
                                                    datasets: [{
                                                        label: 'Civil status(Other Household)',
                                                        data: values,
                                                        backgroundColor,
                                                        hoverOffset: 4
                                                    }]
                                                };

                                                const config = {
                                                    type: 'pie',
                                                    data,
                                                };
                                                new Chart(ctx, config);
                                            })();
                                            </script>
                                        </div>
                                        <?php
                                        foreach (getCivilStatusCounts("survey_form_records_household_member") as $key => $count) {
                                            echo "<b>$key:</b> $count<br>";
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="fw-bold text-muted">Religion </h3>
                        <div class="row">

                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <?php 
                            $percentages = getReligionPercentages("survey_form_records_husband");
                            ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Religion (Husband)</h5>
                                        <div>
                                            <canvas id="religion1"></canvas>
                                            <script>
                                            (function() {
                                                const ctx = document.getElementById('religion1');
                                                let temp = <?php echo json_encode($percentages); ?>;
                                                let labels = Object.keys(temp);
                                                let values = Object.values(temp);
                                                let backgroundColor = [];
                                                for (let i = 0; i < labels.length; i++) {
                                                    let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' +
                                                        Math
                                                        .floor(Math.random() * 256) + ', ' + Math.floor(Math
                                                            .random() *
                                                            256) + ', 0.7)';
                                                    backgroundColor.push(color);
                                                }
                                                const data = {
                                                    labels,
                                                    datasets: [{
                                                        label: 'Religion (Husband)',
                                                        data: values,
                                                        backgroundColor,
                                                        hoverOffset: 4
                                                    }]
                                                };

                                                const config = {
                                                    type: 'polarArea',
                                                    data,
                                                };
                                                new Chart(ctx, config);
                                            })();
                                            </script>
                                        </div>
                                        <?php
                                        foreach (getReligionCounts("survey_form_records_husband") as $key => $count) {
                                            echo "<b>$key:</b> $count<br>";
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <?php 
                            $percentages = getReligionPercentages("survey_form_records_wife");
                            ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Religion (Wife)</h5>
                                        <div>
                                            <canvas id="religion2"></canvas>
                                            <script>
                                            (function() {
                                                const ctx = document.getElementById('religion2');
                                                let temp = <?php echo json_encode($percentages); ?>;
                                                let labels = Object.keys(temp);
                                                let values = Object.values(temp);

                                                let backgroundColor = [];
                                                for (let i = 0; i < labels.length; i++) {
                                                    let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' +
                                                        Math
                                                        .floor(Math.random() * 256) + ', ' + Math.floor(Math
                                                            .random() *
                                                            256) + ', 0.7)';
                                                    backgroundColor.push(color);
                                                }
                                                const data = {
                                                    labels,
                                                    datasets: [{
                                                        label: 'Religion (Wife)',
                                                        data: values,
                                                        backgroundColor,
                                                        hoverOffset: 4
                                                    }]
                                                };

                                                const config = {
                                                    type: 'polarArea',
                                                    data,
                                                };
                                                new Chart(ctx, config);
                                            })();
                                            </script>
                                        </div>
                                        <?php
                                        foreach (getReligionCounts("survey_form_records_wife") as $key => $count) {
                                            echo "<b>$key:</b> $count<br>";
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <?php 
                            $percentages = getReligionPercentages("survey_form_records_children");
                            ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Religion (Children)</h5>
                                        <div>
                                            <canvas id="religion3"></canvas>
                                            <script>
                                            (function() {
                                                const ctx = document.getElementById('religion3');
                                                let temp = <?php echo json_encode($percentages); ?>;
                                                let labels = Object.keys(temp);
                                                let values = Object.values(temp);
                                                let backgroundColor = [];
                                                for (let i = 0; i < labels.length; i++) {
                                                    let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' +
                                                        Math
                                                        .floor(Math.random() * 256) + ', ' + Math.floor(Math
                                                            .random() *
                                                            256) + ', 0.7)';
                                                    backgroundColor.push(color);
                                                }
                                                const data = {
                                                    labels,
                                                    datasets: [{
                                                        label: 'Religion (Other Household)',
                                                        data: values,
                                                        backgroundColor,
                                                        hoverOffset: 4
                                                    }]
                                                };

                                                const config = {
                                                    type: 'polarArea',
                                                    data,
                                                };
                                                new Chart(ctx, config);
                                            })();
                                            </script>
                                        </div>
                                        <?php
                                        foreach (getReligionCounts("survey_form_records_children") as $key => $count) {
                                            echo "<b>$key:</b> $count<br>";
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 overflow-hidden">
                                <?php 
                            $percentages = getReligionPercentages("survey_form_records_household_member");
                            ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Religion (Other Household)</h5>
                                        <div>
                                            <canvas id="religion4"></canvas>
                                            <script>
                                            (function() {
                                                const ctx = document.getElementById('religion4');
                                                let temp = <?php echo json_encode($percentages); ?>;
                                                let labels = Object.keys(temp);
                                                let values = Object.values(temp);
                                                let backgroundColor = [];
                                                for (let i = 0; i < labels.length; i++) {
                                                    let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' +
                                                        Math
                                                        .floor(Math.random() * 256) + ', ' + Math.floor(Math
                                                            .random() *
                                                            256) + ', 0.7)';
                                                    backgroundColor.push(color);
                                                }
                                                const data = {
                                                    labels,
                                                    datasets: [{
                                                        label: 'Religion (Other Household)',
                                                        data: values,
                                                        backgroundColor,
                                                        hoverOffset: 4
                                                    }]
                                                };

                                                const config = {
                                                    type: 'polarArea',
                                                    data,
                                                };
                                                new Chart(ctx, config);
                                            })();
                                            </script>
                                        </div>
                                        <?php
                                        foreach (getReligionCounts("survey_form_records_household_member") as $key => $count) {
                                            echo "<b>$key:</b> $count<br>";
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>
            </div>
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
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="../assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="../assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="../assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="../assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="../assets/vendor/charts/morris-bundle/morris.js"></script>
    <!-- chart c3 js -->
    <script src="../assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="../assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="../assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="../assets/libs/js/dashboard.js"></script>
</body>

</html>