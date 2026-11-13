{{--
    Al-Asra Online Store, header with scroll effect + "Shop" hover mega menu (store.google.com style)

    Save as: resources/views/storefront/partials/header.blade.php
    Use it:  @include('storefront.partials.header')   (replace your old header markup with this)

    Needs Tailwind + Alpine (already loaded in legacy-layout.blade.php).
--}}
@php
    // ---- EDIT HERE ----------------------------------------------------------
    // Categories shown in the Shop panel. Later you can pass $navCategories from
    // a controller / view composer and this default list is ignored.
    // 'image' is optional (path or URL). Without it a soft tile with the initial shows.
    $navCategories = $navCategories ?? [
        ['name' => 'Kitchen',   'slug' => 'kitchen',   'image' => null],
        ['name' => 'Home',      'slug' => 'home',      'image' => null],
        ['name' => 'Drinkware', 'slug' => 'drinkware', 'image' => null],
        ['name' => 'Gadgets',   'slug' => 'gadgets',   'image' => null],
        ['name' => 'Gifts',     'slug' => 'gifts',     'image' => null],
        ['name' => 'Travel',    'slug' => 'travel',    'image' => null],
    ];

    // Top-level links (Shop is handled separately because it opens the panel)
    $navLinks = [
        ['label' => 'About',       'href' => url('/about'),   'match' => 'about*'],
        ['label' => 'Track order', 'href' => url('/track'),   'match' => 'track*'],
        ['label' => 'FAQ',         'href' => url('/faq'),     'match' => 'faq*'],
        ['label' => 'Contact',     'href' => url('/contact'), 'match' => 'contact*'],
    ];

    $logo      = asset('images/logo.png');   // change to your logo path
    $cartUrl   = url('/cart');               // change to route('cart') if you have it
    $cartCount = $cartCount ?? 0;
    $shopUrl   = route('shop');
    // -------------------------------------------------------------------------

    $link  = 'px-4 py-2 rounded-full text-sm font-semibold transition';
    $idle  = 'text-ink hover:bg-rose-100/60';
    $on    = 'bg-rose-100 text-rose-600';
@endphp

<header
    x-data="{
        scrolled: false,
        shop: false,
        mobile: false,
        mobileShop: false,
        t: null,
        openShop()  { clearTimeout(this.t); this.shop = true },
        closeShop() { clearTimeout(this.t); this.t = setTimeout(() => this.shop = false, 140) },
    }"
    x-init="scrolled = window.scrollY > 24"
    @scroll.window.passive="scrolled = window.scrollY > 24"
    @keydown.escape.window="shop = false; mobile = false"
    class="fixed top-0 inset-x-0 z-50 px-3 sm:px-6 transition-[padding] duration-300"
    :class="scrolled ? 'pt-3' : 'pt-1'">

    {{-- Soft dim behind the panel (does not block the mouse) --}}
    <div x-cloak x-show="shop" x-transition.opacity.duration.200ms
         class="fixed inset-0 -z-10 bg-ink/25 backdrop-blur-[2px] pointer-events-none"></div>

    <div class="relative mx-auto max-w-6xl">

        {{-- ================= Bar ================= --}}
        <div class="flex items-center gap-1 transition-all duration-300 ease-out"
             :class="scrolled || shop || mobile
                ? 'h-[60px] px-3 rounded-full border border-white/80 bg-gradient-to-b from-white/95 to-cream/85 backdrop-blur-xl shadow-[0_10px_30px_-12px_rgba(74,21,48,.28)]'
                : 'h-20 px-2 border border-transparent'">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="shrink-0 flex items-center mr-2 md:mr-4" aria-label="Al-Asra Online Store, home">
                <img src="{{ $logo }}" alt="Al-Asra" class="h-9 w-auto transition-all duration-300" :class="scrolled ? 'h-8' : 'h-10'"
                     onerror="this.replaceWith(Object.assign(document.createElement('span'),{className:'font-serif text-xl text-plum',textContent:'Al-Asra'}))">
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-1" aria-label="Main">

                {{-- Shop (opens panel on hover / focus / click) --}}
                <div @mouseenter="openShop()" @mouseleave="closeShop()" class="relative">
                    <a href="{{ $shopUrl }}"
                       @click.prevent="shop = !shop; if (!shop) window.location = '{{ $shopUrl }}'"
                       @focus="openShop()"
                       aria-haspopup="true" :aria-expanded="shop"
                       class="{{ $link }} inline-flex items-center gap-1.5 {{ request()->is('shop*') ? $on : $idle }}"
                       :class="shop ? 'bg-rose-100/70' : ''">
                        Shop
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="shop ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                    </a>
                </div>

                @foreach($navLinks as $l)
                    <a href="{{ $l['href'] }}" @mouseenter="closeShop()"
                       class="{{ $link }} {{ request()->is($l['match']) ? $on : $idle }}">{{ $l['label'] }}</a>
                @endforeach
            </nav>

            <div class="flex-1"></div>

            {{-- Search (desktop) --}}
            <form action="{{ $shopUrl }}" method="GET" role="search" class="hidden lg:block mr-2" @mouseenter="closeShop()">
                <label for="nav-search" class="sr-only">Search products</label>
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-black/40 pointer-events-none" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
                    <input id="nav-search" type="search" name="q" placeholder="Search products"
                           class="w-56 h-10 rounded-full bg-black/[.06] pl-10 pr-4 text-sm placeholder:text-black/40 focus:outline-none focus:bg-white focus:ring-4 focus:ring-rose/15 transition-all focus:w-64">
                </div>
            </form>

            {{-- Bag --}}
            <a href="{{ $cartUrl }}" @mouseenter="closeShop()"
               class="inline-flex items-center gap-2 h-10 pl-5 pr-3 rounded-full bg-rose text-white text-sm font-semibold hover:bg-rose-600 active:scale-[.98] transition">
                Bag
                <span class="min-w-[22px] h-[22px] px-1.5 rounded-full bg-white text-rose-600 text-xs font-bold flex items-center justify-center">{{ $cartCount }}</span>
            </a>

            {{-- Mobile menu button --}}
            <button type="button" @click="mobile = !mobile" :aria-expanded="mobile" aria-label="Menu"
                    class="md:hidden ml-1 w-10 h-10 rounded-full flex items-center justify-center text-ink hover:bg-rose-100/60 transition">
                <svg x-show="!mobile" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg x-cloak x-show="mobile" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        </div>

        {{-- ================= Shop mega panel (desktop) ================= --}}
        <div x-cloak x-show="shop"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-1"
             @mouseenter="openShop()" @mouseleave="closeShop()"
             class="hidden md:block absolute left-0 right-0 top-full pt-3">

            <div class="rounded-[2rem] border border-white/80 bg-white/95 backdrop-blur-xl shadow-[0_30px_70px_-30px_rgba(74,21,48,.45)] p-8 grid lg:grid-cols-[1fr_240px] gap-10">

                {{-- Categories --}}
                <div>
                    <p class="font-serif text-2xl text-ink mb-5">Shop by category</p>
                    <ul class="grid grid-cols-3 xl:grid-cols-6 gap-x-4 gap-y-6">
                        @foreach($navCategories as $c)
                            <li>
                                <a href="{{ route('shop', ['category' => $c['slug']]) }}" class="group block text-center focus:outline-none">
                                    <span class="block aspect-square rounded-2xl bg-cream overflow-hidden flex items-center justify-center transition group-hover:bg-blush group-focus-visible:ring-4 group-focus-visible:ring-rose/30">
                                        @if(!empty($c['image']))
                                            <img src="{{ $c['image'] }}" alt="" loading="lazy" class="w-full h-full object-contain p-3 transition-transform duration-300 group-hover:scale-105">
                                        @else
                                            <span class="font-serif text-4xl text-rose transition-transform duration-300 group-hover:scale-110">{{ mb_substr($c['name'], 0, 1) }}</span>
                                        @endif
                                    </span>
                                    <span class="block mt-2.5 text-sm font-medium text-ink group-hover:text-rose-600 transition">{{ $c['name'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Quick links --}}
                <div class="lg:border-l lg:border-black/10 lg:pl-8">
                    <p class="text-sm font-semibold text-muted mb-3">Quick links</p>
                    <ul class="space-y-1 text-[15px]">
                        <li><a href="{{ $shopUrl }}" class="block rounded-xl px-3 py-2 -mx-3 hover:bg-cream transition">All products</a></li>
                        <li><a href="{{ route('shop', ['sort' => 'new']) }}" class="block rounded-xl px-3 py-2 -mx-3 hover:bg-cream transition">New arrivals</a></li>
                        <li><a href="{{ route('shop', ['sort' => 'popular']) }}" class="block rounded-xl px-3 py-2 -mx-3 hover:bg-cream transition">Best sellers</a></li>
                        <li><a href="{{ url('/track') }}" class="block rounded-xl px-3 py-2 -mx-3 hover:bg-cream transition">Track your order</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- ================= Mobile menu ================= --}}
        <div x-cloak x-show="mobile" x-transition.opacity.duration.150ms
             class="md:hidden absolute left-0 right-0 top-full pt-3">
            <div class="rounded-3xl border border-white/80 bg-white/95 backdrop-blur-xl shadow-[0_30px_70px_-30px_rgba(74,21,48,.45)] p-3 max-h-[75vh] overflow-y-auto">

                <form action="{{ $shopUrl }}" method="GET" role="search" class="p-2">
                    <label for="nav-search-m" class="sr-only">Search products</label>
                    <input id="nav-search-m" type="search" name="q" placeholder="Search products"
                           class="w-full h-11 rounded-full bg-black/[.06] px-5 text-base placeholder:text-black/40 focus:outline-none focus:bg-white focus:ring-4 focus:ring-rose/15 transition">
                </form>

                <button type="button" @click="mobileShop = !mobileShop" :aria-expanded="mobileShop"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-2xl font-semibold text-ink hover:bg-cream transition">
                    Shop
                    <svg class="w-4 h-4 transition-transform duration-200" :class="mobileShop ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <div x-cloak x-show="mobileShop" x-transition.opacity.duration.150ms class="px-2 pb-2">
                    <ul class="grid grid-cols-2 gap-2 pt-1">
                        <li class="col-span-2"><a href="{{ $shopUrl }}" class="block rounded-xl bg-cream px-4 py-2.5 text-sm font-medium">All products</a></li>
                        @foreach($navCategories as $c)
                            <li><a href="{{ route('shop', ['category' => $c['slug']]) }}" class="block rounded-xl bg-cream/70 px-4 py-2.5 text-sm hover:bg-blush transition">{{ $c['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>

                @foreach($navLinks as $l)
                    <a href="{{ $l['href'] }}"
                       class="block px-4 py-3 rounded-2xl font-semibold transition {{ request()->is($l['match']) ? 'bg-rose-100 text-rose-600' : 'text-ink hover:bg-cream' }}">{{ $l['label'] }}</a>
                @endforeach
            </div>
        </div>
    </div>
</header>