<?php
require_once "functions.php";

if (isset($_POST["signup"])) {
    $result = userSignUp($_POST);
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Courgette&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/img/icon-ebook.png" type="image/png">
    <title>Join eBook Apps</title>
</head>
<body class="h-100 d-flex align-items-center py-2">
    <div class="form-sign w-100 m-auto p-4 text-center">
        <form action="" method="post" autocomplete="off">
            <a href="home">
                <img src="assets/img/icon-ebook.png" alt="Icon eBook">
            </a>
            <h1 class="my-3 fs-3">Create an account</h1>
            <?php if (isset($result["error"])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $result["message"] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            <div class="form-floating mb-2">
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" maxlength="20" onkeyup="validateSignUp()" autofocus required>
                <label for="username">Username</label>
                <div class="invalid-feedback text-start">
                    Please choose a username.
                </div>
            </div>
            <div class="form-floating mb-2">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" onkeyup="validateSignUp()" required>
                <label for="password">Password</label>
                <div class="invalid-feedback text-start">
                    Password must be at least 8 characters long
                </div>
            </div>
            <div class="form-floating mb-2">
                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirm Password" onkeyup="validateSignUp()" required>
                <label for="confirmPassword">Confirm Password</label>
                <div class="invalid-feedback text-start">
                    Password didn't match
                </div>
            </div>
            <div class="form-check my-3 d-flex justify-content-center">
                <input type="checkbox" name="show" id="show" class="form-check-input me-2" onclick="showPassword()">
                <label class="form-check-label" for="show">Show Password</label>
            </div>
            <button type="submit" name="signup" class="w-100 btn btn-lg btn-warning">Sign up</button>
            <div class="my-3">
                Already have an account?
                <a href="login" class="link-danger text-decoration-none fw-bold">Sign in</a>
            </div>
            <div class="mt-5 text-muted">
                &copy; <?= date("Y") ?> Created by
                <a href="https://github.com/madfauzy" target="_blank" rel="noopener noreferrer" class="link-warning text-decoration-none fw-bold">
                    <i class="bi bi-balloon-heart-fill text-warning" aria-hidden="true"></i> flookkrup404 in indian
                </a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.33/dist/sweetalert2.all.min.js" integrity="sha256-uGRHvDtVpBeFd7aKWnNdg7qIo+f+dQPlFRMSTqOq7o8=" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
    <?php if (isset($result["success"])): ?>
    <script>
        let timerInterval;
        Swal.fire({
            title: 'Success!',
            html: 'You Will Be Redirected!',
            icon: 'success',
            allowOutsideClick: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
            willClose: () => {
                clearInterval(timerInterval);
            },
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                window.location.href = 'login';
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>
