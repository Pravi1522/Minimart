<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> <!-- Add this line -->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/style.css') }}">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">Admin Login</h3>
                        <form action="{{ route('admin.authenticate') }}" method="POST" id="login-form">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" id="email" class="form-control" 
                                       value="{{ old('email') }}" placeholder="Enter your email">
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" name="password" type="password" class="form-control" 
                                       placeholder="Enter your password" autocomplete="off">
                                <span class="position-absolute top-50 end-0 translate-middle-y me-2 border-0 mt-3" onclick="togglePassword()">
                                    <i class="bi bi-eye"></i>
                                </span>
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            if (password.type === 'password') {
                password.type = 'text';
            } else {
                password.type = 'password';
            }
        }
    </script>
</body>
</html>
