<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Recruitment Portal</title>
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

        .form-section {
            background: white;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
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
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
            font-size: 0.95rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.95rem;
            transition: border-color 0.3s;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.1);
        }

        .role-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .role-option {
            display: flex;
            align-items: center;
        }

        .role-option input[type="radio"] {
            width: auto;
            margin-right: 0.5rem;
        }

        .btn-signup {
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

        .btn-signup:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-signup:disabled {
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
        }

        .links a:hover {
            color: #764ba2;
        }

        .login-link {
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
            font-size: 0.9rem;
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
            width: 25px;
            height: 25px;
            animation: spin 1s linear infinite;
            margin: 0 auto 0.5rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .auth-container {
                grid-template-columns: 1fr;
            }

            .description-section {
                padding: 2rem 1rem;
                min-height: 25vh;
            }

            .description-section h1 {
                font-size: 1.8rem;
            }

            .form-section {
                padding: 2rem 1rem;
            }

            .role-group {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Left: Description Section -->
        <div class="description-section">
            <div>
                <h1>Join Us Today</h1>
                <p>Create your account and start exploring amazing job opportunities or connect with top talent.</p>
            </div>
        </div>

        <!-- Right: Form Section -->
        <div class="form-section">
            <div class="form-wrapper">
                <h2>Sign Up</h2>
                <p>Create your account in minutes</p>

                <div class="error-message" id="errorMessage"></div>

                <form id="signupForm">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" placeholder="John Doe" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="your@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Min. 6 characters" minlength="6" required>
                    </div>

                    <div class="form-group">
                        <label>I am a:</label>
                        <div class="role-group">
                            <div class="role-option">
                                <input type="radio" id="candidate" name="role" value="candidate" checked>
                                <label for="candidate" style="margin: 0;">Job Seeker</label>
                            </div>
                            <div class="role-option">
                                <input type="radio" id="employer" name="role" value="employer">
                                <label for="employer" style="margin: 0;">Employer</label>
                            </div>
                        </div>
                    </div>

                    <div class="loading" id="loading">
                        <div class="spinner"></div>
                        <p style="font-size: 0.9rem;">Creating account...</p>
                    </div>

                    <button type="submit" class="btn-signup" id="submitBtn">Sign Up</button>
                </form>

                <div class="login-link">
                    Already have an account? <a href="/auth/login">Login here</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';

        document.getElementById('signupForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const role = document.querySelector('input[name="role"]:checked').value;
            const submitBtn = document.getElementById('submitBtn');
            const loading = document.getElementById('loading');
            const errorMessage = document.getElementById('errorMessage');

            submitBtn.disabled = true;
            loading.style.display = 'block';
            errorMessage.style.display = 'none';

            try {
                const response = await fetch(`${API_URL}/auth/register`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        name: name,
                        email: email,
                        password: password,
                        role: role
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Store token and user data
                    localStorage.setItem('token', data.data.token);
                    localStorage.setItem('user', JSON.stringify(data.data.user));

                    // Redirect to dashboard
                    window.location.href = '/dashboard';
                } else {
                    errorMessage.textContent = data.message || 'Sign up failed';
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
