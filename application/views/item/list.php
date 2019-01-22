<div class="container">

    <!-- *** ADMIN *** -->
    <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { ?>
    <div class="row bottom-margin">
        <!-- Button for new item -->
        <a href="<?= base_url(); ?>item/create/" class="btn btn-success">
            <?php echo html_escape($this->lang->line('btn_new')); ?></a>
    </div>
    <?php } ?>
    <!-- *** END OF ADMIN *** -->

    <!-- FILTERS AND SORT FORM -->
    <div id="filters" class="" style="overflow: visible;" method="get" action="<?=base_url(" item/index/1")?>"> <div
        class="row">
        <!-- FILTERS -->
        <div class="col-sm-8 top-margin">
            <!-- HEADING -->
            <p class="bg-primary">&nbsp;
                <?php echo html_escape($this->lang->line('text_search_filters')); ?>
            </p>

            <div class="row">
                <!-- TEXT FILTER -->
                <div class="col-xs-12 top-margin">
                    <?php
		  echo form_label($this->lang->line('field_text_search'), 'text_search');
		  echo form_input('ts', $ts, 
						  'id="text_search" class="form-control"
						   placeholder="'.$this->lang->line('field_no_filter').'" onfocusout="updateTable()"');
		?>
                </div>
            </div>

            <div class="row">
                <!-- TAGS FILTER -->
                <div class="col-sm-8 top-margin" id="item_tags">
                    <?php
		  echo form_label($this->lang->line('field_tags'),
						  'item_conditions-multiselect');
		  echo form_dropdown('t[]', $item_tags, $t,
							 'id="item_tags-multiselect" multiple="multiple" onchange="updateTable()"');
		?>
                </div>

                <!-- GROUPS FILTER -->
                <div class="col-sm-4 top-margin" id="item_groups">
                    <?php
		  echo form_label($this->lang->line('field_group'),
						  'item_groups-multiselect');
		  echo form_dropdown('g[]', $item_groups, $g,
							 'id="item_groups-multiselect" multiple="multiple" onchange="updateTable()"');
		?>
                </div>
            </div>

            <div class="row">
                <!-- STOCKING PLACES FILTER -->
                <div class="col-sm-8 top-margin" id="stocking_places">
                    <?php
			echo form_label($this->lang->line('field_stocking_place'),
							'stocking_places-multiselect');
			echo form_dropdown('s[]', $stocking_places, $s,
							   'id="stocking_places-multiselect" multiple="multiple" onchange="updateTable()"');
		  ?>
                </div>

                <!-- CONDITIONS FILTER -->
                <div class="col-sm-4 top-margin" id="item_conditions">
                    <?php
		  echo form_label($this->lang->line('field_item_condition'),
						  'item_conditions-multiselect');
		  echo form_dropdown('c[]', $item_conditions, $c,
							 'id="item_conditions-multiselect" multiple="multiple" onchange="updateTable()"');
		?>
                </div>
            </div>
        </div>

        <!-- SORT ORDER -->
        <div class="col-sm-4 top-margin">
            <!-- HEADING -->
            <p class="bg-primary">&nbsp;
                <?php echo html_escape($this->lang->line('text_sort_order')); ?>
            </p>

            <div class="row">
                <!-- SORT ORDER -->
                <div class="col-xs-12 top-margin">
                    <?php
		  echo form_label($this->lang->line('field_sort_order'),
							'sort_order');
		  echo form_dropdown('o', $sort_order, $o,
							   'id="sort_order" onchange="updateTable()"');
		?>
                </div>
            </div>
            <div class="row">
                <!-- SORTING ASCENDING / DESCENDING -->
                <div class="col-xs-12 top-margin">
                    <?php
		  echo form_label($this->lang->line('field_sort_asc_desc'),
							'sort_asc_desc');
		  echo form_dropdown('ad', $sort_asc_desc, $ad,
							   'id="sort_asc_desc" onchange="updateTable()"');
		?>
                </div>
            </div>
        </div>
    </div>

    <!-- BUTTONS -->
    <div class="row">
        <div class="col-sm-6 col-xs-12 top-margin xs-center">
            <!--<button type="button" onclick="submitNow()" class="btn btn-primary top-margin"><?php //echo html_escape($this->lang->line('btn_submit_filters')); ?></button>-->
            <button type="button" onclick="voidFilter()" class="btn btn-default top-margin">
                <?php echo html_escape($this->lang->line('btn_remove_filters')); ?></button>
        </div>
    </div>

    <!-- END OF FILTERS AND SORT FORM -->
</div>

<!-- PAGINATION -->

<div class="top-margin table-responsive" id="whatToShow">
    <label id="number-item" style="float:right">(0)</label>
    <div id="pagination_top">
        <ul class="pagination">
    </div>

    <!-- LIST OF ITEMS -->
    <?php if(empty($items)) { ?>
    <em>
        <?= html_escape($this->lang->line('msg_no_item')); ?></em>
    <?php } else { ?>
    <table id="table-items" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>
                    <?= html_escape($this->lang->line('header_picture')); ?>
                </th>
                <th>
                    <?= html_escape($this->lang->line('header_status')); ?>
                </th>
                <th>
                    <?= html_escape($this->lang->line('header_item_name')); ?>
                </th>
                <th nowrap>
                    <?= html_escape($this->lang->line('header_stocking_place')); ?>
                </th>
                <th nowrap>
                    <?php
		  echo html_escape($this->lang->line('header_inventory_nb'));
		  echo '<br />'.html_escape($this->lang->line('header_serial_nb'));
		?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item) {
                if (!empty($item->tags)){
                    $array = array();
                    foreach ($item->tags as $key => $value) {
                        array_push($array,$value);
                    }
                }
                $item_tags = empty($array)?"":implode(" ,", $array);
                $item_conditions = $item->item_condition->name;
                $item_groups = $item->item_group_id;
                $stocking_places = $item->stocking_place->name;
                
               // echo $item_tags."; ".$item_conditions."; ".$item_groups."; ".$stocking_places;
		 ?>

            <tr data-item_tags="<?=$item_tags?>" data-item_conditions="<?=$item_conditions?>" data-item_groups="<?=$item_groups?>" data-stocking_places="<?=$stocking_places?>">
                <td>
                    <a href="<?= base_url('/item/view').'/'.$item->item_id ?>" style="display:block">
                        <img src="<?= base_url('uploads/images/'.$item->image); ?>" width="100px" alt="<?php html_escape($this->lang->line('field_image')); ?>" />
                    </a>
                </td>
                <td>
                    <?php
			  echo $item->item_condition->bootstrap_label;
			  echo '<br />'.$item->loan_bootstrap_label;
			  if (!is_null($item->current_loan)) {
				echo '<br /><h6>'.$item->current_loan->item_localisation.'</h6>';
			  }
			?>
                </td>
                <td>
                    <a href="<?= base_url('/item/view').'/'.$item->item_id ?>" style="display:block">
                        <?= html_escape($item->name); ?></a>
                    <h6>
                        <?= html_escape($item->description); ?>
                    </h6>
                </td>
                <td>
                    <?= html_escape($item->stocking_place->name); ?>
                </td>
                <td>
                    <a href="<?= base_url('/item/view').'/'.$item->item_id ?>" style="display:block">
                        <?= html_escape($item->inventory_number_complete); ?></a>
                    <a href="<?= base_url('/item/view').'/'.$item->item_id ?>" style="display:block">
                        <?= html_escape($item->serial_number); ?></a>
                </td>
                <td>
                    <!-- DELETE ACCESS RESTRICTED FOR ADMINISTRATORS ONLY -->
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= ACCESS_LVL_ADMIN) { ?>
                    <a href="<?= base_url('/item/delete').'/'.$item->item_id ?>" class="close" title="Supprimer l'objet">×</a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } ?>
    <div id="pagination_bottom">
        <ul class="pagination"></ul>
    </div>
</div>
</div>

<!-- Initialize the Bootstrap Multiselect plugin: -->
<script type="text/javascript">
var filtred = true;
var items_per_pages = 25;
$(document).ready(function() {
    $(
        '#item_tags-multiselect, #item_conditions-multiselect,#item_groups-multiselect,#stocking_places-multiselect,#sort_order,#sort_asc_desc'
    ).multiselect({
        nonSelectedText: "<?php echo html_escape($this -> lang -> line('field_no_filter'));?>",
        buttonWidth: '100%',
        numberDisplayed: 5
    });
    loadPage();
    updateTable();

    $("#text_search").on("keyup", function() {
        updateTable();
    });
});
var counter = 0,
    textFocused = false;

function loadPage() {
    var linksToChange = $('.pagination').children();
    for (var i = 0; i < linksToChange.length; i++) {
        var linkToChange = linksToChange[i].children[0];
        if (linkToChange.attributes['href'] != null) {
            var linkChanged = "setPage(\'" + linkToChange.attributes['href'].value + "\')";
            linkToChange.setAttribute('href', '#');
            linkToChange.setAttribute('onclick', linkChanged);
        }
    }
}

function setPage(newPage) {
    $('#whatToShow').load(newPage.toString() + ' #whatToShow');
    setTimeout(function() {
        loadPage();
    }, 2000);
    //Delay needed to allow loadPage() to do its thing on the page
}

function voidFilter() {
    //set all select to unselected
    $('#item_conditions-multiselect option:selected, #item_tags-multiselect option:selected, #item_groups-multiselect option:selected, #stocking_places-multiselect option:selected').prop('selected', false);
    //refresh select
    $('#item_tags-multiselect, #item_groups-multiselect, #item_conditions-multiselect, #stocking_places-multiselect').multiselect('refresh');
    //clean search zone
    $('#text_search').val("");
    //set default to "Fonctionel"
    $('#item_conditions-multiselect').val(10);

    updateTable();
}

function loadPart() {
    //First, get the url
    var targetForm = $('#filters');
    var urlWithParams = targetForm.attr('action');
    urlWithParams += "?" + targetForm.serialize();

    //console.log(urlWithParams);

    //Then, load the new url into the whatToShow part
    $('#whatToShow').load(urlWithParams + ' #whatToShow');
}

function changeTextFocus(newFocus) {
    textFocused = newFocus;
}

function updatePagination(index, number) {
    before_after_num_pages = 5;
    index = index == -1 ? 0 : index; //default index set on first element
    pages = Math.ceil(number / items_per_pages);
    $("ul.pagination").empty();
    if (pages > 1) { //display 5 button before and after index if not negative or limit
        pagination = [];
        imin = index - before_after_num_pages < 0 ? 0 : index - before_after_num_pages;
        imax = index + before_after_num_pages > pages ? pages : index + before_after_num_pages;

        for (let i = imin; i < imax; i++) {
            menu_item = $("<li></li>").append($("<a data-page=\"" + (i + 1) + "\">" + (i + 1) + "</a>"));
            if (i == index) {
                menu_item.addClass("active");
            }
            pagination.push(menu_item);
        }
        if (imin > 0) { //button go start
            pagination.unshift($("<li></li>").append($("<a data-page=\"" + 0 + "\">\<\<</a>")));
        }
        if (imax < pages) { //button go end
            pagination.push($("<li></li>").append($("<a data-page=\"" + pages + "\">\>\></a>")));
        }

        $.each(pagination, function(i, value) {
            $("ul.pagination").append(value);
        });
    }
    $("ul.pagination a").click(function() {
        page = $(this).data("page");
        $("ul.pagination li").removeClass("active");
        $("ul.pagination li a").each(function() {
            if ($(this).data("page") == page) {
                $(this).parent().addClass("active");
            }
        });

        //recursive: if click on <a>, event start updateTable and updatePagination
        updateTable();

        //on change page, change scrolling to the top of the screen
        $("html").scrollTop(0); //reset scroll for best result
        $("html").scrollTop($("#whatToShow").position().top);
    });
    return index * items_per_pages;
}

function updateTable() {
    //filter
    //text-filter
    var text_search = $("#text_search").val().toLowerCase();

    //other filters
    var item_tags = [];
    var item_groups = [];
    var stocking_places = [];
    var item_conditions = [];
    $("#item_tags ul li.active a label input").each(function() {
        item_tags.push($.trim($(this).parent().text()));
    });
    $("#item_groups ul li.active a label input").each(function() {
        
        item_groups.push($.trim($(this).val()));
    });
    $("#stocking_places ul li.active a label input").each(function() {
        stocking_places.push($.trim($(this).parent().text()));//+
    });
    $("#item_conditions ul li.active a label input").each(function() {
        item_conditions.push($.trim($(this).parent().text()));
    });
    
    //text filter
    $("#whatToShow table tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(text_search) > -1);
    });
    console.log(item_groups);
        //item_tags+"; "+item_groups+"; "+stocking_places+"; "+item_conditions);
    items_visibles = $("#whatToShow table tbody tr:visible");
    items_visibles.each(function() {
		//tag filter
		valid=false;
        if (arrayInArray(item_tags, $(this).data("item_tags").split(",")) || item_tags.length == 0) {
			if (inArray(item_conditions, $(this).data("item_conditions")) || item_conditions.length == 0) {
				if (inArray(item_groups, $(this).data("item_groups")) || item_groups.length == 0) {
					if (inArray(stocking_places, $(this).data("stocking_places")) || stocking_places.length == 0) {
						valid=true;
                    }
                }
            }
		}
		$(this).toggle(valid);
    });

    // console.log("item_tags :"+item_tags+", item_conditions :"+item_conditions+", item_groups :"+item_groups+", stocking_places :"+stocking_places);



    //update menu
    all_items = $("#table-items tbody tr:visible");
    $("#number-item").text("(" + all_items.length + ")");
    index_page = $(".pagination li.active").first().children().data("page")
    if (index_page == undefined) index_page = 1;
    item_index = updatePagination(index_page - 1, all_items.length);

    //actualize number displayed
    $.each(all_items, function(index, value) {
        if (index < item_index || index >= item_index + items_per_pages) {
            $(this).toggle(false);
        }
    });
}

function arrayInArray(array1, array2) {
	var result = false;
    $.each(array1, function(key, array1_value) {
		if (inArray(array2, array1_value)) result = true;
    });
    return result;
}

function inArray(array, value) {
	var result = false;
    $.each(array, function(key, array_value) {
		if ($.trim(array_value) == $.trim(value))result = true; 
	});
    return result;
}
</script>