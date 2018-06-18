<?php
    // script used to wrap data to popup format

    $data = [
        'name' => 'Gabriel',
        'surname' => 'Mermer',
        'date' => '13.01.2002',
        'ocupation' => 'Warszawa',
        'father' => 'Daniel Mermer',
        'mother' => 'Maria Mermer',
        'bio' => 'jestem sobie małym misiem',
        'profilePic' => 'http://via.placeholder.com/350x150'
    ];  

    function wrapper($data) {
        $name = '<h1>'. $data['name']. '</h1> <br>';
        $surname = '<h1>'. $data['surname']. '</h1> <br>';
        $package = $name . $surname;
        return $package;
    };


    wrapper($data);

