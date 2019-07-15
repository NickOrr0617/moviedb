<?php
require_once 'movie.model.php';
class Movie implements JsonSerializable {
    private $model;

    protected $id = null;
    protected $adult;
    protected $backdropPath;
    protected $genreIds;
    protected $originalLanguage;
    protected $originalTitle;
    protected $overview;
    protected $popularity;
    protected $posterPath;
    protected $releaseDate;
    protected $title;
    protected $video;
    protected $voteAverage;
    protected $voteCount;


    public function __construct() {
        $this->model = new MovieModel();
        if (func_num_args() == 1) {
            $a = $this->model->fetchById(func_get_arg(0));

            if ($a != null) {
                $this->setId($a[0]['id']);
                $this->setAdult($a[0]['adult']);
                $this->setBackdropPath($a[0]['backdrop_path']);
                $this->setGenreIds($a[0]['genre_ids']);
                $this->setOriginalLanguage($a[0]['original_language']);
                $this->setOriginalTitle($a[0]['original_title']);
                $this->setOverview($a[0]['overview']);
                $this->setPopularity($a[0]['popularity']);
                $this->setPosterPath($a[0]['poster_path']);
                $this->setReleaseDate($a[0]['release_date']);
                $this->setTitle($a[0]['title']);
                $this->setVideo($a[0]['video']);
                $this->setVoteAverage($a[0]['vote_average']);
                $this->setVoteCount($a[0]['vote_count']);
            }
        }
    }

    public static function getMovies($offset = 0) {
        $model = new MovieModel();
        //$rc = $model->select('*', null, null, "$offset, 20");
        $rc = $model->select('*', null);
        if (count($rc) == 0) {
            return null;
        } else {
            $movies = array();

            foreach ($rc as $m) {
                $movie = new Movie();
                $movie->setId($m['id']);
                $movie->setAdult($m['adult']);
                $movie->setBackdropPath($m['backdrop_path']);
                $movie->setGenreIds($m['genre_ids']);
                $movie->setOriginalLanguage($m['original_language']);
                $movie->setOriginalTitle($m['original_title']);
                $movie->setOverview($m['overview']);
                $movie->setPopularity($m['popularity']);
                $movie->setPosterPath($m['poster_path']);
                $movie->setReleaseDate($m['release_date']);
                $movie->setTitle($m['title']);
                $movie->setVideo($m['video']);
                $movie->setVoteAverage($m['vote_average']);
                $movie->setVoteCount($m['vote_count']);
                array_push($movies, $movie);
            }
            
            return $movies;
        }
    }


    public function save() {
        $values = array();
        $values['id'] = $this->getId();
        $values['adult'] = $this->getAdult();
        $values['backdrop_path'] = $this->getBackdropPath();
        $values['genre_ids'] = $this->getGenreIds();
        $values['original_language'] = $this->getOriginalLanguage();
        $values['original_title'] = $this->getOriginalTitle();
        $values['overview'] = $this->getOverview();
        $values['popularity'] = $this->getPopularity();
        $values['poster_path'] = $this->getPosterPath();
        $values['release_date'] = $this->getReleaseDate();
        $values['title'] = $this->getTitle();
        $values['video'] = $this->getVideo();
        $values['vote_average'] = $this->getVoteAverage();
        $values['vote_count'] = $this->getVoteCount();
            
        $this->model->insert($values);
    }

    public function jsonSerialize()
    {
        return
        [
            'id'   => $this->getId(),
            'adult' => $this->getAdult(),
            'backdrop_path' => $this->getBackdropPath(),
            'genre_ids' => $this->getGenreIds(),
            'original_language' => $this->getOriginalLanguage(),
            'original_title' => $this->getOriginalTitle(),
            'overview' => $this->getOverview(),
            'popularity' => $this->getPopularity(),
            'poster_path' => $this->getPosterPath(),
            'release_date' => $this->getReleaseDate(),
            'title' => $this->getTitle(),
            'video' => $this->getVideo(),
            'vote_average' => $this->getVoteAverage(),
            'vote_count' => $this->getVoteCount(),
        ];
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setAdult($id) {
        $this->adult = $id;
    }

    public function setBackdropPath($name) {
        $this->backdropPath = $name;
    }

    public function setgenreIds($genreIds) {
        $this->genreIds = $genreIds;
    }

    public function setoriginalLanguage($originalLanguage) {
        $this->originalLanguage = $originalLanguage;
    }

    public function setoriginalTitle($originalTitle) {
        $this->originalTitle = $originalTitle;
    }

    public function setoverview($overview) {
        $this->overview = $overview;
    }

    public function setpopularity($popularity) {
        $this->popularity = $popularity;
    }

    public function setposterPath($posterPath) {
        $this->posterPath = $posterPath;
    }

    public function setreleaseDate($date) {
        $this->releaseDate = $date;
    }

    public function settitle($title) {
        $this->title = $title;
    }

    public function setvideo($video) {
        $this->video = $video;
    }

    public function setvoteAverage($voteAverage) {
        $this->voteAverage = $voteAverage;
    }

    public function setvoteCount($voteCount) {
        $this->voteCount = $voteCount;
    }


    public function getId() {
        return $this->id;
    }

    public function getAdult() {
        return $this->adult;
    }

    public function getBackdropPath() {
        return $this->backdropPath;
    }

    public function getGenreIds() {
        return $this->genreIds;
    }

    public function getOriginalLanguage() {
        return $this->originalLanguage;
    }

    public function getOriginalTitle() {
        return $this->originalTitle;
    }

    public function getOverview() {
        return $this->overview;
    }

    public function getPopularity() {
        return $this->popularity;
    }

    public function getPosterPath() {
        return $this->posterPath;
    }

    public function getReleaseDate() {
        return $this->releaseDate;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getVideo() {
        return $this->video;
    }

    public function getVoteAverage() {
        return $this->voteAverage;
    }
     
    public function getVoteCount() {
        return $this->voteCount;
    }
}
?>
