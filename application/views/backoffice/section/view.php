<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Sections </h3>
  </div>
  <div class="panel-body">
    
<?php


date_default_timezone_set('Europe/Paris');
foreach($sections AS $section){
	$icon = 'glyphicon glyphicon-eye-close';
	$state = '';
	if($section->visible){
		$icon = 'glyphicon glyphicon-eye-open';
		$state = 'active';
	} 
echo '
<div class="list-group-item '.$state.'">
   <h4 class="list-group-item-heading"> <span class="'.$icon.'"></span> '.$section->title.'</h4>
    <p class="list-group-item-text">crée le '.date('d-m-Y',$section->created_at).' à '.date('H:i:s', $section->created_at);
    if(!empty($section->galerie)){
        echo     '<br>
    <h4>'.anchor('backoffice/viewPhotos#'.strtolower(trim($section->galerie)), '<span class="glyphicon glyphicon-picture"></span> '.$section->galerie, array('class' => 'label label-success')).'</h4></p>
    <hr/>';
    } 
echo'
    <p class="list-group-item-text">'.anchor('backoffice/editSection/'.$section->id, 'Editer', array('class' => 'btn btn-primary')).'
     '.anchor('#', 'Supprimer', array('class' => 'btn btn-danger', 'data-toggle' => 'modal', 'data-target'=>'#delete'.$section->id)).'</p>
</div>



<!-- Modal -->
<div class="modal fade" id="delete'.$section->id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmer la supression</h4>
      </div>
      <div class="modal-body">
        Es-tu sur de vouloir suprimmer définitivement <strong>'.$section->title.'</strong> ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Nan</button>
         '.anchor('backoffice/deleteSection/'.$section->id, 'Oui Monsieur', array('class' => 'btn btn-danger')).'
      </div>
    </div>
  </div>
</div>
';

}

?>

</div>
</div>