@extends('storefront.legacy-layout')

@section('title', 'Reset Password')

@section('content')
    @php
        $input = 'w-full h-[52px] rounded-xl border bg-white px-4 text-base placeholder:text-black/30 focus:outline-none focus:border-plum focus:ring-4 focus:ring-rose/15 transition';
    @endphp

    <div class="max-w-xl mx-auto px-4 sm:px-6 py-12 md:py-20">
        <section class="rounded-3xl border border-black/5 bg-white p-6 sm:p-10 shadow-[0_30px_70px_-35px_rgba(91,26,74,.35)]">
            <h1 class="font-serif text-4xl md:text-5xl leading-tight">Set a new password</h1>
            <p class="text-muted mt-2 mb-8">Choose a new password for your customer account.</p>

            @if ($errors->any())
                <div role="alert" class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-xl px-4 py-3 mb-6">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('customer.password.update') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="email" class="block text-sm font-medium mb-1.5">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                        autocomplete="email" class="{{ $input }} {{ $errors->has('email') ? 'border-red-400' : 'border-black/15' }}">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium mb-1.5">New password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="{{ $input }} {{ $errors->has('password') ? 'border-red-400' : 'border-black/15' }}">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium mb-1.5">Confirm new password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="{{ $input }} border-black/15">
                </div>

                <button type="submit" class="w-full h-[54px] bg-plum text-cream rounded-full font-medium hover:bg-ink transition">
                    Reset password
                </button>
            </form>
        </section>
    </div>
@endsection
