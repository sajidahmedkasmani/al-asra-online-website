@extends('storefront.layout')

@push('head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.14.8/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#FFF4EA',
                        ink: '#2A1420',
                        plum: '#4A1530',
                        rose: {
                            DEFAULT: '#F24C00',
                            50: '#FFF4EA',
                            100: '#FFE1D0',
                            200: '#FFC2A1',
                            300: '#FFA572',
                            400: '#FF8743',
                            500: '#F24C00',
                            600: '#D94100',
                            700: '#B83700',
                            800: '#8F2B00',
                            900: '#651E00',
                        },
                        blush: '#FFD9C2',
                        royal: '#5F1E29',
                        muted: '#6B5960',
                    },
                    fontFamily: {
                        serif: ['"DM Serif Display"', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        [x-cloak]{display:none!important}
        body{font-family:Inter,sans-serif;background:#FFF4EA;color:#2A1420}
        .marquee{display:flex;width:max-content;animation:marquee 40s linear infinite}
        .marquee-slow{animation-duration:60s}
        @keyframes marquee{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
        summary::-webkit-details-marker{display:none}
        .no-scrollbar::-webkit-scrollbar{display:none}
        .no-scrollbar{-ms-overflow-style:none;scrollbar-width:none}
        .arch{border-radius:9999px 9999px 0 0}
        @media(prefers-reduced-motion:reduce){.marquee{animation:none}*{transition-duration:.01ms!important}}
    </style>
@endpush
