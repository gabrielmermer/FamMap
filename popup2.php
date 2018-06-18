<?php



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
    $name = htmlspecialchars('<h1>'. $data['name']. '</h1> <br>');
    $surname = htmlspecialchars('<h1>'. $data['surname']. '</h1> <br>');
    $package = $name . $surname;

    echo $package;
};

wrapper($data);

?>