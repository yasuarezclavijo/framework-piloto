<div class="container">
    <div class="row">
        <div class="col-4">
            <a href="<?php echo $absolute_domain ?>film/list"><- Regresar al listado</a>
        </div>
    </div>
    <div class="row">
        <div class="col-4 offset-4">
            <h1><?php echo $title ?></h1>
        </div>
    </div>
    <?php if (isset($message_to_show)) { ?>
    <dvi class="row">
        <div class="col-8 offset-2">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?php echo $message_to_show ?></strong>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-6 offset-3">
            <form method="POST" action="<?php echo $absolute_domain ?>film/submitFilm">
                <div class="form-group">
                    <label for="inputTitle">Titulo</label>
                    <input type="text" class="form-control" name="title" id="inputTitle" placeholder="Titulo pelicula">
                </div>
                <div class="form-group">
                    <label for="inputDescription">Descripción</label>
                    <textarea rows="3" class="form-control" name="description" id="inputDescription"></textarea>
                </div>
                <div class="form-group">
                    <label for="inputYear">Año de lanzamiento</label>
                    <input type="text" class="form-control" name="year_release" id="inputYear" placeholder="Año de lanzamiento">
                </div>
                <div class="form-group">
                    <label for="inputTranslate">Idioma de traducción</label>
                    <select id="inputTranslate" name="language_translate" class="form-control">
                        <option selected>Escoja una opción...</option>
                        <?php foreach ($languages as $language) { ?>
                        <option value="<?php echo $language['language_id'] ?>"><?php echo $language['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputLanguageOriginal">Idioma original</label>
                    <select id="inputLanguageOriginal" name="language_original" class="form-control">
                        <option selected>Escoja una opción...</option>
                        <?php foreach ($languages as $language) { ?>
                        <option value="<?php echo $language['language_id'] ?>"><?php echo $language['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputrentalduration">Duración de renta</label>
                    <input type="number" name="rental_duration" class="form-control" id="inputrentalduration" placeholder="Tiempo en dias">
                </div>
                <div class="form-group">
                    <label for="inputrentalrate">Precio de renta</label>
                    <input type="number" name="price_rental" step="any" class="form-control" id="inputrentalrate" placeholder="Precio de renta">
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
</div>