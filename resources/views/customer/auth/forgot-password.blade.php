@extends('storefront.legacy-layout')

@section('title', 'Forgot Password')

@section('content')
    @php
        $input = 'w-full h-[52px] rounded-xl border bg-white px-4 text-base placeholder:text-black/30 focus:outline-none focus:border-plum focus:ring-4 focus:ring-rose/15 transition';
    @endphp

    <div class="max-w-xl mx-auto px-4 sm:px-6 py-12 md:py-20">
        <section class="rounded-3xl border border-black/5 bg-white p-6 sm:p-10 shadow-[0_30px_70px_-35px_rgba(91,26,74,.35)]">
            <h1 class="font-serif text-4xl md:text-5xl leading-tight">Forgot password?</h1>
            <p class="text-muted mt-2 mb-8">Enter your email and we’ll send you a link to reset your password.</p>

            @if (session('status'))
                <div role="status" class="bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3 mb-6">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div role="alert" class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-xl px-4 py-3 mb-6">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('customer.password.email') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium mb-1.5">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        autocomplete="email" inputmode="email" placeholder="you@example.com"
                        class="{{ $input }} {{ $errors->has('email') ? 'border-red-400' : 'border-black/15' }}">
                </div>

                <button type="submit" class="w-full h-[54px] bg-plum text-cream rounded-full font-medium hover:bg-ink transition">
                    Email password reset link
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-muted">
                Remembered it?
                <a href="{{ route('customer.login') }}" class="text-plum font-medium underline underline-offset-4 hover:text-rose transition">Back to log in</a>
            </p>
        </section>
    </div>
@endsection
