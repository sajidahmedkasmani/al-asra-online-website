<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $replacements = [
            'G. Collection' => 'Al-Asra Store',
            'G.Collection' => 'Al-Asra Store',
            'support@gdotcollection.com' => 'support@alasra.online',
            '+92 334 7779231' => '+92 315 9259927',
            '923347779231' => '923159259927',
        ];

        if (Schema::hasTable('settings')) {
            DB::table('settings')
                ->select('id', 'value')
                ->orderBy('id')
                ->chunkById(100, function ($settings) use ($replacements) {
                    foreach ($settings as $setting) {
                        $value = str_replace(array_keys($replacements), array_values($replacements), (string) $setting->value);
                        if ($value !== $setting->value) {
                            DB::table('settings')->where('id', $setting->id)->update(['value' => $value]);
                        }
                    }
                });

            DB::table('settings')->where('key', 'site_tagline')->where('value', 'Wear the Story, Every Stitch')
                ->update(['value' => 'Original & Imported Essentials']);
            DB::table('settings')->where('key', 'footer_about')
                ->where('value', "A full collection of stitched and unstitched ladies' clothing from Karachi, Pakistan.")
                ->update(['value' => 'Original, imported, and everyday products selected with care in Karachi and delivered across Pakistan.']);
            DB::table('settings')->where('key', 'contact_hours')->where('value', 'Mon–Sat, 11:00 AM – 9:00 PM')
                ->update(['value' => 'Mon–Sat, 11:00 AM – 8:30 PM']);
            DB::table('settings')->where('key', 'social_instagram')->where('value', 'https://instagram.com')
                ->update(['value' => 'https://instagram.com/alasra.onlinestore']);
            DB::table('settings')->where('key', 'newsletter_monogram')->where('value', 'G.')
                ->update(['value' => 'A.']);

            $legacySettings = [
                'collections_title' => ["Three ways\nto dress the day.", "Everyday essentials,\nchosen with care."],
                'collections_subtitle' => ['Stitched, unstitched and everything that goes with it. Pick a collection to start.', 'Explore original finds, natural care, and useful products for everyday life.'],
                'collection_1_title' => ['Stitched', 'Everyday essentials'],
                'collection_1_slug' => ['stitched', 'everyday-essentials'],
                'collection_2_title' => ['Unstitched', 'Natural care'],
                'collection_2_slug' => ['unstitched', 'natural-care'],
                'collection_3_title' => ['Accessories', 'Imported finds'],
                'collection_3_slug' => ['accessories', 'imported-finds'],
                'marquee_items' => ['Embroidery · Lace · Lawn · Cutwork', 'Original finds · Natural care · Everyday essentials'],
                'plum_watermark' => ['Lace. Fringe.', 'Original. Useful.'],
                'plum_b1_title' => ["Lace.<br><span class=\"italic text-rose\">Fringe.</span><br>Cutwork.", "Original.<br><span class=\"italic text-rose\">Useful.</span><br>Everyday."],
                'plum_b1_desc' => ['Three details, one silhouette. Each piece is finished by hand in our Karachi workshop.', 'Thoughtfully selected products for everyday life, delivered from Karachi across Pakistan.'],
                'plum_b1_btn_text' => ['Add to bag', 'Explore the shop'],
                'plum_b2_title' => ["Lace.<br><span class=\"italic text-rose\">Fringe.</span><br>Cutwork.", "Everyday.<br><span class=\"italic text-rose\">Essentials.</span><br>Al-Asra."],
                'plum_b2_desc' => ['These details make these pieces fit the collection, wear after wear.', 'Discover useful finds and original products selected with care.'],
                'edit_badge_2' => ['Embroidery · Lace · Lawn', 'Original · Natural care · Everyday'],
                'edit_title' => ["Made<br><span class=\"italic\">by hand,</span><br>worn by<br>you.", "Thoughtful<br><span class=\"italic\">finds,</span><br>chosen for<br>you."],
                'edit_desc' => ['Soft lace sleeves, fringed hems, scalloped cutwork borders. The details that make a hand-finished kurta.', 'A considered selection of original, imported, and useful products for everyday life.'],
                'find_piece_title' => ['Find your piece.', 'Find what you need.'],
                'good_to_know_desc' => ["A full collection of stitched and unstitched ladies' clothing, based in Karachi, Pakistan. Our team is available Mon–Sat 11:00 AM – 9:00 PM.", 'Original, imported, and everyday products selected with care in Karachi and delivered across Pakistan.'],
                'good_to_know_3_desc' => ['Mon–Sat 11:00 AM – 9:00 PM', 'Mon–Sat 11:00 AM – 8:30 PM'],
                'faq_timing' => ['Mon–Sat, 11:00 AM – 9:00 PM', 'Mon–Sat, 11:00 AM – 8:30 PM'],
                'newsletter_desc' => ['New arrivals and news from G. Collection, in your inbox. Just your email, nothing else.', 'New arrivals and useful updates from Al-Asra Store, in your inbox. Just your email, nothing else.'],
            ];

            foreach ($legacySettings as $key => [$old, $new]) {
                DB::table('settings')->where('key', $key)->where('value', $old)->update(['value' => $new]);
            }
        }

        if (Schema::hasTable('faqs')) {
            DB::table('faqs')->where('question', "What's the difference between stitched and unstitched?")
                ->update([
                    'category' => 'Products & availability',
                    'question' => 'What products do you offer?',
                    'answer' => 'Our catalog includes everyday essentials, original imported products, and natural care items. Browse the shop for current availability.',
                ]);
            DB::table('faqs')->where('question', 'Which sizes and colours are available?')
                ->update([
                    'category' => 'Products & availability',
                    'question' => 'How can I check product details?',
                    'answer' => 'Each product page lists the information currently available for that item. Contact us if you need help.',
                ]);
            DB::table('faqs')->where('question', 'What kind of pieces do you sell?')
                ->update([
                    'category' => 'Products & availability',
                    'question' => 'Are the products original?',
                    'answer' => 'We select products carefully and share clear details so you know what to expect.',
                ]);

            foreach (['question', 'answer'] as $column) {
                foreach ($replacements as $old => $new) {
                    DB::table('faqs')->where($column, 'like', '%'.$old.'%')
                        ->update([$column => DB::raw("REPLACE({$column}, ".DB::getPdo()->quote($old).', '.DB::getPdo()->quote($new).')')]);
                }
            }
        }

        Cache::forget('site_settings');
    }

    public function down(): void
    {
        // Rebranding saved CMS content is intentionally not reversed on rollback.
    }
};
