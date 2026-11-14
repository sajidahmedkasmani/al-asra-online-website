@extends('admin.admin_layout.master')
@section('title', 'Dashboard')

@section('content')
@php
    $hour = now('Asia/Karachi')->hour;
    $greet = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
    $name = explode(' ', trim(auth()->user()->name ?? 'Admin'))[0];

    // key => [label, icon path, route, permission]
    $cards = [
        'products'       => ['Products',      'M20 7l-8-4-8 4m16 0v10l-8 4m8-14l-8 4m0 10L4 17V7m8 14V11', 'admin.products.index', 'products.view'],
        'orders'         => ['Orders',        'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 5h6M9 12h6M9 16h4', 'admin.orders.index', 'orders.view'],
        'pending_orders' => ['Pending',       'M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z', 'admin.orders.index', 'orders.view'],
        'revenue'        => ['Revenue (Rs.)', 'M12 8c-1.7 0-3 .9-3 2s1.3 2 3 2 3 .9 3 2-1.3 2-3 2m0-8V6m0 12v-2m9-4a9 9 0 11-18 0 9 9 0 0118 0z', 'admin.orders.index', 'orders.view'],
    ];

    $badge = [
        'pending'    => 'bg-amber-50 text-amber-700',
        'processing' => 'bg-sky-50 text-sky-700',
        'confirmed'  => 'bg-sky-50 text-sky-700',
        'shipped'    => 'bg-brand-50 text-brand-700',
        'delivered'  => 'bg-emerald-50 text-emerald-700',
        'completed'  => 'bg-emerald-50 text-emerald-700',
        'cancelled'  => 'bg-rose-50 text-rose-700',
    ];
    $bar = [
        'pending'    => 'bg-amber-400',
        'processing' => 'bg-sky-400',
        'confirmed'  => 'bg-sky-400',
        'shipped'    => 'bg-brand-400',
        'delivered'  => 'bg-emerald-500',
        'completed'  => 'bg-emerald-500',
        'cancelled'  => 'bg-rose-400',
    ];

    $orders   = $recentOrders->values();
    $count    = $orders->count();
    $byStatus = $orders->groupBy(fn($o) => strtolower($o->status))->map->count();
    $chart    = $orders->reverse()->values();
    $max      = max((float) $chart->max('total'), 1);
    $pending  = (int) ($stats['pending_orders'] ?? 0);
@endphp

{{-- GREETING --}}
<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3 mb-5 md:mb-6 -mt-2">
    <div>
        <p class="text-sm text-gray-500">{{ now('Asia/Karachi')->format('l, d F Y') }}</p>
        @can('orders.view')
        <p class="text-[15px] mt-0.5">
            {{ $greet }}, {{ $name }}.
            @if($pending > 0)
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="font-medium text-brand-700 underline decoration-bloom-400 decoration-2 underline-offset-4">{{ $pending }} pending {{ \Illuminate\Support\Str::plural('order', $pending) }}</a> waiting for you.
            @else
                You're all caught up. No pending orders right now.
            @endif
        </p>
        @else
        <p class="text-[15px] mt-0.5">{{ $greet }}, {{ $name }}. Welcome to your admin dashboard.</p>
        @endcan
    </div>
    <div class="flex flex-wrap gap-2">
        @can('orders.view')
        <a href="{{ route('admin.orders.index') }}" class="btn-bloom text-sm font-medium rounded-xl px-4 py-2">View orders</a>
        @endcan
        @can('products.view')
        <a href="{{ route('admin.products.index') }}" class="bg-white border border-gray-300 hover:border-brand-600 hover:text-brand-700 transition text-sm font-medium rounded-xl px-4 py-2">Manage products</a>
        @endcan
    </div>
</div>

{{-- STATS: one ruled strip --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-px bg-gray-200 border border-gray-200 rounded-2xl overflow-hidden mb-5 md:mb-6">
    @foreach($cards as $k => [$label,$icon,$route,$permission])
        @can($permission)
        <a href="{{ route($route) }}" class="group bg-white hover:bg-brand-50/60 transition p-4 md:p-5 block">
            <div class="flex items-center justify-between gap-2">
                <p class="text-xs md:text-[13px] text-gray-500">{{ $label }}</p>
                <svg class="w-[18px] h-[18px] text-gray-300 group-hover:text-brand-600 transition" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $icon }}"/></svg>
            </div>
            <p class="text-2xl md:text-[32px] leading-none font-semibold tracking-tight mt-3 truncate"
               x-data="counter({{ (int) ($stats[$k] ?? 0) }})"
               x-text="v.toLocaleString()">{{ number_format($stats[$k] ?? 0) }}</p>
        </a>
        @endcan
    @endforeach
</div>

@can('orders.view')
<div class="grid xl:grid-cols-3 gap-5 md:gap-6">

    {{-- LEFT: chart + orders --}}
    <div class="xl:col-span-2 space-y-5 md:space-y-6 min-w-0">

        {{-- CHART --}}
        <div class="bg-white rounded-3xl soft p-5 md:p-6">
            <div class="flex items-start justify-between gap-3 mb-5">
                <div>
                    <h2 class="font-semibold">Recent order totals</h2>
                    <p class="text-xs text-gray-500">Last {{ $count }} {{ \Illuminate\Support\Str::plural('order', $count) }}, oldest to newest</p>
                </div>
                @if($count)
                <span class="flex items-center gap-1.5 text-xs text-gray-500 shrink-0"><span class="w-2.5 h-2.5 rounded-sm bg-bloom-400"></span>Highest</span>
                @endif
            </div>

            @if($count)
                <div class="flex items-end gap-2 md:gap-3 h-44 border-b border-gray-200">
                    @foreach($chart as $i => $o)
                        @php $h = max(8, round($o->total / $max * 100)); $top = (float) $o->total === (float) $max; @endphp
                        <div class="group relative flex-1 h-full flex flex-col justify-end items-center min-w-0">
                            <span class="absolute -top-1 left-1/2 -translate-x-1/2 -translate-y-full text-[11px] bg-ink text-white rounded-md px-2 py-1 whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none z-10">Rs. {{ number_format($o->total) }}</span>
                            <div class="bar-rise w-full max-w-[44px] rounded-t-md {{ $top ? 'bg-bloom-400 group-hover:bg-bloom-500' : 'bg-brand-500 group-hover:bg-brand-600' }} transition-colors"
                                 style="height:{{ $h }}%; --d:{{ 0.05 + $i * 0.04 }}s"></div>
                        </div>
                    @endforeach
                </div>
                <div class="flex gap-2 md:gap-3 mt-2">
                    @foreach($chart as $o)
                        <p class="flex-1 text-center text-[11px] text-gray-500 truncate">{{ $o->created_at->format('d M') }}</p>
                    @endforeach
                </div>
            @else
                <div class="h-44 flex flex-col items-center justify-center text-gray-500 text-sm border border-dashed border-gray-300 rounded-2xl">
                    <svg class="w-6 h-6 text-gray-300 mb-2" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 20V10m6 10V4m6 16v-7m4 7H2"/></svg>
                    The chart appears once orders come in.
                </div>
            @endif
        </div>

        {{-- ORDERS --}}
        <div class="bg-white rounded-3xl soft p-5 md:p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold">Recent orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-brand-600 hover:text-brand-700 hover:underline">View all</a>
            </div>

            {{-- mobile: cards --}}
            <div class="md:hidden space-y-3">
                @forelse($orders as $o)
                    @php $st = strtolower($o->status); @endphp
                    <a href="{{ route('admin.orders.show', $o) }}" class="block rounded-2xl border border-gray-200 p-4 active:bg-brand-50 transition">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="w-9 h-9 rounded-md bg-brand-100 text-brand-700 text-xs font-semibold flex items-center justify-center shrink-0">{{ strtoupper(substr($o->customer_name, 0, 1)) }}</span>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium truncate">{{ $o->customer_name }}</p>
                                    <p class="text-xs font-mono text-brand-600 truncate">{{ $o->order_number }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[11px] font-medium shrink-0 {{ $badge[$st] ?? 'bg-gray-100 text-gray-600' }}">{{ ucfirst($o->status) }}</span>
                        </div>
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100 text-xs">
                            <span class="font-semibold text-sm">Rs. {{ number_format($o->total) }}</span>
                            <span class="text-gray-500">{{ $o->created_at->format('d M Y') }}</span>
                        </div>
                    </a>
                @empty
                    <div class="py-10 text-center text-gray-500 text-sm">No orders yet.</div>
                @endforelse
            </div>

            {{-- desktop: table --}}
            <div class="hidden md:block overflow-x-auto scroll-thin">
                <table class="w-full text-sm">
                    <thead class="text-left text-xs text-gray-500">
                        <tr class="border-b border-gray-200">
                            <th class="py-2 font-medium">Order #</th>
                            <th class="font-medium">Customer</th>
                            <th class="font-medium">Total</th>
                            <th class="font-medium">Status</th>
                            <th class="font-medium text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $o)
                            @php $st = strtolower($o->status); @endphp
                            <tr class="border-b border-gray-100 last:border-0 hover:bg-brand-50/50 transition">
                                <td class="py-3">
                                    <a href="{{ route('admin.orders.show', $o) }}" class="text-brand-600 font-mono text-xs hover:underline">{{ $o->order_number }}</a>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-7 h-7 rounded-md bg-brand-100 text-brand-700 text-[11px] font-semibold flex items-center justify-center">{{ strtoupper(substr($o->customer_name, 0, 1)) }}</span>
                                        <span class="truncate max-w-[160px]">{{ $o->customer_name }}</span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap font-medium">Rs. {{ number_format($o->total) }}</td>
                                <td><span class="px-2 py-0.5 rounded text-xs font-medium {{ $badge[$st] ?? 'bg-gray-100 text-gray-600' }}">{{ ucfirst($o->status) }}</span></td>
                                <td class="text-xs text-gray-500 text-right whitespace-nowrap">{{ $o->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-10 text-center text-gray-500">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- RIGHT --}}
    <div class="space-y-5 md:space-y-6">
        <div class="bg-white rounded-3xl soft p-5 md:p-6">
            <h2 class="font-semibold mb-4">Order status</h2>
            @forelse($byStatus as $status => $n)
                @php $pct = $count ? round($n / $count * 100) : 0; @endphp
                <div class="mb-4 last:mb-0">
                    <div class="flex items-center justify-between text-xs mb-1.5">
                        <span class="px-2 py-0.5 rounded text-xs font-medium {{ $badge[$status] ?? 'bg-gray-100 text-gray-600' }}">{{ ucfirst($status) }}</span>
                        <span class="text-gray-500">{{ $n }} ({{ $pct }}%)</span>
                    </div>
                    <div class="h-1.5 rounded-full bg-gray-100 overflow-hidden">
                        <div class="h-full rounded-full {{ $bar[$status] ?? 'bg-gray-400' }}" style="width:{{ $pct }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Nothing to show yet.</p>
            @endforelse
        </div>

        <div class="bg-white rounded-3xl soft overflow-hidden">
            <h2 class="font-semibold px-5 md:px-6 pt-5 md:pt-6 pb-3">Quick actions</h2>
            <div class="divide-y divide-gray-100 text-sm">
                @php
                    $qa = 'flex items-center gap-3 px-5 md:px-6 py-3 hover:bg-brand-50/60 transition';
                    $qaIc = 'w-[18px] h-[18px] text-gray-400 shrink-0';
                @endphp
                <a href="{{ Route::has('admin.products.create') ? route('admin.products.create') : route('admin.products.index') }}" class="{{ $qa }}">
                    <svg class="{{ $qaIc }}" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                    <span class="flex-1">Add product</span>
                </a>
                @can('orders.view')
                <a href="{{ route('admin.orders.index') }}" class="{{ $qa }}">
                    <svg class="{{ $qaIc }}" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 5h6M9 12h6M9 16h4"/></svg>
                    <span class="flex-1">Orders</span>
                </a>
                @endcan
                @can('settings.view')
                <a href="{{ route('admin.settings.edit') }}" class="{{ $qa }}">
                    <svg class="{{ $qaIc }}" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 6h10M18 6h2M4 12h2M10 12h10M4 18h12M20 18h0"/><circle cx="16" cy="6" r="2"/><circle cx="8" cy="12" r="2"/><circle cx="18" cy="18" r="2"/></svg>
                    <span class="flex-1">Settings</span>
                </a>
                @endcan
                <a href="{{ route('home') }}" class="{{ $qa }}">
                    <svg class="{{ $qaIc }}" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1h5"/></svg>
                    <span class="flex-1">View site</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endcan
@endsection