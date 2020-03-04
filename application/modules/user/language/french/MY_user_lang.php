<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * French translations for admin module
 * 
 * @author      Orif
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (http://www.orif.ch)
 */

 // Page titles
$lang['title_user_list']                = 'Liste des utilisateurs';
$lang['title_user_update']              = 'Modifier un utilisateur';
$lang['title_user_new']                 = 'Ajouter un utilisateur';
$lang['title_user_delete']              = 'Supprimer un utilisateur';
$lang['title_user_password_reset']      = 'Réinitialiser le mot de passe';
$lang['title_page_login']               = 'Connexion';

// Buttons
$lang['btn_admin']                      = 'Administration';
$lang['btn_login']                      = 'Se connecter';
$lang['btn_logout']                     = 'Se déconnecter';
$lang['btn_change_my_password']         = 'Modifier mon mot de passe';

// Fields labels
$lang['field_username']                 = 'Identifiant';
$lang['field_password']                 = 'Mot de passe';
$lang['field_old_password']             = 'Ancien mot de passe';
$lang['field_new_password']             = 'Nouveau mot de passe';
$lang['field_password_confirm']         = 'Confirmer le mot de passe';
$lang['field_user_name']                = 'Nom d\'utilisateur';
$lang['field_user_usertype']            = 'Type d\'utilisateur';
$lang['field_user_active']              = 'Activé';
$lang['field_deleted_users_display']    = 'Afficher les utilisateurs désactivés';

// Error messages
$lang['msg_err_user_not_exist']         = 'L\'utilisateur sélectionné n\'existe pas';
$lang['msg_err_user_already_inactive']  = 'L\'utilisateur est déjà inactif';
$lang['msg_err_user_already_active']    = 'L\'utilisateur est déjà actif';
$lang['msg_err_user_type_not_exist']    = 'Le type d\'utilisateur n\'existe pas';
$lang['msg_err_user_not_unique']        = 'Ce nom d\'utilisateur est déjà utilisé, merci d\'en choisir un autre';
$lang['msg_err_access_denied_header']   = 'Accès interdit';
$lang['msg_err_access_denied_message']  = 'Vous n\'êtes pas autorisé à accéder à cette fonction';
$lang['msg_err_invalid_password']       = 'L\'identifiant et le mot de passe ne sont pas valides';
$lang['msg_err_invalid_old_password']   = 'L\'ancien mot de passe n\'est pas valide';

// Other texts
$lang['what_to_do']                     = 'Que souhaitez-vous faire ?';
$lang['user']                           = 'Utilisateur';
$lang['user_delete']                    = 'Désactiver ou supprimer cet utilisateur';
$lang['user_reactivate']                = 'Réactiver cet utilisateur';
$lang['user_disabled_info']             = 'Cet utilisateur est désactivé. Vous pouvez le réactiver en cliquant sur le lien correspondant.';
$lang['user_delete_explanation']        = 'La désactivation d\'un compte utilisateur permet de le rendre inutilisable tout en conservant ses informations dans les archives. '
                                         .'Cela permet notamment de garder l\'historique de ses actions.<br><br>'
                                         .'En cas de suppression définitive, toutes les informations concernant cet utilisateur seront supprimées.';
$lang['user_allready_disabled']         = 'Cet utilisateur est déjà désactivé. Voulez-vous le supprimer définitivement ?';
$lang['user_update_usertype_himself']   = 'Vous ne pouvez pas modifier votre propre type d\'utilisateur. Cette opération doit être faite par un autre administrateur.';
$lang['user_delete_himself']            = 'Vous ne pouvez pas désactiver ou supprimer votre propre compte. Cette opération doit être faite par un autre administrateur.';
$lang['page_my_password_change']        = 'Modification de mon mot de passe';
