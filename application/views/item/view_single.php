
Skip to content
This repository

    Pull requests
    Issues
    Gist

    @DidierViret

2
1

    1

OrifInformatique/stock
Code
Issues 0
Pull requests 0
Wiki
Pulse
Graphs
Settings
stock/application/views/item/view_single.php
5ad2e07 on 18 Aug 2015
@DidierViret DidierViret Etat projet David Surbeck (juillet 2015)
276 lines (219 sloc) 9.02 KB

        <div class="clsview">
            
            <div style="font-size:0.6em; margin:2px">
                <a href="<?php echo base_url()."item/" ?>" target="_parent">  &lt; Retour</a>
            </div>
            
            <?php /* ********************************** MESSAGE *********************************************/ ?>
            
            <div style="font-size:1.0em"><?php if(isset($message)){ echo $message; }?></div>
                        
            <?php
                if(isset($error_message))
                { 
                    echo '<div style="color:red">';
                    echo ($error_message);
                    echo '</div>';
                
                }
            ?>
                        
            <?php /* ********************************** AFFICHAGE ARTICLE ***********************************/ ?>

            
            <?php /* **********Script pour la date JS ********** */ ?>
    
            <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/jquery-datepicker-fr.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
            
            
            <?php $item = $array_item[0]; ?>
            
            <form action='<?php echo base_url();?>item/update/<?php echo $item['item_id']?>' method='post' name='process'>
            
            <div class="divitem">
                <div class="divitemheader"><?php echo $item['article_nb'].' '.$item['name'] ?></div>
                

                <div class="tbitem">
                    <div style="font-style:italic; font-size:0.8em; text-align: center;"><p>Détails de l'article : </p></div><br>
                        <table>
                            <tr>
                                <td>
                                    <table>
                                        <tr>
                                            <td>Nom du produit : </td>                              
                                            <td>
                                                <input type="text" size="30" name="name" id="name" maxlength="45" value="<?php echo $item['name'];?>">
                                            </td>
                                            <td></td><td></td>
                                        </tr>
                                        <tr>
                                            <td>Lieu : </td>                                    
                                            <td>
                                                    <?php echo stock_drop_down('stocking_place', $item_link['stocking_place'], 'stocking_place_id', 'name', $item['stocking_place_id']); ?>
                                            </td>                               
                                        </tr>
                                        <tr>
                                            <td>Description : </td>                             
                                            <td>
                                                <textarea name="description" id="description" rows="4" cols="35" maxlength="4096" class="form_content"><?php echo $item['description'];?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fournisseur : </td>                                 
                                            <td>
                                                <?php echo stock_drop_down('supplier', $item_link['supplier'], 'supplier_id', 'name', $item['supplier_id']); ?>
                                            </td>                               
                                        </tr>
                                        <tr>
                                            <td>Numéro de série : </td>                             
                                            <td>
                                                <input type="text" size="30" name="serial_number" id="serial_number" maxlength="45" value="<?php echo $item['serial_number'];?>">
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td></td>                               
                
                                            <td></td>
                                        </tr>       
                                        <tr>
                                            <td>Notes : </td>                               
                
                                            <td>
                                                <textarea rows="4" cols="35" name="remarks" id="remarks" maxlength="4096" class="form_content"><?php echo $item['remarks'];?></textarea>
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td>Prix : </td>                                
                                            <td>
                                                <input type="text" size="30" name="buying_price" id="buying_price" maxlength="45" value="<?php echo $item['buying_price'];?>">
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td>Date d'achat : </td>                                
                                            <td>
                                                <input type="text" size="30" name="buying_date" id="buying_date" maxlength="45" value="<?php echo $item['buying_date'];?>">
                                                <script> $(function() {    $( "#buying_date" ).datepicker();}); </script>
                                            </td>
                                        </tr>                               
                                        <tr>
                                            <td>Garantie : </td>                                
                                            <td>
                                                <input type="text" size="30" name="warranty_duration" id="warranty_duration" maxlength="45" value="<?php echo $item['warranty_duration'];?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Numéro fichier : </td>                              
                                            <td>
                                                <input type="text" size="30" name="file_number" id="file_number" maxlength="45" value="<?php echo $item['file_number'];?>">
                                            </td>
                                        </tr>                       
                                        <tr>                            
                                            <td>Crée par : </td>                                
                
                                            <td>
                                                    <?php echo stock_drop_down('created_by_user_id', $item_link['user'], 'user_id', 'initials', $item['created_by_user_id']); ?>                                                    
                                            </td>
                                        </tr>
                                        <tr>    
                                            <td>Date création : </td>                               
                                            <td>
                                                <input type="text" size="30" name="created_date" id="created_date" maxlength="45" value="<?php echo $item['created_date'];?>">
                                                <script> $(function() {    $( "#created_date" ).datepicker();}); </script>
                                            </td>
                                        </tr>
                                        <tr>                                
                                            <td>Modifié par : </td>                             
                                            <td>
                                                    <?php echo stock_drop_down('modified_by_user_id', $item_link['user'], 'user_id', 'initials', $item['modified_by_user_id']); ?>                                          </td>
                                        </tr>   
                                        <tr>
                                            <td>Date modification : </td>                               
                                            <td>
                                                <input type="text" size="30" name="modified_date" id="modified_date" maxlength="45" value="<?php echo $item['modified_date'];?>">
                                                <script> $(function() {    $( "#modified_date" ).datepicker();}); </script>
                                            </td>
                                        </tr>
                                        <tr>                                
                                            <td>Dernier contrôle par : </td>                                
                                            <td>
                                                    <?php echo stock_drop_down('control_by_user_id', $item_link['user'], 'user_id', 'initials', $item['control_by_user_id']); ?>                                            </td>
                                        </tr>
                                        <tr>    
                                            <td>Date du contrôle : </td>                                
                                            <td>
                                                <input type="text" size="30" name="control_date" id="control_date" maxlength="45" value="<?php echo $item['control_date'];?>">
                                                <script> $(function() {    $( "#control_date" ).datepicker();}); </script>
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
                                
                                <div style="font-style:italic;">Etat : </div><br>
                                <?php 
                                    
                                    foreach ($item_link['item_state'] as $state)
                                    {
                                        echo '<input type="radio" name="item_state_id"';
                                            
                                        if(isset($item['item_state_id']))
                                            if($item['item_state_id'] == $state['item_state_id'])
                                                echo ' checked ';
                                        echo' value="'.$state['item_state_id'].'">';
                                        echo $state['name'].'<br>';
                                            
                                    }
                                    
                                ?>
                                <br><br>
                                
                                
                                <?php /* *********************************** IMAGE ******************************************/ ?>
                                
                                <table class="grey_round_border" style="width:auto;">
                                <?php 
                                    if(isset($item['image']))
                                    {
                                        echo '<tr><td style="padding:10px" colspan="2">';
                                        
                                        echo '<img src="'.
                                        base_url().'uploads/images/'.$item['image'].
                                        '" alt="Image de l\'article" style="width:256px;height:256px;">';
                                        
                                        echo '</td></tr>';
                                    }
                                    ?>
                                    
                                    <tr><td style="padding:10px">
                                    <?php 
                                        if($access_level) 
                                        {
                                            echo '<a href="'.
                                                base_url().'item/upload/'.$item['item_id'].
                                                '">Importer image</a>';
                                        }
                                        if(isset($item['image']))
                                        {
                                            echo '<td style="padding:10px">';
                                        
                                            echo '<a href="'.
                                                base_url().'uploads/images/'.$item['image'].
                                                '" download>Exporter image</a>';
                                            
                                            echo '</td>';
                                        }       
                                    ?> 
                                </tr></table>
                                <br><br>
                                
                                <?php /* ********************************** TAGS *********************************************/ ?>
                                
                                <?php 
                                
                                    if(isset($item['tags']))
                                    {
                                        echo '<div style="font-style:italic;">Etiquettes :</div><br>';
                                    
                                        foreach ($item['tags'] as $tag)
                                        {
                                            echo '<table class="grey_round_border" style="width:auto; margin:2px;"><tr><td>';
                                            echo '- ';
                                            echo $item_link['item_tag'][$tag['item_tag_id']]['name'];
                                            
                                            if($access_level) 
                                            {
                                                echo ' <input type="button" value="x" onclick="window.location.href=\''.base_url().'item/remove_tag/'.$item['item_id'].'/'.$tag['item_tag_link_id'].'\'">';
                                            }
                                            
                                            //echo '<br>';                                  
                                            
                                            echo '</table>';
                                        }
                                    }
                                    if($access_level) 
                                    {
                                        echo '<br> Ajouter ';
        
                                        echo js_drop_down($item['item_id'], $item_link['item_tag'], base_url().'item/add_tag/');
                                    }
                                    
                                ?>                              
                                
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div style="font-style:italic; font-size:0.8em; text-align: center;">
                    <?php if($access_level) echo '<input type="Submit" value="Enregistrer modifications" />'; ?>
                </div>
        </div>
            
        </form>
        
    <br>

            
                    

    Status API Training Shop Blog About Pricing 

    © 2016 GitHub, Inc. Terms Privacy Security Contact Help 

