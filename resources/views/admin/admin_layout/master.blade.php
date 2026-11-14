<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#0B1F2A">
        <title>@yield('title') — {{ config('app.name', 'Store') }} Admin</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            /*  THEME TOKENS: change the whole admin's colours from here.
                brand = emerald/teal (primary) · bloom = violet (secondary) · ink = deep navy-teal */
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            brand: { 50:'#ECFDF8', 100:'#D1FAEC', 200:'#A7F3DB', 300:'#6EE7C3', 400:'#2DD4A4', 500:'#14B88A', 600:'#0E9F77', 700:'#0B7F60' },
                            bloom: { 400:'#A78BFA', 500:'#8B5CF6' },
                            lav: '#E9F2F0',
                            ink: '#0B1F2A',
                        },
                        fontFamily: { sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'] },
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
            body{background:
                radial-gradient(760px 460px at 6% -6%, rgba(45,212,164,.30), transparent 62%),
                radial-gradient(680px 460px at 100% 0%, rgba(139,92,246,.20), transparent 62%),
                radial-gradient(760px 540px at 62% 112%, rgba(14,165,233,.20), transparent 62%), #EAF3F1;
                background-attachment:fixed;-webkit-tap-highlight-color:transparent}
            .side{background:linear-gradient(165deg,#0B1F2A 0%,#0C3340 52%,#0D4A4A 100%)}
            .btn-bloom{background:linear-gradient(135deg,#0E9F77,#0891B2);color:#fff;box-shadow:0 10px 22px -8px rgba(14,159,119,.6);transition:transform .2s ease,box-shadow .2s ease,filter .2s ease}
            .btn-bloom:hover{filter:brightness(1.07);box-shadow:0 14px 26px -8px rgba(14,159,119,.7)}
            .soft{box-shadow:0 1px 0 rgba(255,255,255,.9) inset,0 14px 34px -16px rgba(11,31,42,.22),0 2px 6px -2px rgba(11,31,42,.06)}
            .lift{transition:transform .25s ease, box-shadow .25s ease}
            .lift:hover{transform:translateY(-3px);box-shadow:0 22px 40px -18px rgba(14,159,119,.40)}
            .glass{background:rgba(255,255,255,.66);-webkit-backdrop-filter:blur(18px) saturate(1.4);backdrop-filter:blur(18px) saturate(1.4);border:1px solid rgba(255,255,255,.85)}
            @keyframes rise{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:none}}
            .rise{opacity:0;animation:rise .55s cubic-bezier(.2,.7,.2,1) forwards;animation-delay:var(--d,0s)}
            @keyframes bar-rise{from{transform:scaleY(0)}to{transform:scaleY(1)}}
            /* not ".grow": Tailwind already owns that name (flex-grow) and it stretched every bar */
            .bar-rise{transform-origin:bottom;animation:bar-rise .7s cubic-bezier(.2,.7,.2,1) both;animation-delay:var(--d,0s)}
            .scroll-thin::-webkit-scrollbar{width:6px;height:6px}
            .scroll-thin::-webkit-scrollbar-thumb{background:#A7D8CB;border-radius:9px}
            a:focus-visible,button:focus-visible{outline:2px solid #14B88A;outline-offset:2px}
            @media (prefers-reduced-motion:reduce){.rise,.bar-rise{animation:none;opacity:1}}
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

            <div class="flex min-h-screen">

                {{-- ============ SIDEBAR (desktop) ============ --}}
                <aside class="print:hidden hidden lg:block w-[284px] shrink-0 p-4">
                    <div class="side relative sticky top-4 h-[calc(100vh-2rem)] rounded-[28px] overflow-hidden flex flex-col p-5 text-white shadow-2xl shadow-ink/30">
                        <div class="pointer-events-none absolute -top-20 -right-16 w-60 h-60 rounded-full bg-brand-400/30 blur-3xl"></div>
                        <div class="pointer-events-none absolute bottom-24 -left-20 w-56 h-56 rounded-full bg-bloom-400/25 blur-3xl"></div>

                        <a href="{{ route('admin.dashboard') }}" class="relative flex items-center gap-3 mb-6 px-1">
                            <span class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-400 to-bloom-400 text-white font-extrabold flex items-center justify-center shadow-lg shadow-brand-500/40">{{ $brandMark }}</span>
                            <span class="min-w-0">
                                <span class="block font-bold leading-tight truncate">{{ $appName }}</span>
                                <span class="block text-[11px] text-white/50">Admin panel</span>
                            </span>
                        </a>

                        @can('products.create')
                        <a href="{{ route('admin.products.create') }}"
                           class="btn-bloom relative rounded-2xl py-3 px-4 flex items-center justify-center gap-2 text-sm font-semibold mb-5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                            Add product
                        </a>
                        @endcan

                        <nav class="relative flex-1 overflow-y-auto scroll-thin -mx-1 px-1 space-y-1 text-sm">
                            @foreach($nav as [$label,$route,$pattern,$icon])
                                @can($navPermissions[$route])
                                @php $on = request()->routeIs($pattern); @endphp
                                <a href="{{ route($route) }}" @if($on) aria-current="page" @endif
                                   class="group flex items-center gap-3 px-2.5 py-2 rounded-2xl transition {{ $on ? 'bg-white/10 ring-1 ring-white/15 text-white font-semibold' : 'text-white/65 hover:bg-white/5 hover:text-white' }}">
                                    <span class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 transition {{ $on ? 'bg-gradient-to-br from-brand-400 to-bloom-400 text-white shadow-lg shadow-brand-500/30' : 'bg-white/10 group-hover:bg-white/15' }}">
                                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $icon }}"/></svg>
                                    </span>
                                    {{ $label }}
                                </a>
                                @endcan
                            @endforeach
                        </nav>

                        <div class="relative mt-4 rounded-2xl bg-white/10 ring-1 ring-white/10 p-3 flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-400 to-bloom-400 font-bold flex items-center justify-center shrink-0">{{ $initial }}</span>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold truncate">{{ $user->name ?? 'Admin' }}</p>
                                <p class="text-[11px] text-white/55 truncate">{{ $user->role ?: ($user->email ?? '') }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">@csrf
                                <button title="Logout" aria-label="Logout" class="w-9 h-9 rounded-xl hover:bg-rose-500/20 text-white/70 hover:text-rose-300 flex items-center justify-center transition">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 4h3a2 2 0 012 2v12a2 2 0 01-2 2h-3M10 17l-5-5 5-5M5 12h11"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </aside>

                {{-- ============ MAIN ============ --}}
                <div class="flex-1 min-w-0 flex flex-col">

                    <header class="print:hidden sticky top-0 z-30 px-4 md:px-8 lg:pl-2 pt-3 md:pt-4">
                        <div class="glass rounded-3xl h-16 px-3 md:px-5 flex items-center justify-between gap-3 shadow-lg shadow-ink/5">
                            <div class="flex items-center gap-3 min-w-0">
                                <button type="button" @click="menu = true" aria-label="Open menu" aria-haspopup="dialog"
                                        class="lg:hidden w-10 h-10 rounded-2xl bg-white shadow-sm flex flex-col items-center justify-center gap-[5px] shrink-0 active:scale-95 transition">
                                    <span class="block w-[18px] h-[2px] rounded-full bg-ink"></span>
                                    <span class="block w-[18px] h-[2px] rounded-full bg-ink"></span>
                                    <span class="block w-[18px] h-[2px] rounded-full bg-ink"></span>
                                </button>
                                <h1 class="text-lg md:text-xl font-bold tracking-tight truncate">@yield('title')</h1>
                            </div>

                            <div class="flex items-center gap-2 md:gap-3">
                                @can('orders.view')
                                <form method="GET" action="{{ route('admin.orders.index') }}" class="hidden md:flex items-center gap-2 bg-white/80 rounded-2xl px-4 py-2.5 text-sm w-64 xl:w-72 ring-1 ring-black/5 focus-within:ring-2 focus-within:ring-brand-400 transition">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5" stroke-linecap="round"/></svg>
                                    <input name="q" type="search" placeholder="Search orders..." class="bg-transparent outline-none w-full placeholder:text-gray-400">
                                </form>

                                <a href="{{ route('admin.orders.index') }}" class="w-10 h-10 rounded-2xl bg-white shadow-sm flex items-center justify-center text-gray-500 hover:text-brand-600 transition" aria-label="Orders">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </a>
                                @endcan

                                {{-- profile dropdown --}}
                                <div class="relative" x-data="{ o:false }" @click.outside="o=false" @keydown.escape.window="o=false">
                                    <button @click="o=!o" aria-haspopup="menu" :aria-expanded="o" class="flex items-center gap-2 bg-white shadow-sm rounded-2xl pl-1.5 pr-3 py-1.5 hover:bg-brand-50 transition">
                                        <span class="w-8 h-8 rounded-xl bg-gradient-to-br from-brand-400 to-bloom-400 text-white text-xs font-bold flex items-center justify-center">{{ $initial }}</span>
                                        <span class="hidden sm:block text-sm font-medium text-gray-700 max-w-[110px] truncate">{{ $user->name ?? 'Admin' }}</span>
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6" stroke-linecap="round"/></svg>
                                    </button>
                                    <div x-cloak x-show="o" x-transition.origin.top.right class="absolute right-0 mt-3 w-60 bg-white rounded-3xl shadow-2xl shadow-ink/20 border border-gray-100 p-2 text-sm z-50">
                                        <div class="px-3 py-2.5 border-b border-gray-100 mb-1">
                                            <p class="font-semibold truncate">{{ $user->name ?? 'Admin' }}</p>
                                            <p class="text-[11px] text-gray-400 truncate">{{ $user->email ?? '' }}</p>
                                            @if($user->role)
                                                <span class="inline-block mt-1.5 text-[10px] font-semibold bg-brand-50 text-brand-700 rounded-full px-2 py-0.5">{{ $user->role }}</span>
                                            @endif
                                        </div>
                                        <a href="{{ route('home') }}" class="block px-3 py-2 rounded-xl hover:bg-brand-50 text-gray-600">View site</a>
                                        @can('settings.view')
                                        <a href="{{ route('admin.settings.edit') }}" class="block px-3 py-2 rounded-xl hover:bg-brand-50 text-gray-600">Settings</a>
                                        @endcan
                                        @can('newsletter.manage')
                                        <a href="{{ route('admin.newsletters.index') }}" class="block px-3 py-2 rounded-xl hover:bg-brand-50 text-gray-600">Newsletters</a>
                                        @endcan
                                        @can('users.edit')
                                        <a href="{{ route('admin.permissions.index') }}" class="block px-3 py-2 rounded-xl hover:bg-brand-50 text-gray-600">Manage Permissions</a>
                                        @endcan
                                        <form method="POST" action="{{ route('logout') }}">@csrf
                                            <button class="w-full text-left px-3 py-2 rounded-xl hover:bg-rose-50 text-rose-500 font-medium">Logout</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>

                    <main class="flex-1 px-4 md:px-8 lg:pl-2 pt-5 md:pt-6 pb-12 print:p-0">
                        @if(session('success'))
                            <div class="rise flex items-center gap-3 bg-emerald-50 text-emerald-800 border border-emerald-200 px-4 py-3 rounded-2xl text-sm mb-5">
                                <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs shrink-0">✓</span>{{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="rise flex items-center gap-3 bg-rose-50 text-rose-800 border border-rose-200 px-4 py-3 rounded-2xl text-sm mb-5">
                                <span class="w-6 h-6 rounded-full bg-rose-500 text-white flex items-center justify-center text-xs shrink-0">!</span>{{ session('error') }}
                            </div>
                        @endif
                        @yield('content')
                    </main>
                </div>
            </div>

            {{-- ============ MOBILE / TABLET DRAWER ============ --}}
            <div x-cloak x-show="menu" class="print:hidden lg:hidden fixed inset-0 z-[60]" role="dialog" aria-modal="true" aria-label="Menu">
                <div x-show="menu" x-transition.opacity.duration.200ms @click="menu = false" class="absolute inset-0 bg-ink/50 backdrop-blur-sm"></div>

                <aside x-show="menu"
                       x-transition:enter="transition ease-out duration-250" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                       x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                       class="side absolute inset-y-0 left-0 w-[300px] max-w-[88%] text-white flex flex-col overflow-y-auto overscroll-contain rounded-r-[28px] pt-[max(1rem,env(safe-area-inset-top))] pb-[max(1rem,env(safe-area-inset-bottom))] px-4 shadow-2xl">
                    <div class="pointer-events-none absolute -top-16 -right-12 w-52 h-52 rounded-full bg-brand-400/30 blur-3xl"></div>
                    <div class="pointer-events-none absolute bottom-20 -left-16 w-52 h-52 rounded-full bg-bloom-400/25 blur-3xl"></div>

                    <div class="relative flex items-center justify-between mb-5">
                        <span class="flex items-center gap-3 min-w-0">
                            <span class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-400 to-bloom-400 font-extrabold flex items-center justify-center shrink-0">{{ $brandMark }}</span>
                            <span class="font-bold truncate">{{ $appName }}</span>
                        </span>
                        <button type="button" @click="menu = false" aria-label="Close menu" class="w-10 h-10 rounded-2xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18"/></svg>
                        </button>
                    </div>

                    <div class="relative mb-4 rounded-2xl bg-white/10 ring-1 ring-white/10 p-3 flex items-center gap-3">
                        <span class="w-11 h-11 rounded-xl bg-gradient-to-br from-brand-400 to-bloom-400 font-bold flex items-center justify-center shrink-0">{{ $initial }}</span>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold truncate">{{ $user->name ?? 'Admin' }}</p>
                            <p class="text-[11px] text-white/60 truncate">{{ $user->email ?? '' }}</p>
                            @if($user->role)
                                <p class="text-[11px] text-brand-300 truncate">{{ $user->role }}</p>
                            @endif
                        </div>
                    </div>

                    @can('products.create')
                    <a href="{{ route('admin.products.create') }}" @click="menu = false" class="btn-bloom relative mb-4 rounded-2xl py-3 flex items-center justify-center gap-2 text-sm font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                        Add product
                    </a>
                    @endcan

                    <nav class="relative flex-1 space-y-1 text-[15px]">
                        @foreach($nav as [$label,$route,$pattern,$icon])
                            @can($navPermissions[$route])
                                @php $on = request()->routeIs($pattern); @endphp
                                <a href="{{ route($route) }}" @click="menu = false"
                                   class="flex items-center gap-3 px-2.5 py-2.5 rounded-2xl transition {{ $on ? 'bg-white/10 ring-1 ring-white/15 font-semibold' : 'text-white/70 hover:bg-white/5' }}">
                                    <span class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $on ? 'bg-gradient-to-br from-brand-400 to-bloom-400 shadow-lg shadow-brand-500/30' : 'bg-white/10' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $icon }}"/></svg>
                                    </span>
                                    {{ $label }}
                                </a>
                            @endcan
                        @endforeach
                    </nav>

                    <div class="relative mt-4 pt-3 border-t border-white/10 space-y-1 text-[15px]">
                        <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-2xl text-white/70 hover:bg-white/5">View site</a>
                        @can('users.edit')
                        <a href="{{ route('admin.permissions.index') }}" @click="menu = false" class="block px-3 py-2.5 rounded-2xl text-white/70 hover:bg-white/5">Permissions</a>
                        @endcan
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button class="w-full text-left px-3 py-2.5 rounded-2xl text-rose-300 hover:bg-white/5">Logout</button>
                        </form>
                    </div>
                </aside>
            </div>

        </div>{{-- /menu state wrapper --}}

        @stack('scripts')
    </body>
</html>
