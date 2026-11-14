@extends('admin.admin_layout.master')
@section('title', 'Campaigns')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
        <div>
            <p class="text-sm text-gray-500">Schedule discounts and choose which products they apply to.</p>
        </div>
        @can('products.create')
            <a href="{{ route('admin.campaigns.create') }}" class="btn-bloom rounded-2xl px-5 py-3 text-sm font-semibold text-center">
                Create campaign
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-3xl soft overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-4 font-semibold">Campaign</th>
                        <th class="px-5 py-4 font-semibold">Target</th>
                        <th class="px-5 py-4 font-semibold">Discount</th>
                        <th class="px-5 py-4 font-semibold">Schedule</th>
                        <th class="px-5 py-4 font-semibold">Status</th>
                        <th class="px-5 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($campaigns as $campaign)
                        @php
                            $target = match ($campaign->type) {
                                'category' => $campaign->category?->name ?? 'Category removed',
                                'product' => $campaign->product?->name ?? 'Product removed',
                                'price_range' => 'Rs. '.number_format($campaign->price_min).' – '.number_format($campaign->price_max),
                                default => 'All active products',
                            };
                            $status = !$campaign->is_active
                                ? 'Off'
                                : ($campaign->starts_at->isFuture()
                                    ? 'Scheduled'
                                    : ($campaign->ends_at && $campaign->ends_at->isPast() ? 'Ended' : 'Active'));
                            $statusClass = match ($status) {
                                'Active' => 'bg-emerald-50 text-emerald-700',
                                'Scheduled' => 'bg-sky-50 text-sky-700',
                                default => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <tr>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-ink">{{ $campaign->name }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ str_replace('_', ' ', ucfirst($campaign->type)) }}</p>
                            </td>
                            <td class="px-5 py-4 text-gray-600">{{ $target }}</td>
                            <td class="px-5 py-4 font-medium whitespace-nowrap">
                                {{ number_format((float) $campaign->discount_value, 2) }}
                                {{ $campaign->discount_type === 'percentage' ? '%' : 'Rs.' }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-gray-600">
                                <p>{{ $campaign->starts_at->format('M j, Y H:i') }}</p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Until {{ $campaign->ends_at?->format('M j, Y H:i') ?? 'No end date' }}
                                </p>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">{{ $status }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end items-center gap-2">
                                    @can('products.edit')
                                        <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="rounded-xl bg-gray-100 px-3 py-2 text-xs font-medium hover:bg-gray-200">Edit</a>
                                        <form method="POST" action="{{ route('admin.campaigns.toggle', $campaign) }}">
                                            @csrf
                                            <button class="rounded-xl px-3 py-2 text-xs font-medium {{ $campaign->is_active ? 'bg-amber-50 text-amber-700 hover:bg-amber-100' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                                {{ $campaign->is_active ? 'Turn off' : 'Turn on' }}
                                            </button>
                                        </form>
                                    @endcan
                                    @can('products.delete')
                                        <form method="POST" action="{{ route('admin.campaigns.destroy', $campaign) }}" onsubmit="return confirm('Delete this campaign?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="rounded-xl bg-rose-50 px-3 py-2 text-xs font-medium text-rose-700 hover:bg-rose-100">Delete</button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-gray-500">
                                No campaigns yet. Create one to schedule your first discount.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($campaigns->hasPages())
            <div class="border-t border-gray-100 px-5 py-4">{{ $campaigns->links() }}</div>
        @endif
    </div>
@endsection
