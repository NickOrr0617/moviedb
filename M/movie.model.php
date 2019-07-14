<?php
require_once 'DataModel.php';
require_once 'connections.php';

class MovieModel extends DataModel {
    protected $columns = array('id', 'adult', 'backdrop_path', 'genre_ids', 'original_language', 'original_title', 'overview', 'popularity', 'poster_path', 'release_date', 'title', 'video', 'vote_average', 'vote_count');
    protected $tablename = 'movies';

    public function __construct() {
        $this->openConnection(MOVIEDB_HOST, MOVIEDB_DB, MOVIEDB_USER, MOVIEDB_PASSWORD);
        parent::__construct();
    }
}
?>
