<?php

get('client-fisa',
    ['as' => 'client.fisa.index',
        'uses' => 'ClientFisaController@index' ]);

post('client-fisa',
    ['as' => 'client.fisa.store',
        'uses' => 'ClientFisaController@store' ]);
