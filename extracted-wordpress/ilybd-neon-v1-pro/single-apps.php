<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post();

$pkg     = esc_attr(get_post_meta(get_the_ID(), '_app_pkg', true));
$icon    = esc_url(get_post_meta(get_the_ID(), '_app_icon_url', true));
$size    = esc_html(get_post_meta(get_the_ID(), '_app_size', true) ?: 'Varies with device');
$version = esc_html(get_post_meta(get_the_ID(), '_app_version', true) ?: 'Latest Build');

?>

<div style="background:#050505;color:#eee;padding:20px;font-family:Segoe UI,Roboto,sans-serif;">

    <!-- HEADER -->
    <div style="background:linear-gradient(145deg,#111,#080808);border:1px solid #222;border-radius:24px;padding:25px;display:flex;gap:20px;align-items:center;">

        <img src="<?php echo $icon; ?>"
             style="width:90px;height:90px;border-radius:20px;border:2px solid #39ff14;object-fit:cover;">

        <div>
            <h1 style="color:#fff;margin:0;"><?php the_title(); ?></h1>

            <div style="margin-top:8px;display:flex;gap:10px;flex-wrap:wrap;">
                <span style="color:#39ff14;background:#1a1a1a;padding:4px 10px;border-radius:50px;">
                    Size: <?php echo $size; ?>
                </span>

                <span style="color:#39ff14;background:#1a1a1a;padding:4px 10px;border-radius:50px;">
                    Version: <?php echo $version; ?>
                </span>
            </div>
        </div>

    </div>

    <!-- LOADING BOX -->
    <div style="text-align:center;margin:30px 0;background:#0a0a0a;padding:40px;border-radius:30px;position:relative;">

        <h3 id="status-text" style="color:#39ff14;">Initializing...</h3>
        <div id="timer-count" style="font-size:50px;color:#fff;">10</div>

        <div id="download-options" style="display:none;margin-top:20px;">

            <a href="https://play.google.com/store/apps/details?id=<?php echo $pkg; ?>"
               style="display:block;background:#39ff14;color:#000;padding:15px;margin:10px;border-radius:10px;">
                Direct Download
            </a>

        </div>

    </div>

    <!-- CONTENT -->
    <div style="background:#0d0d0d;padding:15px;border-radius:20px;">
        <?php the_content(); ?>
    </div>

</div>

<script>
(function(){
    let time = 10;
    let el = document.getElementById('timer-count');
    let status = document.getElementById('status-text');

    let interval = setInterval(function(){

        time--;

        if(el) el.innerText = time;

        if(time <= 0){
            clearInterval(interval);

            if(status) status.innerText = "Ready";

            let box = document.getElementById('download-options');
            if(box) box.style.display = "block";
        }

    },1000);
})();
</script>

<?php endwhile; endif; ?>

<?php get_footer(); ?>