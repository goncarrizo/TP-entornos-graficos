<?php
require 'app/bootstrap.php';
require 'app/helpers/mail.php';

$ok = send_app_mail('jnico2609@gmail.com', 'Test local mail', 'Este es un test de envio local.');
echo 'RESULT=' . ($ok ? 'true' : 'false') . PHP_EOL;
