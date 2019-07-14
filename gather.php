<?php
date_default_timezone_set('America/Boise');
set_include_path(
    realpath('lib'). PATH_SEPARATOR . 
    realpath('M') . PATH_SEPARATOR .
    get_include_path());

require_once 'Logger.php';
require_once 'Movie.php';



$json = get_movie_data(1);

$data = json_decode($json);
//var_dump($data);

if (null !== $data) {
    //load to db
    foreach ($data->results as $movie) {
        $m = new Movie();

        $m->setId($movie->id);
        $m->setAdult($movie->adult);
        $m->setBackdropPath($movie->backdrop_path);
        $m->setGenreIds(json_encode($movie->genre_ids));
        $m->setOriginalLanguage($movie->original_language);
        $m->setOriginalTitle($movie->original_title);
        $m->setOverview($movie->overview);
        $m->setPopularity($movie->popularity);
        $m->setPosterPath($movie->poster_path);
        $m->setReleaseDate($movie->release_date);
        $m->setTitle($movie->title);
        $m->setVideo($movie->video);
        $m->setVoteAverage($movie->vote_average);
        $m->setVoteCount($movie->vote_count);

        $m->save();
    }
    echo 'Finished saving results';
}

function get_movie_data($page)
{
    $url = 'https://api.themoviedb.org/3/discover/movie?api_key=37c4ab1fabe3f0aa6a660b8272195ed3&certification=R&primary_release_year=2015&with_genres=878&sort_by=popularity.desc&page=' . $page;
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
