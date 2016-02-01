<?php

    get('identificarea-nevoii',
        ['as' => 'identificarea_nevoii.index',
            'uses' => 'IdentificareaNevoiiController@index' ]);

    post('identificarea-nevoii',
        ['as' => 'identificarea_nevoii.store',
            'uses' => 'IdentificareaNevoiiController@store' ]);
