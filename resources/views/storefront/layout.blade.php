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
</style>
@stack('head')
</head><body>
<div class="loader active" id="page-loader" role="status" aria-live="polite" aria-label="Loading page">
<div class="lmid"><div class="lwrap"><svg class="lcart" style="left:0" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M3 4h2l2.2 11.2a2 2 0 0 0 2 1.6h8.5a2 2 0 0 0 1.9-1.4L21 8H6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20" r="1.5" fill="currentColor"/><circle cx="18" cy="20" r="1.5" fill="currentColor"/></svg><div class="lbar"><i style="transform:scaleX(0)"></i></div></div><div class="lnum">0%</div></div>
</div>
@if((string) setting('store_announcement_enabled', '1') === '1')
<div class="announce">{{ setting('store_announcement_text', 'Free delivery on orders over PKR 10,000 · Cash on delivery across Pakistan') }}</div>
@endif
<header class="nav">
<button class="burger" type="button" aria-label="Open menu" onclick="document.querySelector('.nav nav').classList.toggle('on')">☰</button>
<a href="/" class="brand"><img src="/logo.png" alt="{{ setting('store_brand_name', 'Al-Asra Store') }}"></a>
<nav><a href="{{ route('shop') }}">Shop</a><a href="{{ route('aboutus') }}">About</a><a href="{{ route('customer.dashboard') }}">Track order</a><a href="{{ route('faqs') }}">FAQ</a><a href="{{ route('contact') }}">Contact</a></nav>
<form class="search" action="/shop"><input name="q" placeholder="Search products" aria-label="Search products"></form>
<div class="header-actions">
<a href="{{ route('wishlist.index') }}" class="header-icon" aria-label="Wishlist, {{ count(array_unique(array_map('intval', session('wishlist', [])))) }} items">
<svg fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7-4.6-9.3-9A5.3 5.3 0 0 1 12 6a5.3 5.3 0 0 1 9.3 6C19 16.4 12 21 12 21Z"/></svg>
<span id="wishlist-count" class="{{ count(array_unique(array_map('intval', session('wishlist', [])))) ? '' : 'is-hidden' }}">{{ count(array_unique(array_map('intval', session('wishlist', [])))) }}</span>
</a>
<a href="{{ auth('customer')->check() ? route('customer.dashboard') : route('customer.login') }}" class="header-icon" aria-label="{{ auth('customer')->check() ? 'My account' : 'Log in' }}">
<svg fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
</a>
<button class="cartbtn" type="button" onclick="AlAsraCart.open()">Bag <span id="bag-count">0</span></button>
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
<div><img class="foot-logo" src="/logo.png" alt="{{ setting('store_brand_name', 'Al-Asra Store') }}"><p>{{ setting('store_footer_about', 'Organic, original and imported products. Delivered across Pakistan.') }}</p></div>
<div><h4>{{ setting('store_footer_shop_title', 'Shop') }}</h4>
<a href="{{ setting('store_footer_shop_link_1_url', '/shop') }}">{{ setting('store_footer_shop_link_1_text', 'All products') }}</a>
<a href="{{ setting('store_footer_shop_link_2_url', '/shop?category=organic') }}">{{ setting('store_footer_shop_link_2_text', 'Organic') }}</a>
<a href="{{ setting('store_footer_shop_link_3_url', '/shop?category=natural-care') }}">{{ setting('store_footer_shop_link_3_text', 'Natural care') }}</a></div>
<div><h4>{{ setting('store_footer_help_title', 'Help') }}</h4>
<a href="{{ route('customer.dashboard') }}">{{ setting('store_footer_help_link_1_text', 'Track order') }}</a>
<a href="{{ route('aboutus') }}">{{ setting('store_footer_help_link_2_text', 'About us') }}</a>
<a href="{{ route('contact') }}">{{ setting('store_footer_help_link_3_text', 'Contact') }}</a></div>
<div><h4>{{ setting('store_footer_contact_title', 'Reach us') }}</h4>
<p>{{ setting('store_footer_address', 'Karachi, Pakistan') }}<br>{{ setting('store_footer_phone', '+92 315 9259927') }}<br>{{ setting('store_footer_email', 'support@alasra.online') }}<br>{{ setting('store_footer_hours', 'Mon–Sat, 11:00am–8:30pm') }}</p>
<a href="{{ setting('store_footer_instagram_url', 'https://instagram.com/alasra.onlinestore') }}">{{ setting('store_footer_instagram_label', 'Instagram @alasra.onlinestore') }}</a></div>
</div>
<div class="fbase">© {{ date('Y') }} {{ setting('store_footer_copyright', 'Al-Asra Store. All rights reserved.') }} <span>Cash on delivery · Bank transfer</span></div>
</footer>
<div class="scrim" id="cart-scrim" onclick="AlAsraCart.close()"></div><aside class="drawer" id="cart-drawer" aria-hidden="true"><div class="drawer-top"><h3>Your bag (<span id="drawer-count">0</span>)</h3><button onclick="AlAsraCart.close()" aria-label="Close cart">✕</button></div><p id="ship-msg">Add PKR 10,000 more for free delivery</p><div class="drawer-lines" id="drawer-lines"></div><div class="sum"><span>Subtotal</span><b id="drawer-total">PKR 0</b></div><a class="btn" href="/checkout">Checkout</a><a class="btn ghost" href="/cart">View bag</a></aside>
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
@stack('scripts')
</body></html>
