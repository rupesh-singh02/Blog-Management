<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: "Cabin", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }

        .container-fluid {
            height: 100vh;
        }

        .row {
            display: flex;
            justify-content: center;
            align-items: stretch;
            height: 100%;
        }

        .col-12.col-md-6 {
            padding: 0;
        }

        #signup-container {
            background: rgba(119, 0, 255, 0.8);
            border-right: 2px solid #ddd;
        }

        #login-container {
            background: #fff;
        }

        #login-container .form-container {
            background: rgba(119, 0, 255, 0.7);
        }

        .form-container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 400px;
            width: 100%;
        }

        .form-container h2 {
            font-family: 'Karla', sans-serif;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-floating {
            margin-bottom: 20px;
        }

        .form-control {
            padding: 15px;
            font-size: 16px;
            border-radius: 10px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            padding: 12px 20px;
            width: 100%;
            font-size: 18px;
            border-radius: 10px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1e5cc8;
            border-color: #1e5cc8;
        }

        .error-message {
            background-color: #f8d7da;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            color: #721c24;
        }

        /* Responsive Design */
        @media (max-width: 767px) {
            .row {
                flex-direction: column;
                align-items: center;
                margin-top: 50px;
            }

            .form-container {
                padding: 30px;
            }

            .form-control {
                font-size: 14px;
                padding: 12px;
            }

            .btn-primary {
                font-size: 16px;
                padding: 10px 18px;
            }

            #signup-container {
                border-right: none;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- Signup Form -->
            <div class="col-12 col-md-6 d-flex justify-content-center align-items-center mb-4 mb-md-0"
                id="signup-container">
                <div class="form-container">
                    <h2>Signup</h2>

                    <!-- Error message -->
                    <?php if (isset($signupError)) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong> <?php echo htmlspecialchars($signupError); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <form action="index.php?action=signup" method="post">
                        <div class="form-floating mb-3">
                            <input type="text" id="new-username" name="username" class="form-control" required
                                placeholder=" ">
                            <label for="new-username">Username</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" id="new-email" name="email" class="form-control" required
                                placeholder=" ">
                            <label for="new-email">Email</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" id="new-password" name="password" class="form-control" required
                                placeholder=" ">
                            <label for="new-password">Password</label>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Signup</button>
                    </form>
                </div>
            </div>

            <!-- Login Form -->
            <div class="col-12 col-md-6 d-flex justify-content-center align-items-center" id="login-container">
                <div class="form-container">
                    <h2 class="text-white">Login</h2>

                    <!-- Error message -->
                    <?php if (isset($loginError)) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong> <?php echo htmlspecialchars($loginError); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <form action="index.php?action=loginPost" method="post">
                        <div class="form-floating mb-3">
                            <input type="text" id="username" name="username" class="form-control" required
                                placeholder=" ">
                            <label for="username">Username</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" id="password" name="password" class="form-control" required
                                placeholder=" ">
                            <label for="password">Password</label>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Login</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Success Modal -->
    <?php if (isset($successMessage)) { ?>
        <div class="modal fade" id="signupSuccessModal" tabindex="-1" aria-labelledby="signupSuccessModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="signupSuccessModalLabel">Signup Successful</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php echo htmlspecialchars($successMessage); ?>
                    </div>
                    <div class="modal-footer">
                        <a href="index.php?action=login" class="btn btn-primary">Ok</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <script>
        // Show the modal after successful signup
        <?php if (isset($successMessage)) { ?>
            var successModal = new bootstrap.Modal(document.getElementById('signupSuccessModal'));
            successModal.show();
        <?php } ?>
    </script>

</body>

</html>