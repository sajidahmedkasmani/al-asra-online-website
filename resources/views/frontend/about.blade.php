@extends('storefront.legacy-layout')
@section('title', 'About Us | Al-Asra Store')

@section('content')
@php
    $ph = fn($w,$h,$bg,$fg,$t) => "https://placehold.co/{$w}x{$h}/{$bg}/{$fg}?text=".urlencode($t);
@endphp

{{-- ============ HERO ============ --}}
<section class="max-w-7xl mx-auto px-6 pt-16 md:pt-24 pb-20 grid lg:grid-cols-[1.3fr_1fr] gap-12 items-center">
    <div>
        <p class="text-[11px] uppercase tracking-[0.2em] text-muted mb-6">About Al-Asra</p>
        <h1 class="font-serif text-5xl md:text-8xl leading-[0.98]">
            Useful finds for<br>everyday <span class="italic text-plum">life.</span>
        </h1>
        <p class="text-base md:text-lg text-muted max-w-lg mt-8 leading-relaxed">
            Al-Asra brings together original, imported, and everyday products selected for quality and usefulness. Based in Karachi, we make it simple to shop online and deliver across Pakistan.
        </p>
        <div class="flex flex-wrap gap-3 mt-10">
            <a href="{{ route('shop') }}" class="bg-plum text-white text-xs rounded-full px-7 py-3.5 hover:bg-ink transition">Shop Al-Asra</a>
            <a href="{{ route('contact') }}" class="border border-ink/30 text-xs rounded-full px-7 py-3.5 hover:bg-white transition">Talk to us</a>
        </div>
    </div>

    <div class="relative flex justify-center lg:justify-end items-end gap-4">
        <div class="w-52 md:w-64 aspect-[3/4] rounded-t-full overflow-hidden bg-blush">
            <img src="{{ $ph(600,800,'F8DCE8','5B1A4A','Our story') }}" alt="" class="w-full h-full object-cover" loading="lazy">
        </div>
        <div class="hidden sm:flex flex-col gap-4 pb-10">
            <div class="w-28 aspect-square rounded-full overflow-hidden bg-plum">
                <img src="{{ $ph(300,300,'5B1A4A','F8DCE8','Everyday') }}" alt="" class="w-full h-full object-cover" loading="lazy">
            </div>
            <div class="w-28 aspect-[3/4] rounded-t-full overflow-hidden bg-royal">
                <img src="{{ $ph(300,400,'2D2E8E','FFFFFF','Original') }}" alt="" class="w-full h-full object-cover" loading="lazy">
            </div>
        </div>
    </div>
</section>

{{-- ============ MARQUEE ============ --}}
<div class="overflow-hidden border-y border-black/10 py-5">
    <div class="marquee marquee-slow whitespace-nowrap font-serif italic text-5xl md:text-7xl">
        @for($m=0;$m<4;$m++)
            <span class="mx-6">Everyday essentials</span><span class="text-rose">·</span>
            <span class="mx-6">Original finds</span><span class="text-rose">·</span>
            <span class="mx-6">Natural care</span><span class="text-rose">·</span>
            <span class="mx-6">Delivered across Pakistan</span><span class="text-rose">·</span>
        @endfor
    </div>
</div>

{{-- ============ OUR STORY ============ --}}
<section class="max-w-7xl mx-auto px-6 py-24 grid md:grid-cols-2 gap-14 items-center">
    <div class="relative">
        <div class="aspect-[4/5] rounded-t-[999px] overflow-hidden bg-blush">
            <img src="{{ $ph(800,1000,'F5C8DA','5B1A4A','Al-Asra') }}" alt="" class="w-full h-full object-cover" loading="lazy">
        </div>
        <div class="absolute -bottom-6 -right-2 md:-right-8 bg-plum text-white rounded-3xl px-6 py-5 shadow-[0_20px_40px_-18px_rgba(91,26,74,.7)]">
            <p class="font-serif italic text-3xl leading-none">Original finds,</p>
            <p class="font-serif text-3xl leading-tight">chosen with care</p>
        </div>
    </div>
    <div>
        <p class="text-[11px] uppercase tracking-[0.2em] text-muted mb-4">01 — Our story</p>
        <h2 class="font-serif text-4xl md:text-6xl leading-[1.02] mb-8">Selected with care,<br><span class="italic text-plum">made for everyday.</span></h2>
        <div class="space-y-5 text-muted leading-relaxed">
            <p>Al-Asra started with a simple idea: finding useful, original products online should feel clear and dependable.</p>
            <p>We focus on carefully selected essentials, imported finds, and natural care products that are useful in everyday life.</p>
            <p>From Karachi, we bring together products we believe in and deliver them with care to customers across Pakistan.</p>
        </div>
    </div>
</section>

{{-- ============ VALUES ============ --}}
<section class="bg-blush">
    <div class="max-w-7xl mx-auto px-6 py-24">
        <p class="text-[11px] uppercase tracking-[0.2em] text-plum/70 mb-4">02 — What we believe</p>
        <h2 class="font-serif text-4xl md:text-6xl mb-14 max-w-2xl">Three promises, <span class="italic text-plum">kept simple.</span></h2>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach([
                ['01','Quality first','We choose products for their usefulness, quality, and value.'],
                ['02','Honest and clear','Clear product details and prices, so you know what to expect at delivery.'],
                ['03','Made for real life','Everyday essentials and useful finds, delivered right to your door.'],
            ] as [$n,$t,$d])
                <div class="bg-white rounded-[28px] p-8 hover:-translate-y-1 hover:shadow-[0_24px_40px_-24px_rgba(91,26,74,.45)] transition duration-300">
                    <p class="font-serif italic text-rose text-4xl mb-10">{{ $n }}</p>
                    <p class="font-serif text-2xl mb-3">{{ $t }}</p>
                    <p class="text-sm text-muted leading-relaxed">{{ $d }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ PROCESS ============ --}}
<section class="max-w-7xl mx-auto px-6 py-24">
    <p class="text-[11px] uppercase tracking-[0.2em] text-muted mb-4">03 — From idea to doorstep</p>
    <h2 class="font-serif text-4xl md:text-6xl mb-14">How your order <span class="italic text-plum">gets to you.</span></h2>

    <ol class="grid md:grid-cols-5 gap-6 relative">
        <div class="hidden md:block absolute top-6 left-6 right-6 h-px bg-black/10"></div>
        @foreach([
            ['Selection','Products are chosen for everyday use.'],
            ['Details','We share clear product information.'],
            ['Quality','Each order is checked before dispatch.'],
            ['Packing','Your items are packed with care.'],
            ['Delivery','Sent to your doorstep across Pakistan.'],
        ] as $i => [$t,$d])
            <li class="relative">
                <span class="relative z-10 w-12 h-12 rounded-full bg-plum text-white font-serif flex items-center justify-center mb-5">{{ $i + 1 }}</span>
                <p class="font-serif text-xl mb-1">{{ $t }}</p>
                <p class="text-sm text-muted leading-relaxed">{{ $d }}</p>
            </li>
        @endforeach
    </ol>
</section>

{{-- ============ PROMISES STRIP ============ --}}
<section class="bg-ink text-cream">
    <div class="max-w-7xl mx-auto px-6 py-20 grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
        @foreach([
            ['Free shipping','On bills of Rs. 10,000 and above'],
            ['Pay your way','Cash on Delivery · Bank Transfer'],
            ['Talk to us','Mon–Sat, 11:00 AM – 9:00 PM'],
            ['Based in','Karachi, Pakistan'],
        ] as $i => [$t,$d])
            <div class="border-t border-cream/20 pt-5">
                <p class="text-xs text-rose mb-3">0{{ $i + 1 }}</p>
                <p class="font-serif text-2xl mb-1">{{ $t }}</p>
                <p class="text-sm text-cream/60">{{ $d }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ============ CTA ============ --}}
<section class="max-w-7xl mx-auto px-6 py-24 text-center">
    <h2 class="font-serif text-5xl md:text-7xl leading-[1.02] mb-8">Find something useful<br><span class="italic text-plum">for your everyday.</span></h2>
    <div class="flex flex-wrap justify-center gap-3">
        <a href="{{ route('shop') }}" class="bg-plum text-white text-xs rounded-full px-8 py-4 hover:bg-ink transition">Shop now</a>
        <a href="{{ route('blogs') }}" class="border border-ink/30 text-xs rounded-full px-8 py-4 hover:bg-white transition">Read the journal</a>
    </div>
</section>
@endsection