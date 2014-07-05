<?php
$title = '';
$description = '';
$galerie = '';
$formtitle = '';

if(isset($update)){
  //On est en modification !
  $title = $update->title;
  $formtitle = 'Modification de la photo <strong>'.$title.'</strong>';
  $description = $update->description;
  $galerie = $update->galerie;
}
else{
  $formtitle = 'Nouvelle photo';
}

//si il y auue des erreurs
//Affiche les erreurs au cas où !
if(isset($errors)){
  echo '<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>Erreurs!</strong> ';
  foreach($errors AS $error){
    echo $error;
  }
  echo  '</div>';
}

echo validation_errors(); 

$title = (empty(set_value('title'))) ? $title : set_value('title');
$description = (empty(set_value('description'))) ? $description : set_value('description');
$galerie = (empty(set_value('galerie'))) ? $galerie : set_value('galerie');



?>


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?= $formtitle ?></h3>
  </div>
  <div class="panel-body">


<?php  echo form_open('backoffice/post_addPhoto', array('role' => 'form','method' => 'post', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'));
if(isset($update->id)){
  echo '<input type="hidden" name="id" value="'.$update->id.'" />';
}
?>
  <div class="form-group">
    <label for="title" class="col-sm-2 control-label">Titre</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="title" name="title" value="<?= $title ?>">
    </div>
  </div>

    <div class="form-group">
    <label for="description" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
    <textarea name="description" id="description" class="textarea form-control" rows="20"><?= $description ?></textarea>
    </div>
  </div>

  <div class="form-group">
    <label for="photo" class="col-sm-2 control-label">Photo</label>
    <div class="col-sm-10">
	  <input type="file" id="photo" name="userfile" multiple size="20">
    </div>
  </div>
  
    <div class="form-group">
    <label for="galerie_" class="col-sm-2 control-label">Galerie </label>
    <div class="col-sm-10" id="galerie">
      <input type="text" class="form-control typeahead" id="galerie_" name="galerie" value="<?= $galerie ?>">
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Envoyer</button>
    </div>
  </div>
</form>
  </div>

</div>
