@extends('storefront.layout')
@section('title', 'Your Bag | Al-Asra Store')

@push('head')
<style>
.bag-wrap{width:min(1180px,100%);margin:0 auto;padding:52px 5vw 72px}
.bag-heading{display:flex;align-items:flex-end;justify-content:space-between;gap:16px;margin-bottom:28px}
.bag-heading h1,.bag-empty h1{font-size:clamp(32px,5vw,52px);line-height:1.08;color:var(--plum)}
.bag-heading p,.bag-muted{color:#765c62;font-size:13px}
.bag-grid{display:grid;grid-template-columns:minmax(0,1fr) 360px;gap:48px;align-items:start}
.bag-lines{border-top:1px solid var(--line);border-bottom:1px solid var(--line)}
.bag-line{display:grid;grid-template-columns:112px minmax(0,1fr);gap:18px;padding:20px 0;border-bottom:1px solid var(--line)}
.bag-line:last-child{border-bottom:0}
.bag-image{width:112px;height:128px;border-radius:14px;background:#f7f4f0;object-fit:contain;padding:10px}
.bag-item{display:flex;flex-direction:column;min-width:0}
.bag-item-top,.bag-item-bottom{display:flex;align-items:flex-start;justify-content:space-between;gap:12px}
.bag-item h2{font-size:15px;line-height:1.4}
.bag-unit{margin-top:5px;color:#765c62;font-size:12px}
.bag-remove{border:0;background:none;color:#765c62;text-decoration:underline;text-underline-offset:3px;font:inherit;font-size:11px;cursor:pointer}
.bag-item-bottom{align-items:center;margin-top:auto;padding-top:18px}
.bag-quantity{display:inline-flex;align-items:center;border:1px solid var(--line);border-radius:99px;background:#fff}
.bag-quantity button{width:36px;height:36px;border:0;background:transparent;font-size:17px;cursor:pointer}
.bag-quantity button:disabled{opacity:.35;cursor:not-allowed}
.bag-quantity span{min-width:28px;text-align:center;font-size:12px}
.bag-line-total{font-weight:700;font-size:13px}
.bag-continue{display:inline-flex;align-items:center;gap:8px;margin-top:22px;color:#765c62;font-size:12px}
.bag-summary{position:sticky;top:105px;padding:24px;border:1px solid #5a10241a;border-radius:18px;background:#fff;box-shadow:0 12px 40px -28px #5a102455}
.bag-summary h2{margin-bottom:20px;font-size:24px}
.bag-progress-copy{font-size:12px;line-height:1.6}
.bag-progress{height:6px;margin-top:9px;overflow:hidden;border-radius:9px;background:#f2e9e3}
.bag-progress i{display:block;height:100%;border-radius:inherit;background:var(--orange);transition:width .25s}
.bag-totals{display:grid;gap:12px;margin-top:22px;padding-top:17px;border-top:1px solid var(--line);font-size:12px}
.bag-total-row{display:flex;justify-content:space-between;gap:10px}
.bag-grand-total{align-items:center;margin-top:17px;padding-top:16px;border-top:1px solid var(--line)}
.bag-grand-total b{font-size:24px;color:var(--plum)}
.bag-checkout{display:block;margin-top:14px;padding:15px 20px;border-radius:99px;background:var(--plum);color:#fff;text-align:center;font-size:13px;font-weight:700}
.bag-checkout:hover{background:var(--orange)}
.bag-empty{text-align:center;padding:80px 20px 90px}
.bag-empty-icon{display:grid;place-items:center;width:130px;height:150px;margin:0 auto 28px;border-radius:70px 70px 0 0;background:#fff0e8;color:var(--plum);font-size:42px}
.bag-empty p{margin:12px 0 22px;color:#765c62;font-size:13px}
.bag-shop-link{display:inline-block;padding:13px 24px;border-radius:99px;background:var(--plum);color:white;font-size:12px;font-weight:700}
.bag-mobile-checkout{display:none}
@media(max-width:850px){.bag-grid{grid-template-columns:minmax(0,1fr) 310px;gap:24px}}
@media(max-width:700px){.bag-wrap{padding:34px 5vw 45px}.bag-grid{grid-template-columns:1fr;gap:25px}.bag-summary{position:static}.bag-line{grid-template-columns:88px minmax(0,1fr);gap:13px;padding:16px 0}.bag-image{width:88px;height:108px}.bag-item h2{font-size:13px}.bag-quantity button{width:32px;height:32px}.bag-mobile-checkout{position:sticky;bottom:0;z-index:30;display:flex;justify-content:space-between;align-items:center;gap:16px;margin:22px -5vw -45px;padding:12px 5vw max(12px,env(safe-area-inset-bottom));border-top:1px solid var(--line);background:#fffaf6ed;backdrop-filter:blur(12px)}.bag-mobile-checkout a{padding:12px 23px;border-radius:99px;background:var(--plum);color:#fff;font-size:12px;font-weight:700}.bag-mobile-checkout[hidden]{display:none}}
</style>
@endpush

@section('content')
<main class="bag-wrap" id="bag-page">
    <div class="bag-heading">
        <h1>Your bag</h1>
        <p id="bag-item-count" aria-live="polite"></p>
    </div>
    <div id="bag-content" aria-live="polite"></div>
    <div class="bag-mobile-checkout" id="bag-mobile-checkout" hidden>
        <div><small class="bag-muted">Total</small><br><b id="bag-mobile-total"></b></div>
        <a href="{{ route('checkout.index') }}">Checkout</a>
    </div>
</main>
@endsection

@push('scripts')
<script>
(() => {
    const key = 'alasra-cart';
    const initialCart = @json(array_values($cart));
    const itemCount = document.getElementById('bag-item-count');
    const content = document.getElementById('bag-content');
    const mobileCheckout = document.getElementById('bag-mobile-checkout');
    const escapeHtml = value => String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[char]));
    const money = value => 'PKR ' + Math.round(value).toLocaleString('en-PK');

    if (!AlAsraCart.read().length && initialCart.length) {
        AlAsraCart.save(initialCart.map(item => ({
            id: item.id,
            name: item.name,
            price: Number(item.price),
            image: item.image,
            qty: Number(item.quantity)
        })));
    }

    function render() {
        const items = AlAsraCart.read();
        const summary = AlAsraCart.summary();
        itemCount.textContent = summary.count + (summary.count === 1 ? ' item' : ' items');

        if (!items.length) {
            content.innerHTML = '<section class="bag-empty"><div class="bag-empty-icon" aria-hidden="true">⌑</div><h1>Your bag is empty</h1><p>Find something useful for your everyday routine.</p><a class="bag-shop-link" href="{{ route('shop') }}">Explore the shop</a></section>';
            mobileCheckout.hidden = true;
            return;
        }

        const rows = items.map(item => `
            <article class="bag-line">
                <img class="bag-image" src="${escapeHtml(item.image || '/logo.png')}" alt="${escapeHtml(item.name)}" loading="lazy">
                <div class="bag-item">
                    <div class="bag-item-top">
                        <div><h2>${escapeHtml(item.name)}</h2><p class="bag-unit">${money(item.price)} each</p></div>
                        <button class="bag-remove" type="button" data-remove="${escapeHtml(item.id)}" aria-label="Remove ${escapeHtml(item.name)}">Remove</button>
                    </div>
                    <div class="bag-item-bottom">
                        <div class="bag-quantity" aria-label="Quantity for ${escapeHtml(item.name)}">
                            <button type="button" data-step="-1" data-id="${escapeHtml(item.id)}" aria-label="Decrease quantity" ${item.qty <= 1 ? 'disabled' : ''}>−</button>
                            <span>${Number(item.qty)}</span>
                            <button type="button" data-step="1" data-id="${escapeHtml(item.id)}" aria-label="Increase quantity" ${item.qty >= 99 ? 'disabled' : ''}>+</button>
                        </div>
                        <b class="bag-line-total">${money(item.price * item.qty)}</b>
                    </div>
                </div>
            </article>
        `).join('');

        content.innerHTML = `
            <div class="bag-grid">
                <section aria-label="Bag items">
                    <div class="bag-lines">${rows}</div>
                    <a class="bag-continue" href="{{ route('shop') }}">← <span>Continue shopping</span></a>
                </section>
                <aside class="bag-summary">
                    <h2>Order summary</h2>
                    <p class="bag-progress-copy">${summary.amountUntilFree > 0 ? `Add <b>${money(summary.amountUntilFree)}</b> more for free delivery` : 'You have unlocked free delivery'}</p>
                    <div class="bag-progress" aria-label="Free delivery progress"><i style="width:${summary.shippingProgress}%"></i></div>
                    <div class="bag-totals">
                        <div class="bag-total-row"><span class="bag-muted">Subtotal</span><span>${money(summary.subtotal)}</span></div>
                        <div class="bag-total-row"><span class="bag-muted">Delivery</span><span>${summary.shipping ? money(summary.shipping) : 'Free'}</span></div>
                    </div>
                    <div class="bag-total-row bag-grand-total"><span>Total</span><b>${money(summary.total)}</b></div>
                    <a class="bag-checkout" href="{{ route('checkout.index') }}">Continue to checkout</a>
                    <p class="bag-muted" style="text-align:center;margin-top:10px">Cash on delivery available</p>
                </aside>
            </div>`;
        document.getElementById('bag-mobile-total').textContent = money(summary.total);
        mobileCheckout.hidden = false;
        AlAsraCart.render();
    }

    content.addEventListener('click', event => {
        const removeButton = event.target.closest('[data-remove]');
        if (removeButton) {
            AlAsraCart.remove(removeButton.dataset.remove);
            render();
            return;
        }
        const stepButton = event.target.closest('[data-step]');
        if (stepButton && !stepButton.disabled) {
            const current = AlAsraCart.read().find(item => String(item.id) === stepButton.dataset.id);
            if (current) AlAsraCart.setQty(current.id, Number(current.qty) + Number(stepButton.dataset.step));
            render();
        }
    });

    render();
})();
</script>
@endpush
