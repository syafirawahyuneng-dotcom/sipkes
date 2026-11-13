<?php

/*
|--------------------------------------------------------------------------
| SIP-Kes - Front controller untuk akses tanpa /public/
|--------------------------------------------------------------------------
| Dipanggil oleh .htaccess di root proyek. File ini hanya meneruskan
| request ke public/index.php (entry point Laravel yang sebenarnya).
|
| Dibutuhkan agar Laravel mendeteksi base URL sebagai /sip-kes2 (bukan
| /sip-kes2/public), sehingga route() dan asset() menghasilkan URL tanpa
| /public/. Aset statis tetap dilayani dari folder public/ oleh .htaccess.
*/

require __DIR__ . '/public/index.php';
