<?php

get('client-profil',
    ['as' => 'client.profile.index',
        'uses' => 'ClientProfileController@index' ]);

post('client-profil',
    ['as' => 'client.profile.store',
        'uses' => 'ClientProfileController@store' ]);
