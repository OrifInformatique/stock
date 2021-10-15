<div id="admin-menu" class="container">
    <div class="row">
        <div class="col">
            <?php foreach (config('\Common\Config\AdminPanelConfig')->tabs as $tab){?>
                <a href="<?=base_url($tab['pageLink'])?>" class="btn btn-primary adminnav" ><?=lang($tab['label'])?></a>
            <?php } ?>
        </div>
    </div>
</div>
<script defer>
    document.querySelectorAll('.adminnav').forEach((nav)=>{
        if (nav.href.includes(window.location)){
            nav.classList.add('active')
        }
        else{
            nav.classList.remove('active')
        }
    })
</script>