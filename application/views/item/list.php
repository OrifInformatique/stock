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
					<div id="ts" class="col-xs-12 top-margin">
						<?php 
							echo form_label($this->lang->line('field_text_search'), 'text_search');
							echo form_input('ts', isset($_GET["ts"])?$_GET["ts"]:"", 
							'id="text_search" class="form-control"
							placeholder="'.$this->lang->line('field_no_filter').'"');
							?>
					</div>
				</div>

				<div class="row">
					<!-- TAGS FILTER -->
					<div id="t" class="col-sm-8 top-margin">
						<?= form_label($this->lang->line('field_tags'),'item_conditions-multiselect').form_dropdown('t[]', $item_tags, isset($_GET["t"])?$_GET["t"]:"",'id="item_tags-multiselect" multiple="multiple"');?>
					</div>
					<!-- GROUPS FILTER -->
					<div id="g" class="col-sm-4 top-margin">
						<?= form_label($this->lang->line('field_group'),'item_groups-multiselect').form_dropdown('g[]', $item_groups, isset($_GET["g"])?$_GET["g"]:"",'id="item_groups-multiselect" multiple="multiple"');?>
					</div>
				</div>
				<div class="row">
					<!-- STOCKING PLACES FILTER -->
					<div id="s" class="col-sm-8 top-margin">
						<?= form_label($this->lang->line('field_stocking_place'),'stocking_places-multiselect').form_dropdown('s[]', $stocking_places, isset($_GET["s"])?$_GET["s"]:"",'id="stocking_places-multiselect" multiple="multiple"');?>
					</div>
					<!-- CONDITIONS FILTER -->
					<div id="c" class="col-sm-4 top-margin">
						<?= form_label($this->lang->line('field_item_condition'),'item_conditions-multiselect').form_dropdown('c[]', $item_conditions, isset($_GET["c"])?$_GET["c"]:"10",'id="item_conditions-multiselect" multiple="multiple"');?>
					</div>
				</div>
			</div>

			<!-- SORT ORDER -->
			<div class="col-sm-4 top-margin">
				<!-- HEADING -->
				<p class="bg-primary">&nbsp;<?php echo html_escape($this->lang->line('text_sort_order')); ?></p>

				<div class="row">
					<!-- SORT ORDER -->
					<div id="o" class="col-xs-12 top-margin">
						<?= form_label($this->lang->line('field_sort_order'),'sort_order').form_dropdown('o', $sort_order, isset($_GET["o"])?$_GET["o"]:"",'id="sort_order"');?>
					</div>
				</div>
				<div class="row">
					<!-- SORTING ASCENDING / DESCENDING -->
					<div id="ad" class="col-xs-12 top-margin">
						<?= form_label($this->lang->line('field_sort_asc_desc'),'sort_asc_desc').form_dropdown('ad', $sort_asc_desc, isset($_GET["ad"])?$_GET["ad"]:"",'id="sort_asc_desc"');?>
					</div>
				</div>
			</div>
		</div>

		<!-- BUTTONS -->
		<div class="row">
			<div class="col-sm-6 col-xs-12 top-margin xs-center">
				<a type="button" href="<?= base_url("item/index/")?>" class="btn btn-default top-margin"><?php echo html_escape($this->lang->line('btn_remove_filters')); ?></a>
			</div>
		</div>
		<!-- END OF FILTERS AND SORT FORM -->
	</form>

	<!-- PAGINATION -->
	<div id="pagination_top"></div>

	<div class="top-margin table-responsive">

	<!-- LIST OF ITEMS -->



	<?php  
    $context = $this;
		echo "<em id=\"no_item_message\">".html_escape($context->lang->line('msg_no_item'))."</em>"; 
	?>
    <table id="table_item" class="table table-striped table-hover">
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
</div>
<div id="pagination_bottom"></div>
</div>

<!-- Initialize the Bootstrap Multiselect plugin: -->
<script type="text/javascript">
var urlParam ="";
var page;
$(document).ready(function() {
	page = location.pathname.split("/").pop();
    urlParam = location.search;
    if(urlParam=="") urlParam = "?ts=&c[]=10&o=0&ad=0";
    load_items(page);
   // $("#c li")[0].addClass("active");
   // $("#c li")[0].find("input[type=checkbox]").prop('checked', true);
    
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
	$("input[type=checkbox], input[type=radio]").change(function(){
        urlParam =  getUrlParams();
        load_items(page);
    });
    $("#text_search").on("change paste keyup", function(){
        urlParam =  getUrlParams();
        load_items(page);
    });
    
});
function load_items(page){
    url = "<?= base_url("item/load_list_json/")?>"+page+urlParam;

    $("*").css("cursor", "wait");

    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var result = JSON.parse(response);

			page = result.number_page;
			history.pushState(null, "", "<?= base_url("item/index/")?>"+page+urlParam);


            $("#list_item").empty();
            
            if (result.items.length > 0){ 
                $("#no_item_message").toggle(false);
                $("#table_item").toggle(true);
                $.each(result.items, function (i, item) {
                    $("#list_item").append(load_item(item));
                });
            }else{ 
                $("#no_item_message").toggle(true);
                $("#table_item").toggle(false);
            }
            
            $("#pagination_bottom, #pagination_top").empty();
            $("#pagination_bottom, #pagination_top").append($(result.pagination));
            $("*").css("cursor", "");
            $(".pagination a").removeAttr("href").css("cursor", "pointer");
            $(".pagination a").click(function(e){
                load_items( $(this).data("ciPaginationPage"));
            });
			history.pushState(null, "", "<?= base_url("item/index/")?>"+page+urlParam);

        },
        error : function(resultat, statut, erreur){
            urlParam = "?ts=&c[]=10&o=0&ad=0";
            load_items(page);
            $("*").css("cursor", "");

        }
    });
}

function getUrlParams() {
	ts = $("#ts input").val();;
	t = "";
	$.each($("#t .multiselect-container .active input"), function (i, val) { 
		t+="&t[]="+val.value;
    });
    s = "";
	$.each($("#s .multiselect-container .active input"), function (i, val) { 
		s+="&s[]="+val.value;
    });
    g = "";
	$.each($("#g .multiselect-container .active input"), function (i, val) { 
		g+="&g[]="+val.value;
	});
	c = "";
	$.each($("#c .multiselect-container .active input"), function (i, val) { 
		c+="&c[]="+val.value;
	});
    o = $("#o .multiselect-container .active input")[0].value;
	ad = $("#ad .multiselect-container .active input")[0].value;
	return "?ts="+ts+t+g+s+c+"&o="+o+"&ad="+ad;
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
	inventory_number = item["inventory_number"];
	serial_number = item["serial_number"];
	access_admin = '<?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true && $_SESSION["user_access"] >= ACCESS_LVL_ADMIN) { echo "<td><a href=\"".base_url("/item/delete/"); ?>'+item["item_id"]+'" class=\"close\" title=\"Supprimer l\'objet\">×</a></td> <?php } ?>';
	//endregion 
	//region add to table
	$("#list_item").append($("<tr></tr>")
	.append('<td><a href="'+href+'" style="display:block"><img src="'+src_image+'" width="100px" alt="'+alt_image+'" /></a></td>')
	.append(item_condition+'<br />'+loan_bootstrap_label+item_localisation+'</td>')
	.append('<td><a href="'+href+'" style="display:block">'+item_name+'</a><h6>'+item_description+'</h6></td>')
	.append('<td>'+stocking_place+'</td>')
	.append('<td><a href="'+href+'" style="display:block">'+inventory_number+'</a><a href="'+href+'" style="display:block">'+serial_number+'</a></td>')
	.append(access_admin));
	//endregion
    
}
</script>
