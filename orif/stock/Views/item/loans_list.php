<div class="container">
    <!-- BUTTONS -->
	<a href="<?= $_SESSION['items_list_url'] ?: base_url('/item'); ?>"
        class="btn btn-primary" role="button"><?= lang('MY_application.btn_back_to_list'); ?></a>

    <!-- HEADER -->
    <div><h1 class="title-section"><?= lang('MY_application.page_active_loans_list') ?></h1></div>


    <!-- PAGINATION -->
    <div id="pagination_top"></div>

    <!-- LOANS LIST -->
    <div class="col-lg-12 col-sm-12 table-responsive">
        <div class="alert alert-warning" id="no_item_message"><?= htmlspecialchars(lang('MY_application.msg_no_item')); ?></div>
        <div class="alert alert-danger" id="error_message"></div>

        <table class="table" id="table_item">
            <thead>
                <tr>
                    <th><?= htmlspecialchars(lang('MY_application.header_picture')); ?></th>
                    <th><?= htmlspecialchars(lang('MY_application.header_status')); ?></th>
                    <th><?= htmlspecialchars(lang('MY_application.header_item_name')); ?></th>
                    <th><?= htmlspecialchars(lang('MY_application.header_loan_date_start')); ?></th>
                    <th><?= htmlspecialchars(lang('MY_application.header_loan_date_end')); ?></th>
                    <th nowrap><?= htmlspecialchars(lang('MY_application.header_inventory_nb')).'<br />'.htmlspecialchars(lang('MY_application.header_serial_nb')); ?></th>
                </tr>
            </thead>
            <tbody id="list_item">
            </tbody>
        </table>
    </div>
    <div id="pagination_bottom"></div>
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
    href = '<?= base_url("/item/view/"); ?>/'+item["item_id"];
    src_image = '<?= base_url(config('\Stock\Config\StockConfig')->images_upload_path) . "/" ?>'+item["image"];
    alt_image = '<?php htmlspecialchars(lang("MY_application.field_image")); ?>';
    item_condition = item["condition"]["bootstrap_label"];
    item_localisation = item["current_loan"]["loan_id"]!=null ?'<br><h6>'+item["current_loan"]["item_localisation"]+'</h6>':"";
    item_name = item["name"];
    item_description = item["description"];
    date_start = item['loan']['date'];
    date_end = item['loan']['planned_return_date'];
    inventory_number = item["inventory_number"];
    serial_number = item["serial_number"];
    delete_item = '<?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true && $_SESSION["user_access"] >= ACCESS_LVL_ADMIN) { echo "<td><a href=\"".base_url("/item/delete/"); ?>/'+item["item_id"]+'" class=\"close\" title=\"Supprimer l\'objet\">×</a></td> <?php } ?>';

    // Create formatted table row and return it
    var row = $("<tr>");
    if (item['is_late']) row.addClass('alert-warning');

    row.append('<td><a href="'+href+'" style="display:block"><img src="'+src_image+'" width="100px" alt="'+alt_image+'" /></a></td>');
    row.append('<td>'+item_condition+'<br /><br />'+item_localisation+'</td>');
    row.append('<td><a href="'+href+'">'+item_name+'</a><h6>'+item_description+'</h6></td>');
    row.append('<td>'+date_start+'</td>');
    row.append('<td>'+date_end+'</td>');
    row.append('<td><a href="'+href+'">'+inventory_number+'</a><br><a href="'+href+'">'+serial_number+'</a></td>');
    row.append(delete_item);
    row.append('</tr>');

    return row;
}
</script>
