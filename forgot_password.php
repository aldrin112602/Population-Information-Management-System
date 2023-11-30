<?php
require_once './send_OTP.php';
require_once './config.php';
require_once './global.php';
require_once './audit_trails.php';


if ( isset( $_SESSION[ 'role' ] ) ) {
    if ( $_SESSION[ 'role' ] == 'super_admin' ) {
        header( 'location: ./super_admin/' );
    } else {
        header( 'location: ./admin/' );
    }
}
 $email = $err_msg = $success_msg = null;

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
                $_SESSION['start'] = time();
                $_SESSION['expire'] = $_SESSION['start'] + (10 * 60);
                $_SESSION['email'] = $row['email'];
                $_SESSION['uname'] = $row['username'];
            } else {
                $err_msg = "Something went wrong, please try again!";
            }
        }

        
    }
}
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['otp'])) {
    if(!($_SESSION['reset_verification'] == $_POST['otp'])) {
        $err_msg = "Invalid OTP verification code!";
    } else {
        $_SESSION['reset_verification'] = null;
        $_SESSION['new_password'] = true;
    }
}

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['password'])) {
    $inpt_password = trim($_POST['password']);
    $hashPass = md5($inpt_password);
    $confirm_password = trim($_POST['confirm_password']);
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
        $sql = "UPDATE accounts SET password = '$hashPass' WHERE email = '{$_SESSION['email']}'";
        if( mysqli_query($conn, $sql) ) {
            $success_msg = 'Password changed successfully!';
            logUser($_SESSION[ 'uname' ], 'Password reset successfully!');
            session_destroy();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot password - PIMS | Population Information Monitoring System</title>
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
      " class="w-full d-flex align-items-center justify-content-center flex-column px-3 position-relative">
        <a href="./clear_session.php" class="btn btn-dark border position-absolute"
            style="top: 30px; left: 30px; z-index:10;">Cancel</a>
        <img src="img/pims logo.png" alt="pims logo" class="img-fluid mb-4" width="330px">
        <?php if(!isset($_SESSION['reset_verification']) && !isset($_SESSION['new_password'])) { ?>
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
        <?php } elseif (isset($_SESSION['reset_verification']) && !isset($_SESSION['new_password'])) {
        ?>
        <script>
        let remaining_time = parseInt(<?php echo(($_SESSION['expire'] - time()) / 60) * 60 ?>);
        setInterval(() => {
            if (remaining_time > 0) remaining_time--;
            else {
                $('#time').html('<code>Verification code expired!</code>');
                return;
            }
            $('#time').html('Verification code will be expired <br> after <code>' + remaining_time + 's</code>');
        }, 1000);
        </script>
        <form action="" method="post" class="form p-5 text-white col-12 col-md-4 col-lg-3">
            <h1 class="text-center fw-bolder fs-4">OTP verification</h1>
            <h3 class="text-center fw-semibold fs-6 p-3 text-muted">We have sent a six digit code in your email address!
            </h3>
            <p id="time" class=" text-muted px-3 text-center" style="font-size: 14px;"></p>
            <div class="container my-3">
                <label for="otp" class="mx-2">Enter 6 digits code:</label>
                <input placeholder="xxxxxx" value="<?php echo $_POST[ 'otp' ] ?? null ?>" required type="number"
                    class="form-control form-control-lg input" id="otp" name="otp">
            </div>
            <div class="container my-3 text-center">
                <button type="submit" class="btn">Verify</button><br>
                <p class="mt-3 fs-6">Didn't receive OTP? <a href="resend_OTP.php" class="text-white">Resend</a></p>
            </div>
        </form>
        <?php } else { ?>
        <form action="" method="post" class="form p-5 text-white col-12 col-md-4 col-lg-3">
            <h1 class="text-center fw-bolder fs-4">Create new password</h1>
            <div class="container my-3">
                <label class="mx-2">Enter password password</label>
                <input value="<?php echo $_POST[ 'password' ] ?? null ?>" required type="password"
                    class="form-control form-control-lg input" name="password">
            </div>
            <div class="container my-3">
                <label class="mx-2">Confirm password</label>
                <input value="<?php echo $_POST[ 'confirm_password' ] ?? null ?>" required type="password"
                    class="form-control form-control-lg input" name="confirm_password">
            </div>
            <div class="container my-3 text-center">
                <button type="submit" class="btn">Submit</button>
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

        if(isset($success_msg)) {
            echo '
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "Congratulations!",
                        text: "'. $success_msg .'",
                        icon: "success",
                        onClose: function() {
                            location.href = "login.php";
                        }
                    });
                })
            </script>
        ';
        }


    ?>
</body>

</html>