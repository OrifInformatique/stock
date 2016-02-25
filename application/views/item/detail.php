<div class="container">
    <!-- ITEM NAME AND DESCRIPTION -->
    <div class="row">
        <div class="col-md-8"><h3><?php echo $item->name; ?></h3></div>
        <div class="col-md-3"><h3><?php echo $item->inventory_number; ?></h3></div>
        <div class="col-md-1"><h6 class="text-right">ID <?php echo $item->item_id; ?></h6></div>
    </div>
    <div class="row">
        <div class="col-md-12"><p><?php echo $item->description; ?></p></div>
    </div>

    <!-- ITEM DETAILS -->
    <div class="row">
        <div class="col-md-8">
            <label>Remarques</label>
            <p><?php echo $item->remarks; ?></p>

            <div class="row">
                <div class="col-md-6">
                    <label>Groupe</label><br />
                    <p><?php if(!is_null($item->item_group)){echo $item->item_group->name;} ?></p>
                </div>
                <div class="col-md-6">
                    <label>Numéro de série</label><br />
                    <p><?php echo $item->serial_number; ?></p>
                </div>
            </div>

            <button type="button">Voir document...</button>
        </div>
        <div class="col-md-4">
            <img src="<?php echo $item->image; ?>" width="100%" />
        </div>
    </div>

    <!-- ITEM STATUS, LOAN STATUS AND HISTORY -->
    <div class="row">
        <div class="col-md-3">
            <?php if(!is_null($item->item_condition)){echo $item->item_condition->name;} ?><br />
            Lieu de stockage :<br />
            <?php if(!is_null($item->stocking_place)){echo $item->stocking_place->name;} ?>
        </div>
        <div class="col-md-4">
            <label>Prêt en cours</label><br />
            <label>Date du prêt :&nbsp;</label>DATE DU PRET A DEFINIR<br />
            <label>Retour prévu :&nbsp;</label>RETOUR PREVU A DEFINIR<br />
        </div>
        <div class="col-md-3">
            <button type="button">Historique des prêts...</button>
        </div>
    </div>

    <!-- ITEM SUPPLIER AND BUYING INFORMATIONS -->
    <div class="row">
        <div class="col-md-4">
            <label>Fournisseur :&nbsp;</label><?php if(!is_null($item->supplier)){echo $item->supplier->name;} ?><br />
            <label>Réf. fournisseur :&nbsp;</label><?php echo $item->supplier_ref; ?>
        </div>
        <div class="col-md-4">
            <label>Prix d'achat :&nbsp;</label><?php echo $item->buying_price; ?><br />
            <label>Date d'achat :&nbsp;</label><?php echo $item->buying_date; ?>
        </div>
        <div class="col-md-4">
            <label>Durée de la garantie :&nbsp;</label><?php echo $item->warranty_duration; ?> mois<br />
            ETAT DE LA GARANTIE A DEFINIR
        </div>
    </div>

    <!-- ITEM TAGS -->
    <div class="row">
        <div class="col-md-12">
            <label>Tags :&nbsp;</label>TAGS A DEFINIR
        </div>
    </div>
</div>