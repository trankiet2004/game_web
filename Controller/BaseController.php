<?php
class BaseController {
    protected function render(string $folder, string $file = 'index') {
        $path = __DIR__ . "/../View/{$folder}/{$file}.html";
        if (file_exists($path)) {
            readfile($path);
        } else {
            header("HTTP/1.1 404 Not Found");
            echo "Không tìm thấy {$folder}/{$file}.html";
        }
    }
}
