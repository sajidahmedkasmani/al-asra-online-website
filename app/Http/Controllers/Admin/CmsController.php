<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->old('_tab', $request->get('tab', 'home'));
        if (!in_array($activeTab, ['home', 'footer', 'announcement', 'bank'], true)) {
            $activeTab = 'home';
        }

        if ($activeTab === 'bank') {
            abort_unless($request->user()->can('settings.view'), 403);
        }

        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.cms.index', compact('settings', 'activeTab'));
    }

    public function update(Request $request)
    {
        $tab = $request->input('_tab', 'home');
        $bankFields = ['bank_name', 'bank_account_title', 'bank_account_no', 'bank_iban'];
        if ($tab === 'bank') {
            abort_unless($request->user()->can('settings.edit'), 403);
        }

        $rules = [];
        if ($tab === 'home') {
            $homeFields = [
                'store_home_categories_eyebrow', 'store_home_categories_title',
                'store_home_products_eyebrow', 'store_home_products_title',
                'store_home_why_eyebrow', 'store_home_why_title', 'store_home_why_description',
                'store_home_why_button_text', 'store_home_why_button_url',
                'store_home_story_eyebrow', 'store_home_story_title',
                'store_home_story_description', 'store_home_marquee_text',
            ];
            foreach ($homeFields as $field) {
                $rules[$field] = 'nullable|string|max:2000';
            }
            $rules['store_home_why_button_url'] = 'nullable|string|max:255';
            for ($index = 1; $index <= 4; $index++) {
                $rules["store_home_trust_{$index}_title"] = 'nullable|string|max:100';
                $rules["store_home_trust_{$index}_description"] = 'nullable|string|max:200';
            }
        } elseif ($tab === 'footer') {
            $footerFields = [
                'store_brand_name', 'store_footer_about', 'store_footer_shop_title',
                'store_footer_help_title', 'store_footer_contact_title', 'store_footer_address',
                'store_footer_phone', 'store_footer_email', 'store_footer_hours',
                'store_footer_instagram_label', 'store_footer_instagram_url', 'store_footer_copyright',
            ];
            for ($group = 1; $group <= 3; $group++) {
                foreach (['shop', 'help'] as $column) {
                    $footerFields[] = "store_footer_{$column}_link_{$group}_text";
                    $footerFields[] = "store_footer_{$column}_link_{$group}_url";
                }
            }
            foreach ($footerFields as $field) {
                $rules[$field] = 'nullable|string|max:255';
            }
            $rules['store_footer_about'] = 'nullable|string|max:2000';
            $rules['store_footer_email'] = 'nullable|email|max:255';
            $rules['store_footer_instagram_url'] = 'nullable|url|max:255';
        } elseif ($tab === 'announcement') {
            $rules = [
                'store_announcement_text' => 'nullable|string|max:500',
                'free_shipping_threshold' => 'required|integer|min:0|max:10000000',
            ];
        } elseif ($tab === 'bank') {
            $rules = [
                'bank_name' => 'nullable|string|max:100',
                'bank_account_title' => 'nullable|string|max:100',
                'bank_account_no' => 'nullable|string|max:50',
                'bank_iban' => 'nullable|string|max:50',
            ];
        } else {
            abort(404);
        }

        $inputs = $request->validate($rules);
        if ($tab === 'announcement') {
            $inputs['store_announcement_enabled'] = $request->boolean('store_announcement_enabled') ? '1' : '0';
        }

        Setting::setMany($inputs);

        return redirect()->route('admin.cms.index', ['tab' => $tab])
            ->with('success', 'Website content updated successfully.');
    }
}
