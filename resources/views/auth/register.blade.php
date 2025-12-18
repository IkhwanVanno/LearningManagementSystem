<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - LMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/auth.css')
</head>

<body>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Learning<br>Management System</h2>

            <form method="POST" action="{{ url('/auth/register') }}">
                @csrf

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" placeholder="username" name="name" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" placeholder="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" placeholder="Phone number" name="phone">
                </div>

                <div class="form-group">
                    <label>I'm a</label>
                    <select required name="role">
                        <option value="">Select role</option>
                        <option value="student">Student</option>
                        <option value="mentor">Mentor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" placeholder="password" name="password" required>
                </div>

                <button type="submit" class="btn-primary">Register</button>

                <p class="switch">
                    Already have an account?
                    <a href="{{ url('/auth/login') }}">Login</a>
                </p>
            </form>
        </div>
    </div>

</body>

</html>