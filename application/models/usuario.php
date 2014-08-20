<?php
class Usuario extends Doctrine_Record{
    
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('twitter_id');
        $this->hasColumn('facebook_id');
        $this->hasColumn('screen_name');
        $this->hasColumn('proyecto_id');
    }
    
    function setUp() {
        parent::setUp();
        
        $this->hasOne('Proyecto', array(
            'local'=>'proyecto_id',
            'foreign'=>'id'
        ));
    }
    
    public function perteneceAProyecto(Proyecto $proyecto){
        
        if($proyecto->usuario_id==$this->id)
            return TRUE;
        
        foreach($proyecto->Usuarios as $u)
            if($u->id==$this->id)
                return TRUE;
            
       return FALSE;
    }
    
    
}