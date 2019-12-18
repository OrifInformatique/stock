<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * French translations
 *
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

// Application name
$lang['app_title']                      = 'Section informatique<br />Gestion de stock';

// Page titles
$lang['page_prefix']                    = 'Stock';
$lang['page_item_list']                 = 'Liste des objets';
$lang['page_login']                     = 'Connexion';
$lang['page_password_change']           = 'Modification du mot de passe';

// Date and time formats
$lang['date_format_short']              = 'd.m.Y';
$lang['datetime_format_short']          = 'd.m.Y H:i';

// Fields labels
$lang['field_username']                 = 'Identifiant';
$lang['field_name']                     = 'Nom';
$lang['field_firstname']                = 'Prénom';
$lang['field_lastname']                 = 'Nom';
$lang['field_status']                   = 'Statut';
$lang['field_mail']                     = 'Mail';
$lang['field_password']                 = 'Mot de passe';
$lang['field_password_confirm']         = 'Confirmer mot de passe';
$lang['field_new_password']             = 'Nouveau mot de passe';
$lang['field_old_password']             = 'Ancien mot de passe';
$lang['field_abbreviation']             = 'Abréviation';
$lang['field_short']                    = 'court';
$lang['field_short_name']               = 'Nom court';
$lang['field_long_name']                = 'Nom long';
$lang['field_first_adress']             = 'Première ligne d\'adresse';
$lang['field_second_adress']            = 'Deuxième ligne d\'adresse';
$lang['field_postal_code']              = 'NPA';
$lang['field_city']                     = 'Ville';
$lang['field_tel']                      = 'Téléphone';
$lang['field_email']                    = 'E-mail';
$lang['field_tag']                      = 'Tag';
$lang['field_remarks']                  = 'Remarques';
$lang['field_group']                    = 'Groupe';
$lang['field_serial_number']            = 'Numéro de série';
$lang['field_inventory_number']         = 'Numéro d\'inventaire';
$lang['field_inventory_number_abr']     = 'No inventaire';
$lang['field_item_name']                = 'Nom de l\'objet';
$lang['field_item_description']         = 'Description de l\'objet';
$lang['field_item_condition']           = 'État de l\'objet';
$lang['field_image']                    = 'Photo de l\'objet';
$lang['field_image_upload']             = 'Ajoutez une image<br />(hauteur et largeur max. 360px)';
$lang['field_linked_file_upload']       = 'Ajoutez un fichier joint<br />(un seul fichier possible, pdf ou Word, max. 2Mo)';
$lang['field_stocking_place']           = 'Lieu de stockage';
$lang['field_last_inventory_control']   = 'Dernier contrôle d\'inventaire';
$lang['field_inventory_control']        = 'Contrôle d\'inventaire';
$lang['field_current_loan']             = 'Prêt en cours';
$lang['field_loan_date']                = 'Date du prêt';
$lang['field_loan_planned_return']      = 'Retour prévu';
$lang['field_inventory_control_date']   = 'Date du contrôle';
$lang['field_inventory_controller']     = 'Contrôlé par';
$lang['field_supplier']                 = 'Fournisseur';
$lang['field_supplier_ref']             = 'Réf. fournisseur';
$lang['field_buying_price']             = 'Prix d\'achat';
$lang['field_buying_date']              = 'Date d\'achat';
$lang['field_warranty_duration']        = 'Durée de la garantie (en mois)';
$lang['field_tags']                     = 'Type d\'objet';
$lang['field_text_search']              = 'Nom, description, No inventaire, No série';
$lang['field_no_filter']                = 'Aucun filtre';
$lang['field_sort_order']               = 'Trier par';
$lang['field_sort_asc_desc']            = 'Ordre de tri';
$lang['field_take_photo']               = 'Prendre une photo';
$lang['field_import_photo']             = 'Importer une photo';
$lang['field_add_modify_photo']          = 'Ajouter / Modifier une photo';

// Sorting labels
$lang['sort_order_name']                = 'Nom';
$lang['sort_order_stocking_place_id']   = 'Lieu de stockage';
$lang['sort_order_date']                = 'Date d\'achat';
$lang['sort_order_inventory_number']    = 'No d\'inventaire';

$lang['sort_order_asc']                 = 'Ascendant';
$lang['sort_order_des']                 = 'Descendant';

// List headers
$lang['header_picture']                 = 'Photo';
$lang['header_status']                  = 'Disponibilité';
$lang['header_serial_nb']               = 'No de série';
$lang['header_inventory_nb']            = 'No d\'inventaire';
$lang['header_item_name']               = 'Objet';
$lang['header_item_created_by']         = 'Créé par';

$lang['header_loan_date']               = 'Prêté le';
$lang['header_loan_planned_return']     = 'Retour prévu';
$lang['header_loan_real_return']        = 'Retour effectif';
$lang['header_loan_localisation']       = 'Lieu du prêt';
$lang['header_loan_by_user']            = 'Prêté par';
$lang['header_loan_to_user']            = 'Prêté à';
$lang['header_groups']                  = 'Groupes';
$lang['header_stocking_place']          = 'Lieu de stockage';
$lang['header_stocking_places']         = 'Lieux de stockage';

$lang['header_username']                = 'Identifiant';
$lang['header_lastname']                = 'Nom';
$lang['header_firstname']               = 'Prénom';
$lang['header_email']                   = 'E-mail';
$lang['header_user_type']               = 'Statut';
$lang['header_is_active']               = 'Activé';

$lang['header_suppliers_name']          = 'Nom';
$lang['header_suppliers_address_1']     = 'Première ligne d\'addresse';
$lang['header_suppliers_address_2']     = 'Deuxième ligne d\'adresse';
$lang['header_suppliers_NPA']           = 'NPA';
$lang['header_suppliers_city']          = 'Ville';
$lang['header_suppliers_country']       = 'Pays';
$lang['header_suppliers_phone']         = 'Téléphone';
$lang['header_suppliers_email']         = 'E-mail';

// Admin labels
$lang['admin_tab_users']                = 'Utilisateurs';
$lang['admin_tab_tags']                 = 'Tags';
$lang['admin_tab_stocking_places']      = 'Lieux de stockage';
$lang['admin_tab_suppliers']            = 'Fournisseurs';
$lang['admin_tab_item_groups']          = 'Groupes d\'objets';
$lang['admin_tab_admin']                = 'Administration';

// Admin deletion texts
$lang['admin_delete_item_group']        = 'Supprimer le groupe';
$lang['admin_delete_stocking_place']    = 'Supprimer le lieu de stockage';
$lang['admin_delete_tag']               = 'Supprimer le tag';
$lang['admin_delete_user']              = 'Supprimer l\'utilisateur';
$lang['admin_delete_supplier']          = 'Supprimer le fournisseur';
$lang['admin_delete_item']              = 'Supprimer l\'objet';
$lang['admin_delete_tag_verify']        = 'Voulez-vous vraiment supprimer le tag ';
$lang['admin_delete_user_verify']       = 'Voulez-vous vraiment supprimer l\'utilisateur ';
$lang['admin_delete_tag_verify']        = 'Voulez-vous vraiment supprimer le tag ';
$lang['admin_delete_stocking_place_verify'] = 'Voulez-vous vraiment supprimer le lieu de stockage ';
$lang['admin_delete_item_group_verify'] = 'Voulez-vous vraiment supprimer le groupe d\'objets ';
$lang['admin_delete_supplier_verify']   = 'Voulez-vous vraiment supprimer le fournisseur ';
$lang['delete_user_notok']              = 'Cet utilisateur ne peut pas être supprimé car il est lié à des ';
$lang['delete_notok']                   = 'Cet élément ne peut pas être supprimé car il est en cours d\'utilisation par un ou plusieurs objets.';
$lang['delete_notok_with_amount']       = 'Cet élément ne peut pas être supprimé car il est en cours d\'utilisation par ';
$lang['delete_notok_item']              = ' objet.';
$lang['delete_notok_items']             = ' objets.';
$lang['delete_linked_items']            = 'objets';
$lang['delete_linked_loans_registered'] = 'prêts';
$lang['delete_linked_loans_made']       = 'emprunts';


// Admin other labels
$lang['admin_modify']                   = 'Modification';
$lang['admin_delete']                   = 'Suppression';
$lang['admin_add']                      = 'Creation';
$lang['admin_new']                      = 'Nouveau…';
$lang['admin_cancel']                   = 'Annuler';

// Buttons
$lang['btn_admin']                      = 'Administration';
$lang['btn_cancel']                     = 'Annuler';
$lang['btn_change_password']            = 'Modifier le mot de passe';
$lang['btn_new']                        = 'Nouveau';
$lang['btn_modify']                     = 'Modifier';
$lang['btn_delete']                     = 'Supprimer';
$lang['btn_save']                       = 'Sauvegarder';
$lang['btn_login']                      = 'Se connecter';
$lang['btn_logout']                     = 'Se déconnecter';
$lang['btn_signup']                     = 'S\'inscrire';
$lang['btn_back_to_main']               = 'Retour à l\'accueil';
$lang['btn_back_to_list']               = 'Retour à la liste';
$lang['btn_back_to_object']             = 'Retour à l\'objet';
$lang['btn_linked_doc']                 = 'Voir document';
$lang['btn_create_inventory_control']   = 'Nouveau contrôle';
$lang['btn_inventory_control_history']  = 'Historique contrôles';
$lang['btn_loans_history']              = 'Historique des prêts';
$lang['btn_create_loan']                = 'Ajouter un prêt';
$lang['btn_submit_filters']             = 'Appliquer filtres et tri';
$lang['btn_remove_filters']             = 'Supprimer filtres et tri';
$lang['btn_all']                        = 'Tout';
$lang['btn_none']                       = 'Rien';
$lang['btn_generate_inventory_nb']      = 'Générer un No d\'inventaire';

// Messages
$lang['msg_err_abbreviation']           = 'Une abréviation doit être fournie';
$lang['msg_err_invalid_password']       = 'L\'identifiant et le mot de passe ne sont pas valides';
$lang['msg_err_invalid_new_password']   = 'Le nouveau mot de passe et la confirmation ne correspondent pas';
$lang['msg_err_invalid_old_password']   = 'L\'ancien mot de passe n\'est pas valide';
$lang['msg_err_access_denied']          = 'Accès refusé';
$lang['msg_err_email']                  = 'Entrez une adresse email valide ou laisser vide';
$lang['msg_err_id_needed']              = 'Un identifiant unique doit être fourni';
$lang['msg_err_id_used']                = 'Cet identifiant est déjà utilisé';
$lang['msg_err_inexistent_item']        = 'L\'objet auquel vous essayez d\'accéder n\'existe pas';
$lang['msg_err_item_group_needed']      = 'Le groupe d\'objets doit avoir un nom';
$lang['msg_err_item_group_short']       = 'Le groupe d\'objets doit avoir une abréviation';
$lang['msg_err_pwd_length']             = 'Le mot de passe doit faire au moins 6 caractères';
$lang['msg_err_pwg_wrong']              = 'Le mot de passe et la confirmation ne sont pas pareils';
$lang['msg_err_storage_long_needed']    = 'Le lieu de stockage doit avoir un nom long';
$lang['msg_err_storage_short_needed']   = 'Le lieu de stockage doit avoir un nom court';
$lang['msg_err_supplier_needed']        = 'Un nom de fournisseur doit être fourni';
$lang['msg_err_supplier_unique']        = 'Un nom de fournisseur doit être unique';
$lang['msg_err_tag_name_needed']        = 'Un nom de tag doit être fourni';
$lang['msg_err_unique_groupname']       = 'Un nom de groupe unique doit être fourni';
$lang['msg_err_unique_shortname']       = 'Cette abréviation est déjà utilisée';
$lang['msg_err_stocking_needed']        = 'Un nom d\'emplacement unique doit être fourni';
$lang['msg_err_stocking_short_unique']  = 'Un nom court d\'emplacement doit être fourni';
$lang['msg_err_stocking_unique']        = 'Un nom d\'emplacement unique doit être unique';
$lang['msg_err_stocking_short_unique']  = 'Un nom court d\'emplacement doit être unique';
$lang['msg_err_username_used']          = 'Ce nom est déjà utilisé';
$lang['msg_no_loan']                    = 'Aucun prêt à afficher';
$lang['msg_no_inventory_controls']      = 'Aucun contrôle d\'inventaire';
$lang['msg_no_item']                    = 'Aucun objet à afficher';

// Bootstrap labels
$lang['lbl_loan_status_loaned']         = 'En prêt';
$lang['lbl_loan_status_not_loaned']     = 'Pas de prêt en cours';

// Other texts
$lang['text_months']                    = 'mois';
$lang['text_none']                      = 'aucun';
$lang['text_warranty_status']           = [0 => '',
                                           1 => 'Sous garantie',
                                           2 => 'Echéance proche',
                                           3 => 'Garantie Expirée'];
$lang['text_item_detail']               = 'Photo et détail';
$lang['text_item_condition']            = 'Condition';
$lang['text_item_loan_status']          = 'Disponibilité et prêts';
$lang['text_item_buying_warranty']      = 'Achat et garantie';
$lang['text_item_tags']                 = 'Type d\'objet';
$lang['text_search_filters']            = 'Filtres de recherche';
$lang['text_sort_order']                = 'Ordre de tri';
$lang['text_filtered_items_list']       = 'Liste des objets correspondants';
$lang['text_kinds_to_show']             = 'Afficher uniquement les…';
$lang['text_yes']                       = 'Oui';
$lang['text_no']                        = 'Non';
$lang['text_disable']                   = 'Désactiver';
