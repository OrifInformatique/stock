<div class="container" id="content">
  <div class="row" style="text-align: center;">
    <h3 class="xs-right">
      <a href="#" onclick="loadPage('admin/view_users/')" class="tab_unselected">Utilisateurs</a>
      <a href="#" onclick="loadPage('admin/view_tags/')" class="tab_unselected">Tags</a>
      <a href="#" onclick="loadPage('admin/view_stocking_places/')" class="tab_unselected">Lieux de stockage</a>
      <a href="#" onclick="loadPage('admin/view_suppliers/')" class="tab_unselected">Fournisseurs</a>
      <a href="#" onclick="loadPage('admin/view_item_groups/')" class="tab_unselected">Groupes d'objets</a>
      <a href="#" onclick="loadPage('admin/')" class="tab_selected">Administration</a>
    </h3>
  </div>
</div>

<style type="text/css">
  .tab_unselected {
    display:block;
    float:left;
    padding:10px 15px;
    background:#0000bb;
    border:1px solid #777;
    border-bottom:none;
    border-radius:4px 4px 0 0;
    margin-right:1px;
    color:#fff;
    text-decoration:none;
  }
  .tab_unselected:hover {
    color: #fff;
  }
  .tab_selected {
    display:block;
    float:left;
    padding:10px 15px;
    background:#00bbbb;
    border:1px solid #777;
    border-bottom:none;
    border-radius:4px 4px 0 0;
    margin-right:1px;
    color:#fff;
    text-decoration:none;
  }
  .tab_selected:hover {
    color: #fff;
  }
</style>
<script type="text/javascript">
    function loadPage(endOfPageString) {
        var targetPart = $('#content');
        if(endOfPageString == undefined) {
            endOfPageString = "";
        }
        var newUrlForPart = ('<?php echo base_url(); ?>' + endOfPageString);
        $('#content').load(newUrlForPart + ' #content');
    }
</script>