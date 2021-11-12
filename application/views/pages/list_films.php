<div class="container">
    <div class="row">
        <div class="col-4 offset-4">
            <h1><?php echo $title; ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-10 offset-1">
            <table class="table table-dark">
                <thead>
                    <tr>
                    <?php foreach ($headers as $header) { ?>
                        <th scope="col"><?php echo $header; ?></th>
                    <?php } ?>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($films as $film) { ?>
                    <tr>
                        <td><?php echo $film['title'] ?></td>
                        <td><?php echo $film['description'] ?></td>
                        <td><?php echo $film['rating'] ?></td>
                        <td><a href="#">Editar</a></td>
                        <td><a href="#">Eliminar</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-2 offset-1">
            <a href="<?php echo $absolute_domain ?>film/create" class="btn btn-primary">Crear</a>
        </div>
        <div class="col-5 offset-3">
            <nav class="d-flex flex-row-reverse" aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php if ($current_page == 1) { ?>disabled <?php } ?>"><a class="page-link" href="?page=<?php echo $current_page - 1 ?>">Anterior</a></li>
                <?php if ($current_page > 1)  { ?>
                    <?php for ($i = $current_page -1 ; $i < $current_page + 2; $i++) { ?>
                        <?php if ($i <= $number_pages_total) { ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                        <?php } ?>
                <?php } ?>
                <?php } else { ?>
                    <?php for ($i = $current_page ; $i <= $current_page + 2; $i++) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php } ?>
                <?php } ?>
                    <li class="page-item <?php if ($current_page == $number_pages_total) { ?>disabled <?php } ?>"><a class="page-link" href="?page=<?php echo $current_page + 1 ?>">Siguiente</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>