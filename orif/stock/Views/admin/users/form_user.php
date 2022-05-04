<?php
/**
 * save_user view
 *
 * @author      Orif (ViDi,HeMa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
$update = !is_null($user);
$validation=\Config\Services::validation();
?>
<div class="container">
    <!-- TITLE -->
    <div class="row">
        <div class="col">
            <h1 class="title-section"><?= lang('user_lang.title_user_'.($update ? 'update' : 'new')); ?></h1>
        </div>
    </div>
    
    <!-- INFORMATION MESSAGE IF USER IS DISABLED -->
    <?php if ($update && $user['archive']) { ?>
        <div class="col-12 alert alert-info">
            <?= lang("user_lang.user_disabled_info"); ?>
        </div>
    <?php } ?>
    
    <!-- FORM OPEN -->
    <?php
    $attributes = array(
        'id' => 'user_form',
        'name' => 'user_form'
    );
    echo form_open(base_url('stock/admin/save_user/'.(isset($user['id'])?$user['id']:'')), $attributes, [
        'id' => $user['id'] ?? 0
    ]);
    ?>
        <!-- ERROR MESSAGES -->
        <?php if (! empty($validation->getErrors())) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $validation->listErrors(); ?>
            </div>
        <?php endif ?>

        <!-- USER FIELDS -->
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <?= form_label(lang('user_lang.field_username'), 'user_name', ['class' => 'form-label']); ?>
                    <?= form_input('user_name', $user_name ?? $user['username'] ?? '', [
                        'maxlength' => config("\User\Config\UserConfig")->username_max_length,
                        'class' => 'form-control', 'id' => 'user_name'
                    ]); ?>
                </div>
                <div class="form-group">
                    <?= form_label(lang('user_lang.field_email'), 'user_email', ['class' => 'form-label']); ?>
                    <?= form_input('user_email', $user['email'] ?? '', [
                        'maxlength' => config('\User\Config\UserConfig')->email_max_length,
                        'class' => 'form-control', 'id' => 'user_email'
                    ]); ?>

                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?= form_label(lang('user_lang.field_usertype'), 'user_usertype', ['class' => 'form-label']); ?>
                <?php
                    $dropdown_options = ['class' => 'form-control', 'id' => 'user_usertype'];
                    if(isset($user) && isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user['id']){
                        $dropdown_options['disabled'] = 'disabled';
                        echo form_hidden('user_usertype', $user_usertype ?? $user['fk_user_type'] ?? "");
                        echo "<div class=\"alert alert-info\">".lang('user_lang.user_update_usertype_himself')."</div>";
                    }

                ?>
                <?= form_dropdown('user_usertype', $user_types, $user_usertype ?? $user['fk_user_type'] ?? NULL, $dropdown_options); ?>
                </div>
                <div class="form-group">
                    <!--oninput="autocompleteinput(event)"-->
                    <label style="opacity: 0">empty</label>
                    <span class="row-responsive-2">
                        <button class="multiselect dropdown-toggle btn btn-outline-primary" type="button" style="width: 100%" data-toggle="dropdown"><?=lang('stock_lang.entity_name')?></button>
                        <ul class="multiselect-container dropdown-menu">
                            <?php
                            foreach ($entities as $entity){
                                $checked='';
                                if (isset($user['entities_ids'])){
                                    foreach ($user['entities_ids'] as $user_entity_id){
                                        if ($entity['entity_id']==$user_entity_id){
                                            $checked='checked';
                                        }

                                    }
                                }
                                echo "<li onclick='event.stopImmediatePropagation()'>
                                        <a tabindex='0' class='select-option'><label class='checkbox' for='${entity['name']}'><input type='checkbox' id='${entity['name']}' value='${entity['entity_id']}' aria-label='${entity['name']}' onchange='setfkentity(this)' ${checked}><span class='checkbox'>${entity['name']}</span></label></a>
                                       </li>";
                            }
                            ?>
                        </ul>

                    </span>
                    <?php
                    echo "<input type='hidden'  id='fk_entity_id' name='fk_entity_id' value='";
                    if(isset($user['entities_ids'])) {
                        echo implode(';', $user['entities_ids']) . ";'>";
                    }
                    else{
                        echo "'>";
                    }
                    ?>


                </div>
            </div>
        </div>
        
        <?php if (!$update) { ?>
            <!-- PASSWORD FIELDS ONLY FOR NEW USERS -->
            <div class="row">
                <div class="col-sm-6 form-group">
                    <?= form_label(lang('user_lang.field_password'), 'user_password', ['class' => 'form-label']); ?>
                    <?= form_password('user_password', '', [
                        'class' => 'form-control', 'id' => 'user_password'
                    ]); ?>
                </div>
                <div class="col-sm-6 form-group">
                    <?= form_label(lang('user_lang.field_password_confirm'), 'user_password_again', ['class' => 'form-label']); ?>
                    <?= form_password('user_password_again', '', [
                        'maxlength' => config('\User\Config\UserConfig')->password_max_length,
                        'class' => 'form-control', 'id' => 'user_password_again'
                    ]); ?>
                </div>
            </div>
        <?php } ?>
        
        <?php if ($update) { ?>
            <div class="row">
                <!-- RESET PASSWORD FOR EXISTING USER -->
                <div class="col-12">
                    <a href="<?= base_url('user/admin/password_change_user/'.$user['id']); ?>" >
                        <?= lang("user_lang.title_user_password_reset"); ?>
                    </a>
                </div>
                
                <!-- ACTIVATE / DISABLE EXISTING USER -->
                <?php if ($user['archive']) { ?>
                    <div class="col-12">
                        <a href="<?= base_url('user/admin/reactivate_user/'.$user['id']); ?>" >
                            <?= lang("user_lang.user_reactivate"); ?>
                        </a>
                    </div>
                    <div class="col-12">
                        <a href="<?= base_url('user/admin/delete_user/'.$user['id']); ?>" class="text-danger" >
                            <?= lang("user_lang.btn_hard_delete_user"); ?>
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="col-12">
                        <a href="<?= base_url('user/admin/delete_user/'.$user['id']); ?>" class="text-danger" >
                            <?= lang("user_lang.user_delete"); ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
                    
        <!-- FORM BUTTONS -->
        <div class="row">
            <div class="col text-right">
                <a class="btn btn-default" href="<?= base_url('user/admin/list_user'); ?>"><?= lang('common_lang.btn_cancel'); ?></a>
                <input type="submit" value="<?=lang('common_lang.btn_save')?>" class="btn btn-primary" name="save">
            </div>
        </div>
    <?= form_close(); ?>
    <!--<div class="autoCompleteChoice" style="display: flex;position: absolute;height: auto;flex-wrap: wrap;flex-direction: column;background-color: white;width: 50%;max-width: 250px" class="dropdown-menu"></div>-->
</div>
<!--
<script type="text/javascript">
    function autocompleteinput(){
        const input=document.querySelector('#entity_selector');
        let coordinates=input.getBoundingClientRect();
        const autoCompleteChoice=document.querySelector('.autoCompleteChoice');
        autoCompleteChoice.style.borderWidth='0';
        autoCompleteChoice.innerHTML='';
        autoCompleteChoice.style.left=coordinates.left+'px';
        autoCompleteChoice.style.top=coordinates.top+window.scrollY+36+'px';

        let particle=input.value.includes(';')?input.value.split(';')[input.value.split(';').length-1]:input.value;
        const autoCompleteSelect=document.querySelector('#entity_selector_auto_complete');
        autoCompleteSelect.querySelectorAll('option').forEach((option)=>{
            if (option.innerText.toLocaleLowerCase().includes(particle.toLocaleLowerCase())&&particle!==''&&option.innerText.toLocaleLowerCase()!==particle.toLocaleLowerCase()){
                let btn=document.createElement('button');
                btn.classList.add('btn','btn-outline-secondary','text-dark')
                btn.innerText=option.innerText;
                btn.addEventListener('click',(event)=>{
                    let value=input.getAttribute('data-value');
                    value+=option.value+';';
                    input.setAttribute('data-value',value);
                    input.value=input.value.split(particle).join('')
                    input.value+=event.target.innerText+';';
                    autoCompleteChoice.innerHTML='';
                    input.focus();
                    document.getElementById('fk_entity_id').value=input.getAttribute('data-value');

                })
                autoCompleteChoice.append(btn);
                if (input.value.toLocaleLowerCase().split(';')[input.value.toLocaleLowerCase().split(';').length-1]===option.innerText.toLocaleLowerCase()&&!input.getAttribute('data-value').includes(option.value)){
                    input.setAttribute('data-value',input.getAttribute('data-value')+option.value+';');
                }
            }
        })
        let correctValue=()=>{
            let values=input.value.split(';');
            let parsedValue='';
            values.forEach((val)=>{
                document.querySelectorAll('#entity_selector_auto_complete option').forEach((option)=>{
                    if (val.toLocaleLowerCase()===option.innerText.toLocaleLowerCase()){
                        parsedValue+=option.value+';';
                    }
                })
            })
            parsedValue.split(';').forEach((val)=>{
                input.getAttribute('data-value').split(';').forEach((data)=>{
                    if (val===data){
                        parsedValue.replace(val+';','');
                    }
                })
            });
            input.setAttribute('data-value',parsedValue);

        }
        correctValue();
        document.getElementById('fk_entity_id').value=input.getAttribute('data-value');

    }
    autocompleteinput();
</script>
-->
<script type="text/javascript">
    function setfkentity(element){
        if(element.checked){
            document.getElementById('fk_entity_id').value+=(element.value)+';'
        }
        else{
            document.getElementById('fk_entity_id').value=document.getElementById('fk_entity_id').value.split(element.value+';').join('');
        }

    }
</script>
