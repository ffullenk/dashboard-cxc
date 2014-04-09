



<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Editar proyecto</h3>
</div>
<div class="modal-body">
    <?php if (UsuarioSesion::usuario()): ?>
        <?php if (UsuarioSesion::usuario()->id==$proyecto->usuario_id):?>
        <?php $ok=TRUE ?>
        <form id="formEditarProyecto" class="ajaxForm" method="POST" action="<?= site_url('proyectos/editar_form/' . $proyecto->id) ?>">
            <div class="validacion"></div>
            <label>Nombre</label>
            <input class="input-xlarge" type="text" name="nombre" value="<?=  htmlspecialchars($proyecto->nombre)?>" />
            <label>Descripción</label>
            <textarea class="input-xlarge" type="text" name="descripcion"><?= htmlspecialchars($proyecto->descripcion)?></textarea>
            <label>URL (Opcional)</label>
            <input class="input-xlarge" type="text" name="url" value="<?=  htmlspecialchars($proyecto->url)?>" />
        </form>
        <?php else: ?>
        <p>No eres dueño de este proyecto.</p>
        <?php endif ?>
    <?php else: ?>
        <p>Necesitas estar logueado para crear un proyecto.</p>
    <?php endif ?>

</div>
<div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cerrar</a>
    <?php if(isset($ok)):?><a href="#" class="btn btn-primary" onclick="javascript:$('#formEditarProyecto').submit()">Guardar</a><?php endif ?>
</div>