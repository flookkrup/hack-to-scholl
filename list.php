<?php
require_once "functions.php";

checkCookieLogin();

$username = $_SESSION["username"] ?? null;

$ebookPerPage = 10;
$totalEbook = count(query("SELECT * FROM ebooks", true));
$totalPage = ceil($totalEbook / $ebookPerPage);
$activePage = $_GET["page"] ?? 1;
$index = $ebookPerPage * $activePage - $ebookPerPage;
$ebooks = query("SELECT * FROM ebooks ORDER BY id DESC LIMIT $index, $ebookPerPage", true);

if (isset($_GET["keyword"])) {
    $keyword = htmlspecialchars($_GET["keyword"]);
    $totalEbook = count(searchEbook($keyword));
    $totalPage = ceil($totalEbook / $ebookPerPage);
    $ebooks = searchEbook($keyword, $index, $ebookPerPage);
}
?>
<!DOCTYPE html>
<html lang="en">
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
    <title>List eBook - eBook Apps</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top" aria-label="navigation">
        <div class="container">
            <a href="home" class="navbar-brand d-flex align-items-center">
                <img src="assets/img/icon-ebook.png" alt="Icon eBook" class="me-1"> eBook Apps
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="home" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="list" class="nav-link active" aria-current="page">List eBook</a>
                    </li>
                    <li class="nav-item">
                        <a href="create" class="nav-link">Add eBook</a>
                    </li>
                </ul>
                <form action="" method="get" class="d-flex" autocomplete="off">
                    <input type="search" name="keyword" id="keyword" class="form-control me-2 ms-lg-2" placeholder="Search eBooks" <?php if (isset($keyword)): ?>value="<?= $keyword; ?>"<?php endif; ?> onkeyup="searchEbook()" autofocus>
                </form>
                <?php if (isset($_SESSION["username"])): ?>
                <div class="dropdown d-none d-lg-block">
                    <img src="assets/img/icon-user.png" alt="Icon User" class="btn dropdown-toggle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                        <li>
                            <button type="button" class="dropdown-item user-select-none pe-auto">
                                Signed in as <span class="fw-bold"><?= $username; ?></span>
                            </button>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a href="logout" class="dropdown-item link-warning fw-semibold">Logout</a>
                        </li>
                    </ul>
                </div>
                <div class="text-light my-3 user-select-none d-lg-none">
                    Signed in as <span class="fw-bold"><?= $username; ?></span>
                </div>
                <a href="logout" class="btn btn-warning mb-2 fw-semibold d-lg-none">Logout</a>
                <?php else: ?>
                <a href="login" class="btn btn-warning fw-semibold mt-3 mb-2 my-lg-0 mx-lg-2">Sign In</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main id="content" class="container my-4">
        <h1 class="fs-3<?= !isset($username) ? " mb-4" : ""; ?>">Total eBooks: <?= $totalEbook; ?></h1>
        <?php if ($totalEbook === 0): ?>
        <div class="not-found d-flex flex-column justify-content-center align-items-center">
            <i class="bi bi-search display-1" aria-hidden="true"></i>
            <h2 class="my-4">Oops couldn't find any eBooks!</h2>
        </div>
        <?php else: ?>
        <div class="list-ebook">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-2 g-4">
                <?php foreach ($ebooks as $ebook): ?>
                <div class="col">
                    <?php if (isset($_SESSION["username"])): ?>
                        <?php if ($_SESSION["role"] === "admin"): ?>
                        <div class="text-end">
                            <div class="btn-group" role="group" aria-label="Update and Delete">
                                <a href="update?id=<?= $ebook["id"]; ?>" class="btn btn-sm btn-outline-success">Update</a>
                                <a href="delete?id=<?= $ebook["id"]; ?>" class="btn btn-sm btn-outline-danger" onclick="deleteEbook(event)">Delete</a>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="card shadow-sm">
                        <div class="row g-0">
                            <div class="col-xl-4 text-center m-xl-auto">
                                <img src="assets/img/<?= $ebook["cover"]; ?>" alt="<?= $ebook["cover"]; ?>" class="img-fluid rounded">
                            </div>
                            <div class="col-xl-8">
                                <div class="card-body">
                                    <a href="<?= $ebook["link"]; ?>" target="_blank" rel="noopener noreferrer" class="card-title link-dark text-center text-decoration-none fs-5 fw-bold line-clamp"><?= $ebook["title"]; ?></a>
                                </div>
                                <ul class="list-group list-group-flush mx-2">
                                    <li class="list-group-item">Author: <?= $ebook["author"]; ?></li>
                                    <li class="list-group-item">Category: <?= $ebook["category"]; ?></li>
                                    <li class="list-group-item">Type:
                                        <?php if ($ebook["type"] === "Free"): ?>
                                        <span class="badge bg-success">Free</span>
                                        <?php else: ?>
                                        <span class="badge bg-danger">Paid</span>
                                        <?php endif; ?>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-end align-items-center rounded-bottom">
                                        <?php if ($ebook["status"] === "Verified"): ?>
                                        <span class="status"><i class="bi bi-patch-check-fill text-primary" aria-hidden="true"></i> Verified</span>
                                        <?php else: ?>
                                        <span class="status"><i class="bi bi-patch-exclamation-fill text-danger" aria-hidden="true"></i> Unverified</span>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($totalEbook > 0): ?>
        <nav class="my-4" aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item<?= $activePage <= 1 ? " disabled" : ""; ?>">
                    <a href="?page=<?= $activePage - 1; ?><?= isset($keyword) ? "&keyword=$keyword" : ""; ?>" class="page-link">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                    <li class="page-item<?= $i == $activePage ? " active" : ""; ?>">
                        <a href="?page=<?= $i; ?><?= isset($keyword) ? "&keyword=$keyword" : ""; ?>" class="page-link"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item<?= $activePage >= $totalPage ? " disabled" : ""; ?>">
                    <a href="?page=<?= $activePage + 1; ?><?= isset($keyword) ? "&keyword=$keyword" : ""; ?>" class="page-link">Next</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </main>

    <footer class="bg-dark text-light px-0 py-4 p-sm-4">
        <div class="container d-flex justify-content-between align-items-center flex-column flex-md-row">
            <div>
                &copy; <?= date("Y") ?> Created by
                <a href="https://github.com/madfauzy" target="_blank" rel="noopener noreferrer" class="link-warning text-decoration-none fw-semibold">
                    <i class="bi bi-balloon-heart-fill text-warning" aria-hidden="true"></i> flookkrup404
                </a>
            </div>
            <div>
                eBook Icons Created by
                <a href="https://flaticon.com/free-icons/ebook" title="ebook icons" target="_blank" rel="noopener noreferrer" class="link-warning text-decoration-none fw-semibold">Freepik - Flaticon</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.33/dist/sweetalert2.all.min.js" integrity="sha256-uGRHvDtVpBeFd7aKWnNdg7qIo+f+dQPlFRMSTqOq7o8=" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
    <?php if (isset($_GET["delete"])): ?>
        <?php if ($_GET["delete"] === "success"): ?>
        <script>
            Swal.fire('Success!', 'eBook has been deleted', 'success');
        </script>
        <?php else: ?>
        <script>
            Swal.fire('Error!', 'Failed to delete eBook. Try again!', 'error');
        </script>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
