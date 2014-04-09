



<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Unirse al siguiente proyecto</h3>
</div>
<div class="modal-body">
    <?php if (UsuarioSesion::usuario()): ?>
        <?php if (!UsuarioSesion::usuario()->perteneceAProyecto($proyecto)):?>
        <?php $ok=TRUE ?>
        <form id="formUnirseAProyecto" class="ajaxForm" method="POST" action="<?= site_url('proyectos/unirse_form/' . $proyecto->id) ?>">
            <div class="validacion"></div>
            <label>Nombre</label>
            <p><?= htmlspecialchars($proyecto->nombre) ?></p>
            <label>Descripción</label>
            <p><?= htmlspecialchars($proyecto->descripcion) ?></p>
            <input type="hidden" name="unirse" value="1" />
        </form>
        <?php else: ?>
        <p>Ya perteneces a este proyecto.</p>
        <?php endif ?>
    <?php else: ?>
        <p>Necesitas estar logueado para crear un proyecto.</p>
    <?php endif ?>

</div>
<div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cerrar</a>
    <?php if(isset($ok)):?><a href="#" class="btn btn-primary" onclick="javascript:$('#formUnirseAProyecto').submit()">Unirse</a><?php endif ?>
</div>