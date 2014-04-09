<?php
class Proyecto extends Doctrine_Record{
    
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('nombre');
        $this->hasColumn('descripcion');
        $this->hasColumn('url');
        $this->hasColumn('usuario_id');
    }
    
    function setUp() {
        parent::setUp();
        
        $this->hasMany('Usuario as Usuarios', array(
            'local'=>'id',
            'foreign'=>'proyecto_id'
        ));
        
        $this->hasOne('Usuario as UsuarioDueno', array(
            'local'=>'usuario_id',
            'foreign'=>'id'
        ));
    }
    
    
}