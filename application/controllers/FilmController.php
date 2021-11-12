<?php
include_once('application/models/FilmModel.php');
include_once('application/models/LanguageModel.php');
include_once('core/views.php');

use application\models\FilmModel;
use application\models\LanguageModel;

#define("PATH_VIEWS", 'application/views/');
const PATH_VIEWS = 'application/views/';

class FilmController {

    private $film_model;

    public function __construct() {
        $this->film_model = new FilmModel;    
        $this->language_model = new LanguageModel;
        $this->view = new Views('default');
    }

    public function list() {
        $page = $_GET['page'] ?? 1;
        $items_per_page = 15;
        $start = ($page - 1) * $items_per_page;
        #Consulta de cuantos elementos son en total
        $fields_query_count = ['COUNT(*) as total'];
        $count_result = $this->film_model->get_query($fields_query_count)->fetch();
        $total = (int) $count_result['total'];
        $quantity_pages = ceil($total / $items_per_page);
        # Se encargara de consultar y presentar la visual de la lista de peliculas.
        $fields_to_query = ['film_id', 'title', 'description', 'rating'];
        $result = $this->film_model->get_query($fields_to_query, [], [$start, $items_per_page]);
        $context = [
            'title' => 'Lista de peliculas',
            'films' => $result,
            'headers' => ['Nombre', 'Descripción', 'Clasificación'],
            'number_pages_total' => $quantity_pages,
            'current_page' => $page,
        ];
        $this->view->render('list_films.php', $context);
    }

    public function create() {
        $fields_language = ['language_id', 'name'];
        $result_language = $this->language_model->get_query($fields_language);
        $languages_context = [];
        foreach ($result_language as $language) {
            $languages_context[] = $language;
        }
        $context = [
            'title' => 'Nueva pelicula',
            'languages' => $languages_context,
        ];
        $this->view->render('create_form.php', $context);
    }

    public function submitFilm() {
        var_dump($_POST);
    }
}