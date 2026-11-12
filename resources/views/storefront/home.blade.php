@extends('storefront.layout')
@section('title','Al-Asra Store | Organic & Original, Delivered in Pakistan')
@push('head')
<style>
.ah-dynamic .ah-stage{height:clamp(460px,68svh,680px);min-height:460px}
.ah-carousel{position:absolute;inset:0;z-index:2}
.ah-dynamic .ah-item{position:absolute;left:50%;bottom:0;width:clamp(250px,34vw,450px);height:84%;margin:0;aspect-ratio:auto;opacity:0;filter:blur(7px);transform:translateX(-50%) scale(.76);transform-origin:bottom center;transition:left .7s cubic-bezier(.2,.8,.2,1),bottom .7s,height .7s,width .7s,transform .7s cubic-bezier(.2,.8,.2,1),opacity .5s,filter .7s;mix-blend-mode:multiply;will-change:left,transform,opacity,filter;pointer-events:none}
.ah-dynamic .ah-item picture,.ah-dynamic .ah-item img{display:block;width:100%;height:100%}
.ah-dynamic .ah-item img{object-fit:contain;object-position:center bottom;user-select:none;-webkit-user-drag:none}
.ah-dynamic .ah-item.is-active{left:50%;bottom:0;width:clamp(260px,36vw,470px);height:86%;opacity:1;filter:none;transform:translateX(-50%) scale(1.04);z-index:20}
.ah-dynamic .ah-item.is-prev,.ah-dynamic .ah-item.is-next{bottom:11%;width:clamp(110px,18vw,230px);height:34%;opacity:.82;filter:blur(2px);transform:translateX(-50%) scale(.96);z-index:10}
.ah-dynamic .ah-item.is-prev{left:29%}
.ah-dynamic .ah-item.is-next{left:71%}
.ah-dynamic .ah-item.is-far-prev,.ah-dynamic .ah-item.is-far-next{bottom:8%;width:clamp(90px,15vw,190px);height:27%;opacity:0;filter:blur(7px);z-index:5}
.ah-dynamic .ah-item.is-far-prev{left:4%;transform:translateX(-50%) scale(.76)}
.ah-dynamic .ah-item.is-far-next{left:96%;transform:translateX(-50%) scale(.76)}
.ah-dynamic .ah-item.is-hidden{left:50%;opacity:0}
.ah-info{bottom:clamp(30px,8vh,80px);left:7%;max-width:min(330px,34vw)}
.ah-name{margin:0 0 10px;color:var(--ah-maroon);font-size:clamp(17px,2vw,24px);line-height:1.25;letter-spacing:.1em}
.ah-subtitle{display:block;margin-bottom:7px;color:var(--ah-orange);font-size:11px;font-weight:700;letter-spacing:.16em;text-transform:uppercase}
.ah-desc{display:block;margin:0;color:#4a3a3d;font-size:13px;line-height:1.6}
.ah-secondary-cta{display:inline-block;margin-top:8px;color:var(--ah-maroon);font-size:12px;font-weight:700;text-decoration:underline;text-underline-offset:3px}
.ah-nav{margin-top:14px}
.ah-dynamic .ah-btn{width:64px;height:64px;background:#ffffff70}
.ah-dynamic .ah-btn:hover{background:var(--ah-orange)}
.ah-dynamic .ah-cta{bottom:clamp(34px,8vh,80px);right:5%;max-width:32%;text-align:right}
.ah-dynamic .ah-cta-label{display:inline-block}
.ah-dynamic .ah-cta-ico{flex:none}
.ex-art .category-image{width:min(72%,260px);height:240px;object-fit:contain}
@media(max-width:700px){
 .ah-dynamic .ah-stage{height:clamp(560px,76svh,700px);min-height:560px}
 .ah-dynamic .ah-item.is-active{width:66vw;height:61%;bottom:13%}
 .ah-dynamic .ah-item.is-prev,.ah-dynamic .ah-item.is-next{width:22vw;height:20%;bottom:22%}
 .ah-dynamic .ah-item.is-prev{left:19%}
 .ah-dynamic .ah-item.is-next{left:81%}
 .ah-info{bottom:20px;left:20px;max-width:58vw}
 .ah-name{font-size:16px;margin-bottom:5px}
 .ah-desc{font-size:11px;line-height:1.4}
 .ah-subtitle{font-size:9px}
 .ah-nav{margin-top:9px}
 .ah-dynamic .ah-btn{width:42px;height:42px}
 .ah-dynamic .ah-cta{right:16px;bottom:24px;max-width:36%;font-size:25px}
 .ah-dynamic .ah-cta-ico{width:20px;height:20px}
}
@media(prefers-reduced-motion:reduce){.ah-dynamic .ah-item{transition:none}}

/* 'Unbounded',sans-serif */
</style>
@endpush
@section('content')
@php
$visualProducts = collect($products)->values();
$imgFor = function($p) { $slug = $p->slug ?? ''; $map = ['portable-juice-blender'=>'/images/products/portable-blender.png','ice-cream-tumbler-with-straw'=>'/images/products/ice-cream-tumbler.png','electric-milk-frother'=>'/images/products/milk-frother.png']; return $p->display_image ?? ($map[$slug] ?? '/logo.png'); };
$heroItems = $sliders;
$activeHero = $heroItems->first();
$categoryItems = $categories->take(4);
$trustDefaults = [
    ['Free delivery', 'On orders over PKR 10,000'],
    ['Cash on delivery', 'Or bank transfer'],
    ['Track your order', 'Real-time updates'],
    ['Always here', 'Mon–Sat, 11:00am–8:30pm'],
];
$trustItems = collect(range(1, 4))->map(fn ($index) => [
   'title' => setting("store_home_trust_{$index}_title", $trustDefaults[$index - 1][0]),
   'description' => setting("store_home_trust_{$index}_description", $trustDefaults[$index - 1][1]),
]);
$marqueeItems = $categories->pluck('name')
    ->merge($products->pluck('name'))
    ->filter()
    ->unique()
    ->values();
$marqueeText = setting('store_home_marquee_text') ?: ($marqueeItems->isNotEmpty()
    ? $marqueeItems->implode(' ✦ ') . ' ✦ '
   : 'AL ASRA ✦ EVERYDAY ESSENTIALS ✦ ');
@endphp
@if($heroItems->isNotEmpty())
<section class="ah ah-dynamic" id="home-hero" aria-label="Featured sliders" aria-roledescription="carousel">
 <div class="ah-stage" style="{{ $activeHero->background_style }};--ah-maroon:{{ $activeHero->text_color ?: '#5F1E29' }}">
 <div class="ah-glow" style="background:radial-gradient(ellipse 50% 60% at 50% 60%,#fff,transparent 72%)"></div><div class="ah-grain"></div><div class="ah-brand"><i></i>{{ setting('store_brand_name', 'Al-Asra Store') }}</div>
  <div class="ah-carousel">
   @foreach($heroItems as $index => $slide)
    <figure class="ah-item {{ $index === 0 ? 'is-active' : '' }} {{ $slide->content_type === 'image_only' ? 'image-only' : '' }}"
            data-index="{{ $index }}" data-title="{{ $slide->title }}" data-subtitle="{{ $slide->subtitle }}"
            data-description="{{ $slide->description }}" data-button-text="{{ $slide->button_text }}"
            data-button-url="{{ $slide->button_url }}" data-secondary-button-text="{{ $slide->secondary_button_text }}"
            data-secondary-button-url="{{ $slide->secondary_button_url }}" data-background-color="{{ $slide->background_color ?: '#FAF7F2' }}"
            data-background-gradient="{{ $slide->background_gradient }}" data-text-color="{{ $slide->text_color ?: '#5F1E29' }}"
            data-duration="{{ $slide->slide_duration ?: 5500 }}" aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">
     <picture>
      @if($slide->mobile_image_url)<source media="(max-width: 700px)" srcset="{{ $slide->mobile_image_url }}">@endif
      <img src="{{ $slide->image_url }}" alt="{{ $slide->title ?: 'Al-Asra featured image' }}" fetchpriority="{{ $index === 0 ? 'high' : 'auto' }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
     </picture>
    </figure>
   @endforeach
  </div>
  <div class="ah-info" aria-live="polite">
   @if($activeHero->subtitle)<span class="ah-subtitle" id="hero-subtitle">{{ $activeHero->subtitle }}</span>@else<span class="ah-subtitle" id="hero-subtitle" hidden></span>@endif
   <div class="ah-name" id="hero-name">{{ $activeHero->title ?: 'Al-Asra' }}</div>
   <p class="ah-desc" id="hero-description">{{ $activeHero->description }}</p>
   <a class="ah-secondary-cta" id="hero-secondary-cta" href="{{ $activeHero->secondary_button_url }}" @if(!$activeHero->secondary_button_text || !$activeHero->secondary_button_url) hidden @endif>{{ $activeHero->secondary_button_text }}</a>
   @if($heroItems->count() > 1)
    <div class="ah-nav"><button class="ah-btn" type="button" data-hero-shift="-1" aria-label="Previous slide">←</button><button class="ah-btn" type="button" data-hero-shift="1" aria-label="Next slide">→</button></div>
   @endif
  </div>
  <a class="ah-cta" id="hero-cta" href="{{ $activeHero->button_url ?: '/shop' }}"><span class="ah-cta-label">{{ $activeHero->button_text ?: 'SHOP NOW' }}</span><span class="ah-cta-ico" aria-hidden="true">↗</span></a>
 </div>
</section>
@else
<section class="hero-fallback"><div><h1>AL ASRA</h1><p>Discover useful products, everyday essentials and carefully selected finds.</p><a class="btn" href="/shop">SHOP NOW</a></div></section>
@endif
<section class="trust">
@foreach($trustItems as $item)
<div><b>{{ $item['title'] }}</b><span>{{ $item['description'] }}</span></div>
@endforeach
</section>
@if($categoryItems->isNotEmpty())
<section class="sec"><div class="center"><span class="kick">{{ setting('store_home_categories_eyebrow', 'Shop by category') }}</span><h2>{{ setting('store_home_categories_title', 'Find what you need') }}</h2></div><div class="cats">
@foreach($categoryItems as $category)
@php $categoryImage = $category->products->first()?->display_image ?? '/logo.png'; @endphp
<a class="cat" href="/shop?category={{ $category->slug }}"><img src="{{ $categoryImage }}" alt="{{ $category->name }}" loading="lazy"><div><h3>{{ $category->name }}</h3><p>{{ $category->products_count }} products</p></div></a>
@endforeach
</div></section>
@endif


<section class="sec">
    <div class="center">
        <span class="kick">{{ setting('store_home_products_eyebrow', 'Our selection') }}</span>
        <h2>{{ setting('store_home_products_title', 'Fresh from our shelves') }}</h2>
    </div>
    <div class="chips mid" id="home-cats">
        <button class="on" data-cat="all">All</button>
        @foreach($categories as $c)
        <button data-cat="{{ $c->slug }}">{{ $c->name }}</button>
        @endforeach
    </div>
    <div class="pgrid" id="home-products">
        @forelse($products as $p)
            @php
                $cartItem = ['id' => $p->id, 'name' => $p->name, 'price' => (float) $p->display_price, 'image' => $imgFor($p)];
            @endphp
            <article class="pcard" data-category="{{ $p->productCategory?->slug }}"><a class="pic" href="{{ $p->product_url }}"><img src="{{ $imgFor($p) }}" alt="{{ $p->name }}"></a><small>{{ $p->productCategory?->name ?? 'Al-Asra' }}</small><h3><a href="{{ $p->product_url }}">{{ $p->name }}</a></h3><div class="prow"><b>PKR {{ number_format((float)$p->display_price) }}</b><button class="addbag" type="button" onclick='AlAsraCart.add(@json($cartItem))'>Add to bag</button></div></article>
        @empty
            <div class="empty">Our collection is being refreshed. Please check back soon.</div>
        @endforelse
    </div>
</section>


<section class="obnd"><div class="obt"><span class="kick w">{{ setting('store_home_why_eyebrow', 'Why Al-Asra') }}</span><h2>{{ setting('store_home_why_title', 'Original products you can trust.') }}</h2><p>{{ setting('store_home_why_description', 'Every item is checked before it ships from Karachi to your door.') }}</p><a class="btn white" href="{{ setting('store_home_why_button_url', '/shop') }}">{{ setting('store_home_why_button_text', 'Browse the shop') }}</a></div><div class="obv">@foreach($visualProducts->take(2) as $p)<div class="ob"><img src="{{ $imgFor($p) }}" alt="{{ $p->name }}" loading="lazy"></div>@endforeach</div></section>
@if($categoryItems->isNotEmpty())
<section class="story"><div class="story-head"><span class="kick">{{ setting('store_home_story_eyebrow', 'Discover') }}</span><h2>{{ setting('store_home_story_title', 'Explore our categories') }}</h2><p>{{ setting('store_home_story_description', 'Browse active categories and find products selected for everyday use.') }}</p></div><div class="story-cards">
@foreach($categoryItems->take(3) as $i => $category)
@php $categoryProduct = $category->products->first(); @endphp
<div class="ex-wrap"><article class="ex ex{{ $i }}"><div class="ex-txt"><small>{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }} / {{ $category->name }}</small><h3>{{ $category->name }}</h3><p>{{ $category->products_count }} active {{ \Illuminate\Support\Str::plural('product', $category->products_count) }} to explore.</p><a class="btn" href="/shop?category={{ $category->slug }}">Shop {{ $category->name }}</a></div><div class="ex-art">@if($categoryProduct)<a href="{{ $categoryProduct->product_url }}"><img class="category-image" src="{{ $categoryProduct->display_image ?? '/logo.png' }}" alt="{{ $categoryProduct->name }}" loading="lazy"></a>@endif</div></article></div>
@endforeach
</div></section>
@endif
<div class="marquee"><div>{{ str_repeat($marqueeText, 5) }}</div></div>
<section class="pmq"><div>@foreach($products->concat($products)->take(12) as $p)<a href="{{ $p->product_url }}"><img src="{{ $imgFor($p) }}" alt="{{ $p->name }}" loading="lazy"></a>@endforeach</div></section>
@push('scripts')<script>
const heroSlides=[...document.querySelectorAll('.ah-item')];
const heroCarousel=document.querySelector('.ah-carousel');
const heroStage=document.querySelector('.ah-stage');
if(heroSlides.length>1&&heroCarousel){
 let heroAt=0,heroTimer;
 if(heroSlides.length===2){
  heroSlides.forEach(slide=>{const clone=slide.cloneNode(true);clone.dataset.clone='true';heroCarousel.appendChild(clone)});
 }
 const visibleItems=[...heroCarousel.querySelectorAll('.ah-item')];
 const clearPositions=item=>item.classList.remove('is-active','is-prev','is-next','is-far-prev','is-far-next','is-hidden');
 const showHeroSlide=index=>{
  heroAt=(index+heroSlides.length)%heroSlides.length;
  visibleItems.forEach(item=>{
   clearPositions(item);
   const distance=(Number(item.dataset.index)-heroAt+heroSlides.length)%heroSlides.length;
   if(distance===0&&item.dataset.clone!=='true')item.classList.add('is-active');
   else if(heroSlides.length===2&&distance===1)item.classList.add(item.dataset.clone==='true'?'is-prev':'is-next');
   else if(distance===1)item.classList.add('is-next');
   else if(distance===heroSlides.length-1)item.classList.add('is-prev');
   else if(distance===2&&heroSlides.length>4)item.classList.add('is-far-next');
   else if(distance===heroSlides.length-2&&heroSlides.length>4)item.classList.add('is-far-prev');
   else item.classList.add('is-hidden');
   item.setAttribute('aria-hidden',String(!item.classList.contains('is-active')));
  });
  const active=heroSlides[heroAt];
  document.getElementById('hero-name').textContent=active.dataset.title||'Al-Asra';
  const subtitle=document.getElementById('hero-subtitle');
  subtitle.textContent=active.dataset.subtitle||'';
  subtitle.hidden=!active.dataset.subtitle;
  const description=document.getElementById('hero-description');
  description.textContent=active.dataset.description||'';
  description.hidden=!active.dataset.description;
  const secondary=document.getElementById('hero-secondary-cta');
  secondary.textContent=active.dataset.secondaryButtonText||'';
  secondary.href=active.dataset.secondaryButtonUrl||'#';
  secondary.hidden=!active.dataset.secondaryButtonText||!active.dataset.secondaryButtonUrl;
  const cta=document.getElementById('hero-cta');
  cta.href=active.dataset.buttonUrl||'/shop';
  cta.querySelector('.ah-cta-label').textContent=active.dataset.buttonText||'SHOP NOW';
  heroStage.style.background=active.dataset.backgroundGradient||active.dataset.backgroundColor||'#FAF7F2';
  heroStage.style.setProperty('--ah-maroon',active.dataset.textColor||'#5F1E29');
  clearTimeout(heroTimer);
  if(!window.matchMedia('(prefers-reduced-motion: reduce)').matches){
   heroTimer=setTimeout(()=>showHeroSlide(heroAt+1),Math.max(2000,Number(active.dataset.duration)||5500));
  }
 };
 document.querySelectorAll('[data-hero-shift]').forEach(button=>button.addEventListener('click',()=>showHeroSlide(heroAt+Number(button.dataset.heroShift))));
 showHeroSlide(0);
}
document.querySelectorAll('#home-cats button').forEach(b=>b.addEventListener('click',()=>{document.querySelectorAll('#home-cats button').forEach(x=>x.classList.remove('on'));b.classList.add('on');document.querySelectorAll('#home-products .pcard').forEach(p=>p.hidden=b.dataset.cat!=='all'&&p.dataset.category!==b.dataset.cat)}));
</script>@endpush
@endsection
