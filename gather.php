<?php
date_default_timezone_set('America/Boise');
set_include_path(
    realpath('lib'). PATH_SEPARATOR . 
    realpath('M') . PATH_SEPARATOR .
    get_include_path());

require_once 'Logger.php';
require_once 'Movie.php';

/*
["page"]=>
  int(1)
  ["total_results"]=>
  int(534)
  ["total_pages"]=>
  int(27)

 */

$page = 1;

$json = get_movie_data($page);

$data = json_decode($json);
$moviesSaved = save_results($data->results);

if ($data->total_results >= 100) {
    while ($moviesSaved < 100) {
        $page++;
        $json = get_movie_data($page);

        $data = json_decode($json);

        if ($moviesSaved + count($data->results) < 100) {
            $moviesSaved += save_results($data->results);
        } else {
            //splice so we get 100 results
            $needed = 100 - $moviesSaved;
            $moviesSaved += save_results(array_slice($data->results, 0, $needed));
        }
    }
}

echo "Finished saving results\n";

function save_results($movies) {
    $numResults = 0;
    if (null !== $movies) {
    //load to db
        foreach ($movies as $movie) {
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

            $numResults++;
        }
    }
    return $numResults;
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
