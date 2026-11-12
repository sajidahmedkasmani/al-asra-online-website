@extends('storefront.layout')
@section('title','Al-Asra Store | Organic & Original, Delivered in Pakistan')
@push('head')
<style>
.ah-dynamic .ah-stage{height:clamp(420px,68svh,680px);min-height:420px}
.ah-slides,.ah-slide{position:absolute;inset:0}
.ah-slides{isolation:isolate;z-index:2}
.ah-slide{display:grid;grid-template-columns:1fr 1fr;align-items:center;padding:clamp(32px,7vw,100px);opacity:0;visibility:hidden;transition:opacity .55s ease,visibility .55s}
.ah-slide.is-active{opacity:1;visibility:visible}
.ah-slide.image-only{display:block;padding:0}
.ah-copy{position:relative;z-index:2;max-width:540px}
.ah-copy .ah-kicker{display:block;margin-bottom:14px;color:var(--ah-orange);font-size:12px;font-weight:700;letter-spacing:.18em;text-transform:uppercase}
.ah-copy h1{max-width:12ch;margin:0 0 16px;color:var(--ah-maroon);font-size:clamp(32px,5vw,68px);line-height:1.04;letter-spacing:-.04em}
.ah-copy p{max-width:46ch;margin:0;color:#4a3a3d;font-size:clamp(14px,1.4vw,18px);line-height:1.65}
.ah-actions{display:flex;flex-wrap:wrap;gap:12px;margin-top:24px}
.ah-action{display:inline-flex;align-items:center;justify-content:center;min-height:46px;padding:0 22px;border:1px solid var(--ah-maroon);border-radius:99px;color:var(--ah-maroon);font-size:13px;font-weight:700;text-decoration:none}
.ah-action.primary{border-color:var(--ah-orange);background:var(--ah-orange);color:#fff}
.ah-art{position:relative;z-index:1;display:grid;place-items:center;height:100%;min-height:300px}
.ah-art img{position:absolute;width:100%;height:100%;object-fit:contain;object-position:center}
.ah-art img.ah-secondary{width:62%;height:62%;right:-2%;bottom:4%;opacity:.72;transform:rotate(8deg)}
.ah-art img.ah-main{z-index:1;filter:drop-shadow(0 28px 30px #0002)}
.ah-slide.image-left .ah-copy{order:2}
.ah-slide.image-left .ah-art{order:1}
.ah-slide.image-only picture,.ah-slide.image-only picture img{display:block;width:100%;height:100%}
.ah-slide.image-only picture img{object-fit:cover}
.ah-slide.image-only .ah-image-link{display:block;width:100%;height:100%}
.ah-slide.image-only .ah-banner-cta{position:absolute;z-index:2;left:clamp(20px,5vw,64px);bottom:clamp(20px,5vw,64px)}
.ah-controls{position:absolute;z-index:60;right:clamp(18px,4vw,52px);bottom:clamp(22px,5vw,64px);display:flex;align-items:center;gap:12px}
.ah-dots{display:flex;align-items:center;gap:7px}
.ah-dots button{width:8px;height:8px;padding:0;border:0;border-radius:20px;background:#5f1e2960;cursor:pointer;transition:width .2s,background .2s}
.ah-dots button[aria-current="true"]{width:24px;background:var(--ah-orange)}
.ah-dynamic .ah-nav{margin:0}
.ah-dynamic .ah-btn{width:42px;height:42px;background:#fff9}
.ah-dynamic .ah-btn:hover{background:var(--ah-orange)}
@media(max-width:700px){
 .ah-dynamic .ah-stage{height:clamp(560px,76svh,700px);min-height:560px}
 .ah-slide{grid-template-columns:1fr;padding:64px 24px 100px;align-content:center;gap:0}
 .ah-copy{grid-row:2;max-width:none}
 .ah-copy h1{max-width:14ch;font-size:clamp(29px,8vw,46px)}
 .ah-copy p{font-size:13px}
 .ah-art{grid-row:1;min-height:0;height:clamp(240px,38vh,340px)}
 .ah-slide.image-left .ah-copy,.ah-slide.image-left .ah-art{order:initial}
 .ah-controls{right:18px;bottom:20px}
 .ah-dynamic .ah-btn{width:38px;height:38px}
}
@media(prefers-reduced-motion:reduce){.ah-slide{transition:none}}
</style>
@endpush
@section('content')
@php
$visualProducts = collect($products)->values();
$imgFor = function($p) { $slug = $p->slug ?? ''; $map = ['portable-juice-blender'=>'/images/products/portable-blender.png','ice-cream-tumbler-with-straw'=>'/images/products/ice-cream-tumbler.png','electric-milk-frother'=>'/images/products/milk-frother.png']; return $p->display_image ?? ($map[$slug] ?? '/logo.png'); };
$heroItems = $sliders;
$categoryItems = $categories->take(4);
@endphp
@if($heroItems->isNotEmpty())
<section class="ah ah-dynamic" id="home-hero" aria-label="Featured sliders">
 <div class="ah-stage">
  <div class="ah-glow" style="background:radial-gradient(ellipse 50% 60% at 50% 60%,#fff,transparent 72%)"></div><div class="ah-grain"></div><div class="ah-brand"><i></i>AL ASRA</div>
  <div class="ah-slides">
   @foreach($heroItems as $index => $slide)
    <article class="ah-slide {{ $index === 0 ? 'is-active' : '' }} {{ $slide->content_type === 'image_only' ? 'image-only' : '' }} {{ $slide->image_position === 'left' ? 'image-left' : '' }}"
             style="{{ $slide->background_style }};--ah-maroon:{{ $slide->text_color ?: '#5F1E29' }}"
             data-duration="{{ $slide->slide_duration ?: 5500 }}" aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">
     @if($slide->content_type === 'image_only')
      @if($slide->image_url)
       @if($slide->button_url)<a class="ah-image-link" href="{{ $slide->button_url }}">@endif
       <picture>
        @if($slide->mobile_image_url)<source media="(max-width: 700px)" srcset="{{ $slide->mobile_image_url }}">@endif
        <img src="{{ $slide->image_url }}" alt="{{ $slide->title ?: 'Al-Asra featured banner' }}" fetchpriority="{{ $index === 0 ? 'high' : 'auto' }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
       </picture>
       @if($slide->button_url)</a>@endif
      @endif
      @if($slide->button_text && $slide->button_url)<a class="ah-action primary ah-banner-cta" href="{{ $slide->button_url }}">{{ $slide->button_text }} <span aria-hidden="true">↗</span></a>@endif
     @else
      <div class="ah-copy" style="text-align:{{ $slide->text_alignment ?: 'left' }}">
       @if($slide->subtitle)<span class="ah-kicker">{{ $slide->subtitle }}</span>@endif
       @if($slide->title)<h1>{{ $slide->title }}</h1>@endif
       @if($slide->description)<p>{{ $slide->description }}</p>@endif
       @if($slide->button_text || $slide->secondary_button_text)
        <div class="ah-actions" style="justify-content:{{ $slide->text_alignment === 'right' ? 'flex-end' : ($slide->text_alignment === 'center' ? 'center' : 'flex-start') }}">
         @if($slide->button_text && $slide->button_url)<a class="ah-action primary" href="{{ $slide->button_url }}">{{ $slide->button_text }} <span aria-hidden="true">↗</span></a>@endif
         @if($slide->secondary_button_text && $slide->secondary_button_url)<a class="ah-action" href="{{ $slide->secondary_button_url }}">{{ $slide->secondary_button_text }}</a>@endif
        </div>
       @endif
      </div>
      <div class="ah-art">
       @if($slide->secondary_image_url)<img class="ah-secondary" src="{{ $slide->secondary_image_url }}" alt="" loading="lazy">@endif
       @if($slide->image_url)<img class="ah-main" src="{{ $slide->image_url }}" alt="{{ $slide->title ?: 'Al-Asra featured image' }}" fetchpriority="{{ $index === 0 ? 'high' : 'auto' }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">@endif
      </div>
     @endif
    </article>
   @endforeach
  </div>
  @if($heroItems->count() > 1)
   <div class="ah-controls" aria-label="Slider controls">
    <div class="ah-dots" aria-label="Choose a slide">
     @foreach($heroItems as $index => $slide)<button type="button" aria-label="Go to slide {{ $index + 1 }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"></button>@endforeach
    </div>
    <div class="ah-nav"><button class="ah-btn" type="button" data-hero-shift="-1" aria-label="Previous slide">←</button><button class="ah-btn" type="button" data-hero-shift="1" aria-label="Next slide">→</button></div>
   </div>
  @endif
 </div>
</section>
@else
<section class="hero-fallback"><div><h1>AL ASRA</h1><p>Discover useful products, everyday essentials and carefully selected finds.</p><a class="btn" href="/shop">SHOP NOW</a></div></section>
@endif
<section class="trust"><div><b>Free delivery</b><span>On orders over PKR 10,000</span></div><div><b>Cash on delivery</b><span>Or bank transfer</span></div><div><b>Track your order</b><span>Real-time updates</span></div><div><b>Always here</b><span>Mon–Sat, 11:00am–8:30pm</span></div></section>
<section class="sec"><div class="center"><span class="kick">Shop by category</span><h2>Find what you need</h2></div><div class="cats">
@forelse($categoryItems as $category)
<a class="cat" href="/shop?category={{ $category->slug }}"><img src="{{ $category->slug==='drinkware'?'/images/products/ice-cream-tumbler.png':'/images/products/portable-blender.png' }}" alt="{{ $category->name }}"><div><h3>{{ $category->name }}</h3><p>{{ $category->products_count ?? 'Explore' }} products</p></div></a>
@empty
<a class="cat" href="/shop"><img src="/images/products/portable-blender.png" alt="Kitchen"><div><h3>Kitchen</h3><p>Explore products</p></div></a><a class="cat" href="/shop"><img src="/images/products/ice-cream-tumbler.png" alt="Drinkware"><div><h3>Drinkware</h3><p>Explore products</p></div></a>
@endforelse
</div></section>
<section class="sec"><div class="center"><span class="kick">Our selection</span><h2>Fresh from our shelves</h2></div><div class="chips mid" id="home-cats"><button class="on" data-cat="all">All</button>@foreach($categories as $c)<button data-cat="{{ $c->slug }}">{{ $c->name }}</button>@endforeach</div><div class="pgrid" id="home-products">
@forelse($products as $p)
@php
$cartItem = ['id' => $p->id, 'name' => $p->name, 'price' => (float) $p->display_price, 'image' => $imgFor($p)];
@endphp
<article class="pcard" data-category="{{ $p->productCategory?->slug }}"><a class="pic" href="/product/{{ $p->slug }}"><img src="{{ $imgFor($p) }}" alt="{{ $p->name }}"></a><small>{{ $p->productCategory?->name ?? 'Al-Asra' }}</small><h3><a href="/product/{{ $p->slug }}">{{ $p->name }}</a></h3><div class="prow"><b>PKR {{ number_format((float)$p->display_price) }}</b><button class="addbag" type="button" onclick='AlAsraCart.add(@json($cartItem))'>Add to bag</button></div></article>
@empty
<div class="empty">Our collection is being refreshed. Please check back soon.</div>
@endforelse
</div></section>
<section class="obnd"><div class="obt"><span class="kick w">Why Al-Asra</span><h2>Original products you can trust.</h2><p>Every item is checked before it ships from Karachi to your door.</p><a class="btn white" href="/shop">Browse the shop</a></div><div class="obv">@foreach($visualProducts->take(2) as $p)<div class="ob"><img src="{{ $imgFor($p) }}" alt="{{ $p->name }}"></div>@endforeach</div></section>
<section class="story"><div class="story-head"><span class="kick">Discover</span><h2>Explore Al-Asra</h2><p>Discover useful products, everyday essentials and carefully selected finds — all in one place.</p></div><div class="story-cards">
@foreach([['01 / Featured Finds','Useful products, picked for everyday life.','Explore some of the products currently catching attention at Al-Asra — practical, useful and easy to love.','Explore Collection'],['02 / Everyday Essentials','Small upgrades that make everyday life easier.','From kitchen essentials to drinkware and useful everyday finds, discover products selected with practicality in mind.','Shop Essentials'],['03 / Customer Favourites','Some of the products worth discovering.','Take a closer look at popular Al-Asra picks and discover something useful for yourself.','Shop Favourites']] as $i=>$card)
<div class="ex-wrap"><article class="ex ex{{ $i }}"><div class="ex-txt"><small>{{ $card[0] }}</small><h3>{{ $card[1] }}</h3><p>{{ $card[2] }}</p><a class="btn" href="/shop">{{ $card[3] }}</a></div><div class="ex-art">@foreach($visualProducts->take(3) as $p)<a href="/product/{{ $p->slug }}"><img src="{{ $imgFor($p) }}" alt="{{ $p->name }}"></a>@endforeach</div></article></div>
@endforeach
</div></section>
<div class="marquee"><div>{{ str_repeat('ORIGINAL ✦ DAILY ESSENTIALS ✦ FAST DELIVERY ✦ CASH ON DELIVERY ✦ DELIVERED ACROSS PAKISTAN ✦ ',5) }}</div></div>
<section class="pmq"><div>@foreach($products->concat($products)->take(12) as $p)<a href="/product/{{ $p->slug }}"><img src="{{ $imgFor($p) }}" alt="{{ $p->name }}"></a>@endforeach</div></section>
@push('scripts')<script>
const heroSlides=[...document.querySelectorAll('.ah-slide')];
if(heroSlides.length>1){
 let heroAt=0,heroTimer;
 const showHeroSlide=(index)=>{
  heroAt=(index+heroSlides.length)%heroSlides.length;
  heroSlides.forEach((slide,i)=>{const active=i===heroAt;slide.classList.toggle('is-active',active);slide.setAttribute('aria-hidden',String(!active))});
  document.querySelectorAll('.ah-dots button').forEach((dot,i)=>dot.setAttribute('aria-current',String(i===heroAt)));
  clearTimeout(heroTimer);
  if(!window.matchMedia('(prefers-reduced-motion: reduce)').matches){
   heroTimer=setTimeout(()=>showHeroSlide(heroAt+1),Math.max(2000,Number(heroSlides[heroAt].dataset.duration)||5500));
  }
 };
 document.querySelectorAll('[data-hero-shift]').forEach(button=>button.addEventListener('click',()=>showHeroSlide(heroAt+Number(button.dataset.heroShift))));
 document.querySelectorAll('.ah-dots button').forEach((button,index)=>button.addEventListener('click',()=>showHeroSlide(index)));
 showHeroSlide(0);
}
document.querySelectorAll('#home-cats button').forEach(b=>b.addEventListener('click',()=>{document.querySelectorAll('#home-cats button').forEach(x=>x.classList.remove('on'));b.classList.add('on');document.querySelectorAll('#home-products .pcard').forEach(p=>p.hidden=b.dataset.cat!=='all'&&p.dataset.category!==b.dataset.cat)}));
</script>@endpush
@endsection
