<?php
//Affiche les erreurs au cas où !
if(isset($errors)){
	echo $errors;
}
echo validation_errors(); 
echo form_open('login/post', array('role' => 'form'));
?>
  <div class="form-group">
    <label for="username">Nom d'utilisateur</label>
    <input type="text" class="form-control" id="username" name="username" value="<?php echo set_value('username'); ?>">
  </div>
  <div class="form-group">
    <label for="password">Mot de passe</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <button type="submit" class="btn btn-default">Envoyer</button>
</form>
