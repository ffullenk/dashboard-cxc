<!DOCTYPE html>
<html>
    <head>
        <title>Codeando x Chile</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?= base_url() ?>assets/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="<?= base_url() ?>assets/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
        <link href="<?= base_url() ?>assets/css/render.css" rel="stylesheet" media="screen">
        <link href="<?= base_url() ?>assets/css/common.css" rel="stylesheet" media="screen">
    </head>
    <body>
        <header id="render">
            <div class="container">
                <div class="row">
                    <div class="span7" id="logo">
                        <h1><img src="<?= base_url('assets/img/logo.png') ?>" alt="CodeandoxChile"/></h1>
                    </div>
                    <div class="offset1 span4">
                        <div class="navbar">
                            <div class="navbar-inner">
                                <div class="container"> <a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
                                    <div class="nav-collapse">
                                        <ul class="nav">
                                            <li><a href="#modalCrearProyecto" data-toggle="modal">Crear nuevo proyecto</a></li>
                                            <?php if (!UsuarioSesion::usuario()): ?>
                                                <li><a href="<?= site_url('autenticacion/oauth_login') ?>">Iniciar sesión</a></li>
                                            <?php else: ?>
                                                <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="single.html">Bienvenido <?= UsuarioSesion::usuario()->twitter_screen_name ?><b class="caret"></b></a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="<?= site_url('autenticacion/logout') ?>">Cerrar sesión</a></li>
                                                    </ul>
                                                </li>
                                            <?php endif ?>
                                        </ul>
                                    </div>
                                    <!-- /.nav-collapse --> 
                                </div>
                            </div>
                            <!-- /navbar-inner --> 
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <p style="text-align: right;">Ordenar por
                    <button class="btn" onclick="javascript:$('#items').isotope({ sortBy : 'name' });">Nombre</button>
                    <button class="btn" onclick="javascript:$('#items').isotope({ sortBy : 'id',sortAscending : false });">Recientes</button>
                    <button class="btn" onclick="javascript:$('#items').isotope({ sortBy : 'nusuarios',sortAscending : false });">Integrantes</button>
                    </p>
                </div>

            </div>
        </header>
        <section>
            <div class="container">
                <div class="row">
                    <div id="items">
                        <?php foreach ($proyectos as $p): ?>
                            <?php $colors = array('#e03943', '#f19800', '#0062ad', '#00913d', '#e910b3', '#f34205'); ?>
                            <div class="item" style="background-color: <?= $colors[array_rand($colors)] ?>;">
                                <h3><?= htmlspecialchars($p->nombre) ?></h3>
                                <div class="id hide"><?=$p->id?></div>
                                <div class="nusuarios hide"><?=$p->nusuarios?></div>

                                <p><?= nl2br(htmlspecialchars($p->descripcion)) ?></p>
                                <?php if($p->url):?>
                                <p><a class="link" target="_blank" href="<?=  htmlspecialchars($p->url)?>"><i class="icon-share-alt icon-white"></i> <?=  htmlspecialchars($p->url)?></a></p>
                                <?php endif ?>
                                    
                                <?php
                                $usuarios = array();
                                $usuarios[] = '<a class="label label-inverse" href="http://twitter.com/' . $p->UsuarioDueno->twitter_screen_name . '" target="_blank">@' . $p->UsuarioDueno->twitter_screen_name . '</a>';
                                foreach ($p->Usuarios as $u)
                                    $usuarios[] = '<a class="label" href="http://twitter.com/' . $u->twitter_screen_name . '" target="_blank">@' . $u->twitter_screen_name . '</a>';
                                ?>
                                <p><img src="<?=base_url('assets/img/twitter.png')?>" alt="Twitter" /> <?= implode(' ', $usuarios) ?></p>
                                <br />
                                <p style="text-align: right;">
                                    <?php if (UsuarioSesion::usuario() && $p->usuario_id == UsuarioSesion::usuario()->id): ?>
                                        <a class="unirse" href="#" onclick="javascript:modalEditarProyecto(<?= $p->id ?>)">Editar proyecto <i class="icon-edit icon-white"></i></a>
                                    <?php else: ?>
                                        <a class="unirse" href="#" onclick="javascript:modalUnirseAProyecto(<?= $p->id ?>)">Unirse al proyecto <i class="icon-plus-sign icon-white"></i></a>
                                    <?php endif ?>
                                </p>
                            </div>

                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </section>
        <footer>

        </footer>
        <div id="modalCrearProyecto" class="modal hide fade">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Crear nuevo proyecto</h3>
            </div>
            <div class="modal-body">
                <?php if (UsuarioSesion::usuario()): ?>
                    <?php $ok = TRUE ?>
                    <form id="formCrearProyecto" class="ajaxForm" method="POST" action="<?= site_url('proyectos/crear_form') ?>">
                        <div class="validacion"></div>
                        <label>Nombre</label>
                        <input class="input-xlarge" type="text" name="nombre" />
                        <label>Descripción</label>
                        <textarea class="input-xlarge" name="descripcion"></textarea>
                        <label>URL (Opcional)</label>
                        <input class="input-xlarge" type="text" name="url" />
                    </form>
                <?php else: ?>
                    <p>Necesitas estar logueado para crear un proyecto.</p>
                <?php endif ?>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">Cerrar</a>
                <?php if (isset($ok)): ?><a href="#" class="btn btn-primary" onclick="javascript:$('#formCrearProyecto').submit()">Guardar</a><?php endif ?>
            </div>
        </div>

        <div id="modal" class="modal hide fade">

        </div>



        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.isotope.min.js"></script>
        <script>
            var site_url="<?= site_url() ?>";
            var base_url="<?= base_url() ?>";
        </script>
        <script src="<?= base_url() ?>assets/js/common.js"></script>
    </body>
</html>
