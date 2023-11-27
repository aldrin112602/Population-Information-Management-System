<?php
require_once './send_OTP.php';
require_once './config.php';
require_once './global.php';

if ( isset( $_SESSION[ 'role' ] ) ) {
    if ( $_SESSION[ 'role' ] == 'super_admin' ) {
        header( 'location: ./super_admin/' );
    } else {
        header( 'location: ./admin/' );
    }
}
 $email = $err_msg = null;

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['email'])) {
    $email = trim($_POST['email'] ?? '');
    $query = "SELECT * FROM accounts WHERE email = '$email' LIMIT 1";
    if ($result = mysqli_query($conn, $query)) {
        if (!mysqli_num_rows($result) > 0) {
            $err_msg = "User email did not exist!";
        } else {
            $row = mysqli_fetch_assoc($result);

            $token = random_int(100000, 999999);
            $body = '
                <!DOCTYPE html>
                <html>
                    <head>
                        <title>Verification Code for PIMS - Tanay, Rizal</title>
                    </head>
                    <body>
                        <p>Dear ' . $row['email'] . ',</p>
                        <p>We received a reset verification code request for your account. If you did not initiate this request, please ignore this email, please enter the following verification code:</p>
                        <h2 style="text-align:center; font-size:32px;">' . $token . '</h2>
                        <p>This code is valid for <b>10 minutes</b>, so please enter it as soon as possible.</p>
                        <p>If you have any trouble entering the code, please don\'t hesitate to contact us at <a href="mailto:cabaleroaldrin02@gmail.com">cabaleroaldrin02@gmail.com</a>.</p>
                    </body>
                </html>';
            if (send_mail($row['email'], $body, 'Reset Password Verification (PIMS)')) {
                $_SESSION['reset_verification'] = $token;
            } else {
                $err_msg = "Something went wrong, please try again!";
            }
        }

        
    }
}
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['otp'])) {
    if(!($_SESSION['reset_verification'] == $_POST['otp'])) {
        $err_msg = "Invalid OTP verification code!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - PIMS | Population Information Monitoring System</title>
    <link rel="stylesheet" href="src/bootstrap.min.css" />
    <script src="./src/jquery.min.js"></script>
    <script src="./src/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- Favicon -->
    <link rel="icon" href="img/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />

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

    <!-- custom styles -->
    <style>
    * {
        font-family: "Poppins", sans-serif;
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        transition: all 0.5s;
    }

    .form {
        background-color: rgba(0, 0, 0, 0.8);
        border-radius: 50px;
        box-shadow: 0 0 10px 100vw rgba(0, 0, 20, 0.7);
        backdrop-filter: blur(1px);
    }

    .form .input {
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 70px;
        color: white;
        border: 0;
    }

    div img {
        z-index: 100;
    }

    .form button {
        background-color: #1D5B79;
        border-radius: 70px;
        color: white;
        width: 50%;
    }

    .form button:hover {
        border: 1px solid white;
    }
    </style>
</head>

<body>

    <div style="
        min-height: 100vh;
        background: url(img/bg.jpeg);
        background-repeat: no-repeat;
        background-size: 100% 100%;
      " class="w-full d-flex align-items-center justify-content-center flex-column px-3">
        <img src="img/pims logo.png" alt="pims logo" class="img-fluid mb-4" width="330px">
        <?php if(!isset($_SESSION['reset_verification'])) { ?>
            <form action="" method="post" class="form p-5 text-white col-12 col-md-4 col-lg-3">
                <h1 class="text-center fw-bolder fs-5">Forgot Password</h1>
                <div class="container my-3">
                    <label for="username" class="mx-2">EMAIL</label>
                    <input value="<?php echo $email ?? '' ?>" required type="email"
                        class="form-control form-control-lg input" id="email" name="email">
                </div>
                <div class="container my-3 text-center">
                    <button type="submit" class="btn">Continue</button>
                </div>
            </form>
        <?php } else { ?>
            <form action="" method="post" class="form p-5 text-white col-12 col-md-4 col-lg-3">
                <h1 class="text-center fw-bolder fs-4">OTP verification</h1>
                <div class="container my-3">
                    <label for="otp" class="mx-2">Enter 6 digits code:</label>
                    <input placeholder="xxxxxx" value="<?php echo $_POST[ 'otp' ] ?? null ?>" required type="number"
                        class="form-control form-control-lg input" id="otp" name="otp">
                </div>
                <div class="container my-3 text-center">
                    <button type="submit" class="btn">Verify</button><br>
                    <p class="mt-3 fs-6">Didn't receive OTP? <a href="" class="text-white">Resend</a></p>
                </div>
            </form>
        <?php } ?>
    </div>
    <?php
        if(isset($err_msg)) {
            echo '
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "Error!",
                        text: "'. $err_msg .'",
                        icon: "error",
                    });
                })
            </script>
        ';
        }


    ?>
</body>

</html>