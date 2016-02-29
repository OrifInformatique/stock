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

// Buttons
$lang['btn_cancel']                     = 'Annuler';
$lang['btn_login']                      = 'Se connecter';
$lang['btn_logout']                     = 'Se déconnecter';
$lang['btn_signup']                     = 'S\'inscrire';
$lang['btn_linked_doc']                 = 'Voir document...';
$lang['btn_loans_history']              = 'Historique des prêts...';

// Messages
$lang['msg_err_invalid_password']       = 'L\'identifiant et le mot de passe ne sont pas valides';
$lang['msg_err_access_denied']          = 'Accès refusé';

// Other texts
$lang['text_login']                     = 'Connexion';
$lang['text_months']                    = 'mois';
$lang['text_warranty_status']           = [0 => '',
                                           1 => 'Sous garantie',
                                           2 => 'Echéance proche',
                                           3 => 'Garantie Expirée'];
$lang['text_item_detail']               = 'Photo et détail';
$lang['text_item_loan_status']          = 'Disponibilité';
$lang['text_item_buying_warranty']      = 'Achat et garantie';
$lang['text_item_tags']                 = 'Tags';