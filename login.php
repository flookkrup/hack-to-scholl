<?php
require_once "functions.php";

checkCookieLogin();

if (isset($_SESSION["username"])) {
    header("Location: list");
    exit;
}

if (isset($_POST["signin"])) {
    if (userLogin($_POST)) {
        header("Location: list");
        exit;
    }
    
    $error = true;
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
    <title>Sign in to eBook Apps</title>
</head>
<body class="h-100 d-flex align-items-center py-2">
    <div class="form-sign w-100 m-auto p-4 text-center">
        <form action="" method="post" autocomplete="off">
            <a href="home">
                <img src="assets/img/icon-ebook.png" alt="Icon eBook">
            </a>
            <h1 class="my-3 fs-3">Sign in to <span>eBook Apps</span></h1>
            <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Incorrect username or password!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            <div class="form-floating mb-2">
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" maxlength="20" autofocus required>
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <div class="form-check my-3 d-flex justify-content-center">
                <input type="checkbox" name="remember" id="remember" class="form-check-input me-2">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <button type="submit" name="signin" class="w-100 btn btn-lg btn-warning">Sign in</button>
            <div class="my-3">
                Not a member yet?
                <a href="signup" class="link-danger text-decoration-none fw-semibold">Create an account</a>
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
</body>
</html>
