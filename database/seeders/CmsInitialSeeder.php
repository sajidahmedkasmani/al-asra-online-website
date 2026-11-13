<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class CmsInitialSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Initial Site & CMS Settings
        $defaults = [
            // Announcement Bar
            'announcement_enabled' => '1',
            'announcement_text' => 'Free shipping on orders above Rs. 10,000',
            'free_shipping_threshold' => '10000',

            // Brand & Footer
            'site_name' => 'Al-Asra Store',
            'site_tagline' => 'Original & Imported Essentials',
            'footer_about' => 'Original, imported, and everyday products selected with care in Karachi and delivered across Pakistan.',
            'contact_address' => 'Karachi, Pakistan',
            'contact_hours' => 'Mon–Sat, 11:00 AM – 8:30 PM',
            'contact_phone' => '+92 315 9259927',
            'whatsapp_number' => '923159259927',
            'contact_email' => 'support@alasra.online',
            'social_instagram' => 'https://instagram.com/alasra.onlinestore',
            'social_facebook' => '',
            'social_tiktok' => '',
            'copyright_text' => 'Al-Asra Store. All rights reserved.',

            // Home - Collections section
            'collections_title' => "Everyday essentials,\nchosen with care.",
            'collections_subtitle' => 'Explore original finds, natural care, and useful products for everyday life.',
            'collection_1_title' => 'Everyday essentials',
            'collection_1_slug' => 'everyday-essentials',
            'collection_1_image' => '',
            'collection_2_title' => 'Natural care',
            'collection_2_slug' => 'natural-care',
            'collection_2_image' => '',
            'collection_3_title' => 'Imported finds',
            'collection_3_slug' => 'imported-finds',
            'collection_3_image' => '',

            // Home - Most Loved
            'most_loved_title' => "Most loved,\nright now.",
            'most_loved_link_text' => 'See all',
            'most_loved_link_url' => '/shop',

            // Home - Marquee
            'marquee_items' => 'Original finds · Natural care · Everyday essentials',

            // Home - Plum Feature Section
            'plum_watermark' => 'Original. Useful.',
            'plum_b1_title' => "Original.<br><span class=\"italic text-rose\">Useful.</span><br>Everyday.",
            'plum_b1_desc' => 'Thoughtfully selected products for everyday life, delivered from Karachi across Pakistan.',
            'plum_b1_btn_text' => 'Explore the shop',
            'plum_b1_btn_url' => '/shop',
            'plum_b1_image' => '',
            'plum_b2_title' => "Everyday.<br><span class=\"italic text-rose\">Essentials.</span><br>Al-Asra.",
            'plum_b2_desc' => 'Discover useful finds and original products selected with care.',
            'plum_b2_btn_text' => 'Shop the edit',
            'plum_b2_btn_url' => '/shop',
            'plum_b2_image_1' => '',
            'plum_b2_image_2' => '',

            // Home - The Edit Section
            'edit_badge_1' => 'The Edit',
            'edit_badge_2' => 'Original · Natural care · Everyday',
            'edit_badge_3' => 'Karachi',
            'edit_title' => "Thoughtful<br><span class=\"italic\">finds,</span><br>chosen for<br>you.",
            'edit_desc' => 'A considered selection of original, imported, and useful products for everyday life.',
            'edit_btn_text' => 'Shop the edit',
            'edit_btn_url' => '/shop',

            // Home - Find Your Piece
            'find_piece_title' => 'Find what you need.',

            // Home - Good to Know
            'good_to_know_badge' => 'Good to know',
            'good_to_know_title' => 'Shopping with<br>Al-Asra Store',
            'good_to_know_desc' => 'Original, imported, and everyday products selected with care in Karachi and delivered across Pakistan.',
            'good_to_know_1_title' => 'Free shipping',
            'good_to_know_1_desc' => 'On bills of Rs. 10,000 and above',
            'good_to_know_2_title' => 'Pay your way',
            'good_to_know_2_desc' => 'Cash on Delivery · Bank Transfer',
            'good_to_know_3_title' => 'Talk to us',
            'good_to_know_3_desc' => 'Mon–Sat 11:00 AM – 8:30 PM',
            'good_to_know_4_title' => 'Based in',
            'good_to_know_4_desc' => 'Karachi, Pakistan',

            // Home - FAQ
            'faq_section_title' => 'Questions, answered.',
            'faq_section_subtitle' => "Can't find what you need? Talk to us on WhatsApp.",
            'faq_timing' => 'Mon–Sat, 11:00 AM – 8:30 PM',

            // Home - Newsletter
            'newsletter_title' => "Be first<br>to see<br><span class=\"italic text-plum\">what's new.</span>",
            'newsletter_desc' => 'New arrivals and useful updates from Al-Asra Store, in your inbox. Just your email, nothing else.',
            'newsletter_monogram' => 'A.',
        ];

        foreach ($defaults as $key => $val) {
            Setting::firstOrCreate(['key' => $key], ['value' => $val]);
        }

        // 2. Initial FAQs
        if (Faq::count() === 0) {
            $faqs = [
                ['Ordering & payments', 'How do I pay?', 'Choose Cash on Delivery or Bank Transfer at checkout. Bank details appear on the confirmation page.', 1],
                ['Ordering & payments', 'How does ordering work?', 'Browse the collection, add items to your cart, and proceed to checkout.', 2],
                ['Ordering & payments', 'Can I change or cancel an order?', 'Contact us on WhatsApp as soon as possible and we will help before it ships.', 3],
                ['Shipping & delivery', 'How much is shipping?', 'Free shipping on orders above Rs. 10,000. Below that, standard delivery charges apply.', 4],
                ['Shipping & delivery', 'How long will delivery take?', 'Orders usually arrive within a few working days depending on your city.', 5],
                ['Shipping & delivery', 'Where do you deliver?', 'We deliver across Pakistan from our Karachi base.', 6],
                ['Products & availability', 'What products do you offer?', 'Our catalog includes everyday essentials, original imported products, and natural care items. Browse the shop for current availability.', 7],
                ['Products & availability', 'How can I check product details?', 'Each product page lists the information currently available for that item. Contact us if you need help.', 8],
                ['Products & availability', 'Are the products original?', 'We select products carefully and share clear details so you know what to expect.', 9],
                ['Returns & exchanges', 'Can I exchange an item?', 'Please contact us via WhatsApp within 48 hours of delivery to discuss exchanges.', 10],
                ['Returns & exchanges', 'How long do I have to return something?', 'Within 48 hours of delivery. Message us on WhatsApp to start.', 11],
                ['Customer support', 'When is the team available?', 'Mon–Sat, 11:00 AM – 8:30 PM.', 12],
                ['Customer support', 'How do I contact your team?', 'WhatsApp +92 315 9259927 or support@alasra.online.', 13],
                ['Customer support', 'What happens to my details?', 'We only use them to process and deliver your order.', 14],
            ];

            foreach ($faqs as [$cat, $q, $a, $sort]) {
                Faq::create([
                    'category' => $cat,
                    'question' => $q,
                    'answer' => $a,
                    'sort_order' => $sort,
                    'is_active' => true,
                ]);
            }
        }
    }
}
