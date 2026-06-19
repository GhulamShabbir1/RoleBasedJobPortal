<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruitment Portal - Find Your Dream Job</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Navbar Styles */
        nav.navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        .navbar-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .navbar-links a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .navbar-links a:hover {
            opacity: 0.8;
        }

        .btn {
            padding: 0.7rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-login {
            background: white;
            color: #667eea;
            font-weight: bold;
        }

        .btn-login:hover {
            background: #f0f0f0;
        }

        .btn-signup {
            background: #ff6b6b;
            color: white;
            font-weight: bold;
        }

        .btn-signup:hover {
            background: #ee5a52;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5rem 2rem;
            text-align: center;
            min-height: 70vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            font-weight: 300;
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: white;
            color: #667eea;
            padding: 1rem 2rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: #f0f0f0;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 1rem 2rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: white;
            color: #667eea;
        }

        /* Features Section */
        .features {
            padding: 4rem 2rem;
            background: #f8f9fa;
        }

        .features-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .feature-card h3 {
            margin: 1rem 0;
            color: #667eea;
            font-size: 1.5rem;
        }

        .feature-card p {
            color: #666;
            line-height: 1.8;
        }

        .feature-icon {
            font-size: 2.5rem;
        }

        /* Footer */
        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 4rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .navbar-links {
                gap: 1rem;
            }

            .hero-buttons {
                flex-direction: column;
                width: 100%;
            }

            .btn-primary, .btn-secondary {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="navbar-brand">💼 RecruteMent Portal</a>
        <div class="navbar-links">
            <a href="#features">Features</a>
            <a href="#" class="btn btn-login">Login</a>
            <a href="#" class="btn btn-signup">Sign Up</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Find Your Dream Job</h1>
        <p>Connect with top employers and advance your career</p>
        <div class="hero-buttons">
            <a href="/auth/login" class="btn-primary">Login</a>
            <a href="/auth/signup" class="btn-secondary">Sign Up Now</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <h2 style="text-align: center; margin-bottom: 3rem; font-size: 2.5rem; color: #333;">Why Choose Us?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <h3>Find Perfect Jobs</h3>
                <p>Browse thousands of job listings from top companies and find opportunities that match your skills and interests.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🚀</div>
                <h3>Grow Your Career</h3>
                <p>Access resources to enhance your skills, network with professionals, and accelerate your career growth.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🏢</div>
                <h3>For Employers</h3>
                <p>Find qualified candidates, post jobs, and manage your recruitment process efficiently in one place.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Recruitment Portal. All rights reserved.</p>
        <p>Built with ❤️ for job seekers and employers</p>
    </footer>

    <script>
        // You can add authentication check and redirect to dashboard if already logged in
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');
            if (token) {
                // Redirect to dashboard if already logged in
                window.location.href = '/dashboard';
            }
        });
    </script>
</body>
</html>
