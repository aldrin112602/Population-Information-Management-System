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
    <?php 
        require_once './handle_login.php';
    ?>
    <div style="
        min-height: 100vh;
        background: url(img/bg.jpeg);
        background-repeat: no-repeat;
        background-size: 100% 100%;
      " class="w-full d-flex align-items-center justify-content-center flex-column px-3">
        <img src="img/pims logo.png" alt="pims logo" class="img-fluid mb-4" width="330px">
        <?php if(!isset($_SESSION['validate_otp'])) { ?>
        <form action="" method="post" class="form p-5 text-white col-12 col-md-4 col-lg-3">
            <h1 class="text-center fw-bolder">Login</h1>
            <div class="container my-3">
                <label for="username" class="mx-2">USERNAME</label>
                <input value="<?php echo $username ?>" required type="text" class="form-control form-control-lg input"
                    id="username" name="username">
            </div>
            <div class="container my-3">
                <label for="username" class="mx-2">PASSWORD</label>
                <input value="<?php echo $password ?>" required type="password"
                    class="form-control form-control-lg input" id="password" name="password">
            </div>
            <div class="d-flex align-items-center justify-content-end px-4">
                <a href="./forgot_password.php" class="nav-link"><small>Forgot password?</small></a>
            </div>
            <div class="container my-3 text-center">
                <button type="submit" class="btn">Login</button>
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
</body>

</html>