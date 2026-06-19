<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Recruitment Portal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
        }

        .auth-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* Left Container - Description */
        .description-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .description-section h1 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            font-weight: 300;
        }

        .description-section p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .benefits-list {
            list-style: none;
            margin-top: 2rem;
            text-align: left;
        }

        .benefits-list li {
            margin: 1rem 0;
            padding-left: 2rem;
            position: relative;
        }

        .benefits-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            font-weight: bold;
            font-size: 1.5rem;
        }

        /* Right Container - Form */
        .form-section {
            background: white;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-wrapper {
            max-width: 400px;
            margin: 0 auto;
            width: 100%;
        }

        .form-wrapper h2 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .form-wrapper p {
            color: #666;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .links {
            text-align: center;
            margin-top: 1.5rem;
        }

        .links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 0.5rem;
            transition: color 0.3s;
        }

        .links a:hover {
            color: #764ba2;
        }

        .signup-link {
            margin-top: 1rem;
            color: #666;
        }

        .error-message {
            background: #fee;
            color: #c33;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            display: none;
        }

        .success-message {
            background: #efe;
            color: #3c3;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            display: none;
        }

        .loading {
            display: none;
            text-align: center;
            color: #667eea;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-container {
                grid-template-columns: 1fr;
            }

            .description-section {
                padding: 2rem 1rem;
                min-height: 30vh;
            }

            .description-section h1 {
                font-size: 1.8rem;
            }

            .form-section {
                padding: 2rem 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Left: Description Section -->
        <div class="description-section">
            <div>
                <h1>Welcome Back</h1>
                <p>Log in to your Recruitment Portal account to access job opportunities, manage applications, and advance your career.</p>
                <ul class="benefits-list">
                    <li>Browse thousands of job listings</li>
                    <li>Manage your applications</li>
                    <li>Connect with employers</li>
                    <li>Track your career progress</li>
                </ul>
            </div>
        </div>

        <!-- Right: Form Section -->
        <div class="form-section">
            <div class="form-wrapper">
                <h2>Login</h2>
                <p>Enter your credentials to access your account</p>

                <div class="error-message" id="errorMessage"></div>
                <div class="success-message" id="successMessage"></div>

                <form id="loginForm">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="your@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <div class="loading" id="loading">
                        <div class="spinner"></div>
                        <p>Logging in...</p>
                    </div>

                    <button type="submit" class="btn-login" id="submitBtn">Login</button>
                </form>

                <div class="links">
                    <a href="/forgot-password">Forgot Password?</a>
                </div>

                <div class="signup-link">
                    Don't have an account? <a href="/auth/signup">Sign up here</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';

        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const submitBtn = document.getElementById('submitBtn');
            const loading = document.getElementById('loading');
            const errorMessage = document.getElementById('errorMessage');
            const successMessage = document.getElementById('successMessage');

            submitBtn.disabled = true;
            loading.style.display = 'block';
            errorMessage.style.display = 'none';
            successMessage.style.display = 'none';

            try {
                const response = await fetch(`${API_URL}/auth/login`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Store token and user data
                    localStorage.setItem('token', data.data.token);
                    localStorage.setItem('user', JSON.stringify(data.data.user));

                    successMessage.textContent = data.message;
                    successMessage.style.display = 'block';

                    // Redirect to dashboard after 1 second
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 1000);
                } else {
                    errorMessage.textContent = data.message || 'Login failed';
                    errorMessage.style.display = 'block';
                }
            } catch (error) {
                errorMessage.textContent = 'Network error. Please try again.';
                errorMessage.style.display = 'block';
            } finally {
                submitBtn.disabled = false;
                loading.style.display = 'none';
            }
        });

        // Check if already logged in
        window.addEventListener('load', () => {
            const token = localStorage.getItem('token');
            if (token) {
                window.location.href = '/dashboard';
            }
        });
    </script>
</body>
</html>
