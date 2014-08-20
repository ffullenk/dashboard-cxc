<!DOCTYPE html>
<html>
    <head>
        <?php include('assets/themes/'.$this->config->item('theme').'/header.php'); ?>
        <link href="<?= base_url() ?>assets/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="<?= base_url() ?>assets/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
        <link href="<?= base_url() ?>assets/css/render.css" rel="stylesheet" media="screen">
        <link href="<?= base_url() ?>assets/themes/<?= $this->config->item('theme') ?>/style.css" rel="stylesheet" media="screen">
    </head>
    <body>
        <header id="render">
            <div class="container">
                <div class="row">

                    <div class="span7" id="logo">
                        <h1><img src="<?= base_url('assets/themes/'.$this->config->item('theme').'/logo.png') ?>" alt="Logo"/></h1>                   </div>
                    <div class="offset1 span4">
                        <div class="navbar">
                            <div class="navbar-inner">
                                <div class="container"> <a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
                                    <div class="nav-collapse">
                                        <ul class="nav">
                                            <li><a href="#modalCrearProyecto" data-toggle="modal">Crear nueva idea</a></li>
                                            <?php if (!UsuarioSesion::usuario()): ?>
                                                <li><a>Entra con 
                                                    <?php if($this->config->item('twitter_consumer_key')!=''): ?>
                                                        <span style="cursor: pointer;" onclick="javascript:window.location='<?= site_url('autenticacion/oauth_login') ?>'">Twitter</span> 
                                                    <?php endif;?>
                                                    <?php if($this->config->item('facebook_consumer_key')!=''): ?>
                                                        <span style="cursor: pointer;" onclick="javascript:window.location='<?= site_url('autenticacion/oauth2_login') ?>'">Facebook</span>
                                                    <?php endif;?>
                                                </a></li>
                                            <?php else: ?>
                                                <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="single.html">Bienvenido <?= UsuarioSesion::usuario()->screen_name ?><b class="caret"></b></a>
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
                                if($p->UsuarioDueno->twitter_id)
                                    $usuarios[] = '<a class="label label-inverse" href="http://twitter.com/' . $p->UsuarioDueno->screen_name . '" target="_blank">@' . $p->UsuarioDueno->screen_name . '</a>';
                                else
                                    $usuarios[] = '<a class="label label-inverse" href="http://facebook.com/app_scoped_user_id/' . $p->UsuarioDueno->facebook_id . '" target="_blank">' . $p->UsuarioDueno->screen_name . '</a>';
                                foreach ($p->Usuarios as $u)
                                    if($u->twitter_id)
                                        $usuarios[] = '<a class="label" href="http://twitter.com/' . $u->screen_name . '" target="_blank">@' . $u->screen_name . '</a>';
                                    else
                                        $usuarios[] = '<a class="label" href="http://facebook.com/app_scoped_user_id/' . $u->facebook_id . '" target="_blank">' . $u->screen_name . '</a>';
                                ?>
                                <p><?= implode(' ', $usuarios) ?></p>
                                <br />
                                <p style="text-align: right;">
                                    <?php if (UsuarioSesion::usuario() && $p->usuario_id == UsuarioSesion::usuario()->id): ?>
                                        <a class="unirse" href="#" onclick="javascript:modalEditarProyecto(<?= $p->id ?>)">Editar idea <i class="icon-edit icon-white"></i></a>
                                    <?php else: ?>
                                        <a class="unirse" href="#" onclick="javascript:modalUnirseAProyecto(<?= $p->id ?>)">Unirse a la idea <i class="icon-plus-sign icon-white"></i></a>
                                    <?php endif ?>
                                </p>
                            </div>

                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </section>
        <footer>
            <?php include('assets/themes/'.$this->config->item('theme').'/footer.php'); ?>
        </footer>
        <div id="modalCrearProyecto" class="modal hide fade">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Crear nueva idea</h3>
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
                    <p>Necesitas estar logueado para crear una idea.</p>
                <?php endif ?>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">Cerrar</a>
                <?php if (isset($ok)): ?><a href="#" class="btn btn-primary" onclick="javascript:$('#formCrearProyecto').submit()">Guardar</a><?php endif ?>
            </div>
        </div>

        <div id="modal" class="modal hide fade">

        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.isotope.min.js"></script>
        <script>
            var site_url="<?= site_url() ?>";
            var base_url="<?= base_url() ?>";
        </script>
        <script src="<?= base_url() ?>assets/js/common.js"></script>
    </body>
</html>
