<?php
require_once 'movie.model.php';
class Movie {
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
                $this->setBackdropPath($a[0]['backdropPath']);
                $this->setGenreIds($a[0]['genreIds']);
                $this->setOriginalLanguage($a[0]['originalLanguage']);
                $this->setOriginalTitle($a[0]['originalTitle']);
                $this->setOverview($a[0]['overview']);
                $this->setPopularity($a[0]['popularity']);
                $this->setPosterPath($a[0]['posterPath']);
                $this->setReleaseDate($a[0]['releaseDate']);
                $this->setTitle($a[0]['title']);
                $this->setVideo($a[0]['video']);
                $this->setVoteAverage($a[0]['voteAverage']);
                $this->setVoteCount($a[0]['voteCount']);
            }
        }
    }

    public function save() {
        $values = array();
        $values['id'] = $this->getId();
        $values['adult'] = $this->getAdult();
        $values['backdropPath'] = $this->getBackdropPath();
        $values['genreIds'] = $this->getGenreIds();
        $values['originalLanguage'] = $this->getOriginalLanguage();
        $values['originalTitle'] = $this->getOriginalTitle();
        $values['overview'] = $this->getOverview();
        $values['popularity'] = $this->getPopularity();
        $values['posterPath'] = $this->getPosterPath();
        $values['releaseDate'] = $this->getReleaseDate();
        $values['title'] = $this->getTitle();
        $values['video'] = $this->getVideo();
        $values['voteAverage'] = $this->getVoteAverage();
        $values['voteCount'] = $this->getVoteCount();
            
        $this->model->insert($values, /*exclude*/array());
    }

    protected function setId($id) {
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
