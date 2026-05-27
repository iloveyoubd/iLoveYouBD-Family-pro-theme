<?php
/* Template Name: App Archive Store Pro */
get_header(); ?>

<div class="cyber-store">

    <!-- HEADER -->
    <div class="store-hero">
        <h1 class="store-title">CyberX Pro Store</h1>
        <p class="store-sub">Premium • Secure • Verified APK Ecosystem</p>
    </div>

    <!-- GRID -->
    <div class="app-grid">

        <?php
        $query = new WP_Query(array(
            'post_type' => 'apps',
            'posts_per_page' => 16
        ));

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();

                $icon = get_post_meta(get_the_ID(), '_app_icon_url', true);
                $size = get_post_meta(get_the_ID(), '_app_size', true);
        ?>

        <div class="app-card">

            <div class="badge">APK</div>

            <a href="<?php the_permalink(); ?>" class="card-body">

                <div class="icon-wrap">
                    <?php if($icon): ?>
                        <img src="<?php echo esc_url($icon); ?>" loading="lazy">
                    <?php else: ?>
                        <div class="fallback-icon"><?php echo substr(get_the_title(),0,1); ?></div>
                    <?php endif; ?>
                </div>

                <div class="app-title"><?php the_title(); ?></div>

                <div class="meta">
                    <span><?php echo $size ?: '25 MB'; ?></span>
                    <span class="tag-free">FREE</span>
                </div>

            </a>

            <div class="actions">
                <a href="<?php the_permalink(); ?>" class="btn">Download</a>
                <span class="verify">✔ Secure</span>
            </div>

        </div>

        <?php endwhile; wp_reset_postdata(); endif; ?>

    </div>
</div>

<style>

/* ===== BASE SYSTEM ===== */
.cyber-store{
    background: radial-gradient(circle at top, #0a0f14, #05070a);
    min-height:100vh;
    padding:40px 12px;
    color:#fff;
}

/* ===== HERO ===== */
.store-hero{
    text-align:center;
    margin-bottom:35px;
}

.store-title{
    font-size:28px;
    font-weight:800;
    letter-spacing:2px;
    color:#39ff14;
    text-shadow:0 0 15px #39ff14;
}

.store-sub{
    font-size:12px;
    color:#888;
    margin-top:5px;
}

/* ===== GRID ===== */
.app-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(170px,1fr));
    gap:14px;
    max-width:1200px;
    margin:auto;
}

/* ===== CARD ===== */
.app-card{
    position:relative;
    background:rgba(255,255,255,0.03);
    border:1px solid rgba(57,255,20,0.15);
    border-radius:18px;
    padding:14px;
    transition:.25s;
    backdrop-filter: blur(10px);
    overflow:hidden;
}

.app-card::before{
    content:"";
    position:absolute;
    inset:0;
    border-radius:18px;
    padding:1px;
    background:linear-gradient(45deg,#39ff14,#00e5ff,#ff00ff,#39ff14);
    background-size:300%;
    animation:rgb 6s linear infinite;
    -webkit-mask:linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
    -webkit-mask-composite:xor;
    mask-composite:exclude;
    opacity:.6;
}

@keyframes rgb{
    0%{background-position:0%}
    100%{background-position:300%}
}

.app-card:hover{
    transform:translateY(-6px);
    box-shadow:0 10px 30px rgba(0,255,100,0.15);
}

/* ===== BADGE ===== */
.badge{
    position:absolute;
    top:10px;
    right:10px;
    font-size:9px;
    padding:3px 6px;
    background:#39ff14;
    color:#000;
    font-weight:700;
    border-radius:6px;
}

/* ===== ICON ===== */
.icon-wrap{
    text-align:center;
    margin-bottom:10px;
}

.icon-wrap img{
    width:78px;
    height:78px;
    border-radius:16px;
    border:1px solid rgba(255,255,255,0.1);
}

.fallback-icon{
    width:78px;
    height:78px;
    border-radius:16px;
    background:#111;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:26px;
    color:#39ff14;
}

/* ===== TITLE ===== */
.app-title{
    font-size:13px;
    text-align:center;
    margin:6px 0;
    color:#eee;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

/* ===== META ===== */
.meta{
    display:flex;
    justify-content:space-between;
    font-size:11px;
    color:#888;
    margin-top:6px;
}

.tag-free{
    color:#39ff14;
    font-weight:700;
}

/* ===== ACTIONS ===== */
.actions{
    margin-top:10px;
    border-top:1px solid rgba(255,255,255,0.08);
    padding-top:10px;
}

.btn{
    display:block;
    text-align:center;
    background:linear-gradient(90deg,#39ff14,#00ff88);
    color:#000;
    font-weight:700;
    font-size:12px;
    padding:7px;
    border-radius:10px;
    text-decoration:none;
}

.verify{
    display:block;
    text-align:center;
    font-size:10px;
    margin-top:5px;
    color:#0f0;
    opacity:.8;
}

/* ===== MOBILE ===== */
@media(max-width:480px){
    .app-grid{
        grid-template-columns:repeat(2,1fr);
    }
}

</style>

<?php get_footer(); ?>