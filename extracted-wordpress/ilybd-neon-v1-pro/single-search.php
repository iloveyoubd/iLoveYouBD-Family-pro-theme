<?php
/**
 * Template Part: Single Post Bottom Search (Premium Compact Style)
 * Created for: ILYBD Neon Pro Theme
 */
?>

<div class="single-post-search" style="margin: 30px 0; width: 100%; border-top: 1px solid #1c2128; padding-top: 25px;">
    <form role="search" method="get" action="<?php echo home_url('/'); ?>" style="width: 100%;">
        <div class="tbd-search-wrapper">
            <input type="search" 
                   class="tbd-search-input" 
                   placeholder="পছন্দের কিছু খুঁজুন..." 
                   value="<?php echo get_search_query(); ?>" 
                   name="s" 
                   autocomplete="off" />
            <button type="submit" class="tbd-search-btn">
                <i class="dashicons dashicons-search"></i>
            </button>
        </div>
    </form>
</div>

<style>
/* Premium Compact Inspired Pro UI */
.tbd-search-wrapper {
    display: flex;
    align-items: center;
    background: #161b22; /* Premium dark tone */
    border: 1px solid #30363d;
    border-radius: 8px;
    padding: 6px 18px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.tbd-search-wrapper:focus-within {
    border-color: #58a6ff; 
    background: #0d1117;
    box-shadow: 0 0 0 3px rgba(88, 166, 255, 0.15);
    transform: translateY(-1px);
}

.tbd-search-input {
    width: 100%;
    background: transparent !important;
    border: none !important;
    color: #c9d1d9 !important;
    font-size: 16px !important;
    padding: 12px 0 !important;
    outline: none !important;
    box-shadow: none !important;
    font-family: inherit;
}

.tbd-search-input::placeholder {
    color: #484f58;
}

.tbd-search-btn {
    background: transparent;
    border: none;
    color: #8b949e;
    cursor: pointer;
    font-size: 22px;
    display: flex;
    align-items: center;
    padding-left: 15px;
    transition: color 0.2s;
}

.tbd-search-btn:hover {
    color: #58a6ff;
}

@media (max-width: 768px) {
    .single-post-search {
        margin: 20px 0;
        padding-top: 20px;
    }
    .tbd-search-input {
        font-size: 15px !important;
        padding: 10px 0 !important;
    }
}
</style>
