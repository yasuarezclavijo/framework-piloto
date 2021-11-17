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
        $page = (int) $_GET['page'] ?? 1;
        $messageToShow = $_GET['message'] ?? NULL;
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
        if ($messageToShow != NULL) {
            switch ($messageToShow) {
                case 'deletesucess':
                    $context['message_to_show'] = 'Pelicula eliminada.';
                    break;
                default:
                    $context['message_to_show'] = 'Hemos tenido algun inconveniente con su formulario, por favor intente nuevamente.';
                    break;
            }
        }
        $this->view->render('list_films.php', $context);
    }

    public function create() {
        $messageToShow = $_GET['message'] ?? NULL;
        $context = [
            'title' => 'Nueva pelicula',
            'languages' => $this->get_languages(),
        ];
        if ($messageToShow != NULL) {
            switch ($messageToShow) {
                case 'exists':
                    $context['message_to_show'] = 'Este registro ya se encuentra en la base de datos.';
                    break;
                case 'savesucess':
                    $context['message_to_show'] = 'Registro creado exitosamente';
                    break;
                default:
                    $context['message_to_show'] = 'Hemos tenido algun inconveniente con su formulario, por favor intente nuevamente.';
                    break;
            }
        }
        $this->view->render('create_form.php', $context);
    }

    public function submitFilm() {
        #Consulta de cuantos elementos son en total
        $fields_query_count = ['COUNT(*) as total_peliculas'];
        $count_result_film_duplicate = $this->film_model->get_query($fields_query_count, [['field' => 'title', 'value' => $_POST['title'], 'operator' => '=']])->fetch();
        if ($count_result_film_duplicate["total_peliculas"] > 0) {
            header("Location: {$_SERVER['HTTP_REFERER']}?message=exists");
        } else {
            $fields_to_save = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'release_year' => $_POST['year_release'],
                'language_id' => $_POST['language_translate'],
                'original_language_id' => $_POST['language_original'],
                'rental_duration' => $_POST['rental_duration'],
                'rental_rate' => $_POST['price_rental']
            ];
            $result_insert = $this->film_model->insert_data($fields_to_save);
            if ($result_insert->rowCount()) {
                $path = explode("?", $_SERVER['HTTP_REFERER']);
                header("Location: {$path[0]}?message=savesucess");
            }
        }
    }

    public function editForm() {
        $pk = $_GET['pk'] ?? NULL;
        $messageToShow = $_GET['message'] ?? NULL;
        if ($pk == NULL){
            throw new Exception("Primary key not found for edit form");
        } else {
            $fields_to_show = ['film_id', 'title', 'description', 'release_year', 'language_id', 'original_language_id', 'rental_duration', 'rental_rate'];
            $where = [
                ['field' => 'film_id', 'value' => $pk, 'operator' => '=']
            ];
            $record = $this->film_model->get_query($fields_to_show, $where)->fetch();
            $context = [
                'title' => 'Editar pelicula',
                'languages' => $this->get_languages(),
                'record' => $record
            ];
            if ($messageToShow != NULL) {
                switch ($messageToShow) {
                    case 'savesucess':
                        $context['message_to_show'] = 'Registro actualizado exitosamente';
                        break;
                    default:
                        $context['message_to_show'] = 'Hemos tenido algun inconveniente con su formulario, por favor intente nuevamente.';
                        break;
                }
            }
            $this->view->render('update_form.php', $context);
        }
    }

    public function updateFilm() {
        $fields_to_save = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'release_year' => $_POST['year_release'],
            'language_id' => $_POST['language_translate'],
            'original_language_id' => $_POST['language_original'],
            'rental_duration' => $_POST['rental_duration'],
            'rental_rate' => $_POST['price_rental']
        ];
        $condition_to_where = "film_id = '{$_POST['pk']}'";
        $result_update = $this->film_model->update_data($fields_to_save, $condition_to_where);
        if ($result_update->rowCount()) {
            header("Location: {$_SERVER['HTTP_REFERER']}&message=savesucess");
        }
    }

    public function delete() {
        $pk = $_GET['pk'] ?? NULL;
        if ($pk == NULL){
            throw new Exception("Primary key not found for delete record");
        } else {
            $condition = "film_id = '{$pk}'";
            $result_delete = $this->film_model->delete_data($condition);
            if ($result_delete->rowCount()) {
                header("Location: {$_SERVER['HTTP_REFERER']}&message=deletesucess");
            }
        }
    }

    private function get_languages() {
        $fields_language = ['language_id', 'name'];
        $result_language = $this->language_model->get_query($fields_language);
        $languages_context = [];
        foreach ($result_language as $language) {
            $languages_context[] = $language;
        }
        return $languages_context;
    }
}