<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#0B1F2A">
        <title>Sign in — {{ config('app.name', 'Store') }} Admin</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: { extend: {
                    colors: {
                        brand: { 50:'#ECFDF8', 100:'#D1FAEC', 200:'#A7F3DB', 300:'#6EE7C3', 400:'#2DD4A4', 500:'#14B88A', 600:'#0E9F77', 700:'#0B7F60' },
                        bloom: { 400:'#A78BFA', 500:'#8B5CF6' },
                        ink: '#0B1F2A',
                    },
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'] },
                } }
            }
        </script>
        <script src="//unpkg.com/alpinejs" defer></script>

        <style>
            [x-cloak]{display:none!important}
            .hero{background:
                radial-gradient(620px 420px at 12% 8%, rgba(45,212,164,.55), transparent 62%),
                radial-gradient(560px 460px at 92% 22%, rgba(139,92,246,.55), transparent 62%),
                radial-gradient(640px 520px at 40% 108%, rgba(14,165,233,.50), transparent 62%),
                linear-gradient(160deg,#0B1F2A 0%,#0C3340 55%,#0D4A4A 100%)}
            .paper{background:
                radial-gradient(520px 360px at 100% 0%, rgba(45,212,164,.20), transparent 62%),
                radial-gradient(520px 360px at 0% 100%, rgba(139,92,246,.14), transparent 62%), #F4F8F7}
            .glass{background:rgba(255,255,255,.12);-webkit-backdrop-filter:blur(16px);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.22)}
            .btn-go{background:linear-gradient(135deg,#0E9F77,#0891B2);box-shadow:0 14px 28px -10px rgba(14,159,119,.65);transition:transform .2s ease,filter .2s ease,box-shadow .2s ease}
            .btn-go:hover{filter:brightness(1.07);box-shadow:0 18px 32px -10px rgba(14,159,119,.75)}
            .btn-go:active{transform:scale(.985)}
            @keyframes floaty{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
            .floaty{animation:floaty 6s ease-in-out infinite;animation-delay:var(--d,0s)}
            @keyframes rise{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
            .rise{opacity:0;animation:rise .7s cubic-bezier(.2,.7,.2,1) forwards;animation-delay:var(--d,0s)}
            @keyframes spin{to{transform:rotate(360deg)}}
            @media (prefers-reduced-motion:reduce){.floaty,.rise{animation:none;opacity:1}}
        </style>
    </head>

    <body class="font-sans text-ink antialiased">
        @php
            $appName = config('app.name', 'Store');
            $mark = strtoupper(mb_substr($appName, 0, 1));
        @endphp

        <div class="min-h-screen lg:grid lg:grid-cols-[1.05fr_1fr]">

            {{-- ============ BRAND PANEL ============ --}}
            <section class="hero relative overflow-hidden text-white px-6 py-8 lg:p-14 flex flex-col justify-between lg:min-h-screen rounded-b-[36px] lg:rounded-none">
                <div class="pointer-events-none absolute inset-0 opacity-[.14]" style="background-image:radial-gradient(#fff 1px,transparent 1px);background-size:26px 26px"></div>

                <div class="relative flex items-center gap-3">
                    <span class="w-11 h-11 rounded-2xl bg-white/95 text-ink font-extrabold text-lg flex items-center justify-center shadow-lg">{{ $mark }}</span>
                    <span class="font-bold text-lg tracking-tight">{{ $appName }}</span>
                </div>

                <div class="relative hidden lg:block my-10">
                    <h1 class="text-[44px] xl:text-[52px] leading-[1.05] font-extrabold tracking-tight max-w-md">Your whole store, in one calm place.</h1>
                    <p class="mt-5 text-white/75 max-w-sm text-[15px] leading-relaxed">Orders, products, pages and customers. Sign in to pick up right where you left off.</p>

                    {{-- decorative glass dashboard --}}
                    <div class="relative mt-12 max-w-md h-64" aria-hidden="true">
                        <div class="floaty glass absolute left-0 top-0 w-72 rounded-3xl p-5 shadow-2xl shadow-black/20">
                            <div class="flex items-center gap-2 mb-5">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-300"></span><span class="w-2.5 h-2.5 rounded-full bg-amber-300"></span><span class="w-2.5 h-2.5 rounded-full bg-emerald-300"></span>
                            </div>
                            <div class="flex items-end gap-2.5 h-24">
                                <span class="flex-1 rounded-t-lg bg-white/35" style="height:38%"></span>
                                <span class="flex-1 rounded-t-lg bg-white/35" style="height:62%"></span>
                                <span class="flex-1 rounded-t-lg bg-white/35" style="height:48%"></span>
                                <span class="flex-1 rounded-t-lg bg-gradient-to-t from-brand-300 to-white" style="height:92%"></span>
                                <span class="flex-1 rounded-t-lg bg-white/35" style="height:58%"></span>
                                <span class="flex-1 rounded-t-lg bg-white/35" style="height:74%"></span>
                            </div>
                        </div>
                        <div class="floaty glass absolute right-0 top-20 rounded-2xl px-4 py-3 flex items-center gap-3 shadow-2xl shadow-black/20" style="--d:-2s">
                            <span class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-300 to-brand-500 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12l5 5L20 7"/></svg>
                            </span>
                            <span class="text-sm font-semibold">New order received</span>
                        </div>
                        <div class="floaty glass absolute left-10 bottom-0 rounded-2xl px-4 py-3 flex items-center gap-3 shadow-2xl shadow-black/20" style="--d:-4s">
                            <span class="w-9 h-9 rounded-xl bg-gradient-to-br from-bloom-400 to-bloom-500 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0v10l-8 4m8-14l-8 4m0 10L4 17V7m8 14V11"/></svg>
                            </span>
                            <span class="text-sm font-semibold">Product published</span>
                        </div>
                    </div>
                </div>

                <p class="relative mt-6 lg:mt-0 text-sm text-white/70 lg:hidden">Sign in to manage your store.</p>
                <p class="relative hidden lg:block text-xs text-white/50">&copy; {{ date('Y') }} {{ $appName }}</p>
            </section>

            {{-- ============ FORM ============ --}}
            <section class="paper flex items-center justify-center px-5 py-10 sm:py-14 lg:min-h-screen">
                <div class="rise w-full max-w-[420px]" x-data="{ show: false, loading: false }">

                    <div class="bg-white/80 backdrop-blur-xl rounded-[32px] border border-white shadow-[0_30px_70px_-30px_rgba(11,31,42,.35)] p-7 sm:p-9">
                        <h2 class="text-[28px] font-extrabold tracking-tight">Welcome back</h2>
                        <p class="text-sm text-gray-500 mt-1.5 mb-7">Sign in to your admin account.</p>

                        @if(session('status'))
                            <div class="mb-5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" @submit="loading = true" class="space-y-5" novalidate>
                            @csrf

                            <div>
                                <label for="email" class="block text-[13px] font-semibold text-gray-700 mb-2">Email</label>
                                <div class="relative">
                                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-[18px] h-[18px] text-gray-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 8l9 6 9-6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/></svg>
                                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com"
                                           class="w-full rounded-2xl bg-gray-50 border {{ $errors->has('email') ? 'border-rose-300 ring-4 ring-rose-100' : 'border-gray-200' }} pl-11 pr-4 py-3.5 text-sm placeholder:text-gray-400 focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-100 focus:outline-none transition">
                                </div>
                                @error('email')<p class="text-xs text-rose-600 mt-2">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label for="password" class="block text-[13px] font-semibold text-gray-700">Password</label>
                                    @if(Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-xs font-medium text-brand-700 hover:underline">Forgot password?</a>
                                    @endif
                                </div>
                                <div class="relative">
                                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-[18px] h-[18px] text-gray-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="4" y="11" width="16" height="9" rx="2"/><path d="M8 11V8a4 4 0 118 0v3"/></svg>
                                    <input id="password" name="password" :type="show ? 'text' : 'password'" type="password" required autocomplete="current-password" placeholder="Enter your password"
                                           class="w-full rounded-2xl bg-gray-50 border border-gray-200 pl-11 pr-12 py-3.5 text-sm placeholder:text-gray-400 focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-100 focus:outline-none transition">
                                    <button type="button" @click="show = !show" :aria-label="show ? 'Hide password' : 'Show password'"
                                            class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 rounded-xl text-gray-400 hover:text-brand-600 hover:bg-brand-50 flex items-center justify-center transition">
                                        <svg x-show="!show" class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                        <svg x-cloak x-show="show" class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 3l18 18M10.6 6.1A9.6 9.6 0 0112 6c6.4 0 10 6 10 6a17 17 0 01-3.2 3.9M6.5 7.5C3.8 9.3 2 12 2 12s3.6 6 10 6c1.5 0 2.9-.3 4.1-.8M9.9 9.9a3 3 0 004.2 4.2"/></svg>
                                    </button>
                                </div>
                                @error('password')<p class="text-xs text-rose-600 mt-2">{{ $message }}</p>@enderror
                            </div>

                            <label class="flex items-center gap-2.5 text-sm text-gray-600 cursor-pointer select-none">
                                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }} class="w-4 h-4 rounded-md border-gray-300 text-brand-600 focus:ring-brand-400">
                                Keep me signed in
                            </label>

                            <button type="submit" :disabled="loading" class="btn-go w-full text-white font-semibold rounded-2xl py-3.5 text-sm flex items-center justify-center gap-2 disabled:opacity-80 disabled:cursor-wait">
                                <svg x-cloak x-show="loading" class="w-4 h-4" style="animation:spin .8s linear infinite" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3" opacity=".3"/><path d="M21 12a9 9 0 00-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                                <span x-text="loading ? 'Signing in...' : 'Sign in'">Sign in</span>
                            </button>
                        </form>
                    </div>

                    <p class="text-center text-xs text-gray-400 mt-6">
                        <a href="{{ route('home') }}" class="hover:text-brand-700 transition">Back to {{ $appName }}</a>
                    </p>
                </div>
            </section>
        </div>
    </body>
</html>
