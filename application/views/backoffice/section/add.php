<?php
$title = '';
$menu = '';
$content = '';
$aside = '';
$visible = 0;
$galerie = '';
$formtitle = '';


if(isset($update)){
  //On est en modification !
  $title = $update->title;
  $menu = $update->menu;
  $formtitle = 'Modification de la section <strong>'.$title.'</strong>';
  $content = $update->content;
  $aside = $update->aside;
  $galerie = $update->galerie;
   if($update->visible == 1)$visible =  'checked';
}
else{
  $formtitle = 'Nouvelle section';
}

//si il y auue des erreurs
//Affiche les erreurs au cas où !
if(isset($errors)){
  echo $errors;
}
echo validation_errors(); 

$title = (empty(set_value('title'))) ? $title : set_value('title');
$menu = (empty(set_value('menu'))) ? $menu : set_value('menu');
$content = (empty(set_value('content'))) ? $content : set_value('content');
$aside = (empty(set_value('aside'))) ? $aside : set_value('aside');
$galerie = (empty(set_value('galerie'))) ? $galerie : set_value('galerie');

if(set_value('visible') == 1)$visible =  'checked';



?>


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?= $formtitle ?></h3>
  </div>
  <div class="panel-body">


<?php  echo form_open('backoffice/post_addsection', array('role' => 'form','method' => 'post', 'class' => 'form-horizontal'));
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
    <label for="menu" class="col-sm-2 control-label">Titre dans le menu</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="menu" name="menu" value="<?= $menu ?>">
    </div>
  </div>

  <div class="form-group">
    <label for="content" class="col-sm-2 control-label">Contenu</label>
    <div class="col-sm-10">
    <textarea name="content" id="content" class="textarea form-control" rows="20"><?= $content ?></textarea>
    </div>
  </div>

    <div class="form-group">
    <label for="aside" class="col-sm-2 control-label">Colonne latéral</label>
    <div class="col-sm-10">
    <textarea name="aside" id="aside" class="textarea form-control" rows="20"><?= $aside ?></textarea>
    </div>
  </div>
  
    <div class="form-group">
    <label for="galerie_" class="col-sm-2 control-label">Associé les images labelisé par </label>
    <div class="col-sm-10" id="galerie">
      <input type="text" class="form-control typeahead" id="galerie_" name="galerie" value="<?= $galerie ?>">
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="visible" value="1" <?= $visible ?>> Visible dans le menu en FrontOffice
        </label>
      </div>
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
