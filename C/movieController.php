<?php
require_once 'Controller.php';
require_once 'Movie.php';

class movieController extends Controller {

    public function showMovies($offset = 0) {
        $this->_view = new View();
        $this->_view->SetTitle('Movies');
        
        $this->_view->Addjquery();

        $movies = Movie::getMovies();

        //$this->_view->movies = json_encode($movies);
        $this->_view->movies = $movies;
        $this->_view->render('movies.phtml');
    }
}

?>
