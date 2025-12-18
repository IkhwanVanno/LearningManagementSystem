<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - LMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/auth.css')
</head>

<body>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Learning<br>Management System</h2>

            <form method="POST" action="{{ url('/auth/login') }}">
                @csrf

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" placeholder="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" placeholder="password" name="password" required>
                </div>

                <div class="forgot">
                    <span>Forgot password?</span>
                    <a href="#">Reset</a>
                </div>

                <button type="submit" class="btn-primary">Login</button>

                <div class="divider">
                    <span>OR</span>
                </div>

                <button type="button" class="btn-google">
                    <img src="{{ asset('images/GoogleIcon.png') }}" alt="google">
                    Google
                </button>

                <p class="switch">
                    Don't have an account?
                    <a href="{{ url('/auth/register') }}">Register Now</a>
                </p>
            </form>
        </div>
    </div>

</body>

</html>