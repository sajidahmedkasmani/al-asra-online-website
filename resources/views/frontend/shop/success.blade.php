@extends('storefront.layout')
@section('title', 'Order confirmed | Al-Asra Store')

@push('head')
<style>
.success-wrap{width:min(760px,100%);margin:0 auto;padding:52px 5vw 76px}
.success-card{padding:clamp(24px,5vw,48px);border:1px solid #5a10241a;border-radius:22px;background:#fff;box-shadow:0 16px 55px -38px #5a102455}
.success-mark{display:grid;place-items:center;width:66px;height:66px;margin:0 auto 18px;border-radius:50%;background:#edf8ef;color:#28763b;font-size:32px}
.success-intro{text-align:center}
.success-intro h1{font-size:clamp(30px,5vw,46px);line-height:1.1;color:var(--plum)}
.success-intro p{margin-top:10px;color:#765c62;font-size:13px}
.success-number{display:inline-block;margin-top:12px;padding:8px 14px;border-radius:99px;background:#fff4ea;color:var(--plum);font-size:12px;font-weight:700}
.success-payment{margin-top:26px;padding:18px;border:1px solid #e8d8c8;border-radius:14px;background:#fffaf6;font-size:12px;line-height:1.7}
.success-payment h2{margin-bottom:7px;font-size:18px}
.success-payment ul{margin:8px 0 0;padding-left:19px}
.success-items{margin-top:28px;padding-top:20px;border-top:1px solid var(--line)}
.success-items h2{margin-bottom:12px;font-size:20px}
.success-line,.success-total{display:flex;justify-content:space-between;gap:12px;padding:8px 0;font-size:12px}
.success-total{margin-top:8px;padding-top:15px;border-top:1px solid var(--line);font-size:13px}
.success-total b{font-size:20px;color:var(--plum)}
.success-account{margin-top:24px;padding:18px;border:1px solid #f2c5d6;border-radius:14px;background:#fff7fa;font-size:12px;line-height:1.6}
.success-account h2{margin-bottom:6px;font-size:18px}
.success-actions{display:flex;justify-content:center;flex-wrap:wrap;gap:10px;margin-top:26px}
.success-actions a{padding:13px 22px;border:1px solid var(--plum);border-radius:99px;color:var(--plum);font-size:12px;font-weight:700}
.success-actions a.primary{background:var(--plum);color:#fff}
.success-actions a:hover{background:var(--orange);border-color:var(--orange);color:#fff}
</style>
@endpush

@section('content')
@php
    $s = config('app.settings', []);
    $shipping = (int) ($order->shipping_paisa ?? 0);
    $orderTotal = (float) ($order->total ?? 0);
@endphp
<main class="success-wrap">
    <article class="success-card">
        <header class="success-intro">
            <div class="success-mark" aria-hidden="true">✓</div>
            <span class="kick">Thank you for shopping with us</span>
            <h1>Order confirmed</h1>
            <p>We've received your order and will contact you with delivery updates.</p>
            <span class="success-number">Order #{{ $order->order_number }}</span>
        </header>

        @if($order->payment_method === 'bank_transfer')
            <section class="success-payment">
                <h2>Bank transfer instructions</h2>
                <p>Please transfer <strong>PKR {{ number_format($orderTotal) }}</strong> to:</p>
                <ul>
                    <li><strong>Bank:</strong> {{ $s['bank_name'] ?? 'Meezan Bank' }}</li>
                    <li><strong>Account title:</strong> {{ $s['bank_account_title'] ?? 'G. Collection' }}</li>
                    <li><strong>Account number:</strong> {{ $s['bank_account_no'] ?? '1234567890' }}</li>
                    <li><strong>IBAN:</strong> {{ $s['bank_iban'] ?? 'PK00MEZN0000000012345678' }}</li>
                </ul>
                <p style="margin-top:8px">After transfer, send a screenshot to WhatsApp: {{ $s['whatsapp_number'] ?? '0300-1234567' }}</p>
            </section>
        @else
            <section class="success-payment">
                You will pay <strong>PKR {{ number_format($orderTotal) }}</strong> in cash when your order is delivered.
            </section>
        @endif

        <section class="success-items" aria-label="Order details">
            <h2>Order details</h2>
            @foreach($order->items as $item)
                @php $unitPrice = isset($item->unit_price_paisa) ? $item->unit_price_paisa / 100 : (float) $item->price; @endphp
                <div class="success-line">
                    <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                    <span>PKR {{ number_format($unitPrice * $item->quantity) }}</span>
                </div>
            @endforeach
            <div class="success-line">
                <span>Delivery</span>
                <span>{{ $shipping > 0 ? 'PKR '.number_format($shipping / 100) : 'Free' }}</span>
            </div>
            <div class="success-total">
                <span>Total paid on delivery</span>
                <b>PKR {{ number_format($orderTotal) }}</b>
            </div>
        </section>

        @guest('customer')
            <section class="success-account">
                <h2>Create an account</h2>
                <p>Register with {{ $order->email }} to track this order and get more from your next visit.</p>
                <a href="{{ route('customer.register', ['email' => $order->email]) }}" style="text-decoration:underline">Create your account</a>
            </section>
        @endguest

        @auth('customer')
            <section class="success-account">
                Loyalty points earned on this order will appear in your account.
                <a href="{{ route('customer.dashboard') }}" style="text-decoration:underline">View account</a>
            </section>
        @endauth

        <nav class="success-actions" aria-label="Next steps">
            <a class="primary" href="{{ route('shop') }}">Continue shopping</a>
            @auth('customer')
                <a href="{{ route('customer.dashboard') }}">My account</a>
            @endauth
        </nav>
    </article>
</main>
@endsection

@if(session('clear_cart'))
    @push('scripts')
        <script>AlAsraCart.save([]);</script>
    @endpush
@endif