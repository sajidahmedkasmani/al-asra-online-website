<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>document.documentElement.classList.add('lock')</script>
        <title>@yield('title', setting('store_brand_name', 'Al-Asra Store').' | Organic & Original, Delivered in Pakistan')</title>
        <meta name="description" content="Premium organic, imported and natural care products. Delivered across Pakistan.">
        <link rel="icon" href="/logo.png"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@500;700&family=DM+Sans:wght@400;500;700&family=Anton&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/css/storefront-original.css">
        <style>
            /* Laravel storefront wiring; visual rules remain from the supplied original stylesheet. */
            .nav{position:sticky;top:0;z-index:80}.brand img{height:42px;width:auto;object-fit:contain}.brand{display:flex;align-items:center}.announce{background:#4A1530;color:#fff;text-align:center;padding:9px 12px;font-size:11px;letter-spacing:.04em}.search input{border:1px solid #e9e3dd;border-radius:30px;padding:10px 14px;width:180px}.header-actions{display:flex;align-items:center;gap:14px}.header-icon{position:relative;display:inline-flex;align-items:center;justify-content:center;color:#4A1530}.header-icon svg{width:20px;height:20px}.header-icon span{position:absolute;top:-8px;right:-10px;background:#F24C00;color:#fff;border-radius:50%;min-width:16px;height:16px;padding:0 4px;font-size:10px;display:flex;align-items:center;justify-content:center}.cartbtn{border:1px solid #e9e3dd;border-radius:30px;background:#fff;padding:10px 17px;cursor:pointer}.cartbtn span{background:#F24C00;color:white;border-radius:50%;padding:2px 7px;margin-left:5px}.drawer{position:fixed;z-index:999;right:0;top:0;height:100dvh;width:min(420px,100vw);background:#fff;box-shadow:-20px 0 60px #0002;transform:translateX(105%);transition:transform .35s;display:flex;flex-direction:column;padding:24px}.drawer.open{transform:none}.drawer-top{display:flex;justify-content:space-between;align-items:center}.drawer-lines{overflow:auto;flex:1}.drawer-line{display:flex;gap:12px;align-items:center;padding:14px 0;border-bottom:1px solid #eee}.drawer-line img{width:64px;height:64px;object-fit:contain;background:#f7f4f0;border-radius:10px}.drawer-line div{flex:1}.drawer-line button{border:0;background:#f5f1ed;padding:6px 10px;cursor:pointer}.scrim{position:fixed;inset:0;background:#0007;z-index:998;opacity:0;pointer-events:none;transition:.3s}.scrim.open{opacity:1;pointer-events:auto}.ah-static .ah-item{pointer-events:none}.ah-static .ah-item:nth-child(1){left:30%;height:30%;bottom:12%;transform:translateX(-50%)}.ah-static .ah-item:nth-child(2){left:50%;height:82%;bottom:0;z-index:20;transform:translateX(-50%) scale(1.12)}.ah-static .ah-item:nth-child(3){left:70%;height:30%;bottom:12%;transform:translateX(-50%)}.ah-static .ah-cta{font-family:Anton,sans-serif}.hero-fallback{min-height:68vh;display:grid;place-items:center;background:#f6f1ea;text-align:center;padding:40px}.hero-fallback img{max-height:55vh;max-width:40vw;object-fit:contain}.hero-fallback h1{color:#5F1E29}.chips button{border:1px solid #e8dfd8;border-radius:30px;background:#fff;padding:9px 17px;margin:4px;cursor:pointer}.chips button.on{background:#4A1530;color:white}.pgrid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:20px}.pcard .pic{display:block;aspect-ratio:1/1;background:#f7f4f0;border-radius:14px;overflow:hidden}.pcard .pic img{width:100%;height:100%;object-fit:contain;padding:12px}.pcard .prow{display:flex;align-items:center;justify-content:space-between;gap:8px}.pcard .addbag{border:1px solid #4A1530;color:#4A1530;background:#fff;border-radius:30px;padding:8px 13px;cursor:pointer}.pcard .addbag:hover{background:#4A1530;color:#fff}.obnd{padding:70px 7%}.obnd .obt{max-width:520px}.obv{display:flex;gap:20px;justify-content:center}.obv img{width:min(20vw,220px);height:280px;object-fit:contain}.foot-logo{max-width:150px;max-height:60px;object-fit:contain}.foot a{display:block;margin:7px 0}.story-cards{padding:20px 4vw}.ex-wrap{margin:24px auto;max-width:1100px}.ex{border-radius:24px;background:#f7f4f0;padding:40px;display:grid;grid-template-columns:1fr 1fr;gap:25px;align-items:center;min-height:300px}.ex-art{display:flex;gap:10px;justify-content:center}.ex-art img{width:28%;height:190px;object-fit:contain}.pmq img{height:170px;width:170px}.mobile-menu{display:none}@media(max-width:850px){.search{display:none}.pgrid{grid-template-columns:repeat(2,minmax(0,1fr))}.ex{grid-template-columns:1fr}.ah-static .ah-item:nth-child(1){left:20%;height:20%}.ah-static .ah-item:nth-child(2){height:58%}.ah-static .ah-item:nth-child(3){left:80%;height:20%}}@media(max-width:560px){.pgrid{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.pcard{padding:8px}.pcard h3{font-size:13px}.pcard .addbag{font-size:11px;padding:7px}.ex{padding:24px}.obnd{grid-template-columns:1fr;padding:45px 7%}.obv img{height:170px}.ah-stage{min-height:500px}.ah-static .ah-item:nth-child(1),.ah-static .ah-item:nth-child(3){height:15%}.ah-static .ah-item:nth-child(2){height:48%}}
            .loader.active{visibility:visible;opacity:1}.loader:not(.active){visibility:hidden;opacity:0;pointer-events:none}
            .is-hidden{display:none!important}.store-toast{position:fixed;left:50%;bottom:24px;z-index:1000;max-width:calc(100vw - 32px);padding:12px 18px;border-radius:12px;background:#2A1420;color:#fff;font-size:14px;opacity:0;pointer-events:none;transform:translate(-50%,12px);transition:opacity .2s,transform .2s}.store-toast.show{opacity:1;transform:translate(-50%,0)}.store-toast.error{background:#9f2d20}.store-flash{max-width:1200px;margin:16px auto 0;padding:12px 18px;border-radius:12px;font-size:14px}.store-flash.success{background:#edf8ef;border:1px solid #bee6c5;color:#226334}.store-flash.error{background:#fff1ef;border:1px solid #f0c4bd;color:#8a2c20}
            /* ===== Header: flat at top, floating glossy pill on scroll, Shop hover panel ===== */
            .sh{position:sticky;top:0;z-index:80;height:76px;display:block;margin:0;padding:0;border:0;background:none;pointer-events:none;font-family:'DM Sans',Inter,sans-serif}
            .sh *,.sh *::before,.sh *::after{box-sizing:border-box}
            .sh a{text-decoration:none}
            .sh-bg{position:absolute;inset:0;background:#fff;border-bottom:1px solid #eee5dc;transition:opacity .3s}
            .sh-wrap{position:relative;max-width:1200px;height:100%;margin:0 auto;padding:0 16px}
            .sh-bar{pointer-events:auto;position:relative;display:flex;align-items:center;gap:6px;height:76px;padding:0 8px;border:1px solid transparent;border-radius:0;background:transparent;transition:height .3s,margin .3s,padding .3s,border-radius .3s,background .3s,box-shadow .3s}
            .sh.is-scrolled .sh-bg,.sh.shop-open .sh-bg,.sh.m-open .sh-bg{opacity:0}
            .sh.is-scrolled .sh-bar,.sh.shop-open .sh-bar,.sh.m-open .sh-bar{height:58px;margin-top:9px;padding:0 10px 0 16px;border-color:rgba(255,255,255,.9);border-radius:999px;background:linear-gradient(180deg,rgba(255,255,255,.96),rgba(255,244,234,.88));-webkit-backdrop-filter:blur(18px) saturate(1.4);backdrop-filter:blur(18px) saturate(1.4);box-shadow:0 10px 30px -12px rgba(74,21,48,.3)}
            .sh-brand{display:flex;align-items:center;margin-right:10px;flex:none}
            .sh-brand img{height:40px;width:auto;object-fit:contain;transition:height .3s}
            .sh.is-scrolled .sh-brand img,.sh.shop-open .sh-brand img,.sh.m-open .sh-brand img{height:32px}
            .sh-nav{display:flex;align-items:center;gap:2px}
            .sh .sh-link{display:inline-flex;align-items:center;gap:6px;margin:0;padding:9px 16px;border-radius:999px;color:#2A1420;font-size:14px;font-weight:600;line-height:1;transition:background .2s,color .2s}
            .sh .sh-link:hover,.sh.shop-open #sh-shoplink{background:rgba(255,194,161,.4)}
            .sh .sh-link.on{background:#FFE1D0;color:#D94100}
            .sh-chev{width:13px;height:13px;transition:transform .2s}
            .sh.shop-open .sh-nav .sh-chev{transform:rotate(180deg)}
            .sh-grow{flex:1}
            .sh-search{position:relative;display:flex;align-items:center;margin:0 6px 0 0}
            .sh-search svg{position:absolute;left:14px;width:16px;height:16px;color:rgba(0,0,0,.4);pointer-events:none}
            .sh-search input{width:200px;height:40px;padding:0 16px 0 38px;border:0;border-radius:999px;background:rgba(0,0,0,.06);color:#2A1420;font:inherit;font-size:14px;outline:0;transition:width .25s,background .2s,box-shadow .2s}
            .sh-search input:focus{width:250px;background:#fff;box-shadow:0 0 0 4px rgba(242,76,0,.15)}
            .sh-icon{position:relative;display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;color:#4A1530;transition:background .2s}
            .sh-icon:hover{background:rgba(255,194,161,.4)}
            .sh-icon svg{width:20px;height:20px}
            .sh-icon span{position:absolute;top:2px;right:0;min-width:16px;height:16px;padding:0 4px;border-radius:999px;background:#F24C00;color:#fff;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center}
            .sh-bag{display:inline-flex;align-items:center;gap:8px;height:40px;margin-left:4px;padding:0 8px 0 18px;border:0;border-radius:999px;background:#F24C00;color:#fff;font:inherit;font-size:14px;font-weight:700;cursor:pointer;transition:background .2s,transform .15s}
            .sh-bag:hover{background:#D94100}.sh-bag:active{transform:scale(.98)}
            .sh-bag span{min-width:24px;height:24px;padding:0 6px;margin:0;border-radius:999px;background:#fff;color:#D94100;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center}
            .sh a:focus-visible,.sh button:focus-visible,.sh input:focus-visible{outline:3px solid rgba(242,76,0,.45);outline-offset:2px}
            .sh-burger{display:none;width:40px;height:40px;margin:0 4px 0 -4px;padding:0;border:0;border-radius:50%;background:transparent;color:#2A1420;align-items:center;justify-content:center;cursor:pointer}
            .sh-burger svg{width:22px;height:22px}
            .sh-burger path{transform-origin:12px 12px;transition:transform .25s,opacity .2s}
            .sh.m-open .sh-b1{transform:translateY(5px) rotate(45deg)}
            .sh.m-open .sh-b2{opacity:0}
            .sh.m-open .sh-b3{transform:translateY(-5px) rotate(-45deg)}

            /* Shop panel */
            .sh-panel{position:absolute;left:16px;right:16px;top:60px;padding-top:16px;visibility:hidden;opacity:0;transform:translateY(-8px);pointer-events:none;transition:opacity .2s,transform .2s,visibility 0s .2s}
            .sh.shop-open .sh-panel{visibility:visible;opacity:1;transform:none;pointer-events:auto;transition:opacity .2s,transform .2s}
            .sh-card{display:grid;grid-template-columns:1fr 230px;gap:36px;padding:30px;border:1px solid rgba(255,255,255,.9);border-radius:28px;background:rgba(255,255,255,.97);-webkit-backdrop-filter:blur(18px);backdrop-filter:blur(18px);box-shadow:0 30px 70px -30px rgba(74,21,48,.45)}
            .sh-title{margin:0 0 20px;font-family:Unbounded,'DM Sans',sans-serif;font-size:17px;font-weight:500;color:#2A1420}
            .sh-cats{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:20px 16px;margin:0;padding:0;list-style:none}
            .sh .sh-cat{display:block;text-align:center;color:#2A1420}
            .sh-tile{display:flex;align-items:center;justify-content:center;aspect-ratio:1/1;overflow:hidden;border-radius:18px;background:#f7f4f0;transition:background .2s}
            .sh-tile img{width:100%;height:100%;object-fit:contain;padding:12px;transition:transform .3s}
            .sh-tile b{font-family:Unbounded,'DM Sans',sans-serif;font-size:28px;font-weight:500;color:#F24C00;transition:transform .3s}
            .sh-cat:hover .sh-tile,.sh-cat:focus-visible .sh-tile{background:#FFD9C2}
            .sh-cat:hover .sh-tile img,.sh-cat:hover .sh-tile b{transform:scale(1.08)}
            .sh-catname{display:block;margin-top:10px;font-size:14px;font-weight:600}
            .sh-cat:hover .sh-catname{color:#D94100}
            .sh-quick{padding-left:30px;border-left:1px solid rgba(0,0,0,.08)}
            .sh-qt{margin:0 0 10px;font-size:13px;font-weight:700;color:#6B5960}
            .sh .sh-quick a{display:block;margin:0 -12px;padding:9px 12px;border-radius:12px;color:#2A1420;font-size:15px;transition:background .2s}
            .sh .sh-quick a:hover{background:#FFF4EA}

            /* Mobile */
            .sh-mobile{display:none}
            @media(max-width:1000px){.sh-search{display:none}}
            @media(max-width:850px){
            .sh-nav,.sh-panel{display:none}
            .sh-burger{display:inline-flex}
            .sh-bar{height:64px}
            .sh{height:64px}
            .sh.is-scrolled .sh-bar,.sh.shop-open .sh-bar,.sh.m-open .sh-bar{height:54px;margin-top:6px;padding:0 8px 0 12px}
            .sh-wrap{padding:0 10px}
            .sh-brand{margin-right:0}.sh-brand img{height:34px}
            .sh-bag{padding:0 6px 0 14px}
            .sh-mobile{position:absolute;left:10px;right:10px;top:64px;max-height:calc(100dvh - 80px);overflow-y:auto;padding:10px;border:1px solid rgba(255,255,255,.9);border-radius:24px;background:rgba(255,255,255,.98);box-shadow:0 30px 70px -30px rgba(74,21,48,.45);pointer-events:auto;display:block;visibility:hidden;opacity:0;transform:translateY(-6px);transition:opacity .2s,transform .2s,visibility 0s .2s}
            .sh.m-open .sh-mobile{visibility:visible;opacity:1;transform:none;transition:opacity .2s,transform .2s}
            .sh-msearch{margin:4px 4px 8px}
            .sh-msearch input{width:100%;height:44px;padding:0 18px;border:0;border-radius:999px;background:rgba(0,0,0,.06);font:inherit;font-size:16px;outline:0}
            .sh-macc,.sh .sh-mlink{display:flex;align-items:center;justify-content:space-between;width:100%;padding:14px 16px;border:0;border-radius:16px;background:transparent;color:#2A1420;font:inherit;font-size:15px;font-weight:700;text-align:left;cursor:pointer}
            .sh-macc:hover,.sh .sh-mlink:hover{background:#FFF4EA}
            .sh-macc[aria-expanded="true"] .sh-chev{transform:rotate(180deg)}
            .sh-mcats{display:none;grid-template-columns:1fr 1fr;gap:8px;padding:2px 6px 10px}
            .sh-mcats.open{display:grid}
            .sh .sh-mcats a{padding:11px 14px;border-radius:14px;background:#f7f4f0;color:#2A1420;font-size:14px;font-weight:500}
            .sh .sh-mcats a.sh-mall{grid-column:1/-1;background:#FFE1D0;color:#B83700;font-weight:700}
            }
            @media(prefers-reduced-motion:reduce){.sh *,.sh-bg{transition-duration:.01ms!important}}
        </style>
        @stack('head')
    </head>

    <body>
        <div class="loader active" id="page-loader" role="status" aria-live="polite" aria-label="Loading page">
        <div class="lmid"><div class="lwrap"><svg class="lcart" style="left:0" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M3 4h2l2.2 11.2a2 2 0 0 0 2 1.6h8.5a2 2 0 0 0 1.9-1.4L21 8H6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20" r="1.5" fill="currentColor"/><circle cx="18" cy="20" r="1.5" fill="currentColor"/></svg><div class="lbar"><i style="transform:scaleX(0)"></i></div></div><div class="lnum">0%</div></div>
        </div>
        @if((string) setting('store_announcement_enabled', '1') === '1')
        <div class="announce">{{ setting('store_announcement_text', 'Free delivery on orders over PKR 10,000 · Cash on delivery across Pakistan') }}</div>
        @endif
        @php
            // ---- EDIT HERE: categories shown in the Shop hover panel -----------------
            // slug must match your real category slug (it opens /shop?category=<slug>).
            // 'image' is optional (e.g. '/images/cats/kitchen.png'); without it a letter tile shows.
            $navCategories = $navCategories ?? [
                ['name' => 'Kitchen',   'slug' => 'kitchen',   'image' => null],
                ['name' => 'Home',      'slug' => 'home',      'image' => null],
                ['name' => 'Drinkware', 'slug' => 'drinkware', 'image' => null],
                ['name' => 'Gadgets',   'slug' => 'gadgets',   'image' => null],
                ['name' => 'Gifts',     'slug' => 'gifts',     'image' => null],
                ['name' => 'Travel',    'slug' => 'travel',    'image' => null],
            ];
            $wishCount = count(array_unique(array_map('intval', session('wishlist', []))));
        @endphp
        <header class="sh" id="site-header">
            <div class="sh-bg"></div>
            <div class="sh-wrap">

            <div class="sh-bar">
                <button class="sh-burger" id="sh-burger" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="sh-mobile">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path class="sh-b1" d="M4 7h16"/><path class="sh-b2" d="M4 12h16"/><path class="sh-b3" d="M4 17h16"/></svg>
            </button>

            <a href="/" class="sh-brand"><img src="/logo.png" alt="{{ setting('store_brand_name', 'Al-Asra Store') }}"></a>

            <nav class="sh-nav" aria-label="Main">
                <a href="{{ route('home') }}" class="sh-link {{ request()->routeIs('home') ? 'on' : '' }}">Home</a>
                <a href="{{ route('aboutus') }}" class="sh-link {{ request()->routeIs('aboutus') ? 'on' : '' }}">About us</a>
                <a href="{{ route('shop') }}" id="sh-shoplink" class="sh-link {{ request()->is('shop*') ? 'on' : '' }}" aria-haspopup="true" aria-expanded="false" aria-controls="sh-panel">Shop
                    <svg class="sh-chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </a>
                <!-- <a href="{{ route('customer.dashboard') }}" class="sh-link {{ request()->routeIs('customer.dashboard') ? 'on' : '' }}">Track order</a> -->
                <a href="{{ route('blogs') }}" class="sh-link {{ request()->routeIs('blogs') ? 'on' : '' }}">Blogs</a>
                <a href="{{ route('contact') }}" class="sh-link {{ request()->routeIs('contact') ? 'on' : '' }}">Contact</a>
            </nav>

            <span class="sh-grow"></span>

            <form class="sh-search" action="/shop" role="search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
            <input name="q" placeholder="Search products" aria-label="Search products">
            </form>

            <a href="{{ route('wishlist.index') }}" class="sh-icon" aria-label="Wishlist, {{ $wishCount }} items">
            <svg fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7-4.6-9.3-9A5.3 5.3 0 0 1 12 6a5.3 5.3 0 0 1 9.3 6C19 16.4 12 21 12 21Z"/></svg>
            <span id="wishlist-count" class="{{ $wishCount ? '' : 'is-hidden' }}">{{ $wishCount }}</span>
            </a>
            <a href="{{ auth('customer')->check() ? route('customer.dashboard') : route('customer.login') }}" class="sh-icon" aria-label="{{ auth('customer')->check() ? 'My account' : 'Log in' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </a>
            <button class="sh-bag" type="button" onclick="AlAsraCart.open()">Bag <span id="bag-count">0</span></button>
            </div>

            {{-- Shop hover panel (desktop) --}}
            <div class="sh-panel" id="sh-panel" role="region" aria-label="Shop categories">
                <div class="sh-card">
                    <div>
                        <p class="sh-title">Shop by category</p>
                        <ul class="sh-cats">
                            @foreach($navCategories as $c)
                                <li>
                                    <a href="{{ route('shop', ['category' => $c['slug']]) }}" class="sh-cat">
                                    <span class="sh-tile">@if(!empty($c['image']))<img src="{{ $c['image'] }}" alt="" loading="lazy">@else<b>{{ mb_substr($c['name'], 0, 1) }}</b>@endif</span>
                                    <span class="sh-catname">{{ $c['name'] }}</span></a>
                                </li>
                            @endforeach
                        </ul>
                        </div>
                        <div class="sh-quick">
                        <p class="sh-qt">Quick links</p>
                        <a href="{{ route('shop') }}">All products</a>
                        <a href="{{ route('wishlist.index') }}">Wishlist</a>
                        <a href="{{ route('customer.dashboard') }}">Track your order</a>
                        <a href="{{ route('contact') }}">Contact us</a>
                    </div>
                </div>
            </div>

            {{-- Mobile menu --}}
            <div class="sh-mobile" id="sh-mobile">
                <form class="sh-msearch" action="/shop" role="search"><input name="q" placeholder="Search products" aria-label="Search products"></form>
                <button type="button" class="sh-macc" id="sh-macc" aria-expanded="false">Shop
                <svg class="sh-chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg></button>
                <div class="sh-mcats" id="sh-mcats">
                    <a href="{{ route('shop') }}" class="sh-mall">All products</a>
                    @foreach($navCategories as $c)
                    <a href="{{ route('shop', ['category' => $c['slug']]) }}">{{ $c['name'] }}</a>
                    @endforeach
                </div>
                <a href="{{ route('aboutus') }}" class="sh-mlink">About</a>
                <a href="{{ route('customer.dashboard') }}" class="sh-mlink">Track order</a>
                <a href="{{ route('faqs') }}" class="sh-mlink">FAQ</a>
                <a href="{{ route('contact') }}" class="sh-mlink">Contact</a>
            </div>

            </div>
        </header>

        @if(session('success'))
            <div class="store-flash success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="store-flash error">{{ session('error') }}</div>
        @endif

        <main>@yield('content')</main>

        <footer class="foot">
            <div class="fgrid">
            <div>
                <img class="foot-logo" src="/logo.png" alt="{{ setting('store_brand_name', 'Al-Asra Store') }}">
                <p>{{ setting('store_footer_about', 'Organic, original and imported products. Delivered across Pakistan.') }}</p>
            </div>

            <div>
                <h4>{{ setting('store_footer_shop_title', 'Shop') }}</h4>
                @php
                    $shopFooterLinksValue = setting('store_footer_shop_links');
                    $shopFooterLinks = $shopFooterLinksValue === null ? null : json_decode($shopFooterLinksValue, true);
                    if (!is_array($shopFooterLinks)) {
                        $shopFooterLinks = [
                            ['text' => setting('store_footer_shop_link_1_text', 'All products'), 'url' => setting('store_footer_shop_link_1_url', '/shop')],
                            ['text' => setting('store_footer_shop_link_2_text', 'Organic'), 'url' => setting('store_footer_shop_link_2_url', '/shop?category=organic')],
                            ['text' => setting('store_footer_shop_link_3_text', 'Natural care'), 'url' => setting('store_footer_shop_link_3_url', '/shop?category=natural-care')],
                        ];
                    }
                @endphp
                @foreach($shopFooterLinks as $link)
                    @if(!empty($link['text']) && !empty($link['url']))
                        <a href="{{ $link['url'] }}">{{ $link['text'] }}</a>
                    @endif
                @endforeach
            </div>

            <div>
                <h4>{{ setting('store_footer_help_title', 'Help') }}</h4>
                @php
                    $helpFooterLinksValue = setting('store_footer_help_links');
                    $helpFooterLinks = $helpFooterLinksValue === null ? null : json_decode($helpFooterLinksValue, true);
                    if (!is_array($helpFooterLinks)) {
                        $helpFooterLinks = [
                            ['text' => setting('store_footer_help_link_1_text', 'Track order'), 'url' => setting('store_footer_help_link_1_url', route('customer.dashboard'))],
                            ['text' => setting('store_footer_help_link_2_text', 'About us'), 'url' => setting('store_footer_help_link_2_url', route('aboutus'))],
                            ['text' => setting('store_footer_help_link_3_text', 'Contact'), 'url' => setting('store_footer_help_link_3_url', route('contact'))],
                        ];
                    }
                @endphp
                @foreach($helpFooterLinks as $link)
                    @if(!empty($link['text']) && !empty($link['url']))
                        <a href="{{ $link['url'] }}">{{ $link['text'] }}</a>
                    @endif
                @endforeach
            </div>
            <div>
                <h4>{{ setting('store_footer_contact_title', 'Reach us') }}</h4>
                <p>{{ setting('store_footer_address', 'Karachi, Pakistan') }}<br>{{ setting('store_footer_phone', '+92 315 9259927') }}<br>{{ setting('store_footer_email', 'support@alasra.online') }}<br>{{ setting('store_footer_hours', 'Mon–Sat, 11:00am–8:30pm') }}</p>
                <a href="{{ setting('store_footer_instagram_url', 'https://instagram.com/alasra.onlinestore') }}">{{ setting('store_footer_instagram_label', 'Instagram @alasra.onlinestore') }}</a></div>
            </div>

            <div class="fbase">© {{ date('Y') }} {{ setting('store_footer_copyright', 'Al-Asra Store. All rights reserved.') }} <span>Cash on delivery · Bank transfer</span></div>
        </footer>

        <div class="scrim" id="cart-scrim" onclick="AlAsraCart.close()"></div>
        <aside class="drawer" id="cart-drawer" aria-hidden="true">
            <div class="drawer-top">
                <h3>Your bag (<span id="drawer-count">0</span>)</h3>
                <button onclick="AlAsraCart.close()" aria-label="Close cart">✕</button>
            </div>
            <p id="ship-msg">Add PKR 10,000 more for free delivery</p>
            <div class="drawer-lines" id="drawer-lines"></div>
            <div class="sum">
                <span>Subtotal</span>
                <b id="drawer-total">PKR 0</b>
            </div>
            <a class="btn" href="/checkout">Checkout</a><a class="btn ghost" href="/cart">View bag</a>
        </aside>

        <div id="store-toast" class="store-toast" role="status" aria-live="polite"></div>

        <script>
            const freeShippingThreshold={{ (int) setting('free_shipping_threshold', 10000) }};
            const standardShippingFee={{ (int) setting('shipping_fee', 250) }};
            window.AlAsraCart=(()=>{const key='alasra-cart';const read=()=>{try{return JSON.parse(localStorage.getItem(key)||'[]')}catch{return[]}};const money=n=>'PKR '+Math.round(n).toLocaleString('en-PK');const summary=()=>{const a=read(),subtotal=a.reduce((s,x)=>s+x.price*x.qty,0),shipping=subtotal>0&&subtotal<freeShippingThreshold?standardShippingFee:0;return{count:a.reduce((s,x)=>s+x.qty,0),subtotal,shipping,total:subtotal+shipping,amountUntilFree:Math.max(0,freeShippingThreshold-subtotal),shippingProgress:freeShippingThreshold>0?Math.min(100,Math.round(subtotal/freeShippingThreshold*100)):100}};const save=a=>{localStorage.setItem(key,JSON.stringify(a));render()};const render=()=>{let a=read(),count=a.reduce((s,x)=>s+x.qty,0),total=a.reduce((s,x)=>s+x.price*x.qty,0);document.querySelectorAll('#bag-count,#drawer-count').forEach(x=>x.textContent=count);document.getElementById('drawer-total').textContent=money(total);document.getElementById('ship-msg').textContent=total>=freeShippingThreshold?'You get free delivery':'Add '+money(freeShippingThreshold-total)+' more for free delivery';document.getElementById('drawer-lines').innerHTML=a.length?a.map(x=>`<div class="drawer-line"><img src="${x.image}" alt=""><div><b>${x.name}</b><small>${money(x.price)}</small><div><button onclick="AlAsraCart.qty('${x.id}',-1)">−</button> ${x.qty} <button onclick="AlAsraCart.qty('${x.id}',1)">+</button></div></div><button onclick="AlAsraCart.remove('${x.id}')">✕</button></div>`).join(''):'<p class="empty">Your bag is empty. Add something from the shop.</p>'};return{read,summary,render,save,add(p,quantity=1){let a=read(),x=a.find(i=>String(i.id)===String(p.id)),amount=Math.max(1,Math.min(99,Number(quantity)||1));if(x)x.qty=Math.min(99,x.qty+amount);else a.push({...p,qty:amount});save(a);this.open()},qty(id,d){save(read().map(x=>String(x.id)===String(id)?{...x,qty:x.qty+d}:x).filter(x=>x.qty>0))},setQty(id,qty){save(read().map(x=>String(x.id)===String(id)?{...x,qty:Math.max(1,Math.min(99,Number(qty)||1))}:x))},remove(id){save(read().filter(x=>String(x.id)!==String(id)))},async sync(){const response=await fetch(@json(route('cart.sync')),{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},body:JSON.stringify({items:read().map(x=>({id:Number(x.id),qty:Number(x.qty)}))})});const data=await response.json();if(!response.ok)throw new Error(data.message||'Unable to update your cart. Please try again.');const items=Object.values(data.cart||{}).map(x=>({id:x.id,name:x.name,price:Number(x.price),image:x.image,qty:Number(x.quantity)}));save(items);return data},open(){document.getElementById('cart-drawer').classList.add('open');document.getElementById('cart-scrim').classList.add('open')},close(){document.getElementById('cart-drawer').classList.remove('open');document.getElementById('cart-scrim').classList.remove('open')}}})();document.addEventListener('DOMContentLoaded',AlAsraCart.render);
        </script>

        <script>
            (() => {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
                const toast = document.getElementById('store-toast');
                let toastTimer;
                const showMessage = (message, isError = false) => {
                    toast.textContent = message;
                    toast.classList.toggle('error', isError);
                    toast.classList.add('show');
                    clearTimeout(toastTimer);
                    toastTimer = setTimeout(() => toast.classList.remove('show'), 3500);
                };

                document.addEventListener('click', async (event) => {
                    const wishlistButton = event.target.closest('[data-wishlist-toggle]');
                    if (wishlistButton) {
                        try {
                            const response = await fetch(@json(url('/wishlist')) + '/' + wishlistButton.dataset.productId + '/toggle', {
                                method: 'POST',
                                headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf},
                            });
                            const data = await response.json();
                            if (!response.ok) throw new Error(data.message || 'Could not update your wishlist.');
                            document.querySelectorAll(`[data-wishlist-toggle][data-product-id="${wishlistButton.dataset.productId}"]`).forEach((button) => {
                                button.setAttribute('aria-pressed', data.added ? 'true' : 'false');
                                button.setAttribute('aria-label', data.added ? 'Remove from wishlist' : 'Add to wishlist');
                                button.classList.toggle('text-rose', data.added);
                                button.classList.toggle('text-ink/70', !data.added);
                                button.querySelector('svg')?.setAttribute('fill', data.added ? 'currentColor' : 'none');
                                const label = button.querySelector('[data-wishlist-label]');
                                if (label) label.textContent = data.added ? 'Saved to wishlist' : 'Add to wishlist';
                            });
                            const badge = document.getElementById('wishlist-count');
                            badge.textContent = data.count;
                            badge.classList.toggle('is-hidden', data.count === 0);
                            document.querySelector('[aria-label^="Wishlist,"]')?.setAttribute('aria-label', `Wishlist, ${data.count} items`);
                            if (!data.added && window.location.pathname === @json(route('wishlist.index', [], false))) {
                                window.location.reload();
                                return;
                            }
                            showMessage(data.message);
                        } catch (error) {
                            showMessage(error.message || 'Could not update your wishlist.', true);
                        }
                        return;
                    }

                    const addButton = event.target.closest('[data-cart-add]');
                    if (addButton) {
                        const product = {
                            id: addButton.dataset.productId,
                            name: addButton.dataset.productName,
                            price: Number(addButton.dataset.productPrice),
                            image: addButton.dataset.productImage,
                        };
                        window.AlAsraCart.add(product);
                    }
                });

                document.addEventListener('submit', (event) => {
                    const form = event.target.closest('[data-cart-form]');
                    if (!form) return;
                    event.preventDefault();
                    window.AlAsraCart.add({
                        id: form.dataset.productId,
                        name: form.dataset.productName,
                        price: Number(form.dataset.productPrice),
                        image: form.dataset.productImage,
                    }, Number(form.elements.quantity.value));
                });
            })();
        </script>

        <script>
            (() => {
            const loader=document.getElementById('page-loader');
            const root=document.documentElement;
            const number=loader.querySelector('.lnum');
            const bar=loader.querySelector('.lbar i');
            let progress=0,finished=false;
            const paint=()=>{number.textContent=progress+'%';bar.style.transform='scaleX('+(progress/100)+')';loader.querySelector('.lcart').style.left=progress+'%'};
            const interval=setInterval(()=>{if(progress<90){progress+=Math.max(1,Math.ceil((90-progress)/12));paint()}},90);
            const finish=()=>{
            if(finished)return;
            finished=true;
            clearInterval(interval);
            progress=100;
            paint();
            setTimeout(()=>{root.classList.add('ready');loader.classList.add('open');setTimeout(()=>{root.classList.remove('lock');loader.classList.remove('active')},900)},120);
            };
            if(document.readyState==='complete')finish();else window.addEventListener('load',finish,{once:true});
            setTimeout(finish,3000);
            const begin=()=>{root.classList.add('lock');root.classList.remove('ready');loader.classList.add('active');loader.classList.remove('open')};
            document.addEventListener('click',event=>{
            if(event.defaultPrevented||event.button!==0||event.metaKey||event.ctrlKey||event.shiftKey||event.altKey)return;
            const link=event.target.closest('a[href]');
            if(!link||link.target==='_blank'||link.hasAttribute('download'))return;
            const destination=new URL(link.href,location.href);
            if(destination.origin!==location.origin||(destination.pathname===location.pathname&&destination.search===location.search&&destination.hash))return;
            begin();
            });
            document.addEventListener('submit',event=>{
            const form=event.target;
            if(form.target==='_blank')return;
            if(new URL(form.action||location.href,location.href).origin===location.origin)begin();
            });
            window.addEventListener('pageshow',event=>{if(event.persisted){root.classList.add('ready');root.classList.remove('lock');loader.classList.remove('open','active')}});
            })();
        </script>

        <script>
            (() => {
            const h=document.getElementById('site-header');if(!h)return;
            const shopLink=document.getElementById('sh-shoplink'),panel=document.getElementById('sh-panel');
            const burger=document.getElementById('sh-burger'),macc=document.getElementById('sh-macc'),mcats=document.getElementById('sh-mcats');
            let t;
            const setShop=v=>{h.classList.toggle('shop-open',v);shopLink.setAttribute('aria-expanded',v)};
            const open=()=>{if(innerWidth<=850)return;clearTimeout(t);setShop(true)};
            const close=()=>{clearTimeout(t);t=setTimeout(()=>setShop(false),140)};
            [shopLink,panel].forEach(el=>{el.addEventListener('mouseenter',open);el.addEventListener('mouseleave',close);el.addEventListener('focusin',open);el.addEventListener('focusout',close)});
            h.querySelectorAll('.sh-nav .sh-link:not(#sh-shoplink),.sh-search,.sh-icon,.sh-bag').forEach(el=>el.addEventListener('mouseenter',close));
            const setMobile=v=>{h.classList.toggle('m-open',v);burger.setAttribute('aria-expanded',v);burger.setAttribute('aria-label',v?'Close menu':'Open menu')};
            burger.addEventListener('click',()=>setMobile(!h.classList.contains('m-open')));
            macc.addEventListener('click',()=>{const v=!mcats.classList.contains('open');mcats.classList.toggle('open',v);macc.setAttribute('aria-expanded',v)});
            document.addEventListener('keydown',e=>{if(e.key==='Escape'){setShop(false);setMobile(false)}});
            document.addEventListener('click',e=>{if(h.classList.contains('m-open')&&!e.target.closest('.sh-bar,.sh-mobile'))setMobile(false)});
            addEventListener('resize',()=>{if(innerWidth>850)setMobile(false);else setShop(false)});
            const onScroll=()=>h.classList.toggle('is-scrolled',scrollY>24);
            addEventListener('scroll',onScroll,{passive:true});onScroll();
            })();
        </script>
        @stack('scripts')
    </body>
</html>