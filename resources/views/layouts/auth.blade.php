<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'jobboard')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
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
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                    spacing: {
                        sidebar_width: "280px",
                        gutter: "24px",
                        margin_desktop: "40px",
                        margin_mobile: "16px",
                        container_max_width: "1440px",
                        topbar_height: "72px"
                    },
                    fontFamily: {
                        "headline-md": ["Inter"],
                        "label-sm": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "headline-lg": ["Inter"],
                        "body-md": ["Inter"],
                        "display": ["Inter"]
                    },
                    fontSize: {
                        "headline-md": ["20px", { lineHeight: "28px", fontWeight: "600" }],
                        "label-sm": ["12px", { lineHeight: "16px", letterSpacing: "0.05em", fontWeight: "600" }],
                        "body-lg": ["16px", { lineHeight: "26px", fontWeight: "400" }],
                        "headline-lg-mobile": ["24px", { lineHeight: "32px", fontWeight: "600" }],
                        "headline-lg": ["32px", { lineHeight: "40px", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "body-md": ["14px", { lineHeight: "22px", fontWeight: "400" }],
                        "display": ["48px", { lineHeight: "56px", letterSpacing: "-0.02em", fontWeight: "700" }]
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #FAFAFA;
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .custom-shadow {
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            transition: box-shadow 0.3s ease;
        }
        .custom-shadow:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.04);
        }
        .form-input-transition {
            transition: border-color 0.2s ease, border-width 0.1s ease;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    @yield('content')
    @stack('scripts')
</body>
</html>
