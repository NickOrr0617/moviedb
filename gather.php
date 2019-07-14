<?php

$json = get_movie_data();

$data = json_decode($json);
var_dump($data);

if (null !== $data) {
    //load to db
}

function get_movie_data()
{
    $url = 'https://api.themoviedb.org/3/discover/movie?api_key=37c4ab1fabe3f0aa6a660b8272195ed3&certification=R&primary_release_year=2015&with_genres=878&sort_by=popularity.desc';
    $params = array('http' => array(
        'method' => 'GET',
        'header' => array(
            //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIzN2M0YWIxZmFiZTNmMGFhNmE2NjBiODI3MjE5NWVkMyIsInN1YiI6IjVkMmI4OWY5NThlZmQzMDAxNDBmZDJlMyIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.O238GjHceDMIiAROJ7zCbES7AF4ehXh-afAbxEEJoNI',
            //'Content-Type: application/json;charset=utf-8'
        )
    ));

    $ctx = stream_context_create($params);
    $fp = @fopen($url, 'rb', false, $ctx);
    if (!$fp) {
        throw new Exception("Problem with $url, $php_errormsg");
    }
    $response = @stream_get_contents($fp);
    if ($response === false) {
        throw new Exception("Problem reading data from $url, $php_errormsg");
    }
    return $response;
}

?>
