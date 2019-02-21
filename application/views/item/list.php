<div class="container">

	<!-- *** ADMIN *** -->
<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { ?>
	<div class="row bottom-margin">
		<!-- Button for new item -->
		<a href="<?php echo base_url("item/create/"); ?>"
			class="btn btn-success"><?php echo html_escape($this->lang->line('btn_new')); ?></a>
	</div>
<?php } ?>
	<!-- *** END OF ADMIN *** -->
	<!-- FILTERS AND SORT FORM -->
	<form id="filters" class="" style="overflow: visible;" method="get" action="<?=base_url("item/index/1")?>">
		<div class="row">
			<!-- FILTERS -->
			<div class="col-sm-8 top-margin">
				<!-- HEADING -->
				<p class="bg-primary">&nbsp;<?php echo html_escape($this->lang->line('text_search_filters')); ?></p>

				<div class="row">
					<!-- TEXT FILTER -->
					<div class="col-xs-12 top-margin">
						<?php 
							echo form_label($this->lang->line('field_text_search'), 'text_search');
							echo form_input('ts', $ts, 
							'id="text_search" class="form-control"
							placeholder="'.$this->lang->line('field_no_filter').'"');
							?>
					</div>
				</div>

				<div class="row">
					<!-- TAGS FILTER -->
					<div class="col-sm-8 top-margin">
						<?= form_label($this->lang->line('field_tags'),'item_conditions-multiselect').form_dropdown('t[]', $item_tags, $t,'id="item_tags-multiselect" multiple="multiple"');?>
					</div>
					<!-- GROUPS FILTER -->
					<div class="col-sm-4 top-margin">
						<?= form_label($this->lang->line('field_group'),'item_groups-multiselect').form_dropdown('g[]', $item_groups, $g,'id="item_groups-multiselect" multiple="multiple"');?>
					</div>
				</div>
				<div class="row">
					<!-- STOCKING PLACES FILTER -->
					<div class="col-sm-8 top-margin">
						<?= form_label($this->lang->line('field_stocking_place'),'stocking_places-multiselect').form_dropdown('s[]', $stocking_places, $s,'id="stocking_places-multiselect" multiple="multiple"');?>
					</div>
					<!-- CONDITIONS FILTER -->
					<div class="col-sm-4 top-margin">
						<?= form_label($this->lang->line('field_item_condition'),'item_conditions-multiselect').form_dropdown('c[]', $item_conditions, $c,'id="item_conditions-multiselect" multiple="multiple"');?>
					</div>
				</div>
			</div>

			<!-- SORT ORDER -->
			<div class="col-sm-4 top-margin">
				<!-- HEADING -->
				<p class="bg-primary">&nbsp;<?php echo html_escape($this->lang->line('text_sort_order')); ?></p>

				<div class="row">
					<!-- SORT ORDER -->
					<div class="col-xs-12 top-margin">
						<?= form_label($this->lang->line('field_sort_order'),'sort_order').form_dropdown('o', $sort_order, $o,'id="sort_order"');?>
					</div>
				</div>
				<div class="row">
					<!-- SORTING ASCENDING / DESCENDING -->
					<div class="col-xs-12 top-margin">
						<?= form_label($this->lang->line('field_sort_asc_desc'),'sort_asc_desc').form_dropdown('ad', $sort_asc_desc, $ad,'id="sort_asc_desc"');?>
					</div>
				</div>
			</div>
		</div>

		<!-- BUTTONS -->
		<div class="row">
			<div class="col-sm-6 col-xs-12 top-margin xs-center">
				<button type="submit" class="btn btn-primary top-margin"><?php echo html_escape($this->lang->line('btn_submit_filters')); ?></button>
				<a href="<?php echo base_url(); ?>item"class="btn btn-default top-margin"><?php echo html_escape($this->lang->line('btn_remove_filters')); ?></a>
			</div>
		</div>
		<!-- END OF FILTERS AND SORT FORM -->
	</form>

	<!-- PAGINATION -->
	<div id="pagination_top"><?=$pagination?></div>

	<div class="top-margin table-responsive">

	<!-- LIST OF ITEMS -->



	<?php  
    $context = $this;
	if(empty($items)) { 
		echo "<em>".html_escape($context->lang->line('msg_no_item'))."</em>"; 
	} 
	else
	{
	?>
		<table class="table table-striped table-hover">
			<thead>
					<tr>
						<th><?= html_escape($context->lang->line('header_picture')); ?></th>
						<th><?= html_escape($context->lang->line('header_status')); ?></th>
						<th><?= html_escape($context->lang->line('header_item_name')); ?></th>
						<th nowrap><?= html_escape($context->lang->line('header_stocking_place')); ?></th>
						<th nowrap><?= html_escape($context->lang->line('header_inventory_nb')).'<br />'.html_escape($context->lang->line('header_serial_nb')); ?></th>
					</tr>
			</thead>
			<tbody id="list_item">

			</tbody>
		</table>
	<?php
	}
	?>
</div>
<div id="pagination_bottom"><?=$pagination?></div>
</div>

<!-- Initialize the Bootstrap Multiselect plugin: -->
<script type="text/javascript">

$(document).ready(function() {
  	var no_filter = "<?= html_escape($this->lang->line('field_no_filter')); ?>";

  	$('#item_tags-multiselect').multiselect({
    	nonSelectedText: no_filter,
    	buttonWidth: '100%',
    	numberDisplayed: 10
  	});
  	$('#item_conditions-multiselect, #item_groups-multiselect, #stocking_places-multiselect, #sort_order, #sort_asc_desc').multiselect({
		nonSelectedText: no_filter,
		buttonWidth: '100%',
		numberDisplayed: 5
	});
	load_items();

	$("input[type=checkbox], #text_search").change(function (e) { 
		//4?ts=&t[]=8&t[]=10&c[]=10&o=0&ad=0
		datas = getUrlParams();
		url = "<?= base_url("test/load_list/")?>"+datas;
		
		$.ajax({
			url: url,
			type: "get",
		
			success: function (response) {
				console.log("sucess call")
				//load_items();
			},
			error : function(resultat, statut, erreur){
			
				console.log(resultat);
				console.log(statut);
				console.log(erreur);
			}
		});
	});
});
function getUrlParams() {
	return "4?ts=&t[]=8&t[]=10&c[]=10&o=0&ad=0";
  }
function load_items(){
	items =<?= json_encode($items); ?>;//get items in php
	$("#list_item").empty();
	items.forEach(item => {
		load_item(item);
	});
}

function load_item(item){
	//region params php
	href = '<?= base_url("/item/view/"); ?>'+item["item_id"];
	src_image = '<?= base_url("uploads/images/"); ?>'+item["image"];
	alt_image = '<?php html_escape($context->lang->line("field_image")); ?>';
	item_condition = item["item_condition"]["bootstrap_label"];
	loan_bootstrap_label = item["loan_bootstrap_label"];
	item_localisation = item["current_loan"]!=null?'<br><h6>'+item["current_loan"]["item_localisation"]+'</h6>':"";
	item_name = item["name"]; 
	item_description = item["description"];
	stocking_place = "<span>"+item["stocking_place"]["name"]+"</span>";
	inventory_number_complete = item["inventory_number_complete"];
	serial_number = item["serial_number"];
	access_admin = '<?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true && $_SESSION["user_access"] >= ACCESS_LVL_ADMIN) { echo "<td><a href=\"".base_url("/item/delete/"); ?>'+item["item_id"]+'" class=\"close\" title=\"Supprimer l\'objet\">×</a></td> <?php } ?>';
	//endregion 
	
	//region add to table
	$("#list_item").append($("<tr></tr>"))
	.append('<td><a href="'+href+'" style="display:block"><img src="'+src_image+'" width="100px" alt="'+alt_image+'" /></a></td>')
	.append(item_condition+'<br />'+loan_bootstrap_label+item_localisation+'</td>')
	.append('<td><a href="'+href+'" style="display:block">'+item_name+'</a><h6>'+item_description+'</h6></td>')
	.append('<td>'+stocking_place+'</td>')
	.append('<td><a href="'+href+'" style="display:block">'+inventory_number_complete+'</a><a href="'+href+'" style="display:block">'+serial_number+'</a></td>')
	.append(access_admin);
	//endregion
}
</script>