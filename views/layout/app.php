<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Default Title' ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="../public/assets/css/styles.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/da2c8b88da.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg px-5 fixed-top">
        <div class="container-fluid px-2">
            <a class="navbar-brand p-0" href="#">Let's Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-arrow p-0" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../public/assets/images/user.png" alt="Profile Picture" class="rounded-circle"
                                style="width: 40px; height: 40px;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end py-1">
                            <li class="dropdown-header text-dark text-center fw-bold pt-3">Welcome,
                                <?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['username']) : 'Guest' ?>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="index.php?action=logout">
                                    <button type="submit" class="dropdown-item text-center">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-3 px-0">
        <?php if (isset($content)): ?>
            <?= $content ?>
        <?php else: ?>
            <p>No content available. Debugging: Ensure content is being passed correctly.</p>
        <?php endif; ?>
    </div>


    <!-- Footer -->
    <footer class="footer bg-dark text-white py-4 mt-0">
        <div class="container">
            <div class="d-flex justify-content-center">
                <p class="mb-0">
                    <span>
                        Copyright &copy;2024 All rights reserved
                    </span>
                    <span class="mx-2">
                        |
                    </span>
                    <span>
                        This template is created by Rupesh
                    </span>
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>