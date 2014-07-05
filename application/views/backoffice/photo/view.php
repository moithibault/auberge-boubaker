<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Listing des photos</h3>
  </div>
<?php
    foreach($galeries AS $galerie){
      echo'
      <div class="panel-heading">
        <h3 class="panel-title"><strong><a name="'.strtolower(trim($galerie->galerie)).'">'.$galerie->galerie.'</a></strong></h3>
      </div>
        <div class="panel-body">
          <div class="row">
      ';

      $photos = $galerie->photos;
      foreach($photos AS $photo){
        echo'
      
            <div class="col-sm-6 col-md-4">
              <div class="thumbnail">
                <img src="'.$path_thumbnail.$photo->id.$photo->extension.'" alt="'.$photo->description.'">
                <div class="caption">
                  <h3>'.$photo->title.'</h3>
                  <p>'.$photo->description.'</p>
                  <p>'.anchor('backoffice/editPhoto/'.$photo->id, 'Modifier', array('class'=>'btn btn-primary', 'role'=>'button')).' 
                  '.anchor('backoffice/deletePhoto/'.$photo->id, 'Supprimer', array('class'=>'btn btn-primary', 'role'=>'button')).'</p>
                </div>
              </div>
            </div>
         ';

      }
      echo ' </div>
        </div>';
    }
?>
</div>