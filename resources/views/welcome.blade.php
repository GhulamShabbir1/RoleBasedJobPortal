<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>jobboard | Find your dream job</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary-fixed": "#1b1c1c",
                        "on-error": "#ffffff",
                        "on-secondary-fixed-variant": "#464747",
                        "secondary": "#5e5e5e",
                        "surface-container-highest": "#e2e2e2",
                        "tertiary-container": "#1a1c1c",
                        "surface-bright": "#f9f9f9",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-fixed-dim": "#c6c6c6",
                        "tertiary-fixed": "#e2e2e2",
                        "on-primary-fixed-variant": "#474646",
                        "tertiary": "#000000",
                        "surface-container-low": "#f3f3f3",
                        "surface-container": "#eeeeee",
                        "on-surface": "#1a1c1c",
                        "surface-dim": "#dadada",
                        "surface-variant": "#e2e2e2",
                        "secondary-fixed": "#e4e2e2",
                        "outline": "#747878",
                        "inverse-surface": "#2f3131",
                        "primary-fixed-dim": "#c8c6c5",
                        "on-tertiary-fixed-variant": "#454747",
                        "error": "#ba1a1a",
                        "surface-container-high": "#e8e8e8",
                        "on-secondary": "#ffffff",
                        "on-primary": "#ffffff",
                        "secondary-container": "#e4e2e2",
                        "inverse-on-surface": "#f0f1f1",
                        "background": "#f9f9f9",
                        "surface-tint": "#5f5e5e",
                        "outline-variant": "#c4c7c7",
                        "on-tertiary-container": "#838484",
                        "on-error-container": "#93000a",
                        "on-primary-fixed": "#1c1b1b",
                        "on-primary-container": "#858383",
                        "on-tertiary-fixed": "#1a1c1c",
                        "on-tertiary": "#ffffff",
                        "secondary-fixed-dim": "#c8c6c6",
                        "surface": "#f9f9f9",
                        "inverse-primary": "#c8c6c5",
                        "on-surface-variant": "#444748",
                        "on-secondary-container": "#646464",
                        "error-container": "#ffdad6",
                        "primary": "#000000",
                        "primary-fixed": "#e5e2e1",
                        "on-background": "#1a1c1c"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "sidebar_width": "280px",
                        "gutter": "24px",
                        "margin_desktop": "40px",
                        "margin_mobile": "16px",
                        "container_max_width": "1440px",
                        "topbar_height": "72px"
                    },
                    "fontFamily": {
                        "headline-md": ["Inter"],
                        "label-sm": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "headline-lg": ["Inter"],
                        "body-md": ["Inter"],
                        "display": ["Inter"]
                    },
                    "fontSize": {
                        "headline-md": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                        "body-lg": ["16px", {"lineHeight": "26px", "fontWeight": "400"}],
                        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "body-md": ["14px", {"lineHeight": "22px", "fontWeight": "400"}],
                        "display": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}]
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .luxury-shadow { box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
        .luxury-shadow-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .luxury-shadow-hover:hover { box-shadow: 0 12px 28px rgba(0,0,0,0.06); transform: translateY(-4px); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Accessibility improvements */
        .skip-link {
            position: absolute;
            top: -100%;
            left: 16px;
            background: #000;
            color: #fff;
            padding: 8px 16px;
            z-index: 100;
            border-radius: 4px;
            font-weight: 600;
        }
        .skip-link:focus {
            top: 16px;
        }
        
        /* Focus styles */
        *:focus-visible {
            outline: 2px solid #000;
            outline-offset: 2px;
            border-radius: 4px;
        }
        
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        /* Better contrast for hero text */
        .hero-overlay {
            background: linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0.7));
        }
    </style>
</head>
<body class="bg-background text-on-background selection:bg-primary selection:text-white">

<!-- Skip to content for accessibility -->
<a href="#main-content" class="skip-link">Skip to main content</a>

<!-- Navigation Bar -->
<header class="bg-surface-bright sticky top-0 z-50 h-topbar_height border-b border-surface-container-highest shadow-sm flex justify-between items-center w-full px-margin_mobile md:px-margin_desktop" role="banner">
    <div class="flex items-center gap-8">
        <a href="/" class="font-headline-lg text-headline-lg text-primary" style="text-decoration:none;" aria-label="jobboard home">jobboard</a>
        <nav class="hidden md:flex gap-6 items-center" role="navigation" aria-label="Main navigation">
            <a class="text-primary font-bold border-b-2 border-primary py-2 font-label-sm text-label-sm" href="/" aria-current="page">Home</a>
            <a class="text-on-secondary-fixed-variant hover:bg-surface-container-low transition-all px-3 py-2 rounded-lg font-label-sm text-label-sm focus-visible:bg-surface-container-low" href="/jobs">Jobs</a>
            <a class="text-on-secondary-fixed-variant hover:bg-surface-container-low transition-all px-3 py-2 rounded-lg font-label-sm text-label-sm focus-visible:bg-surface-container-low" href="/companies">Companies</a>
            <a class="text-on-secondary-fixed-variant hover:bg-surface-container-low transition-all px-3 py-2 rounded-lg font-label-sm text-label-sm focus-visible:bg-surface-container-low" href="#resources">Resources</a>
        </nav>
    </div>
    <div class="flex items-center gap-4" id="navActions">
        <!-- Search trigger for mobile -->
        <button class="md:hidden material-symbols-outlined text-primary p-2 hover:bg-surface-container-low rounded-full" aria-label="Search jobs">search</button>
        
        <!-- Default State: Logged out -->
        <div class="hidden md:flex items-center gap-4">
            <a href="/auth/login" class="text-primary font-bold px-4 py-2 hover:bg-surface-container-low rounded-full transition-colors text-sm focus-visible:bg-surface-container-low">Log in</a>
            <a href="/auth/signup" class="bg-primary text-white font-bold px-6 py-2 rounded-full hover:scale-105 transition-transform text-sm focus-visible:scale-105">Sign up</a>
        </div>
        
        <!-- Mobile menu button -->
        <button class="md:hidden material-symbols-outlined text-primary p-2 hover:bg-surface-container-low rounded-full" aria-label="Menu" aria-expanded="false" id="mobileMenuBtn">menu</button>
    </div>
</header>

<!-- Mobile Menu (Hidden by default) -->
<div class="hidden fixed inset-0 z-40 bg-background/95 backdrop-blur-sm md:hidden" id="mobileMenu">
    <div class="flex flex-col pt-24 px-margin_mobile gap-6">
        <a class="text-primary font-bold text-lg py-2" href="/">Home</a>
        <a class="text-on-secondary-fixed-variant text-lg py-2" href="/jobs">Jobs</a>
        <a class="text-on-secondary-fixed-variant text-lg py-2" href="/companies">Companies</a>
        <a class="text-on-secondary-fixed-variant text-lg py-2" href="#resources">Resources</a>
        <hr class="border-surface-container-highest"/>
        <a href="/auth/login" class="text-primary font-bold py-3 text-center border border-outline rounded-full">Log in</a>
        <a href="/auth/signup" class="bg-primary text-white font-bold py-3 text-center rounded-full">Sign up</a>
    </div>
</div>

<main id="main-content" class="w-full max-w-container_max_width mx-auto">
    <!-- Hero Section -->
    <section class="relative text-on-primary-container pt-24 pb-32 px-margin_mobile md:px-margin_desktop overflow-hidden" style="background-image: url('https://lh3.googleusercontent.com/aida/AP1WRLtkWIn8hBiDR_YbS8LreE6cndqRPe7yxtX-EnvOZLgupqrZiQ-KwTjfOQrr6ygWMBz656OQYsIHHvnV3z16fFG4tIYhm_hl6jhGifWP6C_jQvy7Bq3QcbkvVmG8CTkLSLYdGQiEqbNoJ_Zlr3kr5m8ZHphUVuB2GQA66pTHH_WAlRsv9l8HsNfisIgV3kSnhx-B5gTVRUCvv3NQharG_cV6ihcJhQ6ItK6sns4p0iKBz7ZoTASYqLGmOA'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 hero-overlay"></div>
        <div class="relative z-10 max-w-3xl mx-auto text-center">
            <span class="inline-block py-1 px-3 mb-6 border border-white/30 rounded-full font-label-sm text-label-sm text-surface-container-lowest tracking-widest uppercase bg-white/10 backdrop-blur-sm">The Future of Talent</span>
            <h1 class="font-display text-display text-surface-container-lowest mb-6 leading-tight">Find your dream job</h1>
            <p class="font-body-lg text-body-lg text-surface-container-lowest/90 mb-10 max-w-xl mx-auto">
                Navigate the next chapter of your career with the world's most elite recruitment portal. Precision data meets editorial luxury.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/auth/signup" class="bg-surface-container-lowest text-primary font-bold px-10 py-4 rounded-full hover:scale-105 transition-transform inline-block text-center shadow-lg hover:shadow-xl focus-visible:scale-105">Get Started</a>
                <a href="/jobs" class="border-2 border-white/40 text-surface-container-lowest font-bold px-10 py-4 rounded-full hover:bg-white/10 transition-colors inline-block text-center backdrop-blur-sm focus-visible:bg-white/10">Explore Jobs</a>
            </div>
            <div class="mt-20 grid grid-cols-3 gap-4 md:gap-8 border-t border-white/20 pt-12">
                <div class="text-center">
                    <div class="font-headline-lg text-headline-lg md:text-3xl text-surface-container-lowest">10k+</div>
                    <div class="font-label-sm text-label-sm text-surface-container-lowest/80 uppercase mt-1">Active Jobs</div>
                </div>
                <div class="text-center">
                    <div class="font-headline-lg text-headline-lg md:text-3xl text-surface-container-lowest">450</div>
                    <div class="font-label-sm text-label-sm text-surface-container-lowest/80 uppercase mt-1">Top Brands</div>
                </div>
                <div class="text-center">
                    <div class="font-headline-lg text-headline-lg md:text-3xl text-surface-container-lowest">24h</div>
                    <div class="font-label-sm text-label-sm text-surface-container-lowest/80 uppercase mt-1">Avg Response</div>
                </div>
            </div>
        </div>
    </section>

    <!-- NEW: Trusted By Section -->
    <section class="py-16 px-margin_mobile md:px-margin_desktop bg-surface-container-lowest border-b border-surface-container-highest">
        <p class="text-center font-label-sm text-label-sm text-secondary uppercase tracking-widest mb-8">Trusted by innovative companies worldwide</p>
        <div class="flex flex-wrap justify-center items-center gap-8 md:gap-12 opacity-50 grayscale hover:grayscale-0 transition-all">
            <div class="font-headline-md text-headline-md text-secondary/50">Stripe</div>
            <div class="font-headline-md text-headline-md text-secondary/50">Airbnb</div>
            <div class="font-headline-md text-headline-md text-secondary/50">Spotify</div>
            <div class="font-headline-md text-headline-md text-secondary/50">Shopify</div>
            <div class="font-headline-md text-headline-md text-secondary/50">Notion</div>
            <div class="font-headline-md text-headline-md text-secondary/50">Figma</div>
        </div>
    </section>

    <!-- Category Grid (Bento Style) -->
    <section class="py-24 px-margin_mobile md:px-margin_desktop" id="categories">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="font-headline-lg text-headline-lg text-primary mb-2">Browse by Category</h2>
                <p class="font-body-md text-body-md text-secondary">Discover opportunities across the most high-impact industries.</p>
            </div>
            <a href="/jobs" class="text-primary font-bold hidden sm:flex items-center gap-2 group decoration-transparent">
                View All Categories <span class="material-symbols-outlined transition-transform group-hover:translate-x-1" aria-hidden="true">arrow_forward</span>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <!-- Large Feature -->
            <a href="/jobs?category=engineering" class="sm:col-span-2 sm:row-span-2 bg-white rounded-[24px] p-6 md:p-8 border border-surface-container-highest luxury-shadow-hover flex flex-col justify-between group cursor-pointer relative overflow-hidden decoration-transparent text-current" aria-label="Engineering category - 2,450 openings">
                <div class="relative z-10">
                    <span class="material-symbols-outlined text-4xl mb-6 text-primary" aria-hidden="true">engineering</span>
                    <h3 class="font-headline-md text-headline-md mb-2">Engineering</h3>
                    <p class="font-body-md text-body-md text-secondary">Software, Hardware, AI, and DevOps roles at scale.</p>
                </div>
                <div class="font-label-sm text-label-sm text-primary mt-8 z-10">2,450 Openings</div>
                <div class="absolute -right-12 -bottom-12 opacity-[0.03] scale-150 group-hover:rotate-12 transition-transform duration-700" aria-hidden="true">
                    <span class="material-symbols-outlined text-[200px]">engineering</span>
                </div>
            </a>
            <!-- Small Grid Items -->
            <a href="/jobs?category=design" class="bg-white rounded-[24px] p-6 md:p-8 border border-surface-container-highest luxury-shadow-hover flex flex-col justify-between cursor-pointer decoration-transparent text-current" aria-label="Design category - 840 openings">
                <span class="material-symbols-outlined text-3xl mb-4 text-primary" aria-hidden="true">palette</span>
                <div>
                    <h3 class="font-headline-md text-headline-md text-sm mb-1">Design</h3>
                    <div class="font-label-sm text-label-sm text-secondary">840 Openings</div>
                </div>
            </a>
            <a href="/jobs?category=marketing" class="bg-white rounded-[24px] p-6 md:p-8 border border-surface-container-highest luxury-shadow-hover flex flex-col justify-between cursor-pointer decoration-transparent text-current" aria-label="Marketing category - 1,120 openings">
                <span class="material-symbols-outlined text-3xl mb-4 text-primary" aria-hidden="true">campaign</span>
                <div>
                    <h3 class="font-headline-md text-headline-md text-sm mb-1">Marketing</h3>
                    <div class="font-label-sm text-label-sm text-secondary">1,120 Openings</div>
                </div>
            </a>
            <a href="/jobs?category=finance" class="bg-white rounded-[24px] p-6 md:p-8 border border-surface-container-highest luxury-shadow-hover flex flex-col justify-between cursor-pointer decoration-transparent text-current" aria-label="Finance category - 560 openings">
                <span class="material-symbols-outlined text-3xl mb-4 text-primary" aria-hidden="true">account_balance</span>
                <div>
                    <h3 class="font-headline-md text-headline-md text-sm mb-1">Finance</h3>
                    <div class="font-label-sm text-label-sm text-secondary">560 Openings</div>
                </div>
            </a>
            <a href="/jobs?category=operations" class="bg-white rounded-[24px] p-6 md:p-8 border border-surface-container-highest luxury-shadow-hover flex flex-col justify-between cursor-pointer decoration-transparent text-current" aria-label="Operations category - 420 openings">
                <span class="material-symbols-outlined text-3xl mb-4 text-primary" aria-hidden="true">description</span>
                <div>
                    <h3 class="font-headline-md text-headline-md text-sm mb-1">Operations</h3>
                    <div class="font-label-sm text-label-sm text-secondary">420 Openings</div>
                </div>
            </a>
        </div>
        <!-- Mobile view all link -->
        <div class="mt-8 text-center sm:hidden">
            <a href="/jobs" class="text-primary font-bold flex items-center justify-center gap-2 group decoration-transparent">
                View All Categories <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">arrow_forward</span>
            </a>
        </div>
    </section>

    <!-- NEW: How It Works Section -->
    <section class="py-24 px-margin_mobile md:px-margin_desktop bg-surface-container-low">
        <div class="text-center mb-16">
            <h2 class="font-headline-lg text-headline-lg text-primary mb-4">How It Works</h2>
            <p class="font-body-md text-body-md text-secondary max-w-lg mx-auto">Three simple steps to land your dream role.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            <div class="text-center group">
                <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl text-white">person_add</span>
                </div>
                <h3 class="font-headline-md text-headline-md mb-3">Create Profile</h3>
                <p class="font-body-md text-body-md text-secondary">Build your professional profile with your skills, experience, and preferences in under 5 minutes.</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl text-white">search</span>
                </div>
                <h3 class="font-headline-md text-headline-md mb-3">Smart Matching</h3>
                <p class="font-body-md text-body-md text-secondary">Our AI matches you with roles that fit your skills, salary expectations, and culture preferences.</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl text-white">rocket_launch</span>
                </div>
                <h3 class="font-headline-md text-headline-md mb-3">Get Hired</h3>
                <p class="font-body-md text-body-md text-secondary">Apply with one click and get responses from top companies within 24 hours on average.</p>
            </div>
        </div>
    </section>

    <!-- Featured Jobs -->
    <section class="py-24 bg-surface-container-lowest px-margin_mobile md:px-margin_desktop" id="featured-jobs">
        <div class="text-center mb-16">
            <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Featured Opportunities</h2>
            <p class="font-body-md text-body-md text-secondary max-w-lg mx-auto">Hand-picked roles from global industry leaders that define the next generation of business.</p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 max-w-5xl mx-auto">
            <!-- Job Card 1 -->
            <article class="bg-white rounded-[24px] p-6 border border-surface-container-highest luxury-shadow-hover flex flex-col sm:flex-row gap-6 items-start">
                <div class="w-16 h-16 rounded-xl bg-surface-container-low flex items-center justify-center shrink-0">
                    <img class="w-10 h-10 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD10MoQ9iczi1sILcqUzQYDBncbE3XazDiyjaNZ1TO9k2z7ck2Yd0sE5LIC7BjJCT6ud6toVkc8nbwu_DUu1QkI6Q-qnePhl3g4u3my6WOhWMWkEBVEHDbAKG6DdKbXrzTWI3wmV1_-gOz1pKOo4jkmoTuXKmLaIKS535Rd3CkwAcm-9tWpCScNwyt_RkYZvWc8EClWqZCJRCjRj3qsrNVUcaQuInpMfKRv-FPqY87DvZSnCpIQXdBeF1okhP9gHaqp2FCSDl7UFo4" alt="Starlight Systems logo" onerror="this.style.display='none'"/>
                </div>
                <div class="flex-grow min-w-0">
                    <div class="flex justify-between items-start flex-wrap gap-2">
                        <div>
                            <h3 class="font-headline-md text-headline-md text-lg mb-1">Senior Product Designer</h3>
                            <p class="font-body-md text-body-md text-secondary">Starlight Systems • Remote</p>
                        </div>
                        <span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full font-label-sm text-label-sm shrink-0">Featured</span>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-2">
                        <span class="border border-surface-container-highest px-3 py-1 rounded-full font-label-sm text-label-sm text-secondary">UX/UI</span>
                        <span class="border border-surface-container-highest px-3 py-1 rounded-full font-label-sm text-label-sm text-secondary">Design System</span>
                        <span class="border border-surface-container-highest px-3 py-1 rounded-full font-label-sm text-label-sm text-secondary">Figma</span>
                    </div>
                    <div class="mt-6 flex justify-between items-center flex-wrap gap-4">
                        <span class="font-headline-md text-headline-md text-sm">$140k - $190k</span>
                        <a href="/jobs/1" class="bg-primary text-white font-bold px-6 py-2 rounded-full text-sm inline-block hover:scale-105 transition-transform focus-visible:scale-105" aria-label="Apply for Senior Product Designer position">Apply Now</a>
                    </div>
                </div>
            </article>
            <!-- Job Card 2 -->
            <article class="bg-white rounded-[24px] p-6 border border-surface-container-highest luxury-shadow-hover flex flex-col sm:flex-row gap-6 items-start">
                <div class="w-16 h-16 rounded-xl bg-surface-container-low flex items-center justify-center shrink-0">
                    <img class="w-10 h-10 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC5IxtmXc4hjoQh_IGnkXzc01hjCiK67P_olDENHd08XB8QLp2qla-Tl9t1fx3YhiMc8LXZr1-2FhVjWtwwXZXghZeOWrqO_z-5G0BM0vn0wFAVulg9gzuUVL_ho0pkAuiCrtLHYSWP_Q335B6_5KZjjgoZpQTzDtl5TCvxBGLrlfF8KR2A6PfaOzs66pZYARHxkp-4E_5MgQkRynxwaGqxifCzxaLmQtr5r6AX3Ouvd9OA-_Qp5pZotp27MnKTmWZrSoykVqDK58I" alt="Apex Global logo" onerror="this.style.display='none'"/>
                </div>
                <div class="flex-grow min-w-0">
                    <div class="flex justify-between items-start flex-wrap gap-2">
                        <div>
                            <h3 class="font-headline-md text-headline-md text-lg mb-1">Full Stack Engineer</h3>
                            <p class="font-body-md text-body-md text-secondary">Apex Global • New York, NY</p>
                        </div>
                        <span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full font-label-sm text-label-sm shrink-0">Premium</span>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-2">
                        <span class="border border-surface-container-highest px-3 py-1 rounded-full font-label-sm text-label-sm text-secondary">React</span>
                        <span class="border border-surface-container-highest px-3 py-1 rounded-full font-label-sm text-label-sm text-secondary">Node.js</span>
                        <span class="border border-surface-container-highest px-3 py-1 rounded-full font-label-sm text-label-sm text-secondary">AWS</span>
                    </div>
                    <div class="mt-6 flex justify-between items-center flex-wrap gap-4">
                        <span class="font-headline-md text-headline-md text-sm">$160k - $220k</span>
                        <a href="/jobs/2" class="bg-primary text-white font-bold px-6 py-2 rounded-full text-sm inline-block hover:scale-105 transition-transform focus-visible:scale-105" aria-label="Apply for Full Stack Engineer position">Apply Now</a>
                    </div>
                </div>
            </article>
            <!-- Job Card 3 -->
            <article class="bg-white rounded-[24px] p-6 border border-surface-container-highest luxury-shadow-hover flex flex-col sm:flex-row gap-6 items-start">
                <div class="w-16 h-16 rounded-xl bg-surface-container-low flex items-center justify-center shrink-0">
                    <img class="w-10 h-10 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB3GJ1Gu-lYl0Bb4FRoAaKQaTYtPv48yBDha5C8ArC9oyYtJFDaqV8zpcHGAXGO1T7P1clxAfFD66NyVnI-ETmmrKE8kNzuYcqOrSlDeV4rY07WPRHAb5ZZarSShmw_J3-Ou6gIkLAd7tw97WgoSkgTmj2xPTfhV_n2JkSR1rNlK_kbrzPH2aDuem8mB4B8_GSmJWg22O7OXgGoZdIRAAacBfgSiDQAaRphc2ESekkldbxwp0OhtGp68Jwnco7SuBUtzq-BY79Ce9Y" alt="Neural Labs logo" onerror="this.style.display='none'"/>
                </div>
                <div class="flex-grow min-w-0">
                    <div class="flex justify-between items-start flex-wrap gap-2">
                        <div>
                            <h3 class="font-headline-md text-headline-md text-lg mb-1">AI Research Lead</h3>
                            <p class="font-body-md text-body-md text-secondary">Neural Labs • San Francisco, CA</p>
                        </div>
                        <span class="bg-error-container text-on-error-container px-3 py-1 rounded-full font-label-sm text-label-sm shrink-0">Urgent</span>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-2">
                        <span class="border border-surface-container-highest px-3 py-1 rounded-full font-label-sm text-label-sm text-secondary">PyTorch</span>
                        <span class="border border-surface-container-highest px-3 py-1 rounded-full font-label-sm text-label-sm text-secondary">NLP</span>
                        <span class="border border-surface-container-highest px-3 py-1 rounded-full font-label-sm text-label-sm text-secondary">LLMs</span>
                    </div>
                    <div class="mt-6 flex justify-between items-center flex-wrap gap-4">
                        <span class="font-headline-md text-headline-md text-sm">$200k - $280k</span>
                        <a href="/jobs/3" class="bg-primary text-white font-bold px-6 py-2 rounded-full text-sm inline-block hover:scale-105 transition-transform focus-visible:scale-105" aria-label="Apply for AI Research Lead position">Apply Now</a>
                    </div>
                </div>
            </article>
            <!-- Job Card 4 -->
            <article class="bg-white rounded-[24px] p-6 border border-surface-container-highest luxury-shadow-hover flex flex-col sm:flex-row gap-6 items-start">
                <div class="w-16 h-16 rounded-xl bg-surface-container-low flex items-center justify-center shrink-0">
                    <img class="w-10 h-10 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCz06unz5B0ZD0-YdjZDApcI_wa0JGOC_Rkj7Mko0RFhn_tRuRwN6utH2MaW0sO5iwbmd6MpnMloX3ErGEbZZm4y63r3mdriesr4uD7MEPsd1pTs9jX4aL_snUbSgM6zHYybPxsM_WO_KQW6e4V8ARGcarptf5Vp7StDkhgbiyEhyOUbd6Y85d0SKClAIzpcPJvXwqJ8ep7cT3PMjkQcVUGccCp3_hMoYLssvhKppNnTS19P0graIbXCsMm3NySRVd8EFIed0yAmhY" alt="Velvet & Co logo" onerror="this.style.display='none'"/>
                </div>
                <div class="flex-grow min-w-0">
                    <div class="flex justify-between items-start flex-wrap gap-2">
                        <div>
                            <h3 class="font-headline-md text-headline-md text-lg mb-1">Growth Marketing Manager</h3>
                            <p class="font-body-md text-body-md text-secondary">Velvet & Co • London, UK</p>
                        </div>
                        <span class="bg-tertiary-fixed text-tertiary-container px-3 py-1 rounded-full font-label-sm text-label-sm shrink-0">New</span>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-2">
                        <span class="border border-surface-container-highest px-3 py-1 rounded-full font-label-sm text-label-sm text-secondary">SEO/SEM</span>
                        <span class="border border-surface-container-highest px-3 py-1 rounded-full font-label-sm text-label-sm text-secondary">Strategy</span>
                        <span class="border border-surface-container-highest px-3 py-1 rounded-full font-label-sm text-label-sm text-secondary">Analytics</span>
                    </div>
                    <div class="mt-6 flex justify-between items-center flex-wrap gap-4">
                        <span class="font-headline-md text-headline-md text-sm">$110k - $150k</span>
                        <a href="/jobs/4" class="bg-primary text-white font-bold px-6 py-2 rounded-full text-sm inline-block hover:scale-105 transition-transform focus-visible:scale-105" aria-label="Apply for Growth Marketing Manager position">Apply Now</a>
                    </div>
                </div>
            </article>
        </div>
        <div class="mt-16 text-center">
            <a href="/jobs" class="inline-block border-2 border-outline text-primary font-bold px-12 py-4 rounded-full hover:bg-primary hover:text-white hover:border-primary transition-all focus-visible:bg-primary focus-visible:text-white">
                Browse All 10,000+ Jobs
            </a>
        </div>
    </section>

    <!-- NEW: Testimonials Section -->
    <section class="py-24 px-margin_mobile md:px-margin_desktop bg-surface-container-low">
        <div class="text-center mb-16">
            <h2 class="font-headline-lg text-headline-lg text-primary mb-4">What Our Users Say</h2>
            <p class="font-body-md text-body-md text-secondary max-w-lg mx-auto">Join thousands of professionals who found their perfect role through jobboard.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
            <div class="bg-white rounded-[24px] p-8 border border-surface-container-highest luxury-shadow-hover">
                <div class="flex gap-1 mb-4 text-yellow-500">
                    <span class="material-symbols-outlined filled">star</span>
                    <span class="material-symbols-outlined filled">star</span>
                    <span class="material-symbols-outlined filled">star</span>
                    <span class="material-symbols-outlined filled">star</span>
                    <span class="material-symbols-outlined filled">star</span>
                </div>
                <p class="font-body-md text-body-md text-secondary mb-6 italic">"jobboard transformed my job search. The quality of listings and the smart matching algorithm saved me countless hours. Landed my dream role in just two weeks!"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center font-bold text-sm">SJ</div>
                    <div>
                        <div class="font-headline-md text-headline-md text-sm">Sarah Johnson</div>
                        <div class="font-label-sm text-label-sm text-secondary">Product Designer at Stripe</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-[24px] p-8 border border-surface-container-highest luxury-shadow-hover">
                <div class="flex gap-1 mb-4 text-yellow-500">
                    <span class="material-symbols-outlined filled">star</span>
                    <span class="material-symbols-outlined filled">star</span>
                    <span class="material-symbols-outlined filled">star</span>
                    <span class="material-symbols-outlined filled">star</span>
                    <span class="material-symbols-outlined filled">star</span>
                </div>
                <p class="font-body-md text-body-md text-secondary mb-6 italic">"As a hiring manager, the quality of candidates from jobboard is unmatched. The platform attracts truly exceptional talent."</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center font-bold text-sm">MK</div>
                    <div>
                        <div class="font-headline-md text-headline-md text-sm">Michael Kim</div>
                        <div class="font-label-sm text-label-sm text-secondary">Engineering Manager at Airbnb</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-[24px] p-8 border border-surface-container-highest luxury-shadow-hover">
                <div class="flex gap-1 mb-4 text-yellow-500">
                    <span class="material-symbols-outlined filled">star</span>
                    <span class="material-symbols-outlined filled">star</span>
                    <span class="material-symbols-outlined filled">star</span>
                    <span class="material-symbols-outlined filled">star</span>
                    <span class="material-symbols-outlined filled">star</span>
                </div>
                <p class="font-body-md text-body-md text-secondary mb-6 italic">"The transparency on salary ranges and company culture is a game-changer. I've already recommended jobboard to my entire network."</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center font-bold text-sm">AD</div>
                    <div>
                        <div class="font-headline-md text-headline-md text-sm">Alexandra Diaz</div>
                        <div class="font-label-sm text-label-sm text-secondary">Data Scientist at Spotify</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NEW: Resources Section -->
    <section class="py-24 px-margin_mobile md:px-margin_desktop" id="resources">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="font-headline-lg text-headline-lg text-primary mb-2">Career Resources</h2>
                <p class="font-body-md text-body-md text-secondary">Expert advice to accelerate your professional growth.</p>
            </div>
            <a href="#" class="text-primary font-bold hidden sm:flex items-center gap-2 group decoration-transparent">
                View All Articles <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">arrow_forward</span>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="#" class="bg-white rounded-[24px] overflow-hidden border border-surface-container-highest luxury-shadow-hover group cursor-pointer decoration-transparent text-current">
                <div class="h-48 bg-surface-container-low flex items-center justify-center">
                    <span class="material-symbols-outlined text-6xl text-secondary/30">article</span>
                </div>
                <div class="p-6">
                    <span class="font-label-sm text-label-sm text-secondary uppercase">Career Advice</span>
                    <h3 class="font-headline-md text-headline-md mt-2 mb-2 group-hover:text-primary transition-colors">How to Negotiate Your Salary Like a Pro</h3>
                    <p class="font-body-md text-body-md text-secondary line-clamp-2">Master the art of negotiation and secure the compensation you deserve with these proven strategies.</p>
                    <div class="font-label-sm text-label-sm text-secondary mt-4">8 min read</div>
                </div>
            </a>
            <a href="#" class="bg-white rounded-[24px] overflow-hidden border border-surface-container-highest luxury-shadow-hover group cursor-pointer decoration-transparent text-current">
                <div class="h-48 bg-surface-container-low flex items-center justify-center">
                    <span class="material-symbols-outlined text-6xl text-secondary/30">trending_up</span>
                </div>
                <div class="p-6">
                    <span class="font-label-sm text-label-sm text-secondary uppercase">Industry Trends</span>
                    <h3 class="font-headline-md text-headline-md mt-2 mb-2 group-hover:text-primary transition-colors">Top Tech Skills in Demand for 2026</h3>
                    <p class="font-body-md text-body-md text-secondary line-clamp-2">Stay ahead of the curve with the most sought-after technical skills this year.</p>
                    <div class="font-label-sm text-label-sm text-secondary mt-4">5 min read</div>
                </div>
            </a>
            <a href="#" class="bg-white rounded-[24px] overflow-hidden border border-surface-container-highest luxury-shadow-hover group cursor-pointer decoration-transparent text-current">
                <div class="h-48 bg-surface-container-low flex items-center justify-center">
                    <span class="material-symbols-outlined text-6xl text-secondary/30">work</span>
                </div>
                <div class="p-6">
                    <span class="font-label-sm text-label-sm text-secondary uppercase">Remote Work</span>
                    <h3 class="font-headline-md text-headline-md mt-2 mb-2 group-hover:text-primary transition-colors">Building a Standout Remote Work Portfolio</h3>
                    <p class="font-body-md text-body-md text-secondary line-clamp-2">Learn how to showcase your skills and land remote positions at top companies.</p>
                    <div class="font-label-sm text-label-sm text-secondary mt-4">6 min read</div>
                </div>
            </a>
        </div>
    </section>

    <!-- Newsletter / CTA -->
    <section class="py-24 px-margin_mobile md:px-margin_desktop">
        <div class="rounded-[32px] p-12 md:p-20 text-center relative overflow-hidden" style="background:#1a1c1c;">
            <div class="relative z-10 max-w-2xl mx-auto">
                <h2 class="font-headline-lg text-headline-lg text-surface-container-lowest mb-6">Stay ahead of the curve</h2>
                <p class="font-body-lg text-body-lg mb-10" style="color:#c6c6c6;">Get weekly insights and premium job alerts directly to your inbox. No noise, just the best roles.</p>
                <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto" onsubmit="event.preventDefault(); handleSubscribe(this);">
                    <label for="newsletter-email" class="sr-only">Enter your work email</label>
                    <input id="newsletter-email" class="flex-grow bg-white/10 border border-white/20 rounded-full px-6 py-4 text-white placeholder:text-white/40 focus:outline-none focus:border-white focus:bg-white/20 transition-colors" placeholder="Enter your work email" type="email" required aria-required="true"/>
                    <button type="submit" class="bg-surface-container-lowest text-primary font-bold px-8 py-4 rounded-full whitespace-nowrap hover:scale-105 transition-transform focus-visible:scale-105" style="background:#fff; color:#111;">Subscribe</button>
                </form>
                <p class="font-label-sm text-label-sm mt-4" style="color:#747878;">No spam, unsubscribe anytime.</p>
            </div>
            <!-- Decorative elements -->
            <div class="absolute top-0 right-0 opacity-5" aria-hidden="true">
                <span class="material-symbols-outlined text-[300px]">mail</span>
            </div>
        </div>
    </section>
</main>

<!-- Minimalist Footer -->
<footer class="bg-white border-t border-surface-container-highest py-16 px-margin_mobile md:px-margin_desktop" role="contentinfo">
    <div class="max-w-container_max_width mx-auto flex flex-col md:flex-row justify-between items-start gap-12">
        <div class="max-w-xs">
            <span class="font-headline-lg text-headline-lg text-primary mb-6 block">jobboard</span>
            <p class="font-body-md text-body-md text-secondary">The world's premier platform for professional growth and elite career transitions. Founded 2026.</p>
            <div class="flex gap-3 mt-6">
                <a class="w-10 h-10 rounded-full border border-surface-container-highest flex items-center justify-center text-secondary hover:text-primary hover:border-primary transition-all decoration-transparent focus-visible:border-primary" href="#" aria-label="Twitter">
                    <span class="material-symbols-outlined text-xl">share</span>
                </a>
                <a class="w-10 h-10 rounded-full border border-surface-container-highest flex items-center justify-center text-secondary hover:text-primary hover:border-primary transition-all decoration-transparent focus-visible:border-primary" href="#" aria-label="LinkedIn">
                    <span class="material-symbols-outlined text-xl">public</span>
                </a>
                <a class="w-10 h-10 rounded-full border border-surface-container-highest flex items-center justify-center text-secondary hover:text-primary hover:border-primary transition-all decoration-transparent focus-visible:border-primary" href="#" aria-label="GitHub">
                    <span class="material-symbols-outlined text-xl">code</span>
                </a>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-16">
            <div>
                <h5 class="font-label-sm text-label-sm text-primary uppercase tracking-widest mb-6">Platform</h5>
                <ul class="space-y-4 font-body-md text-body-md text-secondary">
                    <li><a class="hover:text-primary transition-colors decoration-transparent focus-visible:text-primary" href="/jobs">Browse Jobs</a></li>
                    <li><a class="hover:text-primary transition-colors decoration-transparent focus-visible:text-primary" href="/companies">Companies</a></li>
                    <li><a class="hover:text-primary transition-colors decoration-transparent focus-visible:text-primary" href="#resources">Career Blog</a></li>
                    <li><a class="hover:text-primary transition-colors decoration-transparent focus-visible:text-primary" href="#">Salary Guide</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-label-sm text-label-sm text-primary uppercase tracking-widest mb-6">Company</h5>
                <ul class="space-y-4 font-body-md text-body-md text-secondary">
                    <li><a class="hover:text-primary transition-colors decoration-transparent focus-visible:text-primary" href="#">About Us</a></li>
                    <li><a class="hover:text-primary transition-colors decoration-transparent focus-visible:text-primary" href="#">Contact</a></li>
                    <li><a class="hover:text-primary transition-colors decoration-transparent focus-visible:text-primary" href="#">Privacy</a></li>
                    <li><a class="hover:text-primary transition-colors decoration-transparent focus-visible:text-primary" href="#">Careers</a></li>
                </ul>
            </div>
            <div class="col-span-2 md:col-span-1">
                <h5 class="font-label-sm text-label-sm text-primary uppercase tracking-widest mb-6">Support</h5>
                <ul class="space-y-4 font-body-md text-body-md text-secondary">
                    <li><a class="hover:text-primary transition-colors decoration-transparent focus-visible:text-primary" href="#">Help Center</a></li>
                    <li><a class="hover:text-primary transition-colors decoration-transparent focus-visible:text-primary" href="#">FAQ</a></li>
                    <li><a class="hover:text-primary transition-colors decoration-transparent focus-visible:text-primary" href="#">Community</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="max-w-container_max_width mx-auto mt-16 pt-8 border-t border-surface-container-low flex flex-col md:flex-row justify-between items-center gap-4">
        <span class="font-label-sm text-label-sm text-secondary">© 2026 jobboard Inc. All rights reserved.</span>
        <div class="flex gap-6 font-label-sm text-label-sm text-secondary">
            <a class="hover:text-primary decoration-transparent focus-visible:text-primary" href="#">Terms</a>
            <a class="hover:text-primary decoration-transparent focus-visible:text-primary" href="#">Cookies</a>
            <a class="hover:text-primary decoration-transparent focus-visible:text-primary" href="#">Legal</a>
        </div>
    </div>
</footer>

<script>
    // Enhanced interactions and accessibility
    document.addEventListener('DOMContentLoaded', () => {
        // Smooth hover effects for cards
        const cards = document.querySelectorAll('.luxury-shadow-hover');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-4px)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        let menuOpen = false;

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                menuOpen = !menuOpen;
                mobileMenu.classList.toggle('hidden', !menuOpen);
                mobileMenuBtn.setAttribute('aria-expanded', menuOpen);
                mobileMenuBtn.textContent = menuOpen ? 'close' : 'menu';
                document.body.style.overflow = menuOpen ? 'hidden' : '';
            });

            // Close menu when clicking links
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    menuOpen = false;
                    mobileMenu.classList.add('hidden');
                    mobileMenuBtn.setAttribute('aria-expanded', 'false');
                    mobileMenuBtn.textContent = 'menu';
                    document.body.style.overflow = '';
                });
            });
        }

        // Auth Logic check to toggle Dashboard link in top right
        if (localStorage.getItem('token')) {
            const navActions = document.getElementById('navActions');
            if (navActions) {
                navActions.innerHTML = `
                    <button class="material-symbols-outlined text-primary p-2 hover:bg-surface-container-low rounded-full focus-visible:bg-surface-container-low" aria-label="Search">search</button>
                    <button class="material-symbols-outlined text-primary p-2 hover:bg-surface-container-low rounded-full focus-visible:bg-surface-container-low relative" aria-label="Notifications">
                        notifications
                        <span class="absolute top-1 right-1 w-2 h-2 bg-error rounded-full"></span>
                    </button>
                    <a href="/dashboard" class="h-8 w-8 rounded-full overflow-hidden border-2 border-outline-variant cursor-pointer block hover:border-primary transition-colors focus-visible:border-primary" aria-label="Dashboard">
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD1dqyZgXsYJXT5UBS0uvrx1ggMiyFasGdpCpXYTmm4MgbxNK7egWM5DoPShoB1kXGVQjtdGVDsssYOkGTg81k6Uw-XpAQeQqK7knfhi0H1s-fbsuyOxq3Qm78-FW73x6WSYOcIzz2t3o0w0G2hD37tltmb5spG1mnQpaHj_rIdLuhYZYO-bIh2jeukL8oiX8X1b2USipVsXiVyEksJhvXTDOMIfLOcQPPN5QUkGrnipThqJ_y-dsgCecpf2-ULEQaF-sqp41vX4sU" alt="User avatar" />
                    </a>
                `;
            }
        }

        // Add intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe sections for fade-in effect
        document.querySelectorAll('section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            section.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
            observer.observe(section);
        });
    });

    // Newsletter subscription handler
    function handleSubscribe(form) {
        const email = form.querySelector('input[type="email"]').value;
        if (email) {
            // In production, send to your API
            console.log('Subscribing:', email);
            alert('Thank you for subscribing! Check your email for confirmation.');
            form.reset();
        }
    }
</script>
</body>
</html>