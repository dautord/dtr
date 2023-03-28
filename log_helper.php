<?php
    function write_log($message) {
        $log_file = 'my_log.txt';
        $current_time = date('Y-m-d H:i:s');
        $formatted_message = $current_time . ' - ' . $message . PHP_EOL;
        file_put_contents($log_file, $formatted_message, FILE_APPEND);
    }
?>