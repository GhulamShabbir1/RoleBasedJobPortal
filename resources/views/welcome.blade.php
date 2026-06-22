<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Job Board · Find Your Dream Job</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: #fafafa;
            color: #111;
            line-height: 1.6;
        }

        /* ---------- NAVBAR (monochrome) ---------- */
        .navbar {
            background: #111;
            color: #eee;
            padding: 1rem 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid #2a2a2a;
        }

        .navbar-brand {
            font-size: 1.6rem;
            font-weight: 600;
            letter-spacing: -0.02em;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand span {
            font-weight: 300;
            color: #aaa;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .navbar-links a {
            color: #ccc;
            text-decoration: none;
            font-weight: 450;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .navbar-links a:hover {
            color: #fff;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-outline-light {
            background: transparent;
            border: 1px solid #444;
            color: #eee;
            padding: 0.5rem 1.4rem;
            border-radius: 40px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-outline-light:hover {
            background: #2a2a2a;
            border-color: #666;
            color: #fff;
        }

        .btn-solid-light {
            background: #fff;
            border: none;
            color: #111;
            padding: 0.5rem 1.4rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-solid-light:hover {
            background: #e0e0e0;
            transform: scale(1.02);
        }

        /* ---------- HERO SECTION ---------- */
        .hero {
            background: #111;
            color: #eee;
            padding: 5rem 2rem 6rem;
            text-align: center;
            min-height: 70vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            right: -5%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.01);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero h1 {
            font-size: 3.8rem;
            font-weight: 600;
            letter-spacing: -0.03em;
            color: #fff;
            margin-bottom: 1rem;
            max-width: 800px;
            line-height: 1.2;
        }

        .hero h1 span {
            color: #aaa;
            font-weight: 300;
        }

        .hero p {
            font-size: 1.25rem;
            color: #bbb;
            max-width: 560px;
            margin: 0 auto 2.5rem;
            line-height: 1.7;
        }

        .hero-buttons {
            display: flex;
            gap: 1.2rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            background: #fff;
            color: #111;
            padding: 0.9rem 2.4rem;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.25s;
            border: none;
            cursor: pointer;
        }

        .btn-hero-primary:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }

        .btn-hero-secondary {
            background: transparent;
            color: #ddd;
            border: 1.5px solid #444;
            padding: 0.9rem 2.4rem;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.25s;
            cursor: pointer;
        }

        .btn-hero-secondary:hover {
            background: #2a2a2a;
            border-color: #777;
            color: #fff;
        }

        .hero-stats {
            display: flex;
            gap: 3rem;
            margin-top: 3rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .hero-stats .stat-item {
            text-align: center;
        }

        .hero-stats .stat-number {
            font-size: 2rem;
            font-weight: 600;
            color: #fff;
        }

        .hero-stats .stat-label {
            font-size: 0.85rem;
            color: #888;
            letter-spacing: 0.02em;
        }

        /* ---------- SECTION COMMON ---------- */
        .section {
            padding: 5rem 2rem;
        }

        .section-alt {
            background: #f7f7f7;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3.5rem;
        }

        .section-header h2 {
            font-size: 2.4rem;
            font-weight: 600;
            color: #111;
            letter-spacing: -0.02em;
        }

        .section-header p {
            color: #666;
            max-width: 500px;
            margin: 0.5rem auto 0;
            font-size: 1rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ---------- JOB CATEGORIES ---------- */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 1.5rem;
        }

        .category-item {
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 16px;
            padding: 1.5rem 1rem;
            text-align: center;
            transition: all 0.2s;
            text-decoration: none;
            color: #111;
        }

        .category-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.04);
            border-color: #ccc;
        }

        .category-item .cat-icon {
            font-size: 2rem;
            color: #222;
            margin-bottom: 0.4rem;
        }

        .category-item .cat-name {
            font-weight: 500;
            font-size: 0.95rem;
        }

        .category-item .cat-count {
            font-size: 0.8rem;
            color: #888;
        }

        /* ---------- FEATURED JOBS ---------- */
        .jobs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .job-card {
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 20px;
            padding: 1.8rem;
            transition: all 0.25s;
        }

        .job-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.04);
        }

        .job-card .job-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #111;
        }

        .job-card .job-company {
            color: #555;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .job-card .job-meta {
            display: flex;
            gap: 1rem;
            margin: 0.8rem 0 1rem;
            font-size: 0.85rem;
            color: #777;
            flex-wrap: wrap;
        }

        .job-card .job-meta i {
            margin-right: 0.3rem;
        }

        .job-card .job-tag {
            display: inline-block;
            background: #f0f0f0;
            padding: 0.2rem 0.8rem;
            border-radius: 40px;
            font-size: 0.75rem;
            font-weight: 500;
            color: #333;
        }

        .job-card .job-apply {
            margin-top: 1.2rem;
            display: inline-block;
            font-weight: 500;
            color: #111;
            text-decoration: none;
            border-bottom: 1.5px solid #ccc;
            padding-bottom: 2px;
            transition: border-color 0.2s;
        }

        .job-card .job-apply:hover {
            border-color: #111;
        }

        /* ---------- TESTIMONIALS ---------- */
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 2rem;
        }

        .testimonial-card {
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 20px;
            padding: 2rem 1.8rem;
            text-align: center;
        }

        .testimonial-card .quote {
            font-size: 0.95rem;
            color: #333;
            font-style: italic;
            line-height: 1.7;
        }

        .testimonial-card .author {
            margin-top: 1.2rem;
            font-weight: 600;
            color: #111;
        }

        .testimonial-card .role {
            font-size: 0.85rem;
            color: #888;
        }

        .testimonial-card .stars {
            color: #111;
            margin-bottom: 0.8rem;
            letter-spacing: 0.1rem;
        }

        /* ---------- BLOG / INSIGHTS ---------- */
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 2rem;
        }

        .blog-card {
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.25s;
        }

        .blog-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.04);
        }

        .blog-card .blog-img {
            height: 160px;
            background: #e8e8e8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #888;
        }

        .blog-card .blog-body {
            padding: 1.5rem 1.8rem;
        }

        .blog-card .blog-body .blog-tag {
            display: inline-block;
            background: #111;
            color: #fff;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 0.2rem 0.8rem;
            border-radius: 40px;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .blog-card .blog-body h4 {
            font-size: 1.1rem;
            margin: 0.6rem 0 0.3rem;
            color: #111;
        }

        .blog-card .blog-body p {
            font-size: 0.9rem;
            color: #666;
        }

        .blog-card .blog-body .blog-link {
            display: inline-block;
            margin-top: 0.8rem;
            font-weight: 500;
            color: #111;
            text-decoration: none;
            border-bottom: 1.5px solid #ccc;
            padding-bottom: 2px;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }

        .blog-card .blog-body .blog-link:hover {
            border-color: #111;
        }

        /* ---------- NEWSLETTER ---------- */
        .newsletter-box {
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 24px;
            padding: 3rem 2.5rem;
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
        }

        .newsletter-box h3 {
            font-size: 1.6rem;
            font-weight: 600;
            color: #111;
        }

        .newsletter-box p {
            color: #666;
            margin: 0.5rem 0 1.5rem;
        }

        .newsletter-box .news-form {
            display: flex;
            gap: 0.8rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .newsletter-box .news-form input {
            flex: 1;
            min-width: 220px;
            padding: 0.8rem 1.2rem;
            border: 1px solid #ddd;
            border-radius: 40px;
            font-size: 0.95rem;
            background: #fcfcfc;
            transition: border-color 0.2s;
        }

        .newsletter-box .news-form input:focus {
            outline: none;
            border-color: #111;
        }

        .newsletter-box .news-form button {
            background: #111;
            color: #fff;
            border: none;
            padding: 0.8rem 2.2rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .newsletter-box .news-form button:hover {
            background: #2a2a2a;
        }

        /* ---------- FAQ ---------- */
        .faq-list {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .faq-item {
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 16px;
            padding: 1.2rem 1.8rem;
            transition: border-color 0.2s;
        }

        .faq-item:hover {
            border-color: #ccc;
        }

        .faq-item .faq-q {
            font-weight: 600;
            color: #111;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }

        .faq-item .faq-q i {
            color: #888;
            transition: transform 0.2s;
        }

        .faq-item .faq-a {
            margin-top: 0.6rem;
            color: #555;
            font-size: 0.95rem;
            display: none;
        }

        .faq-item.active .faq-a {
            display: block;
        }

        .faq-item.active .faq-q i {
            transform: rotate(180deg);
        }

        /* ---------- FOOTER ---------- */
        footer {
            background: #111;
            color: #888;
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            padding: 0.5rem 1.5rem;
            border-top: 1px solid #2a2a2a;
        }

        footer p {
            font-size: 0.9rem;
            margin: 0.3rem 0;
        }

        footer .footer-brand {
            color: #fff;
            font-weight: 500;
            font-size: 1rem;
        }

        footer .footer-brand span {
            color: #888;
            font-weight: 300;
        }

        footer .social-links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 1rem;
        }

        footer .social-links a {
            color: #666;
            font-size: 1.1rem;
            transition: color 0.2s;
            text-decoration: none;
        }

        footer .social-links a:hover {
            color: #fff;
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 820px) {
            .navbar {
                flex-wrap: wrap;
                gap: 0.8rem;
                padding: 0.8rem 1.5rem;
            }
            .navbar-links {
                flex-wrap: wrap;
                gap: 1rem;
                justify-content: center;
                width: 100%;
            }
            .hero h1 {
                font-size: 2.6rem;
            }
            .hero p {
                font-size: 1rem;
            }
            .hero-stats {
                gap: 1.8rem;
            }
            .categories-grid {
                grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 2rem;
            }
            .hero {
                padding: 3rem 1.2rem 4rem;
                min-height: 60vh;
            }
            .hero-buttons {
                flex-direction: column;
                width: 100%;
                max-width: 300px;
                margin: 0 auto;
            }
            .hero-buttons .btn-hero-primary,
            .hero-buttons .btn-hero-secondary {
                width: 100%;
                text-align: center;
            }
            .section {
                padding: 3rem 1.2rem;
            }
            .section-header h2 {
                font-size: 1.8rem;
            }
            .newsletter-box {
                padding: 2rem 1.2rem;
            }
            .newsletter-box .news-form {
                flex-direction: column;
            }
            .newsletter-box .news-form input {
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="/" class="navbar-brand">
            <i class="fas fa-briefcase" style="color:#fff; font-size:1.4rem;"></i>
            job<span>board</span>
        </a>
        <div class="navbar-links">
            <a href="#categories">Jobs</a>
            <a href="#featured">Featured</a>
            <a href="#testimonials">Testimonials</a>
            <a href="#blog">Insights</a>
            <a href="#faq">FAQ</a>
            <div class="nav-actions">
                <a href="/auth/login" class="btn-outline-light">Log in</a>
                <a href="/auth/signup" class="btn-solid-light">Sign up</a>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <h1>Find your <span>dream</span> job</h1>
        <p>Connect with top employers, track applications, and build the career you've always wanted.</p>
        <div class="hero-buttons">
            <a href="/auth/signup" class="btn-hero-primary"><i class="fas fa-arrow-right" style="margin-right:0.6rem;"></i> Get started</a>
            <a href="#categories" class="btn-hero-secondary">Explore jobs</a>
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <div class="stat-number">10k+</div>
                <div class="stat-label">Active jobs</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">500+</div>
                <div class="stat-label">Companies</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">95%</div>
                <div class="stat-label">Satisfaction</div>
            </div>
        </div>
    </section>

    <!-- JOB CATEGORIES -->
    <section class="section" id="categories">
        <div class="container">
            <div class="section-header">
                <h2>Browse by category</h2>
                <p>Find opportunities that match your expertise</p>
            </div>
            <div class="categories-grid">
                <a href="#" class="category-item">
                    <div class="cat-icon"><i class="fas fa-code"></i></div>
                    <div class="cat-name">Engineering</div>
                    <div class="cat-count">1.2k jobs</div>
                </a>
                <a href="#" class="category-item">
                    <div class="cat-icon"><i class="fas fa-paint-brush"></i></div>
                    <div class="cat-name">Design</div>
                    <div class="cat-count">860 jobs</div>
                </a>
                <a href="#" class="category-item">
                    <div class="cat-icon"><i class="fas fa-chart-line"></i></div>
                    <div class="cat-name">Marketing</div>
                    <div class="cat-count">940 jobs</div>
                </a>
                <a href="#" class="category-item">
                    <div class="cat-icon"><i class="fas fa-dollar-sign"></i></div>
                    <div class="cat-name">Finance</div>
                    <div class="cat-count">680 jobs</div>
                </a>
                <a href="#" class="category-item">
                    <div class="cat-icon"><i class="fas fa-headset"></i></div>
                    <div class="cat-name">Support</div>
                    <div class="cat-count">520 jobs</div>
                </a>
                <a href="#" class="category-item">
                    <div class="cat-icon"><i class="fas fa-database"></i></div>
                    <div class="cat-name">Data</div>
                    <div class="cat-count">720 jobs</div>
                </a>
            </div>
        </div>
    </section>

    <!-- FEATURED JOBS -->
    <section class="section section-alt" id="featured">
        <div class="container">
            <div class="section-header">
                <h2>Featured jobs</h2>
                <p>Hand-picked opportunities from top companies</p>
            </div>
            <div class="jobs-grid">
                <div class="job-card">
                    <div class="job-title">Senior Frontend Developer</div>
                    <div class="job-company">GitHub · Remote</div>
                    <div class="job-meta">
                        <span><i class="fas fa-clock"></i> Full-time</span>
                        <span><i class="fas fa-map-marker-alt"></i> Remote</span>
                    </div>
                    <span class="job-tag">React</span>
                    <span class="job-tag">TypeScript</span>
                    <div><a href="#" class="job-apply">Apply now →</a></div>
                </div>
                <div class="job-card">
                    <div class="job-title">Product Designer</div>
                    <div class="job-company">Figma · San Francisco</div>
                    <div class="job-meta">
                        <span><i class="fas fa-clock"></i> Full-time</span>
                        <span><i class="fas fa-map-marker-alt"></i> Hybrid</span>
                    </div>
                    <span class="job-tag">UI/UX</span>
                    <span class="job-tag">Figma</span>
                    <div><a href="#" class="job-apply">Apply now →</a></div>
                </div>
                <div class="job-card">
                    <div class="job-title">Backend Engineer</div>
                    <div class="job-company">Stripe · New York</div>
                    <div class="job-meta">
                        <span><i class="fas fa-clock"></i> Full-time</span>
                        <span><i class="fas fa-map-marker-alt"></i> On-site</span>
                    </div>
                    <span class="job-tag">Python</span>
                    <span class="job-tag">Django</span>
                    <div><a href="#" class="job-apply">Apply now →</a></div>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="section" id="testimonials">
        <div class="container">
            <div class="section-header">
                <h2>What our users say</h2>
                <p>Real stories from real people</p>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <div class="quote">“This platform completely changed my job search. I found my dream role in just two weeks.”</div>
                    <div class="author">Sarah K.</div>
                    <div class="role">Frontend Developer</div>
                </div>
                <div class="testimonial-card">
                    <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <div class="quote">“As an employer, we've hired three amazing candidates through Job Board. It's our go-to platform.”</div>
                    <div class="author">Michael R.</div>
                    <div class="role">CTO, StartupX</div>
                </div>
                <div class="testimonial-card">
                    <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <div class="quote">“The smart matching feature is incredible. I got interviews with companies I actually wanted to work for.”</div>
                    <div class="author">Emily T.</div>
                    <div class="role">Data Analyst</div>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOG / INSIGHTS -->
    <section class="section section-alt" id="blog">
        <div class="container">
            <div class="section-header">
                <h2>Career insights</h2>
                <p>Tips and advice to grow your career</p>
            </div>
            <div class="blog-grid">
                <div class="blog-card">
                    <div class="blog-img"><i class="fas fa-file-alt"></i></div>
                    <div class="blog-body">
                        <span class="blog-tag">Career</span>
                        <h4>How to write a resume that stands out</h4>
                        <p>Learn the key elements that recruiters look for in a resume.</p>
                        <a href="#" class="blog-link">Read more →</a>
                    </div>
                </div>
                <div class="blog-card">
                    <div class="blog-img"><i class="fas fa-lightbulb"></i></div>
                    <div class="blog-body">
                        <span class="blog-tag">Interview</span>
                        <h4>10 common interview questions and how to answer them</h4>
                        <p>Prepare for your next interview with these expert tips.</p>
                        <a href="#" class="blog-link">Read more →</a>
                    </div>
                </div>
                <div class="blog-card">
                    <div class="blog-img"><i class="fas fa-rocket"></i></div>
                    <div class="blog-body">
                        <span class="blog-tag">Growth</span>
                        <h4>Building your personal brand online</h4>
                        <p>How to use social media to attract job opportunities.</p>
                        <a href="#" class="blog-link">Read more →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NEWSLETTER -->
    <section class="section" id="newsletter">
        <div class="container">
            <div class="newsletter-box">
                <h3>Stay in the loop</h3>
                <p>Get the latest job postings, career tips, and exclusive opportunities delivered to your inbox.</p>
                <form class="news-form" onsubmit="event.preventDefault(); alert('Thanks for subscribing!');">
                    <input type="email" placeholder="Enter your email" required />
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="section section-alt" id="faq">
        <div class="container">
            <div class="section-header">
                <h2>Frequently asked questions</h2>
                <p>Quick answers to common questions</p>
            </div>
            <div class="faq-list">
                <div class="faq-item active">
                    <div class="faq-q">
                        How do I create an account?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-a">Click on "Sign up" in the navigation bar, fill in your details, and verify your email. It takes less than 2 minutes.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-q">
                        Is Job Board free for job seekers?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-a">Yes, creating a profile and applying for jobs is completely free for job seekers.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-q">
                        How do employers post jobs?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-a">Employers can sign up for a company account and post jobs directly from their dashboard.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-q">
                        Can I save jobs and apply later?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-a">Yes, you can save any job to your favorites and apply when you're ready.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <p class="footer-brand">job<span>board</span></p>
        <p style="color:#666; font-size:0.85rem;">© 2026 · All rights reserved</p>
        <div class="social-links">
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
            <a href="#"><i class="fab fa-github"></i></a>
        </div>
    </footer>

    <script>
        (function() {
            // Redirect if already logged in
            if (localStorage.getItem('token')) {
                window.location.href = '/dashboard';
            }

            // FAQ toggle
            document.querySelectorAll('.faq-item .faq-q').forEach((q) => {
                q.addEventListener('click', function() {
                    const item = this.closest('.faq-item');
                    item.classList.toggle('active');
                });
            });

            // Smooth scroll for "Explore jobs" button
            document.querySelector('.btn-hero-secondary')?.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('categories').scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        })();
    </script>
</body>
</html>