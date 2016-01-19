<div class="clsfilter">

    Options de filtrage :

    <?php echo js_drop_down('stocking_place', $filters['stocking_place'], base_url() . 'item/filter/'); ?>
    <?php echo js_drop_down('supplier', $filters['supplier'], base_url() . 'item/filter/'); ?>
    <?php echo js_drop_down('item_tag', $filters['item_tag'], base_url() . 'item/filter/'); ?>
    <?php echo js_drop_down('created_by', $filters['created_by'], base_url() . 'item/filter/'); ?>

    <a href="<?php echo base_url() . "item/" ?>" target="_parent">
        <button>Effacer filtre</button>
    </a>

    <br>
    <form action='<?php echo base_url(); ?>item/search' method='post' name='search'>
        Mot ou phrase : <input type="text" size="30" name="term" id="term" maxlength="30">
        <a href="<?php echo base_url() . "item/search" ?>" target="_parent">
            <button>Rechercher</button>
        </a>
    </form>


    <?php if ($access_level) echo '<a href="' . base_url() . 'item/new_item" target="_parent"><button>Nouvel article</button></a>'; ?>


</div>

<div class="clsview">

    <div style="font-size:1.0em"><p><?php if (isset($message)) {
                echo $message;
            } ?></p></div>

    <?php foreach ($array_item as $item): ?>
        <div class="divitem">
            <div class="tbitem">
                <div style="font-size:1.2em; text-shadow: 1px 1px #888;">
                    <a href="<?php echo base_url() . 'item/view/' . $item['item_id']; ?>"><?php echo $item['article_nb']; ?></a>
                </div>

                <table>
                    <tr>
                        <td>
                            <?php if ($access_level) echo '<a href="' . base_url() . 'item/remove/' . $item['item_id'] . '" target="_parent"><button>X</button></a>'; ?>

                            <?php echo $item['name'] ?> </td>
                        <td>
                            <div style="font-size:0.6em">Créé par :
                            </div><?php echo $item_link['user'][intval($item['created_by_user_id'])]['initials'] ?></td>
                        <td>
                            <div style="font-style:italic"><?php echo substr($item['description'], 0, 50) ?></div>
                        </td>

                    </tr>
                </table>

            </div>
        </div>
    <?php endforeach ?>
    <br>

</div>

			
					

