@extends('storefront.legacy-layout')

@section('title', 'Log in | Al-Asra Online Store')

@section('content')
    @php
        // Shared input style (padding is set per input so the leading icon has room)
        $input = 'w-full h-[54px] rounded-2xl border bg-white pl-12 pr-4 text-base placeholder:text-black/30 focus:outline-none focus:border-plum focus:ring-4 focus:ring-rose/15 transition';
    @endphp

    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 md:py-16">
        <div class="grid lg:grid-cols-[1.05fr_1fr] lg:rounded-[2rem] lg:overflow-hidden lg:border lg:border-black/5 lg:bg-white lg:shadow-[0_30px_70px_-35px_rgba(91,26,74,.35)]">

            {{-- Brand panel (desktop only) --}}
            <aside class="hidden lg:flex relative bg-plum text-cream p-12 flex-col justify-between overflow-hidden">
                <div class="absolute -right-16 -bottom-10 w-72 h-96 arch bg-rose/25"></div>
                <div class="absolute right-24 -bottom-10 w-44 h-60 arch bg-cream/10"></div>

                {{-- Logo --}}
                <div class="relative flex items-center gap-3">
                    <span class="w-11 h-11 rounded-2xl bg-cream/15 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 8h14l-1 12H6L5 8z"/><path d="M9 8V6.5a3 3 0 0 1 6 0V8"/></svg>
                    </span>
                    <div class="leading-tight">
                        <p class="font-serif text-2xl">Al-Asra</p>
                        <p class="text-xs text-cream/70 tracking-wide">Online Store</p>
                    </div>
                </div>

                {{-- Headline + perks --}}
                <div class="relative">
                    <h2 class="font-serif text-5xl leading-[1.05]">Everything you need,<br>in one cart.</h2>
                    <p class="mt-4 text-cream/75 max-w-xs">From kitchen finds to little gifts, your favourite everyday items are waiting for you.</p>

                    <ul class="mt-8 space-y-3 text-sm text-cream/90">
                        <li class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-cream/15 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h11v9H3zM14 10h4l3 3v3h-7"/><circle cx="7" cy="18" r="1.6"/><circle cx="17" cy="18" r="1.6"/></svg>
                            </span>
                            Track every order in one place
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-cream/15 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7-4.6-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 11c0 5.4-7 10-7 10z"/></svg>
                            </span>
                            Save your favourite items
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-cream/15 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M13 3L5 14h6l-1 7 8-11h-6l1-7z"/></svg>
                            </span>
                            Check out faster, every time
                        </li>
                    </ul>
                </div>
            </aside>

            {{-- Form --}}
            <section class="lg:p-14 flex flex-col justify-center">

                {{-- Mobile brand mark --}}
                <div class="flex items-center gap-3 mb-8 lg:hidden">
                    <span class="w-11 h-11 rounded-2xl bg-plum text-cream flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 8h14l-1 12H6L5 8z"/><path d="M9 8V6.5a3 3 0 0 1 6 0V8"/></svg>
                    </span>
                    <div class="leading-tight">
                        <p class="font-serif text-xl text-plum">Al-Asra</p>
                        <p class="text-xs text-muted tracking-wide">Online Store</p>
                    </div>
                </div>

                <h1 class="font-serif text-4xl md:text-5xl leading-tight">Welcome back</h1>
                <p class="text-muted mt-2 mb-8">Log in to see your orders and shop faster.</p>

                @if($errors->any())
                    <div role="alert" class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 text-sm rounded-2xl px-4 py-3 mb-6">
                        <svg class="w-5 h-5 shrink-0 mt-px" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16.5v.01"/></svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('customer.login') }}" x-data="{ show:false, busy:false }" @submit="busy = true" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium mb-1.5">Email</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-black/35 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="M4 7l8 6 8-6"/></svg>
                            </span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                autocomplete="username" inputmode="email" autocapitalize="none" spellcheck="false" placeholder="you@example.com"
                                class="{{ $input }} {{ $errors->has('email') ? 'border-red-400' : 'border-black/15' }}">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-medium">Password</label>
                            <a href="{{ route('customer.password.request') }}" class="text-sm text-plum underline underline-offset-4 hover:text-rose transition">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-black/35 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="10" width="16" height="10" rx="3"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                            </span>
                            <input id="password" :type="show ? 'text' : 'password'" name="password" required
                                autocomplete="current-password" placeholder="Enter your password"
                                class="{{ $input }} !pr-14 {{ $errors->has('password') ? 'border-red-400' : 'border-black/15' }}">
                            <button type="button" @click="show = !show" :aria-pressed="show" :aria-label="show ? 'Hide password' : 'Show password'"
                                    class="absolute right-1.5 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl flex items-center justify-center text-muted hover:text-plum hover:bg-cream transition focus:outline-none focus-visible:ring-4 focus-visible:ring-plum/30">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M1.5 12S5.5 5 12 5s10.5 7 10.5 7-4 7-10.5 7S1.5 12 1.5 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg x-cloak x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M17.9 17.9A10.6 10.6 0 0 1 12 19.5C5.5 19.5 1.5 12 1.5 12a18 18 0 0 1 4.6-5.4M9.9 4.7A10 10 0 0 1 12 4.5c6.5 0 10.5 7.5 10.5 7.5a18 18 0 0 1-2.1 3M1 1l22 22"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember me --}}
                    <label class="relative inline-flex items-center gap-3 cursor-pointer select-none min-h-[44px]">
                        <input type="checkbox" name="remember" class="peer sr-only" @checked(old('remember'))>
                        <span class="w-[22px] h-[22px] rounded-md border-2 border-black/25 bg-white flex items-center justify-center transition peer-checked:bg-plum peer-checked:border-plum peer-focus-visible:ring-4 peer-focus-visible:ring-plum/30">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12l5 5L20 6"/></svg>
                        </span>
                        <span class="text-sm">Keep me logged in</span>
                    </label>

                    {{-- Submit --}}
                    <button type="submit" :disabled="busy"
                            class="w-full h-[56px] flex items-center justify-center gap-3 bg-plum text-cream rounded-full font-medium text-base shadow-[0_12px_24px_-12px_rgba(91,26,74,.6)] hover:bg-ink hover:-translate-y-px active:translate-y-0 active:scale-[.99] disabled:opacity-70 disabled:cursor-wait transition focus:outline-none focus-visible:ring-4 focus-visible:ring-plum/30">
                        <svg x-cloak x-show="busy" class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".3" stroke-width="3"/><path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                        <span x-text="busy ? 'Logging in…' : 'Log in'">Log in</span>
                    </button>
                </form>

                {{-- Divider --}}
                <div class="flex items-center gap-4 my-6 text-xs text-muted">
                    <span class="h-px flex-1 bg-black/10"></span>
                    <span>or</span>
                    <span class="h-px flex-1 bg-black/10"></span>
                </div>

                {{-- Google --}}
                <a href="{{ route('customer.google.redirect') }}"
                   class="w-full h-[54px] flex items-center justify-center gap-3 border border-black/15 bg-white rounded-full font-medium text-base hover:bg-cream hover:border-black/25 transition focus:outline-none focus-visible:ring-4 focus-visible:ring-plum/30">
                    <svg aria-hidden="true" class="w-5 h-5" viewBox="0 0 48 48">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.76 7.18l7.73 6C44.42 37.97 46.98 31.7 46.98 24.55z"/>
                        <path fill="#FBBC05" d="M10.53 28.59A14.4 14.4 0 0 1 9.75 24c0-1.59.27-3.13.76-4.59l-7.98-6.19A23.9 23.9 0 0 0 0 24c0 3.87.93 7.53 2.56 10.78l7.97-6.19z"/>
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.91-5.8l-7.73-6c-2.14 1.45-4.89 2.3-8.18 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                    </svg>
                    Continue with Google
                </a>

                {{-- Footer links --}}
                <div class="mt-8 pt-6 border-t border-black/10 text-center text-sm text-muted space-y-2">
                    <p>New to Al-Asra Online Store?
                        <a href="{{ route('customer.register') }}" class="text-plum font-medium underline underline-offset-4 hover:text-rose transition">Create an account</a>
                    </p>
                    <p><a href="{{ route('shop') }}" class="hover:text-rose transition">Continue shopping as a guest →</a></p>
                </div>
            </section>
        </div>
    </div>
@endsection