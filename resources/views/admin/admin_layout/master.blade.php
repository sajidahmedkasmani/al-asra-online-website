<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#0F2B2A">
        <title>@yield('title') — {{ config('app.name', 'Store') }} Admin</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            /*  THEME TOKENS: change the look of the whole admin from here.
                brand = primary (buttons, links, focus) · bloom = brass accent
                lav = page canvas · ink = dark chrome + text                    */
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            brand: { 50:'#EAF5F3', 100:'#D3EBE6', 200:'#A9D6CE', 300:'#7BBFB3', 400:'#3DA697', 500:'#228B7C', 600:'#12766B', 700:'#0D5E55' },
                            bloom: { 400:'#D9A93F', 500:'#B8821F' },
                            lav: '#EEF1EF',
                            ink: '#0F2B2A',
                            gray: { 50:'#F5F7F6', 100:'#EBEFED', 200:'#DCE3E0', 300:'#C3CDC9', 400:'#8E9C97', 500:'#66756F', 600:'#4B5A55', 700:'#36433F', 800:'#222D2A', 900:'#121B19' },
                        },
                        fontFamily: {
                            sans: ['"IBM Plex Sans"', 'system-ui', 'sans-serif'],
                            mono: ['"IBM Plex Mono"', 'ui-monospace', 'monospace'],
                        },
                        borderRadius: { md:'0.25rem', lg:'0.3125rem', xl:'0.375rem', '2xl':'0.5rem', '3xl':'0.5rem' },
                        boxShadow: {
                            sm:'0 1px 2px rgba(15,43,42,.06)',
                            md:'0 2px 6px -1px rgba(15,43,42,.10)',
                            lg:'0 8px 20px -6px rgba(15,43,42,.18)',
                            xl:'0 12px 28px -8px rgba(15,43,42,.22)',
                            '2xl':'0 18px 40px -10px rgba(15,43,42,.28)',
                        },
                    }
                }
            }
        </script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('counter', (to) => ({
                    v: 0,
                    init() {
                        const d = 900, s = performance.now();
                        const step = (t) => {
                            const p = Math.min((t - s) / d, 1);
                            this.v = Math.round(to * (1 - Math.pow(1 - p, 3)));
                            if (p < 1) requestAnimationFrame(step);
                        };
                        requestAnimationFrame(step);
                    }
                }));
            });
        </script>
        <script src="//unpkg.com/alpinejs" defer></script>

        <style>
            [x-cloak]{display:none!important}
            body{background:#EEF1EF;-webkit-tap-highlight-color:transparent;font-feature-settings:"tnum" 1}
            /* flat bordered panel (was a floating soft-shadow card) */
            .soft{border:1px solid #D9E0DD;box-shadow:0 1px 0 rgba(15,43,42,.03)}
            .lift{transition:border-color .15s ease}
            .lift:hover{border-color:#12766B}
            .btn-bloom{background:#12766B;color:#fff;transition:background-color .15s ease}
            .btn-bloom:hover{background:#0D5E55;opacity:1}
            /* page-load fades were removed on purpose; classes kept so existing markup still works */
            .rise{opacity:1;animation:none}
            @keyframes bar-rise{from{transform:scaleY(0)}to{transform:scaleY(1)}}
            /* renamed from .grow: Tailwind has its own .grow (flex-grow) which stretched every bar to full height */
            .bar-rise{transform-origin:bottom;animation:bar-rise .6s cubic-bezier(.2,.7,.2,1) both;animation-delay:var(--d,0s)}
            .scroll-thin::-webkit-scrollbar{width:6px;height:6px}
            .scroll-thin::-webkit-scrollbar-thumb{background:#C3CDC9;border-radius:9px}
            a:focus-visible,button:focus-visible,summary:focus-visible{outline:2px solid #3DA697;outline-offset:2px}
            @media (prefers-reduced-motion:reduce){.bar-rise{animation:none}}
        </style>
    </head>

    <body class="font-sans text-ink antialiased min-h-screen">
        @php
        $nav = [
            ['Dashboard', 'admin.dashboard',      'admin.dashboard',   'M3 12l9-9 9 9M5 10v10h5v-6h4v6h5V10'],
            ['Products',  'admin.products.index', 'admin.products.*',  'M20 7l-8-4-8 4m16 0v10l-8 4m8-14l-8 4m0 10L4 17V7m8 14V11'],
            ['Orders',    'admin.orders.index',   'admin.orders.*',    'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 5h6M9 12h6M9 16h4'],
            ['Sliders',   'admin.sliders.index',  'admin.sliders.*',   'M4 5a1 1 0 011-1h14a1 1 0 011 1v10a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm4 14h8m-4-4v4'],
            ['CMS Content','admin.cms.index',     'admin.cms.*',       'M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm3 4h10M7 14h7'],
            ['FAQs',      'admin.faqs.index',     'admin.faqs.*',      'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['Settings',  'admin.settings.edit',  'admin.settings.*',  'M12 15a3 3 0 100-6 3 3 0 000 6zM19.4 15a1.7 1.7 0 00.3 1.8l.1.1a2 2 0 11-2.8 2.8l-.1-.1a1.7 1.7 0 00-1.8-.3 1.7 1.7 0 00-1 1.5V21a2 2 0 11-4 0v-.1a1.7 1.7 0 00-1.1-1.5 1.7 1.7 0 00-1.8.3l-.1.1a2 2 0 11-2.8-2.8l.1-.1a1.7 1.7 0 00.3-1.8 1.7 1.7 0 00-1.5-1H3a2 2 0 110-4h.1a1.7 1.7 0 001.5-1.1 1.7 1.7 0 00-.3-1.8l-.1-.1a2 2 0 112.8-2.8l.1.1a1.7 1.7 0 001.8.3H9a1.7 1.7 0 001-1.5V3a2 2 0 114 0v.1a1.7 1.7 0 001 1.5 1.7 1.7 0 001.8-.3l.1-.1a2 2 0 112.8 2.8l-.1.1a1.7 1.7 0 00-.3 1.8V9a1.7 1.7 0 001.5 1H21a2 2 0 110 4h-.1a1.7 1.7 0 00-1.5 1z'],
            ['Users',     'admin.users.index',    'admin.users.*',     'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
            ['Newsletters', 'admin.newsletters.index', 'admin.newsletters.*', 'M3 8l9 6 9-6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z'],
        ];
        $navPermissions = [
            'admin.dashboard' => 'admin.dashboard',
            'admin.products.index' => 'products.view',
            'admin.orders.index' => 'orders.view',
            'admin.sliders.index' => 'sliders.view',
            'admin.cms.index' => 'cms.view',
            'admin.faqs.index' => 'faqs.view',
            'admin.settings.edit' => 'settings.view',
            'admin.users.index' => 'users.view',
            'admin.newsletters.index' => 'newsletter.manage',
        ];
        $user = auth()->user();
        $initial = strtoupper(substr($user->name ?? 'A', 0, 1));
            $appName = config('app.name', 'Store');
            $brandMark = strtoupper(mb_substr($appName, 0, 1));
        @endphp

        <div x-data="{ menu: false }"
            x-effect="document.body.classList.toggle('overflow-hidden', menu)"
            @keydown.escape.window="menu = false">

            {{-- ============ TOP BAR + TAB NAV ============ --}}
            <header class="print:hidden sticky top-0 z-40">

                <div class="bg-ink text-white border-b-2 border-bloom-400">
                    <div class="max-w-[1400px] mx-auto h-14 px-4 md:px-8 flex items-center gap-3">

                        <button type="button" @click="menu = true" aria-label="Open menu" aria-haspopup="dialog"
                                class="md:hidden -ml-1 w-10 h-10 rounded-xl hover:bg-white/10 flex flex-col items-center justify-center gap-[5px] shrink-0 transition">
                            <span class="block w-[18px] h-[2px] rounded-full bg-white"></span>
                            <span class="block w-[18px] h-[2px] rounded-full bg-white"></span>
                            <span class="block w-[18px] h-[2px] rounded-full bg-white"></span>
                        </button>

                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 min-w-0 mr-2">
                            <span class="w-8 h-8 rounded-xl bg-white text-ink font-bold text-sm flex items-center justify-center shrink-0">{{ $brandMark }}</span>
                            <span class="font-semibold truncate max-w-[160px] sm:max-w-[240px]">{{ $appName }}</span>
                            <span class="hidden sm:inline text-xs text-white/50 border-l border-white/20 pl-2.5">Admin</span>
                        </a>

                        <div class="flex-1"></div>

                        @can('orders.view')
                        <form method="GET" action="{{ route('admin.orders.index') }}" class="hidden lg:flex items-center gap-2 bg-white/10 rounded-xl px-3 py-1.5 text-sm w-72 focus-within:bg-white/15 focus-within:ring-1 ring-brand-300 transition">
                            <svg class="w-4 h-4 text-white/50 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5" stroke-linecap="round"/></svg>
                            <input name="q" type="search" placeholder="Search orders" class="bg-transparent outline-none w-full text-white placeholder:text-white/50">
                        </form>
                        @endcan

                        @can('products.create')
                        <a href="{{ route('admin.products.create') }}"
                           class="hidden sm:inline-flex items-center gap-1.5 bg-bloom-400 hover:bg-bloom-500 hover:text-white text-ink text-sm font-medium rounded-xl px-3.5 py-1.5 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                            Add product
                        </a>
                        @endcan

                        <a href="{{ route('home') }}" title="View site" aria-label="View site" class="hidden sm:flex w-9 h-9 rounded-xl hover:bg-white/10 items-center justify-center text-white/70 hover:text-white transition">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1h5"/></svg>
                        </a>

                        {{-- profile dropdown --}}
                        <div class="relative" x-data="{ o:false }" @click.outside="o=false" @keydown.escape.window="o=false">
                            <button @click="o=!o" class="flex items-center gap-2 rounded-xl pl-1 pr-2 py-1 hover:bg-white/10 transition" aria-haspopup="menu" :aria-expanded="o">
                                <span class="w-8 h-8 rounded-xl bg-brand-500 text-white text-xs font-semibold flex items-center justify-center">{{ $initial }}</span>
                                <span class="hidden sm:block text-sm text-white/90 max-w-[110px] truncate">{{ $user->name ?? 'Admin' }}</span>
                                <svg class="w-3 h-3 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6" stroke-linecap="round"/></svg>
                            </button>
                            <div x-cloak x-show="o" x-transition.origin.top.right class="absolute right-0 mt-2 w-56 bg-white text-ink rounded-2xl shadow-xl border border-gray-200 p-1.5 text-sm z-50">
                                <div class="px-3 py-2 border-b border-gray-100 mb-1">
                                    <p class="font-medium truncate">{{ $user->name ?? 'Admin' }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $user->email ?? '' }}</p>
                                    @if($user->role)
                                        <p class="text-xs text-brand-600 truncate">{{ $user->role }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-xl hover:bg-gray-50 text-gray-600">View site</a>
                                @can('settings.view')
                                <a href="{{ route('admin.settings.edit') }}" class="block px-3 py-2 rounded-xl hover:bg-gray-50 text-gray-600">Settings</a>
                                @endcan
                                @can('newsletter.manage')
                                <a href="{{ route('admin.newsletters.index') }}" class="block px-3 py-2 rounded-xl hover:bg-gray-50 text-gray-600">Newsletters</a>
                                @endcan
                                @can('users.edit')
                                <a href="{{ route('admin.permissions.index') }}" class="block px-3 py-2 rounded-xl hover:bg-gray-50 text-gray-600">Manage Permissions</a>
                                @endcan
                                <form method="POST" action="{{ route('logout') }}">@csrf
                                    <button class="w-full text-left px-3 py-2 rounded-xl hover:bg-rose-50 text-rose-600">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- tab navigation (tablet + desktop) --}}
                <nav class="hidden md:block bg-white border-b border-gray-200" aria-label="Admin sections">
                    <div class="max-w-[1400px] mx-auto px-4 md:px-8 flex gap-1 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                        @foreach($nav as [$label,$route,$pattern,$icon])
                            @can($navPermissions[$route])
                            @php $on = request()->routeIs($pattern); @endphp
                            <a href="{{ route($route) }}" @if($on) aria-current="page" @endif
                               class="shrink-0 flex items-center gap-2 h-11 px-3 text-sm border-b-2 -mb-px transition {{ $on ? 'border-bloom-400 text-ink font-medium' : 'border-transparent text-gray-500 hover:text-ink hover:border-gray-300' }}">
                                <svg class="w-[17px] h-[17px] {{ $on ? 'text-brand-600' : '' }}" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $icon }}"/></svg>
                                {{ $label }}
                            </a>
                            @endcan
                        @endforeach
                    </div>
                </nav>
            </header>

            {{-- ============ PAGE ============ --}}
            <div class="max-w-[1400px] mx-auto px-4 md:px-8 pt-6 md:pt-8 pb-12 print:p-0">
                <h1 class="print:hidden text-2xl md:text-[28px] leading-tight font-semibold tracking-tight mb-5 md:mb-6">@yield('title')</h1>

                <main>
                    @if(session('success'))
                        <div class="bg-emerald-50 text-emerald-800 border border-emerald-200 px-4 py-3 rounded-2xl text-sm mb-5">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="bg-rose-50 text-rose-800 border border-rose-200 px-4 py-3 rounded-2xl text-sm mb-5">{{ session('error') }}</div>
                    @endif
                    @yield('content')
                </main>
            </div>

            {{-- ============ MOBILE DRAWER ============ --}}
            <div x-cloak x-show="menu" class="print:hidden md:hidden fixed inset-0 z-[60]" role="dialog" aria-modal="true" aria-label="Menu">
                <div x-show="menu" x-transition.opacity.duration.200ms @click="menu = false" class="absolute inset-0 bg-ink/60"></div>

                <aside x-show="menu"
                       x-transition:enter="transition ease-out duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                       x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                       class="absolute inset-y-0 left-0 w-[290px] max-w-[85%] bg-ink text-white flex flex-col overflow-y-auto overscroll-contain pt-[max(1rem,env(safe-area-inset-top))] pb-[max(1rem,env(safe-area-inset-bottom))]">

                    <div class="flex items-center justify-between px-4 h-12 mb-2">
                        <span class="flex items-center gap-2.5 min-w-0">
                            <span class="w-8 h-8 rounded-xl bg-white text-ink font-bold text-sm flex items-center justify-center shrink-0">{{ $brandMark }}</span>
                            <span class="font-semibold truncate">{{ $appName }}</span>
                        </span>
                        <button type="button" @click="menu = false" aria-label="Close menu" class="w-10 h-10 rounded-xl hover:bg-white/10 flex items-center justify-center transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18"/></svg>
                        </button>
                    </div>

                    <div class="mx-4 mb-4 flex items-center gap-3 rounded-2xl bg-white/10 px-3 py-3">
                        <span class="w-10 h-10 rounded-xl bg-brand-500 text-white font-semibold flex items-center justify-center shrink-0">{{ $initial }}</span>
                        <div class="min-w-0">
                            <p class="text-sm font-medium truncate">{{ $user->name ?? 'Admin' }}</p>
                            <p class="text-xs text-white/60 truncate">{{ $user->email ?? '' }}</p>
                            @if($user->role)
                                <p class="text-xs text-bloom-400 truncate">{{ $user->role }}</p>
                            @endif
                        </div>
                    </div>

                    @can('products.create')
                    <a href="{{ route('admin.products.create') }}" @click="menu = false"
                       class="mx-4 mb-4 inline-flex items-center justify-center gap-1.5 bg-bloom-400 text-ink text-sm font-medium rounded-xl py-2.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                        Add product
                    </a>
                    @endcan

                    <nav class="flex-1 px-2 space-y-0.5">
                        @foreach($nav as [$label,$route,$pattern,$icon])
                            @can($navPermissions[$route])
                                @php $on = request()->routeIs($pattern); @endphp
                                <a href="{{ route($route) }}" @click="menu = false"
                                   class="flex items-center gap-3 px-3 py-3 rounded-xl text-[15px] border-l-2 transition {{ $on ? 'bg-white/10 border-bloom-400 text-white font-medium' : 'border-transparent text-white/70 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="w-5 h-5 shrink-0 {{ $on ? 'text-bloom-400' : '' }}" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $icon }}"/></svg>
                                    {{ $label }}
                                </a>
                            @endcan
                        @endforeach
                    </nav>

                    <div class="px-2 mt-4 pt-3 border-t border-white/10 space-y-0.5 text-[15px]">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-white/70 hover:bg-white/5 hover:text-white transition">View site</a>
                        @can('users.edit')
                        <a href="{{ route('admin.permissions.index') }}" @click="menu = false" class="flex items-center gap-3 px-3 py-3 rounded-xl text-white/70 hover:bg-white/5 hover:text-white transition">Permissions</a>
                        @endcan
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button class="w-full text-left flex items-center gap-3 px-3 py-3 rounded-xl text-rose-300 hover:bg-white/5 transition">Logout</button>
                        </form>
                    </div>
                </aside>
            </div>

        </div>{{-- /menu state wrapper --}}

        @stack('scripts')
    </body>
</html>
