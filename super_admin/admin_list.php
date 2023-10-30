<?php 
    require_once '../config.php';
    require_once '../global.php';

    if(isset($_SESSION['role'])) {
        if($_SESSION['role'] == 'super_admin') {
            // header('location: ../super_admin');
        } else {
            header('location: ../admin');
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
    <title>Barangay list - PIMS | Population Information Monitoring System</title>
    <link rel="stylesheet" href="../src/bootstrap.min.css" />
    <script src="../src/bootstrap.bunddle.min.js"></script>
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

    <!-- jquery -->
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
        transition: all 0.5s;
    }
    </style>
</head>

<body>
    <?php 
        require_once './handle_adding_admin.php';
        require_once './handle_remove_admin.php';
        require_once './handle_update_admin.php';
    ?>
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
                            <li class="nav-item my-2">
                                <a href="./barangay_list.php"
                                    class="text-center text-white d-flex align-items-center justify-content-start gap-2 ml-4 fs-5">
                                    <span class="material-symbols-outlined">folder_managed</span>
                                    Manage Brgy
                                </a>
                            </li>
                            <li class="nav-item my-2 current-page">
                                <a href="./admin_list.php"
                                    class="text-center text-white d-flex align-items-center justify-content-start gap-2 ml-4 fs-5">
                                    <span class="material-symbols-outlined">group</span>
                                    Manage Admins
                                </a>
                            </li>
                            <!-- <li class="nav-item my-2">
                                <a href="#"
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
                                    <h2 class="pageheader-title font-weight-bold col-12 col-md-6">Manage Admins</h2>
                                    <form action="javascript:void(0)"
                                        class="col-12 col-md-6 d-flex align-items-center justify-content-between gap-2 mb-3">
                                        <div class="position-relative" style="width: 100%; ">
                                            <!-- search icon -->
                                            <span class="material-symbols-outlined position-absolute" style="top: 50%;
                                                         left: 13px;
                                                         transform: translateY(-50%);">
                                                search
                                            </span>
                                            <input onchange="w3.filterHTML('#tbl', 'tr', this.value)"
                                                oninput="w3.filterHTML('#tbl', 'tr', this.value)" type="text"
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
                                        <script>
                                        ! function e() {
                                            let n = document.getElementById("searchInput"),
                                                t = document.getElementById("startButton");
                                            if ("webkitSpeechRecognition" in window) var r =
                                                new webkitSpeechRecognition;
                                            else if (!("SpeechRecognition" in window)) return;
                                            else var r = new SpeechRecognition;
                                            r.continuous = !1, r.interimResults = !1, r.lang = "en-US", r.onresult =
                                                function(e) {
                                                    let t = e.results[0][0].transcript;
                                                    n.value = t;
                                                    w3.filterHTML('#tbl', 'tr', t);
                                                }, r.onerror = function(e) {
                                                    console.error("Speech recognition error:", e.error)
                                                }, t.addEventListener("click", function() {
                                                    r.start()
                                                })
                                        }();
                                        </script>

                                        <button data-bs-toggle="modal" data-bs-target="#addBrgy" role="button"
                                            class="btn text-white btn-lg" style="
                                            background-color: #1D5B79;
                                            border-radius: 50px;
                                        ">+ Add Admin</button>
                                    </form>
                                </div>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">admin</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">List</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col fw-bold">#</th>
                                    <th scope="col fw-bold">Barangay</th>
                                    <th scope="col fw-bold">Municipalaty</th>
                                    <th scope="col fw-bold">Province</th>
                                    <th scope="col fw-bold">Username</th>
                                    <th scope="col fw-bold">Password</th>
                                    <th scope="col fw-bold">Address</th>
                                    <th scope="col fw-bold">Contact</th>
                                    <th scope="col fw-bold">Email</th>
                                    <th scope="col fw-bold">Role</th>
                                    <th scope="col fw-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tbl">
                                <?php
                                 $brgy_rows = getRows("role = 'admin'", "accounts");
                                 
                                 $rows_count = 1;
                                 foreach($brgy_rows as $row) {
                                    ?>
                                <tr>
                                    <th scope="row">
                                        <?php echo $rows_count ?>
                                    </th>
                                    <td>
                                        <?php echo $row['barangay'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['municipality'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['province'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['username'] ?>
                                    </td>
                                    <td>
                                        <?php echo hideKeys($row['password']) ?>
                                    </td>
                                    <td>
                                        <?php echo $row['address'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['contact'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['email'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['role'] ?>
                                    </td>
                                    <td class="d-flex align-items-center justify-content-center gap-2">
                                        <button data-username="<?php echo $row['username'] ?>" id="removeAdmin"
                                            class="btn btn-danger btn-sm fs-6 d-flex align-items-center justify-content-center">
                                            <span class="material-symbols-outlined fs-6">
                                                close
                                            </span></button>
                                        <button data-username="<?php echo $row['username'] ?>" id="editAdmin"
                                            class="btn btn-success btn-sm d-flex align-items-center justify-content-center"><span
                                                class="material-symbols-outlined fs-6">
                                                border_color
                                            </span></button>
                                    </td>
                                </tr>
                                <?php
                                $rows_count++;
                                 }
                                ?>
                                <script>
                                function showConfirmation(username) {
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: 'This action cannot be undone.',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, proceed!',
                                        cancelButtonText: 'Cancel',
                                        reverseButtons: true,
                                    }).then((result) => (result.isConfirmed && window.open(`?username=${username}`,
                                        "_self")));
                                }

                                $(document).ready(function() {
                                    $('button[id="removeAdmin"]').on('click', function() {
                                        let username = $(this).attr('data-username');
                                        showConfirmation(username);
                                    });
                                    $('button[id="editAdmin"]').on('click', function() {
                                        let username = $(this).attr('data-username');
                                        window.open("./admin_list.php?update_username=" + username,
                                            "_self");

                                    })
                                })
                                </script>
                            </tbody>
                        </table>
                    </div>

                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <!-- Modal -->
                    <div class="modal fade" id="addBrgy" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <form action="" method="post" class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addBrgyLabel">Add Admin</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="form-label">Username:</label>
                                    <input name="username" required type="text" class="form-control">

                                    <label class="form-label mt-3">Password:</label>
                                    <input name="password" required type="text" class="form-control">

                                    <label class="form-label mt-3">Municipalaty:</label>
                                    <input name="municipality" required type="text" class="form-control">

                                    <label class="form-label mt-3">Province:</label>
                                    <input name="province" required type="text" class="form-control">

                                    <input id="unique_id_hidden" name="unique_id" required type="hidden">

                                    <label class="form-label mt-3">Assign to barangay:</label>
                                    <select id="selectBrgy" required name="barangay" class="form-select">
                                        <option selected disabled class="d-none"></option>
                                        <?php
                                            $brgy_rows = getRows(null, "barangay");
                                            foreach($brgy_rows as $row) {
                                        ?>
                                        <option data-unique-id="<?php echo $row['unique_id'] ?>"
                                            value="<?php echo $row['barangay'] ?>"><?php echo $row['barangay'] ?>
                                        </option>
                                        <?php
                                            }
                                        ?>
                                    </select>

                                    <script>
                                    $(document).ready(function() {
                                        $('#selectBrgy').on('change', function() {
                                            var selectedOption = $(this).find(':selected');
                                            var uniqueId = selectedOption.data('unique-id');
                                            $('#unique_id_hidden').val(uniqueId);
                                        });
                                    });
                                    </script>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button name="add_admin" type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- update admin modal -->
                    <div class="modal fade" id="updateAdmin" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <form action="" method="post" class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateBrgyLabel">Edit admin</h5>
                                    <button onclick="closeUpdate()" type="button" class="btn-close"
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php 
                                        $username = htmlspecialchars( $_GET[ 'update_username' ] ?? null );
                                        $sql = "SELECT * FROM accounts WHERE username = '$username'";
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                    ?>

                                    <label class="form-label">Username:</label>
                                    <input name="username" value="<?php echo $row['username'] ?? null ?>" required type="text"
                                        class="form-control">

                                    <label class="form-label mt-3">Password:</label>
                                    <input name="password" value="<?php echo $row['password'] ?? null ?>" required
                                        type="password" class="form-control">

                                    <label class="form-label mt-3">Municipalaty:</label>
                                    <input name="municipality" value="<?php echo $row['municipality'] ?? null ?>" required
                                        type="text" class="form-control">

                                    <label class="form-label mt-3">Province:</label>
                                    <input name="province" value="<?php echo $row['province'] ?? null ?>" required type="text"
                                        class="form-control">

                                    <input id="unique_id_hidden_2" name="unique_id" required type="hidden">

                                    <label class="form-label mt-3">Assign to barangay:</label>
                                    <select id="selectBrgy_2" required name="barangay" class="form-select">
                                        <option selected disabled class="d-none"></option>
                                        <?php
                                            $brgy = $row['barangay'];
                                            $brgy_rows = getRows(null, "barangay");
                                            foreach($brgy_rows as $row) {
                                        ?>
                                        <option <?php echo $brgy == ($row['barangay'] ?? null) ? 'selected' : '' ?> data-unique-id="<?php echo $row['unique_id'] ?? null ?>"
                                            value="<?php echo $row['barangay'] ?? null ?>"><?php echo $row['barangay'] ?? null ?>
                                        </option>
                                        <?php
                                            }
                                        ?>
                                    </select>

                                    <script>
                                    $(document).ready(function() {
                                        $('#selectBrgy_2').on('change', function() {
                                            var selectedOption = $(this).find(':selected');
                                            var uniqueId = selectedOption.data('unique-id');
                                            $('#unique_id_hidden_2').val(uniqueId);
                                        });
                                    });
                                    </script>

                                </div>
                                <div class="modal-footer">
                                    <button onclick="closeUpdate()" type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button name="update_btn" type="submit" class="btn btn-primary">Save
                                        changes</button>
                                    <script>
                                    function closeUpdate() {
                                        setTimeout(() => {
                                            window.open('./admin_list.php', '_self');
                                        }, 100);
                                    }
                                    </script>
                                </div>
                            </div>
                        </form>
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
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="../assets/libs/js/main-js.js"></script>
</body>

</html>