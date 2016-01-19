<div class="clsview">

    <div style="font-size:0.6em; margin:2px">
        <a href="<?php echo base_url() . "item/" ?>" target="_parent">  &lt; Retour</a>
    </div>

    <?php /* ********************************** MESSAGE *********************************************/ ?>

    <div style="font-size:1.0em"><?php if (isset($message)) {
            echo $message;
        } ?></div>

    <?php
    if (isset($error_message)) {
        echo '<div style="color:red">';
        echo($error_message);
        echo '</div>';

    }
    ?>

    <?php /* ********************************** AFFICHAGE ARTICLE ***********************************/ ?>


    <?php /* **********Script pour la date JS ********** */ ?>

    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-datepicker-fr.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>


    <?php $item = $array_item[0]; ?>

    <form action='<?php echo base_url(); ?>item/create/' method='post' name='process'>

        <div class="divitem">
            <div class="divitemheader">Nouvel article</div>


            <div class="tbitem">
                <table>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td>Nom du produit :</td>
                                    <td>
                                        <input type="text" size="30" name="name" id="name" maxlength="45"
                                               value="<?php echo $item['name']; ?>">
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Lieu : </b></td>
                                    <td>
                                        <?php echo stock_drop_down('stocking_place', $item_link['stocking_place'], 'stocking_place_id', 'name', $item['stocking_place_id']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Description :</td>
                                    <td>
                                        <textarea name="description" id="description" rows="4" cols="35"
                                                  maxlength="4096"
                                                  class="form_content"><?php echo $item['description']; ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Fournisseur :</td>
                                    <td>
                                        <?php echo stock_drop_down('supplier', $item_link['supplier'], 'supplier_id', 'name', $item['supplier_id']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Numéro de série :</td>
                                    <td>
                                        <input type="text" size="30" name="serial_number" id="serial_number"
                                               maxlength="45" value="<?php echo $item['serial_number']; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>

                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Notes :</td>

                                    <td>
                                        <textarea rows="4" cols="35" name="remarks" id="remarks" maxlength="4096"
                                                  class="form_content"><?php echo $item['remarks']; ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prix :</td>
                                    <td>
                                        <input type="text" size="30" name="buying_price" id="buying_price"
                                               maxlength="45" value="<?php echo $item['buying_price']; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Date d'achat : </b></td>
                                    <td>
                                        <input type="text" size="30" name="buying_date" id="buying_date" maxlength="45"
                                               value="<?php echo $item['buying_date']; ?>">
                                        <script> $(function () {
                                                $("#buying_date").datepicker();
                                            }); </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Garantie :</td>
                                    <td>
                                        <input type="text" size="30" name="warranty_duration" id="warranty_duration"
                                               maxlength="45" value="<?php echo $item['warranty_duration']; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Numéro fichier :</td>
                                    <td>
                                        <input type="text" size="30" name="file_number" id="file_number" maxlength="45"
                                               value="<?php echo $item['file_number']; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Crée par : </b></td>

                                    <td>
                                        <?php echo stock_drop_down('created_by_user_id', $item_link['user'], 'user_id', 'initials', $item['created_by_user_id']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date création :</td>
                                    <td>
                                        <input type="text" size="30" name="created_date" id="created_date"
                                               maxlength="45" value="<?php echo $item['created_date']; ?>">
                                        <script> $(function () {
                                                $("#created_date").datepicker();
                                            }); </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Modifié par :</td>
                                    <td>
                                        <?php echo stock_drop_down('modified_by_user_id', $item_link['user'], 'user_id', 'initials', $item['modified_by_user_id']); ?>                                            </td>
                                </tr>
                                <tr>
                                    <td>Date modification :</td>
                                    <td>
                                        <input type="text" size="30" name="modified_date" id="modified_date"
                                               maxlength="45" value="<?php echo $item['modified_date']; ?>">
                                        <script> $(function () {
                                                $("#modified_date").datepicker();
                                            }); </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Dernier contrôle par :</td>
                                    <td>
                                        <?php echo stock_drop_down('control_by_user_id', $item_link['user'], 'user_id', 'initials', $item['control_by_user_id']); ?>                                            </td>
                                </tr>
                                <tr>
                                    <td>Date du contrôle :</td>
                                    <td>
                                        <input type="text" size="30" name="control_date" id="control_date"
                                               maxlength="45" value="<?php echo $item['control_date']; ?>">
                                        <script> $(function () {
                                                $("#control_date").datepicker();
                                            }); </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>

                                    <td></td>
                                </tr>

                            </table>
                        </td>
                        <td>

                            <?php /* ********************************** ETAT *********************************************/ ?>

                            <div style="font-style:italic;">Etat :</div>
                            <br>
                            <?php

                            foreach ($item_link['item_state'] as $state) {

                                echo '<input type="radio" name="item_state_id"';

                                if (isset($item['item_state_id']))
                                    if ($item['item_state_id'] == $state['item_state_id'])
                                        echo ' checked ';
                                echo ' value="' . $state['item_state_id'] . '">';

                                echo $state['name'] . '<br>';

                            }

                            ?>
                            <br><br>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
</div>
<div style="font-style:italic; font-size:0.8em; text-align: center;">
    <input type='Submit' value='Créer article'/>
</div>
</div>

</form>

<br>

			
					

