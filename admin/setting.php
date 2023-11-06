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
        header('location: ../');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Settings - PIMS | Population Information Monitoring System</title>
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

    <!-- jquery plugin -->
    <script src="../src/jquery.min.js"></script>
    <script src="../src/sweetalert2/sweetalert2.all.min.js"></script>

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
    <?php
    $name = $success_msg = $error_msg = $email = $username = $first_name = $last_name = $password = $inpt_password = $confirm_password = null;

    if (isset($_POST['update'])) {
            $username = filter_and_implode($_POST['username']);
            $email = filter_and_implode($_POST['email']);
            $number = filter_and_implode($_POST['number']);
            $address = ucwords(filter_and_implode($_POST['address']));

            if (!preg_match("/^[a-zA-Z0-9._-]*$/", $username)) {
                $err_msg = "Usernames can only contain letters, numbers, dots, dashes, and underscores!";
            } elseif (!preg_match('/^(09|\+639)[0-9]{9}$/', $number)) {
                $err_msg = 'Invalid number, please enter a valid number!';
            } else {
                $sql = "UPDATE accounts SET username=?, address=?, email=?, contact=?";
                $params = array($username, $address, $email, $number);

                if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                    $file = $_FILES['file'];
                    $fileName = $file['name'];
                    $fileTmpName = $file['tmp_name'];
                    $fileNameNew = uniqid('', true) . '.' . strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $fileDestination = './profile/' . $fileNameNew;

                    if (move_uploaded_file($fileTmpName, $fileDestination)) {
                        $sql .= ", profile=?";
                        $params[] = $fileDestination;
                    }
                }

                $sql .= " WHERE username=?";
                $params[] = $_SESSION['username'];

                $stmt = mysqli_prepare($conn, $sql);
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, str_repeat('s', count($params)), ...$params);
                    $result = mysqli_stmt_execute($stmt);

                    if ($result) {
                        $_SESSION['username'] = $username;
                        $_SESSION['email'] = $email;
                        $success_msg = 'Profile updated successfully!';
                    } else {
                        $err_msg = "Error: " . mysqli_error($conn);
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    $err_msg = "Error: " . mysqli_error($conn);
                }
            }
        }

        // handle change password
        if(isset($_POST['change-password'])) {
            $inpt_password = trim($_POST['pswd']);
            $confirm_password = trim($_POST['con-pswd']);
            // Validate password
            $uppercase    = preg_match( '@[A-Z]@', $inpt_password );
            $lowercase    = preg_match( '@[a-z]@', $inpt_password );
            $_number       = preg_match( '@[0-9]@', $inpt_password );
            $specialChars = preg_match( '@[^\w]@', $inpt_password );
            $length       =  strlen( $inpt_password ) < 8;

            // validate code 
            if ( !$lowercase ) $err_msg  = 'Password must atleast have one lowercase!';
            elseif ( !$_number ) $err_msg = 'Password must atleast have one digit!';
            elseif ( !$specialChars ) $err_msg  = 'Password must atleast have one special character!';
            elseif ( $length ) $err_msg  = 'Password must atleast eight characters!';
            elseif ($inpt_password != $confirm_password) {
                $err_msg = 'Confirm password did not match, please try again!';
            } else {
                // update password
                $sql = "UPDATE accounts SET password = '$inpt_password' WHERE username = '{$_SESSION['username']}'";
                    if( mysqli_query($conn, $sql) ) {
                        $success_msg = 'Password changed successfully!';
                        $password = $inpt_password;
                    }
            }
        }

        
        
        $sql = "SELECT * FROM accounts WHERE username = '{$_SESSION['username']}' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $profile = !empty($row['profile']) ? $row['profile'] : 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Circle-icons-profile.svg/1200px-Circle-icons-profile.svg.png';
        $username = $row['username'] ?? null;
        $address = $row['address'] ?? null;
        $contact = $row['contact'] ?? null;
        $email = $row['email'] ?? null;
        $password = $row['password'] ?? null;

    ?>
    <link rel="stylesheet" href="./style.css">
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
                                <img src="<?php echo $profile; ?>"
                                    alt="Profile avatar" class="img-fluid rounded-circle" width="100px"><br>
                                <h3 class="text-white py-2"><?php echo $_SESSION['username']; ?></h3>
                            </li>
                            <li class="nav-item my-1">
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
                            <li class="nav-item my-1  current-page">
                                <a href=""
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
                            <div class="page-header row justify-content-between">
                                <h2 class="pageheader-title font-weight-bold pb-4 col">Settings</h2>
                                <div class="text-end col ">
                                    <small class="fw-bold">Date: <?php echo date("F d, Y", strtotime(date('Y-m-d'))); ?></small> |
                                    <small id="time" class="fw-bold"><?php echo 'Time: ' .  date("g:i:s A"); ?></small>
                                </div>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href=""
                                                    class="breadcrumb-link">Settings</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <main class="mt-2">
                        <div class="wrapper">
                            <!-- Page Content  -->
                            <div id="content" class="p-0" style="margin-left: 0.5rem;">
                                <!-- main content goes here -->
                                <div class="">
                                    <h3 class="fw-semibold p-3 text-left bg-white text-dark px-md-5">
                                        My Account
                                    </h3>
                                    <div class="mt-4 bg-white p-4">
                                        <h5 class="fw-semibold p-3 text-left bg-white px-md-5">UPDATE
                                            PROFILE</h5>
                                        
                                        <form action="" method="post"
                                            enctype="multipart/form-data">
                                            <div
                                                class="d-md-flex align-items-start justify-content-center gap-5">
                                                <!-- row 1 -->
                                                <div class="col-md-3 col-12">
                                                    <div class="border border-1 border-primary px-4 py-3">
                                                        <h5 class="fw-semibold">Profile Image</h5>
                                                        <div>
                                                            <img style="max-height: 20rem; width: 100%; object-fit: cover;"
                                                                id="profile-img" class="img-fluid"
                                                                src="<?php echo $profile ?>" alt="">
                                                            <div class="d-grid border-1 border-primary mt-3">
                                                                <input id="file-input" type="file" accept="image/*"
                                                                    class="d-none" name="file">
                                                                <button style="border: 2px dashed rgba(0,0,0,0.4);"
                                                                    type="button" id="file-btn"
                                                                    class="btn btn-lg btn-light d-flex align-items-center justify-content-center gap-2">
                                                                    <span
                                                                        class="material-symbols-outlined">add_photo_alternate</span>Upload
                                                                    an image
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-grid pt-4">
                                                        <button type="submit" name="update"
                                                            class="btn btn-lg btn-primary btn-block">Update
                                                            profile</button>
                                                    </div>
                                                </div>
                                                <script>
                                                // choose file
                                                $(document).ready(() => {
                                                    $('#file-btn').on('click', () => {
                                                        $('#file-input').click();
                                                    })

                                                    $('#file-input').on('change', function() {
                                                        const reader = new FileReader();
                                                        reader.onload = (e) => {
                                                            $('#profile-img').attr('src', e.target
                                                                .result);
                                                        }
                                                        reader.readAsDataURL(this.files[0]);
                                                    })
                                                })
                                                </script>
                                                <!-- row 2 -->
                                                <div class="col-md-7 mt-3">
                                                    <div>
                                                        <label class="form-label fs-5" for="">Username</label>
                                                        <input autocomplete="off" value="<?php echo $username; ?>"
                                                            required
                                                            class="form-control form-control-lg border-1 border-primary"
                                                            type="text" name="username">
                                                    </div>

                                                    <div class="my-3">
                                                        <label class="form-label fs-5" for="">Email Address</label>
                                                        <input autocomplete="off" value="<?php echo $email; ?>" required
                                                            class="form-control form-control-lg border-1 border-primary"
                                                            type="email" name="email">
                                                    </div>

                                                    <div class="my-3">
                                                        <label class="form-label fs-5" for="">Contact Number</label>
                                                        <input autocomplete="off" value="<?php echo $contact; ?>"
                                                            required
                                                            class="form-control form-control-lg border-1 border-primary"
                                                            type="number" name="number">
                                                    </div>

                                                    <div class="my-3">
                                                        <label class="form-label fs-5" for="">Address</label>
                                                        <textarea id="addrs" autocomplete="off" required
                                                            class="form-control form-control-lg border-1 border-primary"
                                                            name="address"><?php echo $address; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- change password -->
                                    <div class="mt-4 bg-white p-4">
                                        <h5 class="fw-semibold p-3 text-left bg-white text-dark px-md-5">
                                            CHANGE PASSWORD
                                        </h5>
                                        <form action="" method="post" class="px-md-4 col-md-8 mx-md-4">
                                            <div class="position-relative px-md-4 my-3">
                                                <label for="" class="mb-1 form-label fw-semibold fs-5">Current
                                                    Password</label>
                                                <input id="pswd" readonly type="password"
                                                    value="<?php echo $password; ?>"
                                                    class="form-control form-control-lg border-1 border-primary">
                                                <!-- eye icon -->
                                                <span class="material-symbols-outlined position-absolute"
                                                    id="eye"
                                                    style="top: 56%; right: 2.7rem; cursor: pointer;">visibility_off</span>
                                            </div>
                                            <div class="position-relative px-md-4  my-3">
                                                <label for="" class="mb-1 form-label fw-semibold fs-5">New
                                                    Password</label>
                                                <input required type="password" name="pswd"
                                                    value="<?php echo $inpt_password; ?>"
                                                    class="form-control form-control-lg border-1 border-primary">
                                            </div>
                                            <div class="position-relative px-md-4  my-3">
                                                <label for="" class="mb-1 form-label fw-semibold fs-5">Confirm
                                                    Password</label>
                                                <input required type="password" name="con-pswd"
                                                    value="<?php echo $confirm_password; ?>"
                                                    class="form-control form-control-lg border-1 border-primary">
                                            </div>
                                            <div class="px-md-4 d-grid  my-3">
                                                <button type="submit" class="btn btn-block btn-lg btn-primary"
                                                    name="change-password">Change Password</button>
                                            </div>
                                        </form>
                                    </div>


                                </div> <!-- End of main content  -->

                            </div>


                        </div>
                    </main>


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
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="../assets/libs/js/main-js.js"></script>
    <script>
    $(document).ready(function() {
        // show/hide password
        $('span[id="eye"]').on('click', function() {
            $(this).html($(this).html().trim() == 'visibility' ? 'visibility_off' : 'visibility');
            $('input[id="pswd"]').prop('type', $('input[id="pswd"]').prop('type') === 'text' ?
                'password' : 'text');
        });

        // update time zone
        setInterval(function() {
            $.ajax({
                url: "../get-time.php",
                success: function(data) {
                    $('#time').html(data);
                }
            });
        }, 500);
    });
    </script>
    <?php 
        if (isset($err_msg)) {
            echo '
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: "Error!",
                            text: "'. $err_msg .'",
                            icon: "error",
                            onClose: function() {
                                // do something
                            }
                        });
                    })
                </script>
            ';
            
        }
        if (isset($success_msg)) {
            echo '
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: "Success!",
                            text: "'. $success_msg .'",
                            icon: "success",
                            onClose: function() {
                                // do something
                            }
                        });
                    })
                </script>
            ';
        }
    ?>
</body>

</html>