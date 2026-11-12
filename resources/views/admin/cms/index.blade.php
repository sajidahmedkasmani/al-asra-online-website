@extends('admin.admin_layout.master')
@section('title', 'Website Content (CMS)')

@section('content')
@php
    $homeSections = [
        [
            'title' => 'Shop by category',
            'fields' => [
                ['key' => 'store_home_categories_eyebrow', 'label' => 'Small heading', 'default' => 'Shop by category'],
                ['key' => 'store_home_categories_title', 'label' => 'Section title', 'default' => 'Find what you need'],
            ],
        ],
        [
            'title' => 'Featured products',
            'fields' => [
                ['key' => 'store_home_products_eyebrow', 'label' => 'Small heading', 'default' => 'Our selection'],
                ['key' => 'store_home_products_title', 'label' => 'Section title', 'default' => 'Fresh from our shelves'],
            ],
        ],
        [
            'title' => 'Why Al-Asra',
            'fields' => [
                ['key' => 'store_home_why_eyebrow', 'label' => 'Small heading', 'default' => 'Why Al-Asra'],
                ['key' => 'store_home_why_title', 'label' => 'Title', 'default' => 'Original products you can trust.'],
                ['key' => 'store_home_why_description', 'label' => 'Description', 'default' => 'Every item is checked before it ships from Karachi to your door.', 'type' => 'textarea'],
                ['key' => 'store_home_why_button_text', 'label' => 'Button text', 'default' => 'Browse the shop'],
                ['key' => 'store_home_why_button_url', 'label' => 'Button link', 'default' => '/shop'],
            ],
        ],
        [
            'title' => 'Explore categories',
            'fields' => [
                ['key' => 'store_home_story_eyebrow', 'label' => 'Small heading', 'default' => 'Discover'],
                ['key' => 'store_home_story_title', 'label' => 'Section title', 'default' => 'Explore our categories'],
                ['key' => 'store_home_story_description', 'label' => 'Description', 'default' => 'Browse active categories and find products selected for everyday use.', 'type' => 'textarea'],
            ],
        ],
    ];
    $trustDefaults = [
        ['Free delivery', 'On orders over PKR 10,000'],
        ['Cash on delivery', 'Or bank transfer'],
        ['Track your order', 'Real-time updates'],
        ['Always here', 'Mon–Sat, 11:00am–8:30pm'],
    ];
    $footerLinkGroups = [
        'shop' => [
            'title' => 'Shop links',
            'links' => [
                ['All products', '/shop'],
                ['Organic', '/shop?category=organic'],
                ['Natural care', '/shop?category=natural-care'],
            ],
        ],
        'help' => [
            'title' => 'Help links',
            'links' => [
                ['Track order', '/track'],
                ['About us', '/about'],
                ['Contact', '/contact'],
            ],
        ],
    ];
@endphp
<div class="max-w-6xl mx-auto" x-data="{ tab: '{{ $activeTab }}' }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-ink">Storefront Content</h1>
            <p class="text-sm text-gray-500 mt-0.5">Edit the sections and copy shown in the current Al-Asra storefront.</p>
        </div>
        <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 bg-white soft text-gray-700 hover:text-brand-600 px-4 py-2 rounded-xl text-xs font-medium transition">
            Preview live site
        </a>
    </div>

    @if($errors->any())
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            Please review the highlighted values and try again.
        </div>
    @endif

    <div class="flex flex-wrap gap-2 p-1.5 bg-white/70 backdrop-blur rounded-2xl soft mb-6">
        @foreach(['home' => 'Home page', 'footer' => 'Footer & contact', 'announcement' => 'Announcement bar'] as $key => $label)
            <button type="button" @click="tab = '{{ $key }}'"
                    :class="tab === '{{ $key }}' ? 'bg-brand-500 text-white shadow-sm' : 'text-gray-600 hover:bg-white'"
                    class="px-5 py-2.5 rounded-xl text-xs font-semibold transition">{{ $label }}</button>
        @endforeach
        @can('settings.view')
            <button type="button" @click="tab = 'bank'"
                    :class="tab === 'bank' ? 'bg-brand-500 text-white shadow-sm' : 'text-gray-600 hover:bg-white'"
                    class="px-5 py-2.5 rounded-xl text-xs font-semibold transition">Bank details</button>
        @endcan
        @can('faqs.view')
            <a href="{{ route('admin.faqs.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-gray-600 hover:bg-white transition ml-auto">Manage FAQs →</a>
        @endcan
    </div>

    <div x-show="tab === 'home'" x-cloak>
        <form action="{{ route('admin.cms.update') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="_tab" value="home">

            <div class="bg-white rounded-2xl p-6 soft flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-base font-bold text-ink">Homepage carousel</h2>
                    <p class="text-xs text-gray-500 mt-1">Slides, images, text and buttons are managed in the existing slider manager.</p>
                </div>
                @can('sliders.view')
                    <a href="{{ route('admin.sliders.index') }}" class="btn-bloom text-white px-5 py-2.5 rounded-xl text-xs font-medium text-center">Manage slides</a>
                @endcan
            </div>

            @foreach($homeSections as $section)
                <section class="bg-white rounded-2xl p-6 soft">
                    <h2 class="text-base font-bold text-ink border-b border-gray-100 pb-3 mb-4">{{ $section['title'] }}</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach($section['fields'] as $field)
                            <div class="{{ ($field['type'] ?? '') === 'textarea' ? 'md:col-span-2' : '' }}">
                                <label class="block text-xs font-medium text-gray-700 mb-1">{{ $field['label'] }}</label>
                                @if(($field['type'] ?? '') === 'textarea')
                                    <textarea name="{{ $field['key'] }}" rows="3" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">{{ old($field['key'], $settings[$field['key']] ?? $field['default']) }}</textarea>
                                @else
                                    <input type="text" name="{{ $field['key'] }}" value="{{ old($field['key'], $settings[$field['key']] ?? $field['default']) }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach

            <section class="bg-white rounded-2xl p-6 soft">
                <h2 class="text-base font-bold text-ink border-b border-gray-100 pb-3 mb-4">Trust strip</h2>
                <p class="text-xs text-gray-500 mb-4">Edit the four short messages directly below the carousel.</p>
                <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4">
                    @foreach($trustDefaults as $index => $defaults)
                        @php $number = $index + 1; @endphp
                        <div class="rounded-xl border border-gray-100 bg-gray-50 p-3 space-y-3">
                            <p class="text-[11px] font-semibold uppercase text-gray-500">Message {{ $number }}</p>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Title</label>
                                <input name="store_home_trust_{{ $number }}_title" value="{{ old('store_home_trust_'.$number.'_title', $settings['store_home_trust_'.$number.'_title'] ?? $defaults[0]) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Description</label>
                                <input name="store_home_trust_{{ $number }}_description" value="{{ old('store_home_trust_'.$number.'_description', $settings['store_home_trust_'.$number.'_description'] ?? $defaults[1]) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="bg-white rounded-2xl p-6 soft">
                <h2 class="text-base font-bold text-ink mb-2">Scrolling product strip</h2>
                <label class="block text-xs font-medium text-gray-700 mb-1">Optional custom message</label>
                <input name="store_home_marquee_text" value="{{ old('store_home_marquee_text', $settings['store_home_marquee_text'] ?? '') }}" placeholder="Leave blank to show live category and product names" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">
                <p class="text-xs text-gray-500 mt-1">When blank, the strip continues to use current categories and products.</p>
            </section>

            <div class="flex justify-end">
                <button type="submit" class="btn-bloom text-white px-8 py-3 rounded-xl text-sm font-medium">Save homepage content</button>
            </div>
        </form>
    </div>

    <div x-show="tab === 'footer'" x-cloak>
        <form action="{{ route('admin.cms.update') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="_tab" value="footer">

            <section class="bg-white rounded-2xl p-6 soft">
                <h2 class="text-base font-bold text-ink border-b border-gray-100 pb-3 mb-4">Brand and footer introduction</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Store name</label>
                        <input name="store_brand_name" value="{{ old('store_brand_name', $settings['store_brand_name'] ?? 'Al-Asra Store') }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Footer description</label>
                        <textarea name="store_footer_about" rows="3" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">{{ old('store_footer_about', $settings['store_footer_about'] ?? 'Organic, original and imported products. Delivered across Pakistan.') }}</textarea>
                    </div>
                </div>
            </section>

            @foreach($footerLinkGroups as $group => $definition)
                <section class="bg-white rounded-2xl p-6 soft">
                    <h2 class="text-base font-bold text-ink border-b border-gray-100 pb-3 mb-4">{{ $definition['title'] }}</h2>
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Column heading</label>
                        <input name="store_footer_{{ $group }}_title" value="{{ old('store_footer_'.$group.'_title', $settings['store_footer_'.$group.'_title'] ?? ucfirst($group)) }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">
                    </div>
                    <div class="grid md:grid-cols-3 gap-4">
                        @foreach($definition['links'] as $index => $link)
                            @php $number = $index + 1; @endphp
                            <div class="rounded-xl border border-gray-100 bg-gray-50 p-3 space-y-3">
                                <p class="text-[11px] font-semibold uppercase text-gray-500">Link {{ $number }}</p>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Text</label>
                                    <input name="store_footer_{{ $group }}_link_{{ $number }}_text" value="{{ old('store_footer_'.$group.'_link_'.$number.'_text', $settings['store_footer_'.$group.'_link_'.$number.'_text'] ?? $link[0]) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Link URL</label>
                                    <input name="store_footer_{{ $group }}_link_{{ $number }}_url" value="{{ old('store_footer_'.$group.'_link_'.$number.'_url', $settings['store_footer_'.$group.'_link_'.$number.'_url'] ?? $link[1]) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach

            <section class="bg-white rounded-2xl p-6 soft">
                <h2 class="text-base font-bold text-ink border-b border-gray-100 pb-3 mb-4">Contact and social links</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach([
                        ['store_footer_contact_title', 'Contact column heading', 'Reach us'],
                        ['store_footer_address', 'Address', 'Karachi, Pakistan'],
                        ['store_footer_phone', 'Phone', '+92 315 9259927'],
                        ['store_footer_email', 'Email', 'support@alasra.online'],
                        ['store_footer_hours', 'Working hours', 'Mon–Sat, 11:00am–8:30pm'],
                        ['store_footer_instagram_label', 'Instagram link text', 'Instagram @alasra.onlinestore'],
                        ['store_footer_instagram_url', 'Instagram URL', 'https://instagram.com/alasra.onlinestore'],
                    ] as [$key, $label, $default])
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">{{ $label }}</label>
                            <input name="{{ $key }}" value="{{ old($key, $settings[$key] ?? $default) }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">
                        </div>
                    @endforeach
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Copyright text (year is added automatically)</label>
                        <input name="store_footer_copyright" value="{{ old('store_footer_copyright', $settings['store_footer_copyright'] ?? 'Al-Asra Store. All rights reserved.') }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">
                    </div>
                </div>
            </section>

            <div class="flex justify-end">
                <button type="submit" class="btn-bloom text-white px-8 py-3 rounded-xl text-sm font-medium">Save footer content</button>
            </div>
        </form>
    </div>

    <div x-show="tab === 'announcement'" x-cloak>
        <form action="{{ route('admin.cms.update') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="_tab" value="announcement">
            <section class="bg-white rounded-2xl p-6 soft max-w-3xl">
                <h2 class="text-base font-bold text-ink border-b border-gray-100 pb-3 mb-4">Top announcement bar</h2>
                <label class="flex items-center gap-3 p-4 bg-brand-50 rounded-xl mb-5">
                    <input type="checkbox" name="store_announcement_enabled" value="1" {{ old('store_announcement_enabled', $settings['store_announcement_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                    <span class="text-sm font-medium text-gray-800">Show announcement bar on the storefront</span>
                </label>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Announcement message</label>
                        <textarea name="store_announcement_text" rows="2" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">{{ old('store_announcement_text', $settings['store_announcement_text'] ?? 'Free delivery on orders over PKR 10,000 · Cash on delivery across Pakistan') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Free delivery threshold (PKR)</label>
                        <input type="number" min="0" step="1" name="free_shipping_threshold" value="{{ old('free_shipping_threshold', $settings['free_shipping_threshold'] ?? 10000) }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">
                    </div>
                </div>
                <div class="flex justify-end pt-5">
                    <button type="submit" class="btn-bloom text-white px-8 py-3 rounded-xl text-sm font-medium">Save announcement settings</button>
                </div>
            </section>
        </form>
    </div>

    @can('settings.view')
    <div x-show="tab === 'bank'" x-cloak>
        <form action="{{ route('admin.cms.update') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="_tab" value="bank">
            <section class="bg-white rounded-2xl p-6 soft max-w-3xl">
                <h2 class="text-base font-bold text-ink border-b border-gray-100 pb-3 mb-4">Bank transfer details</h2>
                <div class="space-y-4">
                    @foreach([
                        ['bank_name', 'Bank name'],
                        ['bank_account_title', 'Account title'],
                        ['bank_account_no', 'Account number'],
                        ['bank_iban', 'IBAN'],
                    ] as [$key, $label])
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">{{ $label }}</label>
                            <input name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm">
                        </div>
                    @endforeach
                </div>
                @can('settings.edit')
                    <div class="flex justify-end pt-5">
                        <button type="submit" class="btn-bloom text-white px-8 py-3 rounded-xl text-sm font-medium">Save bank details</button>
                    </div>
                @endcan
            </section>
        </form>
    </div>
    @endcan
</div>
@endsection
