<?php

get('client-solicitari',
    ['as' => 'client.solicitari.index',
        'uses' => 'ClientSolicitariController@index' ]);

post('client-solicitari',
    ['as' => 'client.solicitari.store',
        'uses' => 'ClientSolicitariController@store' ]);
