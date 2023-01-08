<?php
require_once "functions.php";

checkCookieLogin();

$username = $_SESSION["username"] ?? null;

$keyword = htmlspecialchars($_GET["keyword"]);
$ebookPerPage = 10;
$totalEbook = count(searchEbook($keyword));
$totalPage = ceil($totalEbook / $ebookPerPage);
$activePage = $_GET["page"] ?? 1;
$index = $ebookPerPage * $activePage - $ebookPerPage;
$ebooks = searchEbook($keyword, $index, $ebookPerPage);
?>
<h1 class="fs-3">Total eBooks: <?= $totalEbook; ?></h1>
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
