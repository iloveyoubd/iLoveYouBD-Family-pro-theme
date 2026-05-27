<?php
class IBD_Key_Rotator {
    
    public static function get_active_key($type = 'gemini') {
        $current_index = get_option("ibd_{$type}_active_index", 1);
        $key = get_option("ibd_{$type}_key_" . $current_index);

        if (!$key && $current_index < 10) {
            self::switch_to_next_key($type);
            return self::get_active_key($type);
        }
        return $key;
    }

    public static function switch_to_next_key($type) {
        $current_index = get_option("ibd_{$type}_active_index", 1);
        $next_index = ($current_index >= 10) ? 1 : $current_index + 1;
        update_option("ibd_{$type}_active_index", $next_index);
        self::log_activity("System switched to {$type} Key #{$next_index} due to limit/error.");
    }

    public static function log_activity($message) {
        $logs = get_option('ibd_ai_logs', []);
        array_unshift($logs, [
            'time' => current_time('mysql'),
            'msg'  => $message
        ]);
        update_option('ibd_ai_logs', array_slice($logs, 0, 50));
    }
}
