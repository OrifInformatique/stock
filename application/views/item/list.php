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
                
                //saves all tags in data attributes for to be recovered by js/JQuery
                $item_tags = empty($item->tags)?"":implode(" ,", $item->tags);
                $item_conditions = $item->item_condition->name;
                $item_groups = $item->item_group_id;
                $stocking_places = $item->stocking_place->name;
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
    num_of_pages = Math.ceil(number / items_per_pages);
    $("ul.pagination").empty();
    if (num_of_pages > 1) { //display 5 button before and after index if not negative or limit
        pagination = [];
        imin = index - before_after_num_pages < 1 ? 0 : index - (before_after_num_pages-1);
        imax = index + before_after_num_pages > num_of_pages ? num_of_pages : index + before_after_num_pages;

        for (let i = imin; i < imax; i++) {
            menu_item = $("<li></li>").addClass("page-item").append($("<a></a>").addClass("page-link").text(i + 1).data("page", i+1).attr("href", "#"));
            if (i == index) {
                menu_item.addClass("active");
            }
            pagination.push(menu_item);
        }
        if (imin > 0) { //button go start
            pagination.unshift($("<li></li>").addClass("page-item").append($("<a></a>").addClass("page-link").attr("title", "1").data("page", 0).attr("href", "#").append($("<span></span>").attr("aria-hidden", true).text("«")).append($("<span></span>").addClass("sr-only").text("Previous"))));
        }
        if (imax < num_of_pages) { //button go end
            pagination.push($("<li></li>").addClass("page-item").append($("<a></a>").addClass("page-link").attr("title", num_of_pages).data("page", num_of_pages).attr("href", "#").append($("<span></span>").attr("aria-hidden", true).text("»")).append($("<span></span>").addClass("sr-only").text("Next"))));
        }
        $.each(pagination, function(i, value) {
            $("ul.pagination").append(value);
        });
    }
    $("ul.pagination a").click(function() {

        //change classes for view
        page = $(this).data("page");
        $("ul.pagination li").removeClass("active");
        $("ul.pagination li a").each(function() {
            if ($(this).data("page") == page) {
                $(this).parent().addClass("active");
            }
        });

        //re-update all elements
        updateTable();

        //on change page, change scrolling to the top of the screen if the scroll position is bottom of "#whatToShow"
        if($("html").position().top>$("#whatToShow").position().top-$("html").position().top){
            $("html").scrollTop(0); //reset scroll
            $("html").scrollTop($("#whatToShow").position().top); //set scroll to top of "#whatToShow"
        }
    });
    return index * items_per_pages;
}

function updateTable() {
    //filters
    var text_search = $("#text_search").val().toLowerCase();
    var item_tags = [];
    var item_groups = [];
    var stocking_places = [];
    var item_conditions = [];

    //apply text filter
    $("#whatToShow table tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(text_search) > -1);
    });

    //get all values of filters
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
    
    //get (and loop over) all elements (after text filter)
    items_visibles = $("#whatToShow table tbody tr:visible");
    items_visibles.each(function() {
		valid=false;
        //apply filter for this element
        if (arrayInArray(item_tags, $(this).data("item_tags").split(",")) || item_tags.length == 0) {
			if (inArray(item_conditions, $(this).data("item_conditions")) || item_conditions.length == 0) {
				if (inArray(item_groups, $(this).data("item_groups")) || item_groups.length == 0) {
					if (inArray(stocking_places, $(this).data("stocking_places")) || stocking_places.length == 0) {
						valid=true;
                    }
                }
            }
		}
        //if valid all filter, show element
		$(this).toggle(valid);
    });

    //update menu 
    items_visibles = $("#table-items tbody tr:visible");
    $("#number-item").text("(" + items_visibles.length + ")");
    index_page=($(".pagination li.active").first().children().data("page"));
    index_page=index_page==undefined?0:index_page-1;
    item_index=updatePagination(index_page, items_visibles.length);

    //actualize number displayed
    $.each(items_visibles, function(index, value) {
        if (index < item_index || index >= item_index + items_per_pages) {
            $(this).toggle(false);
        }
    });
}

//this function return true only if a element of array 1 is equals of a element of array 2
function arrayInArray(array1, array2) {
	var result = false;
    $.each(array1, function(key, array1_value) {
		if (inArray(array2, array1_value)) result = true;
    });
    return result;
}

//this function return true only if the value is in array
function inArray(array, value) {
	var result = false;
    $.each(array, function(key, array_value) {
		if ($.trim(array_value) == $.trim(value))result = true; 
	});
    return result;
}
</script>