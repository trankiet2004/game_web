<?php
$id = $_GET['id'] ?? '';
$mapping = [
    'blogs' => '../kiet/blogs.php',
    'index' => '../thinh/index.php',
    'about_us' => '../bao/about_us.php',
    'forum' => '../bao/forum.php',
    'contact_us' => '../thinh/contact_us.php'
];

if (!isset($mapping[$id])) {
    http_response_code(404);
    echo "Không tìm thấy file";
    exit;
}

$content = file_get_contents($mapping[$id]);

$content = preg_replace('/<base href="\.\.\/(.*?)\/">/', '<base href="/View/$1/">', $content);

echo $content;