<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login · Job Board</title>
    <!-- Font Awesome (optional, for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: #f7f7f7;
            color: #111;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ---------- MAIN CONTAINER (two columns) ---------- */
        .auth-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            max-width: 1200px;
            width: 100%;
            min-height: 100vh;
            background: #fff;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.03);
        }

        /* ---------- LEFT: BRAND / DESCRIPTION (black theme) ---------- */
        .brand-side {
            background: #111;
            color: #eee;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .brand-side::after {
            content: '';
            position: absolute;
            bottom: -20%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 50%;
            pointer-events: none;
        }

        .brand-side .brand-icon {
            font-size: 3.2rem;
            color: #fff;
            margin-bottom: 1.2rem;
        }

        .brand-side h1 {
            font-size: 2.6rem;
            font-weight: 600;
            letter-spacing: -0.02em;
            color: #fff;
            margin-bottom: 0.8rem;
        }

        .brand-side h1 span {
            font-weight: 300;
            color: #aaa;
        }

        .brand-side .tagline {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #ccc;
            max-width: 360px;
            margin: 0 auto 1.2rem;
        }

        .brand-side .divider-light {
            width: 60px;
            height: 2px;
            background: #333;
            margin: 1.2rem auto;
        }

        .brand-side .feature-list {
            list-style: none;
            margin-top: 1.5rem;
            text-align: left;
            width: 100%;
            max-width: 320px;
        }

        .brand-side .feature-list li {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.5rem 0;
            font-size: 0.95rem;
            color: #ddd;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .brand-side .feature-list li:last-child {
            border-bottom: none;
        }

        .brand-side .feature-list i {
            color: #aaa;
            width: 1.4rem;
            font-size: 1rem;
        }

        /* ---------- RIGHT: FORM ---------- */
        .form-side {
            background: #fff;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .form-wrapper {
            max-width: 400px;
            width: 100%;
        }

        .form-wrapper .form-header {
            margin-bottom: 2rem;
        }

        .form-wrapper .form-header h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #111;
            letter-spacing: -0.02em;
        }

        .form-wrapper .form-header p {
            color: #666;
            margin-top: 0.3rem;
            font-size: 0.95rem;
        }

        /* ---------- FORM ELEMENTS (monochrome) ---------- */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            font-size: 0.9rem;
            color: #222;
            margin-bottom: 0.3rem;
        }

        .form-group .input-wrap {
            position: relative;
        }

        .form-group .input-wrap i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.6rem;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #fcfcfc;
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            color: #111;
        }

        .form-group input:focus {
            outline: none;
            border-color: #111;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.04);
            background: #fff;
        }

        .form-group input::placeholder {
            color: #aaa;
        }

        /* ---------- MESSAGES ---------- */
        .message-box {
            padding: 0.8rem 1rem;
            border-radius: 10px;
            margin-bottom: 1.2rem;
            font-size: 0.9rem;
            display: none;
        }

        .message-box.error {
            background: #f8f0f0;
            color: #b33;
            border-left: 3px solid #b33;
        }

        .message-box.success {
            background: #f0f8f0;
            color: #2a7a2a;
            border-left: 3px solid #2a7a2a;
        }

        /* ---------- LOADING ---------- */
        .loading-box {
            display: none;
            text-align: center;
            padding: 0.5rem 0;
            color: #555;
            font-size: 0.9rem;
        }

        .loading-box .spinner {
            display: inline-block;
            width: 22px;
            height: 22px;
            border: 2px solid #ddd;
            border-top-color: #111;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            margin-right: 0.6rem;
            vertical-align: middle;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ---------- BUTTON ---------- */
        .btn-login {
            width: 100%;
            padding: 0.85rem;
            background: #111;
            color: #fff;
            border: none;
            border-radius: 40px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 0.5rem;
            letter-spacing: 0.01em;
        }

        .btn-login:hover {
            background: #2a2a2a;
            transform: scale(1.01);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* ---------- FOOTER LINKS ---------- */
        .form-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.95rem;
            color: #555;
        }

        .form-footer a {
            color: #111;
            font-weight: 500;
            text-decoration: none;
            border-bottom: 1.5px solid #ccc;
            padding-bottom: 1px;
            transition: border-color 0.2s;
        }

        .form-footer a:hover {
            border-color: #111;
        }

        .form-footer .forgot-link {
            display: inline-block;
            margin-top: 0.5rem;
            font-weight: 400;
            color: #777;
            border-bottom-color: #ddd;
        }

        .form-footer .forgot-link:hover {
            color: #111;
            border-bottom-color: #111;
        }

        .form-footer .signup-link {
            margin-top: 1rem;
            color: #666;
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 820px) {
            .auth-grid {
                grid-template-columns: 1fr;
                min-height: auto;
                box-shadow: none;
            }

            .brand-side {
                padding: 2.5rem 1.5rem;
                min-height: 35vh;
            }

            .brand-side h1 {
                font-size: 2.2rem;
            }

            .form-side {
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .brand-side h1 {
                font-size: 1.8rem;
            }

            .brand-side .feature-list li {
                font-size: 0.85rem;
            }

            .form-wrapper .form-header h2 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>

<div class="auth-grid">

    <!-- LEFT: Brand / Description (black theme) -->
    <div class="brand-side">
        <div class="brand-icon"><i class="fas fa-briefcase"></i></div>
        <h1>job<span>board</span></h1>
        <div class="divider-light"></div>
        <p class="tagline">
            Welcome back. Access your dashboard, track applications, and connect with top employers.
        </p>
        <ul class="feature-list">
            <li><i class="fas fa-check-circle"></i> 1000+ active job listings</li>
            <li><i class="fas fa-check-circle"></i> Smart application tracking</li>
            <li><i class="fas fa-check-circle"></i> Direct employer messaging</li>
            <li><i class="fas fa-check-circle"></i> Personalized recommendations</li>
        </ul>
        <div style="margin-top: 1.8rem; font-size: 0.8rem; color: #555; letter-spacing: 0.02em;">
            <i class="fas fa-shield-alt" style="margin-right: 0.4rem;"></i> Secure & encrypted
        </div>
    </div>

    <!-- RIGHT: Login Form -->
    <div class="form-side">
        <div class="form-wrapper">

            <div class="form-header">
                <h2>Welcome back</h2>
                <p>Log in to your account</p>
            </div>

            <!-- error & success messages -->
            <div class="message-box error" id="errorMessage"></div>
            <div class="message-box success" id="successMessage"></div>

            <form id="loginForm" novalidate>
                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email address</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="jane@example.com" required />
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required />
                    </div>
                </div>

                <!-- loading indicator -->
                <div class="loading-box" id="loadingBox">
                    <span class="spinner"></span> Logging in...
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-login" id="submitBtn">
                    <i class="fas fa-arrow-right" style="margin-right: 0.5rem;"></i> Log in
                </button>
            </form>

            <!-- footer links -->
            <div class="form-footer">
                <a href="/forgot-password" class="forgot-link">Forgot password?</a>
                <div class="signup-link">
                    Don't have an account? <a href="/auth/signup">Sign up</a>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    (function() {
        const API_URL = 'http://localhost:8000/api'; // adjust to your backend

        const form = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const loadingBox = document.getElementById('loadingBox');
        const errorBox = document.getElementById('errorMessage');
        const successBox = document.getElementById('successMessage');

        // check if already logged in
        if (localStorage.getItem('token')) {
            window.location.href = '/dashboard';
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            // simple client-side validation
            if (!email || !password) {
                errorBox.textContent = 'Please enter your email and password.';
                errorBox.style.display = 'block';
                successBox.style.display = 'none';
                return;
            }

            // disable UI
            submitBtn.disabled = true;
            loadingBox.style.display = 'block';
            errorBox.style.display = 'none';
            successBox.style.display = 'none';

            try {
                const response = await fetch(`${API_URL}/auth/login`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });

                const data = await response.json();

                if (data.success) {
                    // store token & user
                    localStorage.setItem('token', data.data.token);
                    localStorage.setItem('user', JSON.stringify(data.data.user));

                    successBox.textContent = data.message || 'Login successful!';
                    successBox.style.display = 'block';

                    // redirect after short delay
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 800);
                } else {
                    errorBox.textContent = data.message || 'Invalid credentials. Please try again.';
                    errorBox.style.display = 'block';
                }
            } catch (err) {
                errorBox.textContent = 'Network error. Please check your connection.';
                errorBox.style.display = 'block';
            } finally {
                submitBtn.disabled = false;
                loadingBox.style.display = 'none';
            }
        });

        // clear messages on input
        document.querySelectorAll('#loginForm input').forEach(input => {
            input.addEventListener('input', () => {
                errorBox.style.display = 'none';
                successBox.style.display = 'none';
            });
        });

    })();
</script>
</body>
</html>