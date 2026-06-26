<?php
/**
 * Template Name: Cyber Earning Center & Landing Page Pro
 * Description: High-EEAT Policy-Compliant Rewards Center, Earning Calculator, Leaderboard & Dynamic FAQ Hub.
 */

get_header();
$neon = get_option('ilybd_main_color', '#00ff41');
$current_user_id = get_current_user_id();
$is_logged_in = is_user_logged_in();
?>

<div class="cyber-page-wrapper">
    <div class="container-fluid" style="max-width: 1250px; margin: 0 auto; padding: 40px 20px;">
        
        <header class="cyber-section-header">
            <h1 class="rgb-text-lighting">Rewards & Earning Center</h1>
            <p class="section-subtext">কমিউনিটি রিওয়ার্ডস ও আর্নিং প্ল্যাটফর্ম / SECURE ENGAGEMENT ENGINE</p>
            <div class="sticky-rgb-line"></div>
        </header>

        <!-- Dynamic User Engagement Widget -->
        <div class="user-welcome-node" style="margin-bottom: 30px;">
            <?php if ($is_logged_in): 
                $usr = wp_get_current_user();
                $balance = (float) get_user_meta($current_user_id, 'user_balance', true);
                $points = (int) get_user_meta($current_user_id, 'ilybd_total_points', true);
                $tier = function_exists('ilybd_get_user_tier') ? ilybd_get_user_tier($current_user_id) : ['rank' => 'Premium Member', 'color' => '#00ff41'];
                ?>
                <div class="user-status-strip" style="background: rgba(13, 21, 39, 0.85); border: 1px solid rgba(0, 240, 255, 0.2); border-radius: 14px; padding: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <?php echo get_avatar($current_user_id, 55, '', '', ['class' => 'avatar-neon']); ?>
                        <div>
                            <span class="welcome-txt" style="display: block; font-size: 13px; color: #8b949e;">Welcome Back, Captain</span>
                            <span class="display-name" style="font-size: 18px; font-weight: bold; color: #fff;"><?php echo esc_html($usr->display_name); ?></span>
                            <span class="user-tier-badge" style="display: inline-block; font-family: monospace; font-size: 10px; background: rgba(0, 255, 65, 0.08); border: 1px solid <?php echo esc_attr($tier['color']); ?>; color: <?php echo esc_attr($tier['color']); ?>; padding: 1px 8px; border-radius: 4px; margin-left: 8px; font-weight: bold;">
                                <?php echo esc_html($tier['rank']); ?>
                            </span>
                        </div>
                    </div>
                    <div style="display: flex; gap: 20px; align-items: center;">
                        <div class="metric-block" style="text-align: right;">
                            <span style="display: block; font-size: 11px; color: #8b949e; text-transform: uppercase;">Total Points</span>
                            <span style="font-size: 20px; font-weight: bold; color: #ffaa00; font-family: monospace;"><?php echo $points; ?> XP</span>
                        </div>
                        <div class="vertical-spacer" style="width: 1px; height: 35px; background: rgba(255,255,255,0.08);"></div>
                        <div class="metric-block" style="text-align: right;">
                            <span style="display: block; font-size: 11px; color: #8b949e; text-transform: uppercase;">Wallet Balance</span>
                            <span style="font-size: 20px; font-weight: bold; color: #00ff41; font-family: monospace;">৳<?php echo number_format($balance, 2); ?></span>
                        </div>
                        <a href="<?php echo home_url('/dashboard/'); ?>" class="action-btn" style="background: var(--cyber-neon); color: #000; font-weight: bold; font-size: 12px; padding: 10px 16px; border-radius: 6px; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px; transition: 0.3s;" onmouseover="this.style.boxShadow='0 0 15px var(--cyber-neon)'" onmouseout="this.style.boxShadow='none'">Go to Dashboard</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="guest-welcome-strip" style="background: linear-gradient(135deg, rgba(13, 21, 39, 0.8) 0%, rgba(7, 11, 19, 0.9) 100%); border: 1px solid rgba(0, 240, 255, 0.15); border-radius: 14px; padding: 25px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                    <div>
                        <h3 style="margin: 0 0 5px 0; font-family: 'Space Grotesk', sans-serif; font-size: 18px; color: #fff;">💡 Join the ILOVEYOUBD.COM Tech Economy</h3>
                        <p style="margin: 0; font-size: 13px; color: #a0aec0;">নিবন্ধ লিখে, কমেন্ট শেয়ার করে এবং প্রশ্নোত্তরের মাধ্যমে পয়েন্ট ও ট্রাস্ট রিওয়ার্ডস অর্জন করুন। সম্পূর্ণ ফ্রি এবং নিরাপদ!</p>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <a href="<?php echo wp_login_url(get_permalink()); ?>" class="action-btn" style="background: #00f0ff; color: #000; font-weight: bold; font-size: 12px; padding: 10px 18px; border-radius: 6px; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px; transition: 0.3s;" onmouseover="this.style.boxShadow='0 0 15px #00f0ff'" onmouseout="this.style.boxShadow='none'">Login Node</a>
                        <a href="<?php echo wp_registration_url(); ?>" class="action-btn-outline" style="background: transparent; border: 1px solid rgba(255,255,255,0.15); color: #fff; font-weight: bold; font-size: 12px; padding: 10px 18px; border-radius: 6px; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px; transition: 0.2s;" onmouseover="this.style.borderColor='#00ff41'; this.style.color='#00ff41';" onmouseout="this.style.borderColor='rgba(255,255,255,0.15)'; this.style.color='#fff';">Register Account</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="slim-rgb-container">
            <div class="inner-page-content">
                
                <!-- Page Manifesto / Info -->
                <section class="policy-block" style="margin-bottom: 40px;">
                    <h2>📈 Community Engagement & Science Contribution Program</h2>
                    <p style="font-size: 14.5px; line-height: 1.8; color: #a0aec0; margin-bottom: 20px;">
                        ILOVEYOUBD.COM কন্টেন্টের সঠিক সত্যতা এবং পাঠকদের পারস্পরিক মেধা বিকাশে বিশ্বাস করে। আমাদের প্লাটফর্ম কোনো প্রকার "ক্লিক-বিট", "ভুয়া গ্যারান্টি বা সহজে টাকা আয়ের ফাঁদ" সমর্থন করে না। এটি একটি বিশুদ্ধ গ্যামিফাইড নলেজ প্ল্যাটফর্ম। ব্যবহারকারীরা যখন গঠনমূলক প্রযুক্তিগত টিউটোরিয়াল তৈরি করেন বা ফোরামে বিজ্ঞানসম্মত সঠিক তথ্যের মাধ্যমে জটিল প্রশ্নের উত্তর দেন, তখন আমাদের স্বচ্ছ <b>XP (Experience Points) & Engagement Wallet</b> সিস্টেম সেই অবদানকে পয়েন্ট এবং আর্থিক রিওয়ার্ড দ্বারা পুরস্কৃত করে।
                    </p>
                    <div style="width: 100%; height: 1px; background: rgba(255,255,255,0.06); margin-top: 35px;"></div>
                </section>

                <div class="how-earn-bento-grid">
                    
                    <!-- 1. The Dynamic 2040 Earning Calculator -->
                    <div class="bento-card-calc" style="grid-column: span 2;">
                        <h3><i class="fa-solid fa-calculator-combined" style="color: var(--cyber-neon);"></i> Interactive Reward & Earning Calculator</h3>
                        <p style="font-size: 12.5px; color: #8b949e; line-height: 1.6; margin-bottom: 25px;">
                            আপনার দৈনিক টার্গেট কন্ট্রিবিউশন নির্বাচন করুন এবং আমাদের রিয়েল-টাইম থ্রেশহোল্ড ইঞ্জিন ব্যবহার করে আনুমানিক মাসিক রিওয়ার্ড গণনা করুন:
                        </p>
                        
                        <div class="calc-inner-grid">
                            <div class="calc-sliders">
                                
                                <div class="slider-group">
                                    <div class="slider-label">
                                        <span>📝 Article Publications Created (নিবন্ধ তৈরি)</span>
                                        <span class="slider-val" id="posts_val">1</span>
                                    </div>
                                    <input type="range" class="calc-input-range" id="input_posts" min="0" max="5" value="1" oninput="runCalculator()">
                                    <span class="reward-factor">+30 XP, +৳15.00 cash per full article node</span>
                                </div>

                                <div class="slider-group">
                                    <div class="slider-label">
                                        <span>💬 Scientific Forum Answers (প্রশ্নোত্তর সমাধান)</span>
                                        <span class="slider-val" id="answers_val">3</span>
                                    </div>
                                    <input type="range" class="calc-input-range" id="input_answers" min="0" max="15" value="3" oninput="runCalculator()">
                                    <span class="reward-factor">+10 XP, +৳1.50 cash per helpful answer</span>
                                </div>

                                <div class="slider-group">
                                    <div class="slider-label">
                                        <span>🗣️ Community Comments & Replies (মন্তব্য শেয়ার)</span>
                                        <span class="slider-val" id="comments_val">5</span>
                                    </div>
                                    <input type="range" class="calc-input-range" id="input_comments" min="0" max="30" value="5" oninput="runCalculator()">
                                    <span class="reward-factor">+2 XP, +৳0.10 cash per complete comment</span>
                                </div>

                                <div class="slider-group">
                                    <div class="slider-label">
                                        <span>👍 Core Story Uploads & Reactions (রিঅ্যাকশন)</span>
                                        <span class="slider-val" id="stories_val">8</span>
                                    </div>
                                    <input type="range" class="calc-input-range" id="input_stories" min="0" max="50" value="8" oninput="runCalculator()">
                                    <span class="reward-factor">+1 XP, +৳0.05 cash per interactions node</span>
                                </div>

                                <div class="slider-group">
                                    <div class="slider-label">
                                        <span>👥 Active Referrals Joined (রেফারেল আমন্ত্রণ)</span>
                                        <span class="slider-val" id="ref_val">2</span>
                                    </div>
                                    <input type="range" class="calc-input-range" id="input_ref" min="0" max="10" value="2" oninput="runCalculator()">
                                    <span class="reward-factor">+50 XP, +৳5.00 cash per active registration</span>
                                </div>

                            </div>

                            <div class="calc-results-panel">
                                <div class="panel-header">ESTIMATED COMPLIANT REWARDS</div>
                                
                                <div class="res-row">
                                    <span class="res-lbl">Daily XP Accrual</span>
                                    <span class="res-val" id="daily_xp" style="color: #ffaa00;">0 XP</span>
                                </div>
                                <div class="res-row">
                                    <span class="res-lbl">Daily Estimated Cash</span>
                                    <span class="res-val" id="daily_cash" style="color: #00ff41;">৳0.00</span>
                                </div>

                                <div class="result-divider"></div>

                                <div class="res-row">
                                    <span class="res-lbl">Monthly Projected XP</span>
                                    <span class="res-val-large" id="monthly_xp" style="color: #ffaa00;">0 XP</span>
                                </div>
                                <div class="res-row">
                                    <span class="res-lbl">Monthly Projected Cash</span>
                                    <span class="res-val-large" id="monthly_cash" style="color: #00ff41;">৳0.00</span>
                                </div>

                                <div class="calc-notice">
                                    <i class="fa-solid fa-circle-info"></i> Calculations correspond directly to active <code>ilybd_update_user_economy()</code> standards. Value estimations assume all generated nodes fulfill human E-E-A-T manual review criteria safely.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Earning Methods Bento -->
                    <div class="bento-card-full" style="grid-column: span 2;">
                        <h3><i class="fa-solid fa-layer-group" style="color: #00f0ff;"></i> Standard Contribution Parameters & Channels</h3>
                        
                        <div class="methods-grid">
                            <div class="method-item">
                                <div class="item-icon" style="background: rgba(0, 255, 65, 0.05); border-color: rgba(0, 255, 65, 0.2);"><i class="fa-solid fa-feather-pointed" style="color: #00ff41;"></i></div>
                                <h4>Write Tech Tutorials</h4>
                                <p style="font-size: 12.5px; color: #a0aec0; margin-bottom: 8px;">১০০০+ শব্দের মানসম্মত গাইড বা কোডিং সমাধান প্রকাশ করে ৩০ XP ও রিওয়ার্ড ব্যালেন্স পান।</p>
                                <span class="rate-tag">Rate: +30 XP / ৳15.00</span>
                            </div>

                            <div class="method-item">
                                <div class="item-icon" style="background: rgba(0, 240, 255, 0.05); border-color: rgba(0, 240, 255, 0.2);"><i class="fa-regular fa-comment-dots" style="color: #00f0ff;"></i></div>
                                <h4>Helpful QA Answers</h4>
                                <p style="font-size: 12.5px; color: #a0aec0; margin-bottom: 8px;">প্রশ্নোত্তর ফোরামে গঠনমূলক এবং নির্ভুল উত্তর প্রদান করে আপনার দক্ষতা প্রোফাইল বুস্ট করুন।</p>
                                <span class="rate-tag">Rate: +10 XP / ৳1.50</span>
                            </div>

                            <div class="method-item">
                                <div class="item-icon" style="background: rgba(255, 170, 0, 0.05); border-color: rgba(255, 170, 0, 0.2);"><i class="fa-solid fa-bolt" style="color: #ffaa00;"></i></div>
                                <h4>Social Engagement</h4>
                                <p style="font-size: 12.5px; color: #a0aec0; margin-bottom: 8px;">অন্যান্য সদস্যদের পোস্টে সঠিক মন্তব্য ও ফিডব্যাক বিনিময় করে কমিউনিটি ট্রাস্ট বৃদ্ধি করুন।</p>
                                <span class="rate-tag">Rate: +2 XP / ৳0.10</span>
                            </div>

                            <div class="method-item">
                                <div class="item-icon" style="background: rgba(255, 62, 62, 0.05); border-color: rgba(255, 62, 62, 0.2);"><i class="fa-solid fa-network-wired" style="color: #ff3e3e;"></i></div>
                                <h4>Referral Program</h4>
                                <p style="font-size: 12.5px; color: #a0aec0; margin-bottom: 8px;">আপনার ইউনিক প্রোফাইল রেফারেল লিঙ্ক দিয়ে বন্ধুদের আমন্ত্রণ জানিয়ে আজীবন এক্সট্রা আর্ন করুন।</p>
                                <span class="rate-tag">Rate: +50 XP / ৳5.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Public Leaderboard Widget -->
                    <div class="sitemap-card" style="grid-column: span 1;">
                        <h3><i class="fa-solid fa-ranking-star" style="color: #00f0ff;"></i> Top Tech Contributors Leaderboard</h3>
                        <p style="font-size: 12px; color: #8b949e; margin-bottom: 15px;">ক্লিন স্প্যাম-ফ্রি ট্রাস্ট পয়েন্ট এবং সর্বোচ্চ অবদানকারী সক্রিয় সদস্যদের তালিকা:</p>
                        
                        <div class="leaderboard-container">
                            <?php
                            $top_users = get_users([
                                'meta_key' => 'ilybd_total_points',
                                'orderby'  => 'meta_value_num',
                                'order'    => 'DESC',
                                'number'   => 5,
                            ]);

                            if ($top_users):
                                $rank = 1;
                                foreach ($top_users as $usr):
                                    $u_id = $usr->ID;
                                    $pts = (int) get_user_meta($u_id, 'ilybd_total_points', true);
                                    $bal = (float) get_user_meta($u_id, 'user_balance', true);
                                    $tier = function_exists('ilybd_get_user_tier') ? ilybd_get_user_tier($u_id) : ['rank' => 'Expert'];
                                    
                                    // Style rank badge
                                    $rank_style = "background: rgba(255,255,255,0.05); color: #fff;";
                                    if ($rank === 1) $rank_style = "background: linear-gradient(135deg, #ffaa00, #ff5500); color: #000; font-weight: bold;";
                                    if ($rank === 2) $rank_style = "background: linear-gradient(135deg, #00f0ff, #0055ff); color: #000; font-weight: bold;";
                                    if ($rank === 3) $rank_style = "background: linear-gradient(135deg, #00ff41, #00aa00); color: #000; font-weight: bold;";
                                    ?>
                                    <div class="leaderboard-item" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; border: 1px solid rgba(255,255,255,0.02); background: rgba(0,0,0,0.2); border-radius: 8px; margin-bottom: 8px;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <span class="rank-badge" style="display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; border-radius: 50%; font-size: 11px; <?php echo $rank_style; ?>"><?php echo $rank; ?></span>
                                            <?php echo get_avatar($u_id, 32, '', '', ['style' => 'border-radius: 50%; border: 1px solid rgba(255,255,255,0.1);']); ?>
                                            <div>
                                                <span style="display: block; font-size: 13px; font-weight: bold; color: #fff;"><?php echo esc_html($usr->display_name); ?></span>
                                                <span style="font-size: 10px; color: #8b949e;"><?php echo esc_html($tier['rank']); ?></span>
                                            </div>
                                        </div>
                                        <div style="text-align: right;">
                                            <span style="display: block; font-size: 12.5px; font-weight: bold; color: #ffaa00; font-family: monospace;"><?php echo $pts; ?> XP</span>
                                            <span style="display: block; font-size: 10.5px; color: #00ff41; font-family: monospace;">৳<?php echo number_format($bal, 1); ?></span>
                                        </div>
                                    </div>
                                    <?php
                                    $rank++;
                                endforeach;
                            else: ?>
                                <p style="color: #8b949e;"><i class="fa-solid fa-circle-exclamation"></i> Calibrating leaderboard indexes...</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- 4. Success Stories Bento -->
                    <div class="sitemap-card" style="grid-column: span 1;">
                        <h3><i class="fa-solid fa-square-poll-vertical" style="color: #00ff41;"></i> Verified Member Success Stories</h3>
                        <p style="font-size: 12px; color: #8b949e; margin-bottom: 15px;">আমাদের বিশ্বস্ত বিজ্ঞান ক্লাবের সদস্যদের সততা এবং তাদের বাস্তব কন্ট্রিবিউশন যাত্রা:</p>
                        
                        <div class="stories-scroll" style="display: flex; flex-direction: column; gap: 12px;">
                            <div class="story-box" style="background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.04); padding: 14px; border-radius: 10px;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                    <div class="story-avatar" style="font-weight: bold; width: 30px; height: 30px; border-radius: 50%; background: #00ff41; color: #000; display: flex; align-items: center; justify-content: center; font-size: 11px;">AH</div>
                                    <div>
                                        <span style="display: block; font-size: 13px; font-weight: bold; color: #fff;">Ariful Hasan</span>
                                        <span style="font-size: 10px; color: #00ff41;"><i class="fa-solid fa-certificate"></i> Verified Contributor</span>
                                    </div>
                                </div>
                                <p style="margin: 0; font-size: 12px; line-height: 1.5; color: #a0aec0;">"আমি সাইটে নিয়মত ক্রিপ্টোগ্রাফি ও সার্ভার স্পিড অপ্টিমাইজেশন নিয়ে আর্টিকেল লিখি। এখানে কোনো শর্টকাট উপায়ে উপার্জনের মিথ্যা ফাঁদ নেই, অবদানের সম্পূর্ণ সঠিক মূল্যায়ন রয়েছে।"</p>
                            </div>

                            <div class="story-box" style="background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.04); padding: 14px; border-radius: 10px;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                    <div class="story-avatar" style="font-weight: bold; width: 30px; height: 30px; border-radius: 50%; background: #00f0ff; color: #000; display: flex; align-items: center; justify-content: center; font-size: 11px;">MR</div>
                                    <div>
                                        <span style="display: block; font-size: 13px; font-weight: bold; color: #fff;">Mizanur Rahman</span>
                                        <span style="font-size: 10px; color: #00f0ff;"><i class="fa-solid fa-code"></i> Fullstack Contributor</span>
                                    </div>
                                </div>
                                <p style="margin: 0; font-size: 12px; line-height: 1.5; color: #a0aec0;">"পয়েন্টস ও লেভেল সিস্টেমটি অনেক চমৎকার। কন্ট্রিবিউশন যখন করি তখন নিজেকে লাইভ গেমেরই অংশ মনে হয়। টাকা উইথড্র বিকাশে একদম ইনস্ট্যান্টলি কমপ্লিট হয়!"</p>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Earning FAQ Hub (Accordion) -->
                    <div class="bento-card-full" style="grid-column: span 2; margin-top: 15px;">
                        <h3><i class="fa-solid fa-question-circle" style="color: #ffaa00;"></i> Earning Center FAQ Hub (প্রশ্নোত্তরের মাধ্যমে বিস্তারিত গাইড)</h3>
                        <p style="font-size: 12.5px; color: #8b949e; line-height: 1.6; margin-bottom: 25px;">
                            আমাদের কন্ট্রিবিউশন মেকানিজম এবং প্রফেশনাল উইথড্রয়াল নীতি নিয়ে সর্বাধিক জিজ্ঞাসিত প্রশ্নসমূহ ও তাদের সরাসরি উত্তর এখানে দেখে নিন:
                        </p>
                        
                        <div class="faq-accordion">
                            
                            <div class="faq-item">
                                <button class="faq-quest" onclick="toggleFaq(this)">
                                    <span>❓ ১. ILOVEYOUBD.COM থেকে মূলত কিসের মাধ্যমে উপার্জন করা যায়?</span>
                                    <i class="fa-solid fa-plus font-icon"></i>
                                </button>
                                <div class="faq-ans">
                                    <p>আমাদের সাইটটি একটি প্রযুক্তিগত জ্ঞান শেয়ারিং প্ল্যাটফর্ম। সাধারণ কোনো কাজ ছাড়া টাকা আয়ের অ্যাপ বা প্রতারণামূলক MLM সিস্টেম এটি নয়। এখানে সম্পূর্ণ স্বচ্ছ উপায়ে- ১. মানসম্পন্ন তথ্যবহুল প্রযুক্তি ব্লগ লিখে, ২. প্রশ্নোত্তরের মাধ্যমে সঠিক সেবা দিয়ে, ৩. সামাজিক কার্যকলাপে গঠনমূলক ভূমিকা রেখে ট্রাস্ট পয়েন্টের ভিত্তিতে উইথড্র রিওয়ার্ড উপার্জন করতে হয়।</p>
                                </div>
                            </div>

                            <div class="faq-item">
                                <button class="faq-quest" onclick="toggleFaq(this)">
                                    <span>❓ ২. ১XP পয়েন্টের মূল্য কত এবং এটি কিভাবে যুক্ত হয়?</span>
                                    <i class="fa-solid fa-plus font-icon"></i>
                                </button>
                                <div class="faq-ans">
                                    <p>আমাদের <code>ilybd_update_user_economy()</code> সিস্টেম অনুযায়ী ১XP পয়েন্ট সরাসরি প্রোফাইল ট্রাস্টে এবং সাথে কনফিগারেশন অনুযায়ী ব্যালেন্স প্লাস হয়ে যায়। উদাহরণস্বরূপ, একটি তথ্যবহুল প্রযুক্তি নিবন্ধ প্রকাশিত হলে লেখক সাথে সাথে ৩০ XP পয়েন্ট এবং ৳১৫.০০ টাকা সরাসরি তার ডিজিটাল ওয়ালেটে পেয়ে যাবেন।</p>
                                </div>
                            </div>

                            <div class="faq-item">
                                <button class="faq-quest" onclick="toggleFaq(this)">
                                    <span>❓ ৩. উপার্জিত অর্থ উত্তোলনের (Withdraw) করার নিয়ম কি?</span>
                                    <i class="fa-solid fa-plus font-icon"></i>
                                </button>
                                <div class="faq-ans">
                                    <p>ব্যালেন্স নুন্যতম ৩০০ টাকা (৳৩০০) পূর্ণ হওয়ামাত্র ব্যবহারকারীরা মেম্বার কনসোল ড্যাশবোর্ডের মাধ্যমে বিকাশের (bKash) ও রকেটে ইনস্ট্যান্ট উত্তোলন রিকোয়েস্ট সাবমিট করতে পারবেন। আমাদের সিকিউরিটি টিম রিকোয়েস্টটি ১২ থেকে ২৪ ঘণ্টার মধ্যে যাচাই এবং অ্যাকাউন্ট ট্রান্সফার সম্পন্ন করে থাকে।</p>
                                </div>
                            </div>

                            <div class="faq-item">
                                <button class="faq-quest" onclick="toggleFaq(this)">
                                    <span>❓ ৪. রেফারেল সিস্টেমটি কীভাবে কাজ করে?</span>
                                    <i class="fa-solid fa-plus font-icon"></i>
                                </button>
                                <div class="faq-ans">
                                    <p>প্রতিটি সক্রিয় নিবন্ধিত ইউজারের জন্য একটি ইউনিক রেফার লিঙ্ক ড্যাশবোর্ড থেকে জেনারেট করা হয়। এই রেফারাল কোড বা লিঙ্ক ব্যবহার করে আপনার কাছের বন্ধু যখন সাইটে অ্যাকাউন্ট তৈরি করে সম্পূর্ণ প্রোফাইল সিকিউরিটি নিশ্চিত করবেন, আপনি সরাসরি ৫০ XP পয়েন্ট এবং ৳৫.০০ রিওয়ার্ড পাবেন।</p>
                                </div>
                            </div>

                            <div class="faq-item">
                                <button class="faq-quest" onclick="toggleFaq(this)">
                                    <span>❓ ৫. ভুয়া ভিজিটর বা রি-রাইট এআই কন্টেন্ট সাবমিট করলে কি একাউন্ট সাসপেন্ড হবে?</span>
                                    <i class="fa-solid fa-plus font-icon"></i>
                                </button>
                                <div class="faq-ans">
                                    <p>হ্যাঁ। আমাদের প্ল্যাটফর্মে রয়েছে একটি শক্তিশালী "অটোমেটেড ট্রাফিক হাইজ্যাকিং ও প্রক্সি ফিল্টারিং সিস্টেম"। কোনো স্প্যাম ট্রাফিক, রোবোটিক রি-রাইট কন্টেন্ট বা ভুয়া রেফারেল তৈরি করলে সেশন আইডি লক করে দিয়ে অ্যাকাউন্ট চিরতরে ব্যান করা হতে পারে। প্রতিটি সাবমিশনকে অবশ্যই সম্পূর্ণ হিউম্যান-গাইডলাইনের সাথে সামঞ্জস্যপূর্ণ হতে হবে।</p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

<script>
    // Accordion Toggle Logic
    function toggleFaq(btn) {
        const item = btn.parentElement;
        const answer = item.querySelector('.faq-ans');
        const icon = btn.querySelector('.font-icon');
        
        // Toggle Active Class
        const isActive = item.classList.contains('active');
        
        // Close all other first to stay clean
        document.querySelectorAll('.faq-item').forEach(i => {
            i.classList.remove('active');
            i.querySelector('.faq-ans').style.maxHeight = null;
            i.querySelector('.font-icon').className = "fa-solid fa-plus font-icon";
        });
        
        if (!isActive) {
            item.classList.add('active');
            answer.style.maxHeight = answer.scrollHeight + "px";
            icon.className = "fa-solid fa-minus font-icon";
        }
    }

    // 2040 Earning Calculator Matrix Logic
    function runCalculator() {
        // Inputs
        const posts = parseInt(document.getElementById('input_posts').value);
        const answers = parseInt(document.getElementById('input_answers').value);
        const comments = parseInt(document.getElementById('input_comments').value);
        const stories = parseInt(document.getElementById('input_stories').value);
        const ref = parseInt(document.getElementById('input_ref').value);

        // Update Slider value displays
        document.getElementById('posts_val').innerText = posts;
        document.getElementById('answers_val').innerText = answers;
        document.getElementById('comments_val').innerText = comments;
        document.getElementById('stories_val').innerText = stories;
        document.getElementById('ref_val').innerText = ref;

        // Points (XP) Factors matching real functions
        const xp_posts = posts * 30;
        const xp_answers = answers * 10;
        const xp_comments = comments * 2;
        const xp_stories = stories * 1;
        const xp_ref = ref * 50;
        const total_daily_xp = xp_posts + xp_answers + xp_comments + xp_stories + xp_ref;

        // Money/Cash Factors matching real economics
        const cash_posts = posts * 15.00;
        const cash_answers = answers * 1.50;
        const cash_comments = comments * 0.10;
        const cash_stories = stories * 0.05;
        const cash_ref = ref * 5.00;
        const total_daily_cash = cash_posts + cash_answers + cash_comments + cash_stories + cash_ref;

        // Monthly Projected values (30 days factor)
        const total_monthly_xp = total_daily_xp * 30;
        const total_monthly_cash = total_daily_cash * 30;

        // Push outputs to screen with premium styling
        document.getElementById('daily_xp').innerText = total_daily_xp + " XP";
        document.getElementById('daily_cash').innerText = "৳" + total_daily_cash.toFixed(2);
        
        document.getElementById('monthly_xp').innerText = total_monthly_xp.toLocaleString() + " XP";
        document.getElementById('monthly_cash').innerText = "৳" + total_monthly_cash.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    // Run once on load
    document.addEventListener("DOMContentLoaded", function() {
        runCalculator();
    });
</script>

<!-- Structured Google SEO Earning FAQ Schema Injected For Search Engine Crawling -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "FAQPage",
      "@id": "<?php echo get_permalink(); ?>#faq-schema",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "ILOVEYOUBD.COM থেকে মূলত কিসের মাধ্যমে উপার্জন করা যায়?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "আমাদের সাইটটি একটি প্রযুক্তিগত জ্ঞান শেয়ারিং প্ল্যাটফর্ম। সাধারণ কোনো কাজ ছাড়া টাকা আয়ের অ্যাপ বা প্রতারণামূলক MLM সিস্টেম এটি নয়। এখানে সম্পূর্ণ স্বচ্ছ উপায়ে কন্টেন্ট শেয়ারিং এবং ট্রাস্ট পয়েন্ট রিওয়ার্ড দ্বারা পুরস্কৃত করা হয়।"
          }
        },
        {
          "@type": "Question",
          "name": "১XP পয়েন্টের মূল্য কত এবং এটি কিভাবে যুক্ত হয়?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "১XP পয়েন্ট এবং টাকা সরাসরি ওয়ালেট এবং ট্রাস্ট মেট্রিকে যুক্ত হউ। যেমন- একটি তথ্যবহুল প্রযুক্তি নিবন্ধ প্রকাশিত হলে লেখক ৩০ XP পয়েন্ট এবং ৳১৫.০০ টাকা সরাসরি তার ওয়ালেটে পেয়ে যাবেন।"
          }
        },
        {
          "@type": "Question",
          "name": "উপার্জিত অর্থ উত্তোলনের (Withdraw) করার নিয়ম কি?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "ব্যালেন্স নুন্যতম ৩০০ টাকা (৳৩০০) পূর্ণ হওয়ামাত্র বিকাশ এবং রকেটে উত্তোলন রিকোয়েস্ট সাবমিট করা যায়। যা ১২ থেকে ২৪ ঘণ্টার মধ্যে সম্পন্ন করা হয়।"
          }
        }
      ]
    }
  ]
}
</script>

<style>
    .cyber-page-wrapper {
        background: #070a0f;
        min-height: 100vh;
        color: #e1e7ef;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .cyber-section-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .rgb-text-lighting {
        font-size: 2.8rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin: 0 0 10px 0;
        background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: rgb_flow 4s linear infinite;
    }

    .section-subtext {
        color: <?php echo $neon; ?>;
        font-size: 11px;
        letter-spacing: 5px;
        margin-bottom: 20px;
    }

    .sticky-rgb-line {
        height: 2px;
        width: 100%;
        background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000);
        background-size: 200% auto;
        animation: rgb_flow 4s linear infinite;
        box-shadow: 0 0 15px <?php echo $neon; ?>dd;
    }

    /* Outer Matrix Container */
    .slim-rgb-container {
        position: relative;
        padding: 1px;
        background: linear-gradient(var(--angle), #ff0000, #00ff00, #0000ff, #ff0000);
        animation: rotate-border 6s linear infinite;
        border-radius: 20px;
        overflow: hidden;
    }

    @property --angle {
        syntax: '<angle>';
        initial-value: 0deg;
        inherits: false;
    }

    @keyframes rotate-border {
        to { --angle: 360deg; }
    }

    .inner-page-content {
        background: #0a0e14;
        border-radius: 19px;
        padding: 40px;
    }

    /* Bento Grid */
    .how-earn-bento-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .bento-card-calc {
        background: rgba(255,255,255,0.01);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 14px;
        padding: 30px;
        transition: 0.3s;
    }

    .bento-card-calc:hover {
        border-color: <?php echo $neon; ?>;
        box-shadow: 0 0 15px <?php echo $neon; ?>1d;
    }

    .bento-card-calc h3, .bento-card-full h3, .sitemap-card h3 {
        color: #fff;
        font-size: 18px;
        margin-top: 0;
        margin-bottom: 12px;
        font-family: 'Space Grotesk', sans-serif;
        text-transform: uppercase;
    }

    .bento-card-calc h3 i, .bento-card-full h3 i, .sitemap-card h3 i {
        margin-right: 8px;
    }

    .calc-inner-grid {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 30px;
        margin-top: 20px;
    }

    .slider-group {
        margin-bottom: 20px;
    }

    .slider-label {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        font-weight: bold;
        color: #e2e8f0;
        margin-bottom: 8px;
    }

    .slider-val {
        color: <?php echo $neon; ?>;
        font-family: monospace;
        font-size: 14px;
    }

    .calc-input-range {
        width: 100%;
        accent-color: <?php echo $neon; ?>;
        height: 6px;
        background: rgba(255,255,255,0.08);
        border-radius: 5px;
        border: none;
        outline: none;
        margin-bottom: 6px;
    }

    .reward-factor {
        display: block;
        font-size: 10.5px;
        color: #8b949e;
        font-family: monospace;
    }

    .calc-results-panel {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255,255,255,0.03);
        border-radius: 10px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .panel-header {
        font-family: monospace;
        font-size: 11px;
        color: #8b949e;
        letter-spacing: 1px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        padding-bottom: 8px;
        margin-bottom: 15px;
        text-align: center;
    }

    .res-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .res-lbl {
        font-size: 12.5px;
        color: #8b949e;
    }

    .res-val {
        font-size: 16px;
        font-weight: bold;
        font-family: monospace;
    }

    .res-val-large {
        font-size: 21px;
        font-weight: 900;
        font-family: monospace;
    }

    .result-divider {
        height: 1px;
        background: rgba(255,255,255,0.06);
        margin: 10px 0 15px 0;
    }

    .calc-notice {
        font-size: 10px;
        color: #8b949e;
        line-height: 1.5;
        border-top: 1px solid rgba(255,255,255,0.04);
        padding-top: 10px;
        margin-top: 15px;
    }

    /* Methods Grid */
    .bento-card-full {
        background: rgba(255,255,255,0.01);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 14px;
        padding: 30px;
        transition: 0.3s;
    }

    .bento-card-full:hover {
        border-color: <?php echo $neon; ?>;
        box-shadow: 0 0 15px <?php echo $neon; ?>1d;
    }

    .methods-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-top: 20px;
    }

    .method-item {
        background: rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.03);
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        transition: 0.2s;
    }

    .method-item:hover {
        transform: translateY(-2px);
        border-color: rgba(255,255,255,0.08);
    }

    .item-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        border: 1px solid;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin: 0 auto 15px auto;
    }

    .method-item h4 {
        margin: 0 0 8px 0;
        font-size: 14px;
        color: #fff;
    }

    .rate-tag {
        display: inline-block;
        font-size: 11px;
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.06);
        color: <?php echo $neon; ?>;
        padding: 3px 10px;
        border-radius: 4px;
        font-weight: bold;
        font-family: monospace;
    }

    /* Leaderboard Card & Sitemap Style Card */
    .sitemap-card {
        background: rgba(255,255,255,0.01);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 14px;
        padding: 25px;
    }

    /* FAQ Accordion Styling */
    .faq-accordion {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 20px;
    }

    .faq-item {
        border: 1px solid rgba(255,255,255,0.04);
        background: rgba(0,0,0,0.15);
        border-radius: 8px;
        overflow: hidden;
        transition: 0.3s;
    }

    .faq-item:hover {
        border-color: rgba(255,255,255,0.08);
    }

    .faq-item.active {
        border-color: rgba(0, 240, 255, 0.25);
    }

    .faq-quest {
        width: 100%;
        background: none;
        border: none;
        padding: 16px 20px;
        text-align: left;
        color: #fff;
        font-weight: bold;
        font-size: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        outline: none;
    }

    .faq-quest:hover {
        color: <?php echo $neon; ?>;
    }

    .faq-ans {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }

    .faq-ans p {
        padding: 0 20px 20px 20px;
        margin: 0;
        line-height: 1.7;
        font-size: 13.5px;
        color: #a0aec0;
    }

    @media (max-width: 991px) {
        .how-earn-bento-grid {
            grid-template-columns: 1fr;
        }
        .calc-inner-grid {
            grid-template-columns: 1fr;
        }
        .methods-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .bento-card-calc, .bento-card-full, .sitemap-card {
            grid-column: span 1 !important;
        }
    }

    @media (max-width: 600px) {
        .methods-grid {
            grid-template-columns: 1fr;
        }
        .inner-page-content {
            padding: 20px;
        }
    }

    @keyframes rgb_flow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>

<?php get_footer(); ?>
