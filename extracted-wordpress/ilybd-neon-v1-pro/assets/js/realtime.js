jQuery(document).ready(function($){

    let lastCount = 0;

    /* =========================
       POLLING ENGINE
    ========================= */
    function checkNotifications(){

        $.post(ilybd_ajax.ajaxurl, {
            action: 'ilybd_get_notifications'
        }, function(res){

            if(!res.success) return;

            let data = res.data;

            if(!data || !data.count) return;

            /* FIRST LOAD (no sound) */
            if(lastCount === 0){
                lastCount = data.count;
                return;
            }

            /* NEW NOTIFICATION DETECTED */
            if(data.count > lastCount){

                let newItems = data.items;

                newItems.forEach(function(n){
                    showRealtimeNotification(n.message);
                });

                playNotiSound();
            }

            lastCount = data.count;

        });

    }

    /* =========================
       RUN EVERY 5s
    ========================= */
    setInterval(checkNotifications, 5000);


    /* =========================
       UI NOTIFICATION
    ========================= */
    function showRealtimeNotification(msg){

        let box = $('#noti-box');
        if(!box.length) return;

        let item = $(`
            <div class="noti-item" style="
                background:#000;
                color:#00ff99;
                padding:10px;
                margin-top:5px;
                border:1px solid #00ff99;
                border-radius:8px;
                box-shadow:0 0 12px #00ff99;
            ">
                🔔 ${msg}
            </div>
        `);

        box.append(item);

        setTimeout(function(){
            item.fadeOut(300, function(){
                $(this).remove();
            });
        }, 4000);
    }

});


