<?php
$validation=\Config\Services::validation();
?>

<form class="container" method="post">
    <div class="row">
        <h2 class="col-12 pb-3 pl-0">Migration</h2>
        <div class="col-12 alert alert-info">Les migrations vont modifier la base de données, ceci étant relativement dangereux :<br> <br> elle sont bloquées derrière un mot de passe. </div>
        <label class="col-12 pl-0" for="password">Mot de passe</label>
        <input type="password" class="form-control" name="password" id="password"/>
        <span class="text-danger"><?= $validation->showError('password'); ?></span>
        <div class="col-12 text-right pt-3 pr-0">
            <?= form_submit('save', lang('common_lang.btn_save'), ['class' => 'btn btn-primary']); ?>
        </div>
    </div>
</form>