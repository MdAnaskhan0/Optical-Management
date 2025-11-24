<?php
include 'includes/config.php';

// Redirect if already logged in
if (isLoggedIn()) {
    if (isAdmin()) {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: user/dashboard.php");
    }
    exit();
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND status = 'active'");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['branch_id'] = $user['branch_id'];

        if ($user['role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: user/dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Optical Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .login-container {
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .login-image {
            background: #fff;
            /* Light background instead of gradient */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        .image-content {
            padding: 2rem;
            width: 100%;
            border-radius: 10px;
        }

        .image-content img {
            max-width: 80%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .login-image {
                min-height: 300px;
            }

            .image-content img {
                max-width: 60%;
            }
        }

        .login-form-section {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .login-card {
            border: none;
            border-radius: 0;
            box-shadow: none;
            max-width: 400px;
            width: 100%;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
            border-bottom: none;
            padding: 0;
        }

        .brand-logo {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 0;
            border: 1px solid #dee2e6;
            padding: 0.75rem;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #2c3e50;
        }

        .btn-login {
            background-color: #2c3e50;
            border: none;
            border-radius: 0;
            padding: 0.75rem;
            color: white;
        }

        .btn-login:hover {
            background-color: #34495e;
        }

        .input-group-text {
            background-color: white;
            border: 1px solid #dee2e6;
            border-right: none;
            border-radius: 0;
        }

        .password-toggle {
            background-color: white;
            border: 1px solid #dee2e6;
            border-left: none;
            border-radius: 0;
        }

        @media (max-width: 768px) {
            .login-image {
                min-height: 300px;
            }

            .login-form-section {
                min-height: auto;
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid login-container">
        <div class="row g-0">
            <!-- Left Side - Image Section -->
            <div class="col-lg-6 d-none d-lg-block">
                <div class="login-image">
                    <div class="image-content">
                        <img src="assets/image/3.jpg" alt="Optical Management System"
                            style="max-width: 100%; height: auto;">
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="col-lg-6">
                <div class="login-form-section">
                    <div class="login-card">
                        <div class="login-header">
                            <div class="brand-logo">
                                <i class="fas fa-glasses"></i>
                            </div>
                            <h4 class="mb-2">Welcome Back</h4>
                            <p class="text-muted">Sign in to your account</p>
                        </div>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="username" class="form-label small fw-semibold">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Enter your username" required>
                                    <div class="invalid-feedback">
                                        Please enter your username.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label small fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter your password" required>
                                    <button class="btn password-toggle" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <div class="invalid-feedback">
                                        Please enter your password.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe">
                                <label class="form-check-label small" for="rememberMe">Remember me</label>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-login">
                                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                </button>
                            </div>
                        </form>

                        <div class="text-center">
                            <small class="text-muted">
                                &copy; 2024 Optical Management System
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Auto-focus on username field
        document.getElementById('username').focus();
    </script>
</body>

</html>