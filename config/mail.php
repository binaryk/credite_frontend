<?php

return [
    'driver'     => 'smtp',
    'host'       => 'smtp.gmail.com',
    'port'       => 465,
    'from'       => ['address' => 'lupacescueduard@gmail', 'name' => 'Eduard'],
    'encryption' => 'ssl',
    'username'   => "lupacescueduard@gmail.com",
    'password'   => "Wh95Q0VC2M",
    'sendmail'   => '/usr/sbin/sendmail -bs',
    'pretend'    => false,
];