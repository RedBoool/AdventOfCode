<?php
$key = 'ckczppom';

$i = 0;
while (1) {
    $hash = md5($key.$i);

    if (substr($hash, 0, 5) === '00000') {
        if (empty($sub5)) {
            $sub5 = $i;
        }
    }

    if (substr($hash, 0, 6) === '000000') {
        if (empty($sub6)) {
            $sub6 = $i;
        }
    }

    if (!empty($sub5) && !empty($sub6)) {
        break;
    }

    $i++;
}

print 'Sub5: '.$sub5;
print PHP_EOL;
print 'Sub6: '.$sub6;
print PHP_EOL;