<div class="container">
    <!-- BUTTONS -->
	<a href="<?= $_SESSION['items_list_url'] ?: base_url('/item'); ?>"
        class="btn btn-primary" role="button"><?= lang('MY_application.btn_back_to_list'); ?></a>

    <!-- HEADER -->
    <div>
        <h1 class="title-section"><?= lang('MY_application.page_active_loans_list') ?></h1>
        <p id="late_loans_count" class="alert alert-danger"></p>
    </div>


    <!-- PAGINATION -->
    <div class="row"><div class="col-12">
        <div id="pagination_top"></div>
    </div></div>

    <!-- LOANS LIST -->
    <div class="alert alert-warning" id="no_item_message"><?= htmlspecialchars(lang('MY_application.msg_no_item')); ?></div>
    <div class="alert alert-danger" id="error_message"></div>

    <div>
        <div class="row" id="list_item"></div>
    </div>

    <!-- PAGINATION -->
    <div class="row"><div class="col-12">
        <div id="pagination_bottom"></div>
    </div></div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    // ******************************************
    // Load items list
    // ******************************************
    // Load parameters in the URL
    let page = location.pathname.split("/").pop();
    load_items(page);
});

// ******************************************
// Load or reload items list corresponding to selected filters
// ******************************************
let populating = false;

function load_items(page){
    if (populating) return;
    populating = true;

    // Display "wait" cursor
    $("*").css("cursor", "wait");

    // Hide or empty elements
    $("#no_item_message").toggle(false);
    $("#error_message").toggle(false);
    $("#table_item").toggle(false);
    $('#late_loans_count').toggle(false);
    $("#list_item").empty();
    $("#pagination_bottom, #pagination_top").empty();


    // URL for ajax call to PHP controller                      Stock\Controllers\
    url = "<?= base_url("/Item/load_list_loans_json")?>"+ "/" + page;

    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var result = JSON.parse(response);
            page = result.number_page;
            history.pushState(null, "", "<?= base_url("item/list_loans/")?>"+ "/"+page);

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

            // Show amount of late items if it's given
            if (result.late_loans_count !== false && result.late_loans_count > 0) {
                $('#late_loans_count').toggle(true);
                $('#late_loans_count').text(`<?= lang('MY_application.msg_late_loans_amount'); ?> : ${result.late_loans_count}`);
            }

            // Change cursor
            $("*").css("cursor", "");
            $(".pagination a").css("cursor", "pointer");
            $(".pagination a").click(function(e){
                e.preventDefault();
                let pageLinkNumber = parseInt(e.target.href.split("=").pop(), 10);
                load_items(pageLinkNumber);
            });

            history.pushState(null, "", "<?= base_url("item/list_loans/")?>"+ "/" +page);
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

function display_item(item){
    // Item's parameters
    let href = '<?= base_url("/item/view/"); ?>/'+item["item_id"];
    let src_image = '<?= base_url(); ?>/'+item["image_path"];
    let alt_image = '<?php htmlspecialchars(lang("MY_application.field_image")); ?>';
    let item_condition = item["condition"]["bootstrap_label"];
    let loan_bootstrap_label = item["current_loan"]["bootstrap_label"];
    let item_localisation = item["current_loan"]["loan_id"]!=null ?'<div class="small">'+item["current_loan"]["item_localisation"]+'</div>':"";
    let item_planned_return = '<div class="small">'+'<?= lang("MY_application.field_loan_planned_return"); ?> : '+item["current_loan"]["planned_return_date"]+'</div>';
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
    card_div.addClass('item rounded bg-light');
    if (item['current_loan']['is_late']) {
        card_div.addClass('border border-danger');
        card_div.css('cssText', 'border-width: 2px !important;');
    }

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
