
<div class="container">

    <!-- *** ADMIN *** -->
    <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= config('User\Config\UserConfig')->access_lvl_registered) { ?>
        <div class="row bottom-margin">
            <div class="col-12">
                <!-- Button for new item -->
                <a href="<?php echo base_url("item/create/"); ?>"
                        class="btn btn-success mb-3"><?php echo htmlspecialchars(lang('MY_application.btn_new')); ?></a>
            </div>
        </div>
    <?php } ?>
    <!-- *** END OF ADMIN *** -->

    <!-- FILTERS AND SORT FORM -->
    <form id="filters" class="" style="overflow: visible;" method="get" action="<?=base_url("item/index/1") . "/"?>">
        <div class="row">
            <!-- FILTERS -->
            <div class="col-sm-8 top-margin">
                <!-- HEADING -->
                <p class="bg-primary">&nbsp;<?php echo htmlspecialchars(lang('MY_application.text_search_filters')); ?></p>

                <div class="row">
                    <!-- TEXT FILTER -->
                    <div id="ts" class="col-sm-12 top-margin">
                    <?php
                        echo form_label(lang('MY_application.field_text_search'), 'text_search');
                        echo form_input('ts', isset($_GET["ts"])?$_GET["ts"]:"",
                        'id="text_search" class="form-control"
                        placeholder="'.lang('MY_application.field_no_filter').'"');
                    ?>
                    </div>
                </div>

                <div class="row">
                    <!-- TAGS FILTER -->
                    <div id="t" class="col-sm-8 top-margin">
                        <?= form_label(lang('MY_application.field_tags'),'item_conditions-multiselect').form_dropdown('t[]', $item_tags, isset($_GET["t"])?$_GET["t"]:"",'id="item_tags-multiselect" multiple="multiple"');?>
                    </div>
                    <!-- GROUPS FILTER -->
                    <div id="g" class="col-sm-4 top-margin">
                        <?= form_label(lang('MY_application.field_group'),'item_groups-multiselect').form_dropdown('g[]', $item_groups, isset($_GET["g"])?$_GET["g"]:"",'id="item_groups-multiselect" multiple="multiple"');?>
                    </div>
                </div>
                <div class="row">
                    <!-- STOCKING PLACES FILTER -->
                    <div id="s" class="col-sm-8 top-margin">
                        <?= form_label(lang('MY_application.field_stocking_place'),'stocking_places-multiselect').form_dropdown('s[]', $stocking_places, isset($_GET["s"])?$_GET["s"]:"",'id="stocking_places-multiselect" multiple="multiple"');?>
                    </div>
                    <!-- CONDITIONS FILTER -->
                    <div id="c" class="col-sm-4 top-margin">
                        <?= form_label(lang('MY_application.field_item_condition'),'item_conditions-multiselect').form_dropdown('c[]', $item_conditions, isset($_GET["c"])?$_GET["c"]:"10",'id="item_conditions-multiselect" multiple="multiple"');?>
                    </div>
                </div>
            </div>

            <!-- SORT ORDER -->
            <div class="col-sm-4 top-margin">
                <!-- HEADING -->
                <p class="bg-primary">&nbsp;<?php echo htmlspecialchars(lang('MY_application.text_sort_order')); ?></p>

                <div class="row">
                    <!-- SORT ORDER -->
                    <div id="o" class="col-sm-12 top-margin">
                        <?= form_label(lang('MY_application.field_sort_order'),'sort_order').form_dropdown('o', $sort_order, isset($_GET["o"])?$_GET["o"]:"",'id="sort_order"');?>
                    </div>
                </div>
                <div class="row">
                    <!-- SORTING ASCENDING / DESCENDING -->
                    <div id="ad" class="col-sm-12 top-margin">
                        <?= form_label(lang('MY_application.field_sort_asc_desc'),'sort_asc_desc').form_dropdown('ad', $sort_asc_desc, isset($_GET["ad"])?$_GET["ad"]:"",'id="sort_asc_desc"');?>
                    </div>
                </div>

                <!-- RESET FILTERS AND DISPLAY LOANS BUTTONS -->
                <div class="text-right">
                    <?= form_label("&nbsp;") ?>
                </div>
                <div class="text-right">
                    <a href="<?= base_url("item/index/") . "/"?>" class="btn btn-default"><?php echo htmlspecialchars(lang('MY_application.btn_remove_filters')); ?></a>
                    <a href="<?= base_url("item/list_loans/") . "/"?>" class="btn btn-primary">
                        <?php echo htmlspecialchars(lang('MY_application.btn_to_loans')); ?>
                        <?php if(isset($late_loans_count) && $late_loans_count > 0): ?>
                            <span class="badge badge-danger"><?= $late_loans_count ?></span>
                        <?php endif ?>
                    </a>
                </div>
            </div>
        </div>
    </form>
    <!-- END OF FILTERS AND SORT FORM -->

    <!-- PAGINATION -->
    <div class="row"><div class="col-12">
        <div id="pagination_top"></div>
    </div></div>

    <!-- LIST OF ITEMS -->
    <div class="alert alert-warning" id="no_item_message"><?= htmlspecialchars(lang('MY_application.msg_no_item')); ?></div>
    <div class="alert alert-danger" id="error_message"></div>

    <div>
        <div class="row" id="list_item">
        </div>
    </div>

    <!-- PAGINATION -->
    <div class="row"><div class="col-12">
        <div id="pagination_bottom"></div>
    </div></div>
</div>


<script type="text/javascript">
$(document).ready(function() {

    // ******************************************
    // Initialize the Bootstrap Multiselect plugin
    // ******************************************
    var no_filter = "<?= htmlspecialchars(lang('MY_application.field_no_filter')); ?>";
    $('#item_tags-multiselect').multiselect({
        nonSelectedText: no_filter,
        buttonWidth: '100%',
        buttonClass: 'btn btn-outline-primary',
        numberDisplayed: 10
    });
    $('#item_conditions-multiselect, #item_groups-multiselect, #stocking_places-multiselect, #sort_order, #sort_asc_desc').multiselect({
        nonSelectedText: no_filter,
        buttonWidth: '100%',
        buttonClass: 'btn btn-outline-primary',
        numberDisplayed: 5
    });


    // ******************************************
    // Load items list
    // ******************************************
    // Load parameters in the URL
    page = location.pathname.split("/").pop();
    filters = location.search;
    load_items(page, filters);

    // Reload items list on filter update
    $("input[type=checkbox], input[type=radio]").change(function(){
        // Load page 1 with new filters
        load_items(1, getFilters());
    });
    $("#text_search").on("change blur", function(){
        // Load page 1 with new filters
        load_items(1, getFilters());
    });
});


// ******************************************
// Load or reload items list corresponding to selected filters
// ******************************************
let populating = false;

function load_items(page, filters){
    if (populating) return;
    populating = true;

    // Display "wait" cursor
    $("*").css("cursor", "wait");

    // Hide or empty elements
    $("#no_item_message").toggle(false);
    $("#error_message").toggle(false);
    $("#table_item").toggle(false);
    $("#list_item").empty();
    $("#pagination_bottom, #pagination_top").empty();


    // URL for ajax call to PHP controller                      Stock\Controllers\
    url = "<?= base_url("/Item/load_list_json")?>"+ "/" + page+filters;

    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var result = JSON.parse(response);
            page = result.number_page;
            filters=getFilters();
            history.pushState(null, "", "<?= base_url("item/index/")?>"+ "/"+page+filters);

            // Empty list before filling it
            if (result.items.length > 0){
                $("#table_item").toggle(true);
                $.each(result.items, function (i, item) {
                    $("#list_item").append(display_item(item));
                });
            } else {
                $("#no_item_message").toggle(true);
            }

            $("#pagination_top, #pagination_bottom").html(result.pagination);

            // Change cursor
            $("*").css("cursor", "");
            $(".pagination a").css("cursor", "pointer");
            $(".pagination a").click(function(e){
                e.preventDefault();
                let pageLinkNumber = parseInt(e.target.href.split("=").pop(), 10);
                load_items(pageLinkNumber, getFilters());
            });

            history.pushState(null, "", "<?= base_url("item/index/")?>"+ "/" +page+filters);
            populating = false;
        },
        error : function(resultat, statut, erreur){
            $("#error_message").toggle(true);
            $("#error_message").append(resultat.responseText);

            // Display normal cursor
            $("*").css("cursor", "");
            populating = false;
        }
    });
}

function getFilters() {
    // Text search filter
    ts = $("#ts input").val();

    // Tags filter
    t = "";
    $.each($("#t .multiselect-container .active input"), function (i, val) {
        t+="&t[]="+val.value;
    });

    // Stocking places filter
    s = "";
    $.each($("#s .multiselect-container .active input"), function (i, val) {
        s+="&s[]="+val.value;
    });

    // Groups filter
    g = "";
    $.each($("#g .multiselect-container .active input"), function (i, val) {
        g+="&g[]="+val.value;
    });

    // Conditions filter
    c = "";
    $.each($("#c .multiselect-container .active input"), function (i, val) {
        c+="&c[]="+val.value;
    });

    // Sort order
    o = $("#o .multiselect-container .active input")[0].value;

    // Sort ascending/descending
    ad = $("#ad .multiselect-container .active input")[0].value;

    return "?ts="+ts+t+g+s+c+"&o="+o+"&ad="+ad;
}

function display_item(item){
    // Item's parameters
    let href = '<?= base_url("/item/view/"); ?>/'+item["item_id"];
    let src_image = '<?= base_url(); ?>/'+item["image_path"];
    let alt_image = '<?php htmlspecialchars(lang("MY_application.field_image")); ?>';
    let item_condition = item["condition"]["bootstrap_label"];
    let loan_bootstrap_label = item["current_loan"]["bootstrap_label"];
    let item_localisation = item["current_loan"]["loan_id"]!=null ?'<div class="small">'+item["current_loan"]["item_localisation"]+'</div>':"";
    let item_planned_return = item["current_loan"]["loan_id"]!=null ?'<div class="small">'+'<?= lang("MY_application.field_loan_planned_return"); ?> : '+item["current_loan"]["planned_return_date"]+'</div>':"";
    let item_name = item["name"];
    let item_description = item["description"];
    let stocking_place = "<span>"+item["stocking_place"]["name"]+"</span>";
    let inventory_number = item["inventory_number"];
    let serial_number = item["serial_number"];
    let delete_item = '<?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true && $_SESSION["user_access"] >= config('\User\Config\UserConfig')->access_lvl_admin) { echo "<td><a href=\"".base_url("/item/delete/"); ?>/'+item["item_id"]+'" class=\"close\" title=\"Supprimer l\'objet\">×</a></td> <?php } ?>';

    // Create formatted card
    let card = $('<div>');
    card.addClass('col-xl-3 col-md-4 col-sm-6');

    // Card contents
    let card_div = $('<div>');
    card_div.addClass('item bg-light rounded');

    card_div.append(
        `<div class="item_picture"><a href="${href}"><img src="${src_image}" width="100" alt="${alt_image}"/></a></div>`,
        `<div><a href="${href}">${inventory_number}</a></div>`,
        `<div><a href="${href}">${item_name}</a></div>`,
        '<div class="small">' + (serial_number ? `<?= lang('MY_application.header_serial_nb'); ?> : ${serial_number}` : '') + '</div>',
        `<div class="small fst-italic mt-2 mb-2">${item_description}</div>`,
        `<div class="small"> <?= lang('MY_application.field_stocking_place_short'); ?> : ${stocking_place}</div>`,
        `<div class="mt-2">${item_condition} ${loan_bootstrap_label} ${item_localisation} ${item_planned_return}</div>`,
    );
    card.append(card_div);
    return card;
}
</script>
