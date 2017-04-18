<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * French translations
 *
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

// Application name
$lang['app_title']                      = 'Gestion de stock';

// Page titles
$lang['page_prefix']                    = 'Stock';
$lang['page_item_list']                 = 'Liste des objets';

// Date and time formats
$lang['date_format_short']              = 'd.m.Y';
$lang['datetime_format_short']          = 'd.m.Y H:i';

// Fields labels
$lang['field_username']                 = 'Identifiant';
$lang['field_password']                 = 'Mot de passe';
$lang['field_remarks']                  = 'Remarques';
$lang['field_group']                    = 'Groupe';
$lang['field_serial_number']            = 'Numéro de série';
$lang['field_image']                    = 'Photo de l\'objet';
$lang['field_stocking_place']           = 'Lieu de stockage';
$lang['field_current_loan']             = 'Prêt en cours';
$lang['field_loan_date']                = 'Date du prêt';
$lang['field_loan_planned_return']      = 'Retour prévu';
$lang['field_supplier']                 = 'Fournisseur';
$lang['field_supplier_ref']             = 'Réf. fournisseur';
$lang['field_buying_price']             = 'Prix d\'achat';
$lang['field_buying_date']              = 'Date d\'achat';
$lang['field_warranty_duration']        = 'Durée de la garantie';
$lang['field_tags']                     = 'Tags';

// List headers
$lang['header_inventory_nb']            = 'No d\'inventaire';
$lang['header_item_name']               = 'Objet';
$lang['header_item_description']        = 'Description';
$lang['header_item_created_by']         = 'Créé par';

$lang['header_loan_date']               = 'Prêté le';
$lang['header_loan_planned_return']     = 'Retour prévu';
$lang['header_loan_real_return']        = 'Retour effectif';
$lang['header_loan_localisation']       = 'Lieu du prêt';
$lang['header_loan_by_user']            = 'Prêté par';
$lang['header_loan_to_user']            = 'Prêté à';
$lang['header_tags']                    = 'Tags :';
$lang['header_conditions']              = 'Conditions :';
$lang['header_groups']                  = 'Groupes :';
$lang['header_stocking_places']         = 'Lieux de stockage :';

// Buttons
$lang['btn_admin']                      = 'Administration';
$lang['btn_cancel']                     = 'Annuler';
$lang['btn_login']                      = 'Se connecter';
$lang['btn_logout']                     = 'Se déconnecter';
$lang['btn_signup']                     = 'S\'inscrire';
$lang['btn_back_to_main']               = 'Retour à l\'accueil';
$lang['btn_back_to_object']             = 'Retour à l\'objet';
$lang['btn_modify_item']                = 'Modifier';
$lang['btn_delete_item']                = 'Supprimer';
$lang['btn_linked_doc']                 = 'Voir document…';
$lang['btn_loans_history']              = 'Historique des prêts…';
$lang['btn_create_loan']                = 'Ajouter un prêt…';
$lang['btn_submit']                     = 'Sauvegarder';
$lang['btn_submit_filters']             = 'Activer les filtres';
$lang['btn_toggle_filters']             = 'Voir/masquer les filtres';
$lang['btn_all']                        = 'Tout';
$lang['btn_none']                       = 'Rien';

// Messages
$lang['msg_err_invalid_password']       = 'L\'identifiant et le mot de passe ne sont pas valides';
$lang['msg_err_access_denied']          = 'Accès refusé';
$lang['msg_no_loan']                    = 'Aucun prêt à afficher';
$lang['msg_no_item']                    = 'Aucun objet à afficher';

// Other texts
$lang['text_login']                     = 'Connexion';
$lang['text_months']                    = 'mois';
$lang['text_warranty_status']           = [0 => '',
                                           1 => 'Sous garantie',
                                           2 => 'Echéance proche',
                                           3 => 'Garantie Expirée'];
$lang['text_item_detail']               = 'Photo et détail';
$lang['text_item_condition']            = 'Condition';
$lang['text_item_loan_status']          = 'Disponibilité et prêts';
$lang['text_item_buying_warranty']      = 'Achat et garantie';
$lang['text_item_tags']                 = 'Tags';
$lang['text_kinds_to_show']             = 'Afficher uniquement les…';
