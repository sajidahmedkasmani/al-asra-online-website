@extends('admin.admin_layout.master')
@section('title', 'Dashboard')

@section('content')
@php
    $hour = now('Asia/Karachi')->hour;
    $greet = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
    $name = explode(' ', trim(auth()->user()->name ?? 'Admin'))[0];

    $cards = [
        'products'       => ['Products',      'from-brand-400 to-brand-600',  'bg-brand-100',  'M20 7l-8-4-8 4m16 0v10l-8 4m8-14l-8 4m0 10L4 17V7m8 14V11', 'admin.products.index', 'products.view'],
        'orders'         => ['Orders',        'from-sky-400 to-blue-600',     'bg-sky-100',    'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 5h6M9 12h6M9 16h4', 'admin.orders.index', 'orders.view'],
        'pending_orders' => ['Pending',       'from-amber-300 to-orange-500', 'bg-amber-100',  'M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z', 'admin.orders.index', 'orders.view'],
        'revenue'        => ['Revenue (Rs.)', 'from-bloom-400 to-bloom-500',  'bg-violet-100', 'M12 8c-1.7 0-3 .9-3 2s1.3 2 3 2 3 .9 3 2-1.3 2-3 2m0-8V6m0 12v-2m9-4a9 9 0 11-18 0 9 9 0 0118 0z', 'admin.orders.index', 'orders.view'],
    ];

    $badge = [
        'pending'    => 'bg-amber-50 text-amber-600',
        'processing' => 'bg-sky-50 text-sky-600',
        'confirmed'  => 'bg-sky-50 text-sky-600',
        'shipped'    => 'bg-violet-50 text-violet-600',
        'delivered'  => 'bg-emerald-50 text-emerald-600',
        'completed'  => 'bg-emerald-50 text-emerald-600',
        'cancelled'  => 'bg-rose-50 text-rose-600',
    ];
    $hex = [
        'pending'    => '#F59E0B',
        'processing' => '#0EA5E9',
        'confirmed'  => '#0EA5E9',
        'shipped'    => '#8B5CF6',
        'delivered'  => '#10B981',
        'completed'  => '#10B981',
        'cancelled'  => '#F43F5E',
    ];

    $orders   = $recentOrders->values();
    $count    = $orders->count();
    $byStatus = $orders->groupBy(fn($o) => strtolower($o->status))->map->count();
    $chart    = $orders->reverse()->values();
    $max      = max((float) $chart->max('total'), 1);
    $pending  = (int) ($stats['pending_orders'] ?? 0);

    // conic-gradient donut for the status split
    $acc = 0; $segs = [];
    foreach ($byStatus as $s => $n) {
        $p = $count ? $n / $count * 100 : 0;
        $segs[] = ($hex[$s] ?? '#94A3B8') . ' ' . round($acc, 2) . '% ' . round($acc + $p, 2) . '%';
        $acc += $p;
    }
    $donut = $segs ? 'conic-gradient(' . implode(',', $segs) . ')' : '#E5E7EB';
@endphp

{{-- HERO --}}
<div class="rise relative overflow-hidden rounded-[28px] bg-gradient-to-br from-brand-700 via-brand-600 to-sky-600 text-white p-6 md:p-9 mb-5 md:mb-6 shadow-xl shadow-brand-700/25">
    <div class="pointer-events-none absolute -right-16 -top-20 w-72 h-72 rounded-full bg-white/15 blur-2xl"></div>
    <div class="pointer-events-none absolute right-40 -bottom-24 w-64 h-64 rounded-full bg-bloom-400/50 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-10 -bottom-16 w-52 h-52 rounded-full bg-brand-300/30 blur-3xl"></div>

    <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="max-w-xl">
            <p class="inline-flex items-center gap-2 text-xs bg-white/15 backdrop-blur rounded-full px-3 py-1 mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-brand-200 animate-pulse"></span>{{ now('Asia/Karachi')->format('l, d F Y') }}
            </p>
            <h2 class="text-3xl md:text-[40px] font-extrabold leading-[1.1] tracking-tight">{{ $greet }}, {{ $name }}</h2>
            @can('orders.view')
            <p class="text-sm md:text-base text-white/85 mt-3">
                @if($pending > 0)
                    You have <span class="font-bold text-white">{{ $pending }} pending {{ \Illuminate\Support\Str::plural('order', $pending) }}</span> waiting for you.
                @else
                    You're all caught up. No pending orders right now.
                @endif
            </p>
            @else
            <p class="text-sm md:text-base text-white/85 mt-3">Welcome to your admin dashboard.</p>
            @endcan
            <div class="flex flex-wrap gap-2.5 mt-6">
                @can('orders.view')
                <a href="{{ route('admin.orders.index') }}" class="bg-white text-brand-700 hover:bg-brand-50 text-sm font-semibold rounded-2xl px-6 py-3 shadow-lg shadow-black/10 transition active:scale-95">View orders</a>
                @endcan
                @can('products.view')
                <a href="{{ route('admin.products.index') }}" class="bg-white/15 hover:bg-white/25 backdrop-blur ring-1 ring-white/25 transition text-sm font-semibold rounded-2xl px-6 py-3 active:scale-95">Manage products</a>
                @endcan
            </div>
        </div>

        @can('orders.view')
        <div class="relative shrink-0 w-full lg:w-64 rounded-3xl bg-white/15 backdrop-blur-md ring-1 ring-white/25 p-5">
            <p class="text-xs text-white/75">Waiting for action</p>
            <p class="text-5xl font-extrabold tracking-tight mt-1 tabular-nums">{{ number_format($pending) }}</p>
            <p class="text-xs text-white/75 mt-1">pending {{ \Illuminate\Support\Str::plural('order', $pending) }}</p>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold bg-white/20 hover:bg-white/30 rounded-xl px-3 py-2 transition">Review now
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
        </div>
        @endcan
    </div>
</div>

{{-- STAT CARDS --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-3 md:gap-5 mb-5 md:mb-6">
    @foreach($cards as $k => [$label,$grad,$tint,$icon,$route,$permission])
        @can($permission)
        <a href="{{ route($route) }}" class="rise lift relative overflow-hidden bg-white rounded-3xl soft p-4 md:p-5 block" style="--d:{{ 0.06 * ($loop->index + 1) }}s">
            <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full {{ $tint }} opacity-80"></div>
            <div class="relative">
                <div class="w-11 h-11 md:w-12 md:h-12 rounded-2xl bg-gradient-to-br {{ $grad }} text-white flex items-center justify-center shadow-lg mb-4">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $icon }}"/></svg>
                </div>
                <p class="text-xs md:text-[13px] font-medium text-gray-500">{{ $label }}</p>
                <p class="text-2xl md:text-[28px] font-extrabold tracking-tight mt-0.5 truncate tabular-nums"
                   x-data="counter({{ (int) ($stats[$k] ?? 0) }})"
                   x-text="v.toLocaleString()">{{ number_format($stats[$k] ?? 0) }}</p>
            </div>
        </a>
        @endcan
    @endforeach
</div>

@can('orders.view')
<div class="grid xl:grid-cols-3 gap-5 md:gap-6">

    {{-- LEFT: chart + orders --}}
    <div class="xl:col-span-2 space-y-5 md:space-y-6 min-w-0">

        {{-- CHART --}}
        <div class="rise bg-white rounded-[28px] soft p-5 md:p-7" style="--d:.3s">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-bold text-lg">Recent order totals</h2>
                    <p class="text-xs text-gray-400">Last {{ $count }} {{ \Illuminate\Support\Str::plural('order', $count) }}, oldest to newest</p>
                </div>
                <span class="text-xs font-semibold bg-brand-50 text-brand-700 rounded-full px-3 py-1.5">Rs.</span>
            </div>

            @if($count)
                <div class="flex items-end gap-2 md:gap-4 h-48 rounded-2xl bg-[linear-gradient(to_bottom,transparent_0,transparent_calc(25%-1px),#EEF2F1_calc(25%-1px),#EEF2F1_25%)] bg-[length:100%_25%]">
                    @foreach($chart as $i => $o)
                        @php $h = max(8, round($o->total / $max * 100)); @endphp
                        <div class="group relative flex-1 h-full flex flex-col justify-end items-center min-w-0">
                            <span class="absolute -top-1 left-1/2 -translate-x-1/2 -translate-y-full text-[11px] font-semibold bg-ink text-white rounded-lg px-2.5 py-1 whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none z-10">Rs. {{ number_format($o->total) }}</span>
                            <div class="bar-rise w-full max-w-[48px] rounded-t-2xl bg-gradient-to-t from-brand-600 via-brand-400 to-sky-300 group-hover:from-bloom-500 group-hover:via-bloom-400 group-hover:to-sky-300 transition-colors shadow-lg shadow-brand-500/20"
                                 style="height:{{ $h }}%; --d:{{ 0.35 + $i * 0.06 }}s"></div>
                        </div>
                    @endforeach
                </div>
                <div class="flex gap-2 md:gap-4 mt-3">
                    @foreach($chart as $o)
                        <p class="flex-1 text-center text-[11px] text-gray-400 truncate">{{ $o->created_at->format('d M') }}</p>
                    @endforeach
                </div>
            @else
                <div class="h-48 flex flex-col items-center justify-center text-gray-400 text-sm">
                    <div class="w-14 h-14 rounded-2xl bg-brand-50 text-brand-500 flex items-center justify-center mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 20V10m6 10V4m6 16v-7m4 7H2"/></svg>
                    </div>
                    The chart appears once orders come in.
                </div>
            @endif
        </div>

        {{-- ORDERS --}}
        <div class="rise bg-white rounded-[28px] soft p-5 md:p-7" style="--d:.4s">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-bold text-lg">Recent orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-brand-700 bg-brand-50 hover:bg-brand-100 rounded-full px-4 py-2 transition">View all</a>
            </div>

            {{-- mobile: cards --}}
            <div class="md:hidden space-y-3">
                @forelse($orders as $o)
                    @php $st = strtolower($o->status); @endphp
                    <a href="{{ route('admin.orders.show', $o) }}" class="block rounded-3xl bg-gray-50/80 ring-1 ring-gray-100 p-4 active:bg-brand-50 transition">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-400 to-bloom-400 text-white text-sm font-bold flex items-center justify-center shrink-0">{{ strtoupper(substr($o->customer_name, 0, 1)) }}</span>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold truncate">{{ $o->customer_name }}</p>
                                    <p class="text-[11px] font-mono text-brand-600 truncate">{{ $o->order_number }}</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold shrink-0 {{ $badge[$st] ?? 'bg-gray-100 text-gray-600' }}">{{ ucfirst($o->status) }}</span>
                        </div>
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-200/70 text-xs">
                            <span class="font-bold text-sm">Rs. {{ number_format($o->total) }}</span>
                            <span class="text-gray-400">{{ $o->created_at->format('d M Y') }}</span>
                        </div>
                    </a>
                @empty
                    <div class="py-10 text-center text-gray-400 text-sm">No orders yet.</div>
                @endforelse
            </div>

            {{-- desktop: table --}}
            <div class="hidden md:block overflow-x-auto scroll-thin">
                <table class="w-full text-sm border-separate border-spacing-y-1.5">
                    <thead class="text-left text-xs text-gray-400">
                        <tr>
                            <th class="pb-1 pl-3 font-medium">Order #</th>
                            <th class="pb-1 font-medium">Customer</th>
                            <th class="pb-1 font-medium">Total</th>
                            <th class="pb-1 font-medium">Status</th>
                            <th class="pb-1 pr-3 font-medium text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $o)
                            @php $st = strtolower($o->status); @endphp
                            <tr class="group hover:bg-brand-50/70 transition">
                                <td class="py-2.5 pl-3 rounded-l-2xl">
                                    <a href="{{ route('admin.orders.show', $o) }}" class="text-brand-700 font-mono text-xs font-medium hover:underline">{{ $o->order_number }}</a>
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <span class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-400 to-bloom-400 text-white text-xs font-bold flex items-center justify-center">{{ strtoupper(substr($o->customer_name, 0, 1)) }}</span>
                                        <span class="truncate max-w-[160px] font-medium">{{ $o->customer_name }}</span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap font-bold">Rs. {{ number_format($o->total) }}</td>
                                <td><span class="px-3 py-1 rounded-full text-[11px] font-semibold {{ $badge[$st] ?? 'bg-gray-100 text-gray-600' }}">{{ ucfirst($o->status) }}</span></td>
                                <td class="pr-3 text-xs text-gray-400 text-right whitespace-nowrap rounded-r-2xl">{{ $o->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-10 text-center text-gray-400">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- RIGHT --}}
    <div class="space-y-5 md:space-y-6">
        <div class="rise bg-white rounded-[28px] soft p-5 md:p-7" style="--d:.45s">
            <h2 class="font-bold text-lg mb-5">Order status</h2>
            @if($count)
                <div class="relative w-40 h-40 mx-auto mb-6">
                    <div class="absolute inset-0 rounded-full shadow-lg shadow-ink/10" style="background: {{ $donut }}"></div>
                    <div class="absolute inset-[18px] rounded-full bg-white flex flex-col items-center justify-center">
                        <span class="text-3xl font-extrabold leading-none tabular-nums">{{ $count }}</span>
                        <span class="text-[11px] text-gray-400 mt-1">{{ \Illuminate\Support\Str::plural('order', $count) }}</span>
                    </div>
                </div>
            @endif
            @forelse($byStatus as $status => $n)
                @php $pct = $count ? round($n / $count * 100) : 0; @endphp
                <div class="flex items-center justify-between gap-3 py-2.5 border-t border-gray-100 first:border-0 text-sm">
                    <span class="flex items-center gap-2.5 min-w-0">
                        <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background: {{ $hex[$status] ?? '#94A3B8' }}"></span>
                        <span class="truncate">{{ ucfirst($status) }}</span>
                    </span>
                    <span class="text-gray-400 text-xs tabular-nums">{{ $n }} · {{ $pct }}%</span>
                </div>
            @empty
                <p class="text-sm text-gray-400">Nothing to show yet.</p>
            @endforelse
        </div>

        <div class="rise bg-white rounded-[28px] soft p-5 md:p-7" style="--d:.5s">
            <h2 class="font-bold text-lg mb-4">Quick actions</h2>
            @php
                $qa = 'lift flex items-center gap-3 rounded-2xl p-3.5 text-sm font-semibold';
                $ic = 'w-10 h-10 rounded-xl flex items-center justify-center shrink-0 text-white shadow-md';
            @endphp
            <div class="grid gap-2.5">
                <a href="{{ Route::has('admin.products.create') ? route('admin.products.create') : route('admin.products.index') }}" class="{{ $qa }} bg-brand-50 text-brand-700">
                    <span class="{{ $ic }} bg-gradient-to-br from-brand-400 to-brand-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg></span>Add product
                </a>
                @can('orders.view')
                <a href="{{ route('admin.orders.index') }}" class="{{ $qa }} bg-amber-50 text-amber-700">
                    <span class="{{ $ic }} bg-gradient-to-br from-amber-300 to-orange-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 5h6M9 12h6M9 16h4"/></svg></span>Orders
                </a>
                @endcan
                @can('settings.view')
                <a href="{{ route('admin.settings.edit') }}" class="{{ $qa }} bg-sky-50 text-sky-700">
                    <span class="{{ $ic }} bg-gradient-to-br from-sky-400 to-blue-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 6h10M18 6h2M4 12h2M10 12h10M4 18h12"/><circle cx="16" cy="6" r="2"/><circle cx="8" cy="12" r="2"/><circle cx="18" cy="18" r="2"/></svg></span>Settings
                </a>
                @endcan
                <a href="{{ route('home') }}" class="{{ $qa }} bg-violet-50 text-violet-700">
                    <span class="{{ $ic }} bg-gradient-to-br from-bloom-400 to-bloom-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1h5"/></svg></span>View site
                </a>
            </div>
        </div>
    </div>
</div>
@endcan
@endsection