@extends('storefront.layout')
@section('title', 'Checkout | Al-Asra Store')

@push('head')
<style>
.checkout-wrap{width:min(1180px,100%);margin:0 auto;padding:48px 5vw 70px}
.checkout-head{margin-bottom:30px}
.checkout-head .kick{display:block;margin-bottom:8px}
.checkout-head h1{font-size:clamp(32px,5vw,52px);line-height:1.08;color:var(--plum)}
.checkout-layout{display:grid;grid-template-columns:minmax(0,1.35fr) minmax(300px,.8fr);gap:36px;align-items:start}
.checkout-card{padding:clamp(20px,3vw,32px);border:1px solid #5a10241a;border-radius:18px;background:#fff}
.checkout-card h2{margin-bottom:22px;font-size:24px}
.checkout-fields{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}
.checkout-field{display:grid;gap:7px;min-width:0}
.checkout-field.full{grid-column:1/-1}
.checkout-field label{font-size:12px;font-weight:700;color:var(--plum)}
.checkout-field input,.checkout-field textarea{width:100%;min-height:46px;padding:12px 14px;border:1px solid #5a10242a;border-radius:10px;background:#fff;color:var(--ink);font:inherit;font-size:13px}
.checkout-field textarea{min-height:92px;resize:vertical}
.checkout-field input:focus,.checkout-field textarea:focus{outline:2px solid #f24c0040;border-color:var(--orange)}
.checkout-error{color:#b42318;font-size:11px}
.checkout-alert{margin-bottom:18px;padding:12px 14px;border:1px solid #e8bbb1;border-radius:10px;background:#fff5f2;color:#8f2f20;font-size:12px}
.checkout-muted{color:#765c62;font-size:12px}
.checkout-payment{display:grid;gap:10px;margin-top:24px}
.checkout-payment h3{margin-bottom:2px;font-size:18px}
.checkout-payment label{display:flex;align-items:center;gap:10px;padding:13px;border:1px solid #5a10242a;border-radius:10px;background:#fff;font-size:13px;cursor:pointer}
.checkout-payment input{accent-color:var(--plum)}
.checkout-place-order{width:100%;margin-top:22px;padding:15px 20px;border:0;border-radius:99px;background:var(--plum);color:#fff;font:700 13px 'DM Sans';cursor:pointer}
.checkout-place-order:hover{background:var(--orange)}
.checkout-place-order:disabled{opacity:.6;cursor:wait}
.checkout-summary{position:sticky;top:105px}
.checkout-summary h2{margin-bottom:18px;font-size:24px}
.checkout-items{display:grid;gap:12px;max-height:330px;overflow:auto;padding-right:3px}
.checkout-item{display:grid;grid-template-columns:58px minmax(0,1fr) auto;gap:11px;align-items:center}
.checkout-item img{width:58px;height:64px;border-radius:9px;background:#f7f4f0;object-fit:contain;padding:5px}
.checkout-item-name{font-size:12px;line-height:1.4}
.checkout-item-qty{margin-top:3px;color:#765c62;font-size:11px}
.checkout-item-price{font-size:12px;font-weight:700}
.checkout-summary-totals{display:grid;gap:11px;margin-top:18px;padding-top:17px;border-top:1px solid var(--line);font-size:12px}
.checkout-summary-row{display:flex;justify-content:space-between;gap:10px}
.checkout-grand-total{margin-top:4px;padding-top:14px;border-top:1px solid var(--line);font-weight:700}
.checkout-grand-total b{font-size:22px;color:var(--plum)}
.checkout-delivery{margin-top:18px;color:#765c62;font-size:11px;line-height:1.6}
@media(max-width:800px){.checkout-layout{grid-template-columns:1fr;gap:18px}.checkout-summary{position:static;order:-1}}
@media(max-width:520px){.checkout-wrap{padding:32px 5vw 48px}.checkout-fields{grid-template-columns:1fr}.checkout-field.full{grid-column:auto}.checkout-item{grid-template-columns:50px minmax(0,1fr) auto}.checkout-item img{width:50px;height:56px}}
</style>
@endpush

@section('content')
<main class="checkout-wrap">
    <header class="checkout-head">
        <span class="kick">Almost there</span>
        <h1>Checkout</h1>
    </header>

    @if(session('error'))
        <p class="checkout-alert" role="alert">{{ session('error') }}</p>
    @endif
    @if($errors->any())
        <div class="checkout-alert" role="alert">Please review the highlighted details and try again.</div>
    @endif
    <p class="checkout-alert" id="checkout-cart-error" role="alert" hidden></p>

    <div class="checkout-layout">
        <section class="checkout-card">
            @guest('customer')
                <div class="checkout-alert" style="border-color:#e8d8c8;background:#fffaf6;color:var(--ink)">
                    <strong>Have an account?</strong> <a href="{{ route('customer.login') }}" style="text-decoration:underline">Log in</a> for a faster checkout, or continue as a guest.
                </div>
            @endguest
            @auth('customer')
                <p class="checkout-alert" style="border-color:#c7e2ca;background:#f3fbf3;color:#265b30">
                    Logged in as <strong>{{ auth('customer')->user()->name }}</strong>.
                </p>
            @endauth

            <h2>Delivery details</h2>
            <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="checkout-fields">
                    <div class="checkout-field">
                        <label for="checkout-name">Full name</label>
                        <input id="checkout-name" name="customer_name" value="{{ old('customer_name', auth('customer')->user()->name ?? '') }}" autocomplete="name" required>
                        @error('customer_name')<span class="checkout-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="checkout-field">
                        <label for="checkout-email">Email address</label>
                        <input id="checkout-email" type="email" name="email" value="{{ old('email', auth('customer')->user()->email ?? '') }}" autocomplete="email" required>
                        @error('email')<span class="checkout-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="checkout-field">
                        <label for="checkout-phone">Phone number</label>
                        <input id="checkout-phone" name="phone" value="{{ old('phone') }}" autocomplete="tel" required>
                        @error('phone')<span class="checkout-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="checkout-field">
                        <label for="checkout-city">City</label>
                        <input id="checkout-city" name="city" value="{{ old('city') }}" autocomplete="address-level2" required>
                        @error('city')<span class="checkout-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="checkout-field full">
                        <label for="checkout-address">Complete delivery address</label>
                        <textarea id="checkout-address" name="address" autocomplete="street-address" required>{{ old('address') }}</textarea>
                        @error('address')<span class="checkout-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="checkout-field full">
                        <label for="checkout-notes">Order notes <span class="checkout-muted">(optional)</span></label>
                        <textarea id="checkout-notes" name="notes">{{ old('notes') }}</textarea>
                        @error('notes')<span class="checkout-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="checkout-payment">
                    <h3>Payment method</h3>
                    <label><input type="radio" name="payment_method" value="cod" @checked(old('payment_method', 'cod') === 'cod') required> <span>Cash on delivery</span></label>
                    <label><input type="radio" name="payment_method" value="bank_transfer" @checked(old('payment_method') === 'bank_transfer') required> <span>Bank transfer</span></label>
                    @error('payment_method')<span class="checkout-error">{{ $message }}</span>@enderror
                </div>

                <button class="checkout-place-order" id="checkout-submit" type="submit">Place order</button>
            </form>
        </section>

        <aside class="checkout-card checkout-summary">
            <h2>Your order</h2>
            <div id="checkout-items" class="checkout-items"></div>
            <div id="checkout-totals" class="checkout-summary-totals"></div>
            <p class="checkout-delivery">Delivery fee is calculated from your order total. Free delivery on eligible orders.</p>
        </aside>
    </div>
</main>
@endsection

@push('scripts')
<script>
(() => {
    const initialCart = @json(array_values($cart));
    const itemsElement = document.getElementById('checkout-items');
    const totalsElement = document.getElementById('checkout-totals');
    const form = document.getElementById('checkout-form');
    const errorElement = document.getElementById('checkout-cart-error');
    const submitButton = document.getElementById('checkout-submit');
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

    function renderOrder() {
        const items = AlAsraCart.read();
        const summary = AlAsraCart.summary();
        itemsElement.innerHTML = items.length ? items.map(item => `
            <div class="checkout-item">
                <img src="${escapeHtml(item.image || '/logo.png')}" alt="${escapeHtml(item.name)}">
                <div><p class="checkout-item-name">${escapeHtml(item.name)}</p><p class="checkout-item-qty">Qty ${Number(item.qty)}</p></div>
                <b class="checkout-item-price">${money(item.price * item.qty)}</b>
            </div>
        `).join('') : '<p class="checkout-muted">Your bag is empty. <a href="{{ route('shop') }}" style="text-decoration:underline">Continue shopping</a>.</p>';
        totalsElement.innerHTML = `
            <div class="checkout-summary-row"><span class="checkout-muted">Subtotal</span><span>${money(summary.subtotal)}</span></div>
            <div class="checkout-summary-row"><span class="checkout-muted">Delivery</span><span>${summary.shipping ? money(summary.shipping) : 'Free'}</span></div>
            <div class="checkout-summary-row checkout-grand-total"><span>Total</span><b>${money(summary.total)}</b></div>`;
        submitButton.disabled = summary.count === 0;
    }

    form.addEventListener('submit', async event => {
        if (form.dataset.synced === 'true') return;
        event.preventDefault();
        errorElement.hidden = true;
        submitButton.disabled = true;
        submitButton.textContent = 'Preparing your order…';

        try {
            const result = await AlAsraCart.sync();
            if (!result.summary.item_count) {
                throw new Error('Your bag is empty. Add products before checking out.');
            }
            form.dataset.synced = 'true';
            form.requestSubmit(event.submitter);
        } catch (error) {
            errorElement.textContent = error.message || 'We could not prepare your order. Please try again.';
            errorElement.hidden = false;
            submitButton.disabled = false;
            submitButton.textContent = 'Place order';
            renderOrder();
        }
    });

    renderOrder();
})();
</script>
@endpush
