<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up · Job Board</title>
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
            min-height: 60vh;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.03);
        }

        /* ---------- LEFT: BRAND / DESCRIPTION (black/white) ---------- */
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
            border-radius: 15px 0 0 15px;
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
            border-radius: 0 15px 15px 0;
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

        .brand-side .highlight-list {
            list-style: none;
            margin-top: 1.5rem;
            text-align: left;
            width: 100%;
            max-width: 320px;
        }

        .brand-side .highlight-list li {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.5rem 0;
            font-size: 0.95rem;
            color: #ddd;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .brand-side .highlight-list li:last-child {
            border-bottom: none;
        }

        .brand-side .highlight-list i {
            color: #aaa;
            width: 1.4rem;
            font-size: 1rem;
        }

        /* subtle separator */
        .brand-side .divider-light {
            width: 60px;
            height: 2px;
            background: #333;
            margin: 1.2rem auto;
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

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.6rem;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #fcfcfc;
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            color: #111;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #111;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.04);
            background: #fff;
        }

        .form-group input::placeholder {
            color: #aaa;
        }

        /* role radio group */
        .role-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
            margin-top: 0.2rem;
        }

        .role-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f9f9f9;
            padding: 0.6rem 1rem;
            border-radius: 30px;
            border: 1px solid #e8e8e8;
            transition: background 0.15s, border-color 0.15s;
            cursor: pointer;
        }

        .role-option:hover {
            background: #f0f0f0;
        }

        .role-option input[type="radio"] {
            width: auto;
            margin-right: 0.2rem;
            accent-color: #111;
        }

        .role-option label {
            margin: 0;
            font-weight: 400;
            font-size: 0.9rem;
            color: #333;
            cursor: pointer;
        }

        /* error & loading */
        .error-box {
            background: #f8f0f0;
            color: #b33;
            padding: 0.8rem 1rem;
            border-radius: 10px;
            margin-bottom: 1.2rem;
            font-size: 0.9rem;
            display: none;
            border-left: 3px solid #b33;
        }

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

        /* submit button */
        .btn-submit {
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

        .btn-submit:hover {
            background: #2a2a2a;
            transform: scale(1.01);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* footer links */
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

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 820px) {
            .auth-grid {
                grid-template-columns: 1fr;
                min-height: auto;
                box-shadow: none;
            }

            .brand-side {
                padding: 2.5rem 1.5rem;
                min-height: 40vh;
            }

            .brand-side h1 {
                font-size: 2.2rem;
            }

            .form-side {
                padding: 2rem 1.5rem;
            }

            .role-group {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 480px) {
            .brand-side h1 {
                font-size: 1.8rem;
            }

            .brand-side .highlight-list li {
                font-size: 0.85rem;
            }

            .role-group {
                grid-template-columns: 1fr;
            }

            .form-wrapper .form-header h2 {
                font-size: 1.6rem;
            }
        }

        /* small extras */
        .text-muted {
            color: #888;
        }
        .mt-1 {
            margin-top: 0.5rem;
        }
        .flex-center {
            display: flex;
            align-items: center;
            justify-content: center;
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
            Connect with the best opportunities. Join a community of professionals and companies.
        </p>
        <ul class="highlight-list">
            <li><i class="fas fa-check-circle"></i> 1000+ active jobs</li>
            <li><i class="fas fa-check-circle"></i> Top companies hiring</li>
            <li><i class="fas fa-check-circle"></i> Smart matching</li>
            <li><i class="fas fa-check-circle"></i> Free & secure</li>
        </ul>
        <div style="margin-top: 1.8rem; font-size: 0.8rem; color: #555; letter-spacing: 0.02em;">
            <i class="fas fa-lock" style="margin-right: 0.4rem;"></i> Your data is protected
        </div>
    </div>

    <!-- RIGHT: Sign-up Form -->
    <div class="form-side">
        <div class="form-wrapper">

            <div class="form-header">
                <h2>Create account</h2>
                <p>Start your journey in minutes</p>
            </div>

            <!-- error message -->
            <div class="error-box" id="errorMessage"></div>

            <form id="signupForm" novalidate>
                <!-- Full Name -->
                <div class="form-group">
                    <label for="name">Full name</label>
                    <div class="input-wrap">
                        <i class="fas fa-user"></i>
                        <input type="text" id="name" name="name" placeholder="e.g. Jane Smith" required />
                    </div>
                </div>

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
                        <input type="password" id="password" name="password" placeholder="Min. 6 characters" minlength="6" required />
                    </div>
                </div>

                <!-- Role (radio) -->
                <div class="form-group">
                    <label>I am a</label>
                    <div class="role-group">
                        <div class="role-option">
                            <input type="radio" id="candidate" name="role" value="candidate" checked />
                            <label for="candidate">Job seeker</label>
                        </div>
                        <div class="role-option">
                            <input type="radio" id="employer" name="role" value="employer" />
                            <label for="employer">Employer</label>
                        </div>
                    </div>
                </div>

                <!-- loading indicator -->
                <div class="loading-box" id="loadingBox">
                    <span class="spinner"></span> Creating account...
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-arrow-right" style="margin-right: 0.5rem;"></i> Sign up
                </button>
            </form>

            <!-- footer link -->
            <div class="form-footer">
                Already have an account? <a href="/auth/login">Log in</a>
            </div>

        </div>
    </div>
</div>

<script>
    (function() {
        const API_URL = 'http://localhost:8000/api'; // adjust to your backend

        const form = document.getElementById('signupForm');
        const submitBtn = document.getElementById('submitBtn');
        const loadingBox = document.getElementById('loadingBox');
        const errorBox = document.getElementById('errorMessage');

        // check if already logged in
        if (localStorage.getItem('token')) {
            window.location.href = '/dashboard';
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // gather data
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const role = document.querySelector('input[name="role"]:checked').value;

            // simple client-side validation (extra)
            if (!name || !email || password.length < 6) {
                errorBox.textContent = 'Please fill all fields correctly. Password must be at least 6 characters.';
                errorBox.style.display = 'block';
                return;
            }

            // disable UI
            submitBtn.disabled = true;
            loadingBox.style.display = 'block';
            errorBox.style.display = 'none';

            try {
                const response = await fetch(`${API_URL}/auth/register`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ name, email, password, role })
                });

                const data = await response.json();

                if (data.success) {
                    // store token & user
                    localStorage.setItem('token', data.data.token);
                    localStorage.setItem('user', JSON.stringify(data.data.user));
                    // redirect to dashboard
                    window.location.href = '/dashboard';
                } else {
                    errorBox.textContent = data.message || 'Registration failed. Please try again.';
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

        // optional: clear error on input
        document.querySelectorAll('#signupForm input').forEach(input => {
            input.addEventListener('input', () => {
                errorBox.style.display = 'none';
            });
        });

    })();
</script>
</body>
</html>