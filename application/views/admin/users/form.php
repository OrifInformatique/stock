<div class="container">
  <h1 style="text-align: center"><select id="rows" onchange="changeRow()">
    <?php foreach($users as $user) { ?>
    <option value="<?php echo $user->user_id; ?>"<?php if ($user_id == $user->user_id) {echo " selected";} ?>>"<?php echo $user->username; ?>"</option>
    <?php } ?>
  </select>, <select id="actions" onchange="changeAction()">
    <option value="modify">Modification</option>
    <option value="delete">Suppression</option>
    <option value="new">Ajout</option>
  </select>, <select id="regions" style="border:none;width:205px;" onchange="changeRegion()">
    <option value="user">Utilisateurs</option>
    <option value="tag">Tags</option>
    <option value="stocking_place">Lieux de stockage</option>
    <option value="supplier">Fournisseurs</option>
    <option value="item_group">Groupes d'objets</option>
  </select><a href="<?php echo ; ?>">, Administration</a></h1>

  <em><?php echo validation_errors(); if (isset($upload_errors)) {echo $upload_errors;} ?></em>

  <form class="container" method="post">
    Identifiant :
    Nom :
    Prénom :
    Statut : [liste déroulante des statuts]
    Mot de passe (vide: ne rien changer) : <input type="password" value="" />
    Confirmer le mot de passe :
  </form>

  <script src="<?php echo base_url(); ?>assets/js/geoline.js"></script>
</div>