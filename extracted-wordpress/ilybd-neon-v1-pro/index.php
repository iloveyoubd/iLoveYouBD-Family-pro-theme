<?php get_header(); ?>

<div class="ilybd-layout">

    <main class="ilybd-feed-container">

        <?php 
        /**
         * টপ সেকশন মডিউল
         */
        do_action('ilybd_after_header'); 
        get_template_part('template-parts/messenger-stories');
        ?>
        <!-- 🔥 ULTRAPRO NEON SEARCH SYSTEM -->
        <div class="search-section-wrapper" style="max-width: 650px; margin: 10px auto 10px auto; padding: 0 15px; text-align: center;">
            <form role="search" method="get" class="cyber-search-form" action="<?php echo esc_url(home_url('/')); ?>" style="position: relative; display: flex; align-items: center; justify-content: center; width: 100%;">
                <div style="position: relative; width: 100%; display: flex; align-items: center;">
                    <input type="search" class="cyber-search-input" aria-label="Search tutorials or codes" placeholder="পছন্দের টিউটোরিয়াল বা কোড খুঁজুন..." value="<?php echo get_search_query(); ?>" name="s" style="width: 100%; padding: 10px 45px 10px 18px; font-size: 14px; background: #0c1118; border: 1.5px solid rgba(0, 255, 65, 0.25); border-radius: 30px; color: #fff; outline: none; transition: all 0.3s ease; box-shadow: 0 0 10px rgba(0,0,0,0.5), inset 0 1px 3px rgba(0,0,0,0.8); font-family: 'Rajdhani', sans-serif;" required onfocus="this.style.borderColor='#00ff41'; this.style.boxShadow='0 0 15px rgba(0, 255, 65, 0.45), inset 0 1px 3px rgba(0,0,0,0.8)';" onblur="this.style.borderColor='rgba(0, 255, 65, 0.25)'; this.style.boxShadow='0 0 10px rgba(0,0,0,0.5), inset 0 1px 3px rgba(0,0,0,0.8)';">
                    <button type="submit" class="cyber-search-submit" aria-label="Search" style="position: absolute; right: 6px; top: 50%; transform: translateY(-50%); background: linear-gradient(135deg, #00ff41 0%, #00e5ff 100%); border: none; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #000; font-size: 14px; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,255,65,0.4);" onmouseover="this.style.transform='translateY(-50%) scale(1.08)'; this.style.boxShadow='0 0 15px #00ff41';" onmouseout="this.style.transform='translateY(-50%) scale(1.00)'; this.style.boxShadow='0 2px 8px rgba(0,255,65,0.4)';">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
        </div>
        <?php
        do_action('ilybd_slider'); 
        do_action('ilybd_featured'); 
        do_action('ilybd_popular'); 
        ?>

        <section class="latest-posts-wrapper">
            <div class="section-head latest-head">
                <span class="label">⚡ LATEST POSTS</span>
                <span class="line"></span>
            </div>

            <?php do_action('ilybd_latest'); ?>

            <?php if (have_posts()) : ?>
                <div class="ilybd-feed ilybd-post-grid-system">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/post-card'); ?>
                    <?php endwhile; ?>
                </div>

                <div class="ilybd-pagination">
                    <?php the_posts_pagination(); ?>
                </div>
            <?php else : ?>
                <div class="no-posts" style="color: #8b949e; padding: 40px; text-align: center;">No posts found.</div>
            <?php endif; ?>
        </section>

        <section class="community-qa-wrapper">
            <div class="section-head qa-head">
                <span class="label">💬 COMMUNITY Q&A</span>
                <span class="line"></span>
            </div>

            <div class="qa-content-box">
                <?php echo do_shortcode('[recent_questions count="5"]'); ?>

                <div class="qa-footer-action">
                    <p class="qa-helper-text">আপনার কোনো প্রযুক্তিগত সমস্যা আছে? আমাদের বিশেষজ্ঞদের জানান।</p>
                    <a href="<?php echo home_url('/ask-question'); ?>" class="ask-btn-main">
                        প্রশ্ন করুন
                    </a>
                </div>
            </div>
        </section>

        <style>
        /* Community Q&A Design Upgrades */
        .community-qa-wrapper {
            margin-top: 40px;
            margin-bottom: 45px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
        }

        /* Premium Header Styling */
        .qa-head {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .qa-head .label {
            background: linear-gradient(135deg, #00ff41 0%, #00e5ff 100%) !important;
            color: #000000 !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            padding: 6px 14px !important;
            border-radius: 8px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            font-size: 12px !important;
            box-shadow: 0 4px 12px rgba(0, 255, 65, 0.25) !important;
        }

        .qa-head .line {
            flex-grow: 1;
            height: 1px;
            background: linear-gradient(90deg, #00ff41, transparent) !important;
        }

        /* Reddish-Purple Gradient Card Background */
        .qa-content-box {
            background: linear-gradient(135deg, #6e00ff 0%, #ff4b2b 100%) !important; /* Matches single post profile card perfectly */
            border: 1.5px solid rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.45), inset 0 1px 0 rgba(255, 255, 255, 0.2) !important;
            padding: 24px !important;
            border-radius: 16px !important;
            position: relative;
            overflow: hidden;
        }

        /* List Container spacing */
        .qna-list-container {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Q&A Glassmorphic Item box */
        .qna-item-box {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            background: rgba(13, 17, 23, 0.7) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            padding: 15px 18px !important;
            border-radius: 12px !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
            transition: all 0.25s ease-in-out !important;
        }

        .qna-item-box:hover {
            background: rgba(13, 17, 23, 0.82) !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.35) !important;
        }

        /* Stats Section as Badges */
        .qna-stats-left {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-shrink: 0;
        }

        .qna-stat-item {
            text-align: center !important;
            padding: 4px 8px !important;
            border-radius: 8px !important;
            min-width: 58px !important;
            font-size: 10px !important;
            font-weight: 500 !important;
            line-height: 1.2 !important;
        }

        .qna-stat-item.votes-item {
            background: rgba(0, 255, 65, 0.12) !important;
            border: 1px solid rgba(0, 255, 65, 0.25) !important;
            color: #00ff41 !important;
        }

        .qna-stat-item.answers-item {
            background: rgba(0, 229, 255, 0.12) !important;
            border: 1px solid rgba(0, 229, 255, 0.25) !important;
            color: #00e5ff !important;
        }

        .qna-stat-item.views-item {
            background: rgba(255, 255, 255, 0.06) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #e2e8f0 !important;
        }

        .qna-stat-item b {
            display: block !important;
            font-size: 14px !important;
            font-weight: 800 !important;
            line-height: 1.1 !important;
            margin-bottom: 2px !important;
        }

        /* Middle content details */
        .qna-details-mid {
            flex: 1;
            margin: 0 16px !important;
            text-align: left !important;
        }

        .qna-q-title {
            margin: 0 0 5px 0 !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            line-height: 1.4 !important;
        }

        .qna-q-title a {
            color: #ffffff !important;
            text-decoration: none !important;
            transition: color 0.15s ease !important;
        }

        .qna-q-title a:hover {
            color: #00ff41 !important;
        }

        .qna-q-meta {
            font-size: 11px !important;
            color: #cbd5e0 !important;
        }

        .qna-q-meta a {
            color: #00ff41 !important;
            text-decoration: none !important;
            font-weight: 700 !important;
        }

        .qna-q-meta a:hover {
            text-decoration: underline !important;
        }

        /* Action button style */
        .qna-action-right {
            flex-shrink: 0;
        }

        .qna-action-right a {
            background: linear-gradient(135deg, #00ff41 0%, #00b32d 100%) !important;
            color: #000000 !important;
            padding: 6px 12px !important;
            border-radius: 6px !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            border: none !important;
            text-decoration: none !important;
            display: inline-block !important;
            box-shadow: 0 3px 10px rgba(0, 255, 65, 0.2) !important;
            transition: all 0.2s ease !important;
        }

        .qna-action-right a:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 16px rgba(0, 255, 65, 0.4) !important;
        }

        /* Footer elements */
        .qa-footer-action {
            position: relative;
            z-index: 2;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .qa-helper-text {
            font-size: 12px !important;
            color: #ffffff !important;
            font-weight: 500 !important;
            margin: 0 !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3) !important;
        }

        .ask-btn-main {
            background: #ffffff !important;
            color: #000000 !important;
            padding: 8px 20px !important;
            border-radius: 6px !important;
            font-weight: 800 !important;
            font-size: 13px !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            display: inline-block !important;
            border: none !important;
        }

        .ask-btn-main:hover {
            background: #00ff41 !important;
            color: #000000 !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 16px rgba(0, 255, 65, 0.4) !important;
        }

        /* Mobile Responsive Optimization Mode */
        @media (max-width: 600px) {
            .qa-content-box {
                padding: 16px !important;
                border-radius: 12px !important;
            }
            .qna-item-box {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 12px !important;
                padding: 12px !important;
                border-radius: 10px !important;
            }
            .qna-stats-left {
                order: 2 !important;
                justify-content: flex-start !important;
                gap: 6px !important;
            }
            .qna-stat-item {
                flex: 1 !important;
                min-width: auto !important;
                padding: 4px 6px !important;
                border-radius: 6px !important;
            }
            .qna-details-mid {
                order: 1 !important;
                margin: 0 !important;
            }
            .qna-q-title {
                font-size: 14px !important;
            }
            .qna-action-right {
                order: 3 !important;
                width: 100% !important;
                text-align: right !important;
            }
            .qna-action-right a {
                display: block !important;
                text-align: center !important;
                padding: 8px !important;
                border-radius: 6px !important;
            }
            .qa-footer-action {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 10px !important;
                text-align: center !important;
                padding-top: 12px !important;
            }
            .qa-helper-text {
                margin-bottom: 2px !important;
            }
        }
        </style>

        <!-- 📱 DYNAMIC GOOGLE PLAY STORE SAFE DISCOVERY PORTAL --><?php
        $apps_list = array(
            array(
                "packageId" => "com.whatsapp",
                "title" => "WhatsApp Messenger",
                "developer" => "WhatsApp LLC",
                "category" => "Communication / মেসেঞ্জার",
                "rating" => "4.3",
                "size" => "৪৮ MB",
                "downloads" => "5B+",
                "icon" => "https://i.ibb.co/hK70xYF/whatsapp-logo.png",
                "description" => "সহজ, নিরাপদ ও ব্যক্তিগত মেসেজিং এবং ভয়েস কলার গলোবাল সমাধান।"
            ),
            array(
                "packageId" => "com.bKash.customerapp",
                "title" => "bKash - বিকাশ অ্যাপ",
                "developer" => "bKash Limited",
                "category" => "Finance / মোবাইল ব্যাংকিং",
                "rating" => "4.6",
                "size" => "৫৬ MB",
                "downloads" => "50M+",
                "icon" => "https://i.ibb.co/6P69v37/bkash-logo.png",
                "description" => "বাংলাদেশে দ্রুত, সুরক্ষিত ও সবচেয়ে বেশি উপায়ে টাকা লেনদেন এবং নতুন বিল পেমেন্ট।"
            ),
            array(
                "packageId" => "com.konasl.nagad",
                "title" => "Nagad - নগদের অফিশিয়াল অ্যাপ",
                "developer" => "Nagad Limited",
                "category" => "Finance / মোবাইল ওয়ালেট",
                "rating" => "4.5",
                "size" => "৪৫ MB",
                "downloads" => "50M+",
                "icon" => "https://i.ibb.co/Ltb2C6k/nagad-logo.png",
                "description" => "ডাক বিভাগের নির্ভরযোগ্য ডিজিটাল ওয়ালেট ও কম খরচে ক্যাশ আউট করার সুবিধা।"
            ),
            array(
                "packageId" => "com.zhiliaoapp.musically",
                "title" => "TikTok - ভিডিও কন্টেন্ট",
                "developer" => "TikTok Pte. Ltd.",
                "category" => "Social / এন্টারটেইনমেন্ট",
                "rating" => "4.4",
                "size" => "৮২ MB",
                "downloads" => "1B+",
                "icon" => "https://i.ibb.co/m0fW0hS/tiktok-logo.png",
                "description" => "রিলস ও ছোট ভিডিও ক্লিপের মাধ্যমে মেকার রিঅ্যাকশন এবং লাইভ এন্টারটেইনমেন্ট।"
            ),
            array(
                "packageId" => "com.facebook.orca",
                "title" => "Messenger - মেসেঞ্জার",
                "developer" => "Meta Platforms, Inc.",
                "category" => "Communication / চ্যাটিং",
                "rating" => "4.1",
                "size" => "৫২ MB",
                "downloads" => "5B+",
                "icon" => "https://i.ibb.co/3sXfPhH/messenger-logo.png",
                "description" => "ফেসবুক বন্ধুদের সাথে সেকেন্ডে ভয়েস কল, মেসেজিং ও লাইভ চ্যাটিং করার গেটওয়ে।"
            ),
            array(
                "packageId" => "org.telegram.messenger",
                "title" => "Telegram - টেলিগ্রাম",
                "developer" => "Telegram FZ-LLC",
                "category" => "Communication / সিকিউর চ্যাট",
                "rating" => "4.3",
                "size" => "৬৩ MB",
                "downloads" => "1B+",
                "icon" => "https://i.ibb.co/2ZsF46t/telegram-logo.png",
                "description" => "ক্লাউড স্টোরেজ সুবিধাসহ দ্রুত এবং অত্যন্ত নিরাপদ মেসেজিং ও ফাইল শেয়ারিং সার্ভিস।"
            ),
            array(
                "packageId" => "com.gpro.capcut",
                "title" => "CapCut - ভিডিও এডিটর",
                "developer" => "Bytedance Pte. Ltd.",
                "category" => "Video Players & Editors",
                "rating" => "4.5",
                "size" => "১৩৫ MB",
                "downloads" => "500M+",
                "icon" => "https://i.ibb.co/nC3d9t0/capcut-logo.png",
                "description" => "সহজ এডিটিং টুলস, টেক্সট অ্যানিমেশন ও নিওন ফিল্টার টেমপ্লেটসহ আল্টিমেট ভিডিও এডিটর।"
            ),
            array(
                "packageId" => "com.lenovo.anyshare.gps",
                "title" => "SHAREit - ফাইল শেয়ারিং",
                "developer" => "Smart Media4U",
                "category" => "Tools / হাই-স্পিড শেয়ার",
                "rating" => "4.4",
                "size" => "৩৯ MB",
                "downloads" => "1B+",
                "icon" => "https://i.ibb.co/9vB4wQZ/shareit-logo.png",
                "description" => "কোনো ইন্টারনেট বা ডাটা ছাড়াই সেকেন্ডে বড় বড় মুভি ও কন্টেন্ট ফাইল শেয়ার গেটওয়ে।"
            ),
            array(
                "packageId" => "com.dts.freefireth",
                "title" => "Garena Free Fire - ফ্রি ফায়ার",
                "developer" => "Garena International I",
                "category" => "Action / লাইভ সারভাইভাল গেম",
                "rating" => "4.2",
                "size" => "৩৮০ MB",
                "downloads" => "1B+",
                "icon" => "https://play-lh.googleusercontent.com/fA67WeoZis7fE9R8858P_idmB0o_8pks8T_t_d9Zf9GkH88Fh_I6XvFF8b-i9n_OAg=w240-h240",
                "description" => "বিশ্বখ্যাত মোবাইল সারভাইভ্যাল শুটার গেম। প্রতি ১০ মিনিটে আপনি একটি প্রত্যন্ত দ্বীপে নামবেন।"
            ),
            array(
                "packageId" => "com.tencent.ig",
                "title" => "PUBG MOBILE - পাবজি মোবাইল",
                "developer" => "Level Infinite",
                "category" => "Action / রিয়েল ব্যাটেল রয়্যাল",
                "rating" => "4.3",
                "size" => "৮৫০ MB",
                "downloads" => "1B+",
                "icon" => "https://play-lh.googleusercontent.com/yO8vWjGIsM8J-hffcQenunby0Wd56fHTo4L5IpxHOf1x26-2lS6_g9pG2Yq50f-0K7k=w240-h240",
                "description" => "অরিজিনাল ব্যাটল রয়্যাল গেম যা মোবাইলে অত্যন্ত স্মুথ মাল্টিপ্লেয়ার শুটার গেমপ্লে দেয়।"
            ),
            array(
                "packageId" => "com.kiloo.subwaysurf",
                "title" => "Subway Surfers - সাবওয়ে সারফারস",
                "developer" => "SYBO Games",
                "category" => "Arcade / এন্ডলেস রানার",
                "rating" => "4.4",
                "size" => "৮৮ MB",
                "downloads" => "1B+",
                "icon" => "https://play-lh.googleusercontent.com/ykX5G_A7bF_79U6bI4Wp6p9J0uGjH8Of_QhVvW0vK9O5Dk6l6XvFF8YQOf_W_Z-7fA=w240-h240",
                "description" => "পুলিশ ও তার কুকুরের হাত থেকে বাঁচতে ট্রেন লাইনের মাঝে দ্রুত দৌড়ান এবং কয়েন সংগ্রহ করুন।"
            ),
            array(
                "packageId" => "com.ludo.king",
                "title" => "Ludo King - লুডু কিং গেম",
                "developer" => "Gametion Global",
                "category" => "Board / মাল্টিপ্লেয়ার লুডু",
                "rating" => "4.2",
                "size" => "৫২ MB",
                "downloads" => "500M+",
                "icon" => "https://play-lh.googleusercontent.com/mO_MTo2tK7Xn-Qd3g9zM5I-kG6bI5tFF9Y8v2D-D9hG-SkaG6LFF8Y6HOf8W9f-S1A=w240-h240",
                "description" => "বন্ধুদের সাথে কিংবা পরিবারের সাথে অনলাইনে লুডো খেলার সবচেয়ে জনপ্রিয় ও সেরা বোর্ড গেম।"
            ),
            array(
                "packageId" => "com.instagram.android",
                "title" => "Instagram - ইনস্টাগ্রাম",
                "developer" => "Instagram",
                "category" => "Social / ফটো ও রিলস",
                "rating" => "4.0",
                "size" => "৪৬ MB",
                "downloads" => "1B+",
                "icon" => "https://play-lh.googleusercontent.com/VRMWkE5g3CptpwdZ65g3CkiThs38C6HOf8W9Y8zE8_K-SkaG7LFF8Y6HOf8W_Z-7fA=w240-h240",
                "description" => "আপনার বন্ধুদের সাথে ছবি, ভিডিও, স্টোরি এবং মজার রিলস শেয়ার করার গ্লোবাল প্ল্যাটফর্ম।"
            ),
            array(
                "packageId" => "com.facebook.lite",
                "title" => "Facebook Lite - ফেসবুক লাইট",
                "developer" => "Meta Platforms, Inc.",
                "category" => "Social / সোশ্যাল লাইট",
                "rating" => "4.1",
                "size" => "২.৫ MB",
                "downloads" => "1B+",
                "icon" => "https://play-lh.googleusercontent.com/00f0ff=w240-h240",
                "description" => "২জি বা ধীরগতির ইন্টারনেটেও সম্পূর্ণ স্পিডে ফেসবুকের সমস্ত ফিচার ব্যবহারের লাইট সল্যুশন।"
            ),
            array(
                "packageId" => "com.opera.mini.native",
                "title" => "Opera Mini Browser - অপেরা মিনি",
                "developer" => "Opera",
                "category" => "Communication / ফাস্ট ব্রাউজার",
                "rating" => "4.3",
                "size" => "১২ MB",
                "downloads" => "500M+",
                "icon" => "https://play-lh.googleusercontent.com/9v6vH9_8W_kG6z_g8LFF8Y6HOf8W9b-S1A=w240-h240",
                "description" => "ডাটা সেভিং মোড এবং অ্যাড ব্লকারসহ অত্যন্ত দ্রুততম ইন্টারনেট ব্রাউজিংয়ের নির্ভরযোগ্য অ্যাপ।"
            ),
            array(
                "packageId" => "com.picsart.studio",
                "title" => "PicsArt AI Photo Editor",
                "developer" => "PicsArt, Inc.",
                "category" => "Photography / ফটো এডিটর",
                "rating" => "4.1",
                "size" => "৭৫ MB",
                "downloads" => "500M+",
                "icon" => "https://play-lh.googleusercontent.com/bYtqbV8Zg6pIi66S7oYm6=w240-h240",
                "description" => "এআই ব্যাকগ্রাউন্ড রিমুভার, কোলাজ মেকার এবং ফটো ফিল্টার নিয়ে অল-ইন-ওয়ান ডিজাইন পোর্টাল।"
            )
        );

        // Fetch custom published apps from user admin panel
        $admin_apps = get_posts(array(
            'post_type' => 'apps',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));

        if (!empty($admin_apps)) {
            foreach ($admin_apps as $admin_app) {
                $pkg = get_post_meta($admin_app->ID, '_app_pkg', true) ?: 'com.ilybd.app.' . $admin_app->ID;
                $icon = get_post_meta($admin_app->ID, '_app_icon_url', true) ?: 'https://play-lh.googleusercontent.com/bYtqbV8Zg6pIi66S7oYm686B6fN6Yg00f0ff';
                $size = get_post_meta($admin_app->ID, '_app_size', true) ?: 'Varies with device';
                $version = get_post_meta($admin_app->ID, '_app_version', true) ?: 'Latest Build';
                $description = get_the_excerpt($admin_app->ID) ?: wp_trim_words($admin_app->post_content, 12, '...');

                $apps_list[] = array(
                    "packageId" => $pkg,
                    "title" => get_the_title($admin_app->ID),
                    "developer" => "ILYBD Admin",
                    "category" => "আইবিডি অ্যাপস",
                    "rating" => "4.9",
                    "size" => $size,
                    "downloads" => "50K+",
                    "icon" => $icon,
                    "description" => $description,
                    "is_custom_cpt" => true,
                    "custom_url" => get_permalink($admin_app->ID)
                );
            }
        }
        
        if (get_option('ilybd_show_app_section', 1)) :
        ?>
        <section class="play-store-apps-wrapper" style="margin-top: 40px; margin-bottom: 45px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            <div class="section-head play-head" style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                <span class="label" style="background: linear-gradient(135deg, #00f0ff 0%, #0072ff 100%) !important; color: #ffffff !important; font-weight: 800 !important; text-transform: uppercase !important; letter-spacing: 1px !important; padding: 6px 14px !important; border-radius: 8px !important; display: inline-flex !important; align-items: center !important; gap: 6px !important; font-size: 12px !important; box-shadow: 0 4px 12px rgba(0, 240, 255, 0.25) !important;">
                    <i class="fa-brands fa-google-play" style="margin-right: 4px;"></i> GPLAY CLOUD APP HUB (নিরাপদ ডাউনলোড সেন্টার)
                </span>
                <span class="line" style="flex-grow: 1; height: 1px; background: linear-gradient(90deg, #00f0ff, transparent) !important;"></span>
            </div>

            <div class="play-store-container" style="background: linear-gradient(135deg, #051021 0%, #030812 100%) !important; border: 1.5px solid rgba(0, 240, 255, 0.2) !important; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.45) !important; padding: 24px !important; border-radius: 16px !important; position: relative; overflow: hidden; border-top-width: 4px; border-top-color: #00f0ff !important;">
                
                <!-- SEO Rich Description Block -->
                <div style="margin-bottom: 25px; text-align: left; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 20px;">
                    <h3 style="color: #fff; font-size: 20px; font-weight: 950; margin: 0 0 8px 0; text-shadow: 0 0 10px rgba(0, 240, 255, 0.3); font-family: 'Hind Siliguri', sans-serif;">🔒 গুগল প্লে স্টোর সেফ অ্যাপ স্টোর - নিরাপদ এপিকে ডিসকভারি পোর্টাল</h3>
                    <p style="color: #8b949e; font-size: 13px; margin: 0 0 15px 0; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">১০০% আসল ও ম্যালওয়্যার-মুক্ত এপিকে ফাইল ডাউনলোড হাব। আপনি সরাসরি গুগল প্লে-স্টোরের অফিশিয়াল গ্লোবাল সোর্স লিংক থেকে যেকোনো অ্যাপ অথবা গেমস নিরাপদে ডাউনলোড করতে পারবেন।</p>
                    
                    <!-- Search Engine and Navigation Bar -->
                    <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 15px;">
                        <div style="position: relative; flex: 1; min-width: 250px;">
                            <input type="text" id="playAppSearch" onkeyup="filterPlayStoreApps()" placeholder="প্লে স্টোরের যেকোনো অ্যাপ বা গেম সার্চ করুন..." style="width: 100%; padding: 12px 15px 12px 42px; background: rgba(4, 7, 12, 0.85); border: 1.5px solid rgba(0, 240, 255, 0.25); border-radius: 8px; color: #fff; font-size: 13.5px; font-family: 'Hind Siliguri', sans-serif; outline: none; transition: 0.3s; box-shadow: inset 0 2px 4px rgba(0,0,0,0.5);" onfocus="this.style.borderColor='#00f0ff'; this.style.boxShadow='0 0 10px rgba(0,240,255,0.2)';" onblur="this.style.borderColor='rgba(0, 240, 255, 0.25)';">
                            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 16px; top: 16px; color: #00f0ff; font-size: 14px;"></i>
                        </div>
                        
                        <!-- Dynamic Smart Tabs for Filtering -->
                        <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                            <button onclick="changePlayListFilter('all')" id="filterTabAll" class="play-filter-tab active-filter" style="padding: 10px 14px; font-size: 12px; font-weight: 850; border-radius: 8px; border: 1px solid rgba(0,240,255,0.3); background: rgba(0,240,255,0.1) !important; color: #00f0ff; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; transition: 0.3s;">সব কন্টেন্ট</button>
                            <button onclick="changePlayListFilter('apps')" id="filterTabApps" class="play-filter-tab" style="padding: 10px 14px; font-size: 12px; font-weight: 850; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05); background: rgba(255,255,255,0.02) !important; color: #a0aec0; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; transition: 0.3s;">জনপ্রিয় অ্যাপস</button>
                            <button onclick="changePlayListFilter('games')" id="filterTabGames" class="play-filter-tab" style="padding: 10px 14px; font-size: 12px; font-weight: 850; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05); background: rgba(255,255,255,0.02) !important; color: #a0aec0; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; transition: 0.3s;">মোবাইল গেমস</button>
                            <button onclick="changePlayListFilter('ibd')" id="filterTabIbd" class="play-filter-tab" style="padding: 10px 14px; font-size: 12px; font-weight: 850; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05); background: rgba(255,255,255,0.02) !important; color: #a0aec0; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; transition: 0.3s;">আইবিডি অ্যাপস</button>
                        </div>
                    </div>
                </div>

                <!-- Apps Bento Dynamic Grid -->
                <div class="apps-bento-grid" id="appsContainerGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; min-height: 250px;">
                    <?php 
                    $currIndex = 0;
                    foreach ($apps_list as $app) : 
                        $currIndex++;
                        $is_game = (strpos(strtolower($app['category']), 'game') !== false || strpos(strtolower($app['title']), 'fire') !== false || strpos(strtolower($app['title']), 'pubg') !== false || strpos(strtolower($app['title']), 'ludo') !== false || strpos(strtolower($app['title']), 'subway') !== false) ? 'true' : 'false';
                        $is_ibd = !empty($app['is_custom_cpt']) ? 'true' : 'false';
                        $download_url = (!empty($app['is_custom_cpt']) && !empty($app['custom_url'])) ? $app['custom_url'] : "https://play.google.com/store/apps/details?id=" . esc_attr($app['packageId']);
                        $copy_url = (!empty($app['is_custom_cpt']) && !empty($app['custom_url'])) ? $app['custom_url'] : "https://play.google.com/store/apps/details?id=" . esc_attr($app['packageId']);
                        // Keep AdSense spaces in mind - every element is well isolated by at least 25px
                    ?>
                        <div class="app-card-item" data-index="<?php echo $currIndex; ?>" data-game="<?php echo $is_game; ?>" data-ibd="<?php echo $is_ibd; ?>" data-title="<?php echo esc_attr(strtolower($app['title'] . ' ' . $app['developer'] . ' ' . $app['category'])); ?>" style="background: rgba(13, 19, 29, 0.8) !important; border: 1.5px solid rgba(255, 255, 255, 0.05); padding: 16px; border-radius: 12px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s; position: relative; overflow: hidden; height: auto;" onmouseover="this.style.borderColor='#00f0ff'; this.style.boxShadow='0 0 15px rgba(0,240,255,0.15)';" onmouseout="this.style.borderColor='rgba(255, 255, 255, 0.05)'; this.style.boxShadow='none';">
                            <div>
                                <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 12px;">
                                    <img src="<?php echo esc_url($app['icon']); ?>" alt="<?php echo esc_attr($app['title']); ?>" style="width: 52px; height: 52px; border-radius: 12px; background: #070b13; object-fit: cover; border: 1.5px solid rgba(255, 255, 255, 0.08);" onerror="this.src='https://play-lh.googleusercontent.com/bYtqbV8Zg6pIi66S7oYm686B6fN6Yg00f0ff';">
                                    <div style="text-align: left;">
                                        <h4 style="margin: 0; font-size: 14.5px; font-weight: 850; color: #ffffff; line-height: 1.3;" class="app-card-title-txt" title="<?php echo esc_attr($app['title']); ?>">
                                            <?php echo esc_html($app['title']); ?>
                                        </h4>
                                        <span style="font-size: 11px; color: #00f0ff; display: block; margin-top: 2px; font-family: 'JetBrains Mono', monospace; font-weight: bold;"><?php echo esc_html($app['developer']); ?></span>
                                    </div>
                                </div>
                                <p style="color: #cbd5e0; font-size: 12px; line-height: 1.5; margin: 0 0 12px 0; text-align: left; font-family: 'Hind Siliguri', sans-serif;">
                                    <?php echo esc_html($app['description']); ?>
                                </p>
                            </div>
                            
                            <div style="border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 12px; margin-top: auto;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; font-size: 11px; font-family: 'JetBrains Mono', monospace;">
                                    <span style="background: rgba(0, 240, 255, 0.08) !important; color: #00f0ff; padding: 2px 6px; border-radius: 4px; border: 1px solid rgba(0,240,255,0.15); font-weight: bold;"><?php echo esc_html($app['size']); ?></span>
                                    <span style="color: #e2e8f0;"><i class="fa-solid fa-download" style="color: #00ff41; margin-right: 3px;"></i> <?php echo esc_html($app['downloads']); ?></span>
                                    <span style="color: #ffb800;"><i class="fa-solid fa-star" style="margin-right: 3px;"></i> <?php echo esc_html($app['rating']); ?></span>
                                </div>
                                <div style="display: flex; gap: 8px;">
                                    <a href="<?php echo esc_url($download_url); ?>" target="<?php echo !empty($app['is_custom_cpt']) ? '_self' : '_blank'; ?>" style="flex: 1; text-align: center; background: linear-gradient(135deg, #00f0ff 0%, #008be5 100%) !important; color: #000 !important; font-weight: 850; text-transform: uppercase; font-size: 11.5px; padding: 9px 10px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 4px; transition: 0.3s; line-height: 1.2;" onmouseover="this.style.background='#ffffff'; this.style.color='#000';" onmouseout="this.style.background='linear-gradient(135deg, #00f0ff 0%, #008be5 100%)'; this.style.color='#000';">
                                        ডাউনলোড করুন 📥
                                    </a>
                                    <button onclick="navigator.clipboard.writeText('<!-- Auto Generated Play Store Meta Link for <?php echo esc_js($app['title']); ?> -->\n<a href=\'<?php echo esc_js($copy_url); ?>\' target=\'_blank\' rel=\'noopener noreferrer\' style=\'color: #00f0ff; text-decoration: underline; font-weight: bold;\'>Download <?php echo esc_js($app['title']); ?> Safe APK Free</a>'); alert('<?php echo esc_js($app['title']); ?> এর গুগল ইনডেক্স মেটা কিউআর আপনার কপি বোর্ডে সেভ হয়েছে!');" style="background: rgba(255, 255, 255, 0.04) !important; color: #00f0ff; font-weight: 700; font-size: 11px; padding: 9px 12px; border-radius: 6px; text-decoration: none; border: 1px solid rgba(0,240,255,0.2) !important; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='rgba(0, 240, 255, 0.1)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.04)'" title="Copy Search Engine Anchor Tag">
                                        <i class="fa-solid fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Google AdSense Clear Container Zone (Strictly Safe margins to prevent invalid clicks) -->
                <div style="margin: 30px 0 15px 0; padding: 10px; border: 1px dashed rgba(255, 255, 255, 0.04); text-align: center; border-radius: 8px;">
                    <span style="color: rgba(255, 255, 255, 0.25); font-size: 11px; letter-spacing: 2px; text-transform: uppercase;">SPONSORED SEARCH SYSTEMS</span>
                </div>

                <!-- Dynamic Futuristic Pagination Controls -->
                <div style="display: flex; justify-content: center; align-items: center; gap: 6px; margin-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 20px;" id="playPaginationArea">
                    <button onclick="navigatePlayStorePage(-1)" id="prevPlayBtn" style="background: rgba(255,255,255,0.02) !important; border: 1px solid rgba(255,255,255,0.06); color: #fff; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-size: 11.5px; font-weight: 800; transition: 0.3s; font-family: 'Hind Siliguri', sans-serif;" onmouseover="this.style.borderColor='#00f0ff'; this.style.color='#00f0ff';" onmouseout="this.style.borderColor='rgba(255,255,255,0.06)'; this.style.color='#fff';">◀ পূর্ববর্তী</button>
                    
                    <div style="display: flex; gap: 5px;" id="playPageNumbers">
                        <!-- Dynamic Page Buttons will be generated by setupPlayPagination -->
                    </div>

                    <button onclick="navigatePlayStorePage(1)" id="nextPlayBtn" style="background: rgba(255,255,255,0.02) !important; border: 1px solid rgba(255,255,255,0.06); color: #fff; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-size: 11.5px; font-weight: 800; transition: 0.3s; font-family: 'Hind Siliguri', sans-serif;" onmouseover="this.style.borderColor='#00f0ff'; this.style.color='#00f0ff';" onmouseout="this.style.borderColor='rgba(255,255,255,0.06)'; this.style.color='#fff';">পরবর্তি ▶</button>
                </div>
            </div>
        </section>

        <!-- Dynamic Store Orchestrator (Client Side High Speed Engine) -->
        <script>
        const playStoreConfig = {
            currentFilter: 'all',
            currentPage: 1,
            itemsPerPage: 5,
            searchQuery: ''
        };

        function filterPlayStoreApps() {
            const searchInput = document.getElementById('playAppSearch');
            playStoreConfig.searchQuery = searchInput.value.toLowerCase().trim();
            playStoreConfig.currentPage = 1; // reset page to 1 on searching
            renderPlayStoreDOM();
        }

        function changePlayListFilter(type) {
            playStoreConfig.currentFilter = type;
            playStoreConfig.currentPage = 1; // reset page
            
            // Toggle active visual class
            const tabs = document.getElementsByClassName('play-filter-tab');
            for(let i=0; i<tabs.length; i++) {
                tabs[i].classList.remove('active-filter');
                tabs[i].style.background = 'rgba(255,255,255,0.02)';
                tabs[i].style.borderColor = 'rgba(255,255,255,0.05)';
                tabs[i].style.color = '#a0aec0';
            }
            
            let activeTabId = 'filterTabAll';
            if (type === 'apps') activeTabId = 'filterTabApps';
            if (type === 'games') activeTabId = 'filterTabGames';
            if (type === 'ibd') activeTabId = 'filterTabIbd';
            
            const activeTab = document.getElementById(activeTabId);
            activeTab.classList.add('active-filter');
            activeTab.style.background = 'rgba(0, 240, 255, 0.1)';
            activeTab.style.borderColor = 'rgba(0, 240, 255, 0.3)';
            activeTab.style.color = '#00f0ff';
            
            renderPlayStoreDOM();
        }

        function navigatePlayStorePage(direction) {
            playStoreConfig.currentPage += direction;
            renderPlayStoreDOM();
        }

        function setPlayStorePage(pageNum) {
            playStoreConfig.currentPage = pageNum;
            renderPlayStoreDOM();
        }

        function renderPlayStoreDOM() {
            const cards = document.querySelectorAll('#appsContainerGrid .app-card-item');
            let visibleCards = [];
            
            // Stage 1: Filtering based on active queries and categorization tabs
            cards.forEach(card => {
                const titleData = card.getAttribute('data-title');
                const isGame = card.getAttribute('data-game') === 'true';
                const isIbd = card.getAttribute('data-ibd') === 'true';
                
                let matchesSearch = titleData.includes(playStoreConfig.searchQuery);
                let matchesFilter = true;
                
                if (playStoreConfig.currentFilter === 'apps') {
                    matchesFilter = !isGame && !isIbd;
                } else if (playStoreConfig.currentFilter === 'games') {
                    matchesFilter = isGame && !isIbd;
                } else if (playStoreConfig.currentFilter === 'ibd') {
                    matchesFilter = isIbd;
                }
                
                if (matchesSearch && matchesFilter) {
                    visibleCards.push(card);
                    card.style.display = 'flex'; // reveal temporarily for pagination calculation
                } else {
                    card.style.style = 'none';
                    card.setAttribute('style', card.getAttribute('style').replace('display: flex', 'display: none'));
                    card.style.display = 'none';
                }
            });
            
            // Stage 2: Pagination orchestration
            const totalItems = visibleCards.length;
            const totalPages = Math.ceil(totalItems / playStoreConfig.itemsPerPage) || 1;
            
            // Cap current pointer
            if (playStoreConfig.currentPage < 1) playStoreConfig.currentPage = 1;
            if (playStoreConfig.currentPage > totalPages) playStoreConfig.currentPage = totalPages;
            
            const startIndex = (playStoreConfig.currentPage - 1) * playStoreConfig.itemsPerPage;
            const endIndex = startIndex + playStoreConfig.itemsPerPage;
            
            visibleCards.forEach((card, idx) => {
                if (idx >= startIndex && idx < endIndex) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Render Pagination Buttons
            const prevBtn = document.getElementById('prevPlayBtn');
            const nextBtn = document.getElementById('nextPlayBtn');
            
            prevBtn.disabled = playStoreConfig.currentPage === 1;
            prevBtn.style.opacity = prevBtn.disabled ? '0.3' : '1';
            prevBtn.style.pointerEvents = prevBtn.disabled ? 'none' : 'auto';
            
            nextBtn.disabled = playStoreConfig.currentPage === totalPages;
            nextBtn.style.opacity = nextBtn.disabled ? '0.3' : '1';
            nextBtn.style.pointerEvents = nextBtn.disabled ? 'none' : 'auto';
            
            const pageContainer = document.getElementById('playPageNumbers');
            pageContainer.innerHTML = '';
            
            // Generate visual pagination indicators
            for (let p = 1; p <= totalPages; p++) {
                const pBtn = document.createElement('button');
                pBtn.innerText = p;
                pBtn.onclick = () => setPlayStorePage(p);
                
                // Styles
                pBtn.style.padding = '8px 12px';
                pBtn.style.fontSize = '12px';
                pBtn.style.fontWeight = '850';
                pBtn.style.borderRadius = '6px';
                pBtn.style.cursor = 'pointer';
                pBtn.style.transition = '0.3s';
                pBtn.style.border = '1px solid';
                
                if (p === playStoreConfig.currentPage) {
                    pBtn.style.background = '#00f0ff';
                    pBtn.style.color = '#000';
                    pBtn.style.borderColor = '#00f0ff';
                    pBtn.style.boxShadow = '0 0 10px rgba(0,240,255,0.3)';
                } else {
                    pBtn.style.background = 'rgba(255,255,255,0.02)';
                    pBtn.style.color = '#fff';
                    pBtn.style.borderColor = 'rgba(255,255,255,0.06)';
                }
                
                pBtn.onmouseover = () => {
                    if (p !== playStoreConfig.currentPage) {
                        pBtn.style.borderColor = '#00f0ff';
                        pBtn.style.color = '#00f0ff';
                    }
                };
                pBtn.onmouseout = () => {
                    if (p !== playStoreConfig.currentPage) {
                        pBtn.style.borderColor = 'rgba(255,255,255,0.06)';
                        pBtn.style.color = '#fff';
                    }
                };
                
                pageContainer.appendChild(pBtn);
            }
        }

        // Initialize Store on DOM complete loader
        document.addEventListener('DOMContentLoaded', () => {
            renderPlayStoreDOM();
        });
        </script>

        <?php 
        endif; // End of ilybd_show_app_section 
        ?>

        <?php 
        /**
         * we will keep original category action after store
         */
        do_action('ilybd_category'); 
        ?>

    </main>

    <?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
