<?php
/**
 * French translations for user module
 * 
 * @author      Orif
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (http://www.orif.ch)
 */

return[
// Page titles
'title_user_list'                => 'Liste des utilisateurs',
'title_user_update'              => 'Modifier un utilisateur',
'title_user_new'                 => 'Ajouter un utilisateur',
'title_user_delete'              => 'Supprimer un utilisateur',
'title_user_password_reset'      => 'Réinitialiser le mot de passe',
'title_page_login'               => 'Connexion',
'title_administration'           => 'Administration',
'title_register_account'         => 'Enregistrer votre compte',
'title_email_validation'         => 'Validation de l\'e-mail',

// Buttons
'btn_admin'                      => 'Administration',
'btn_login'                      => 'Se connecter',
'btn_logout'                     => 'Se déconnecter',
'btn_connect_with_local_account' => 'Connexion avec un compte local',
'btn_change_my_password'         => 'Modifier mon mot de passe',
'btn_back'                       => 'Retour',
'btn_cancel'                     => 'Annuler',
'btn_save'                       => 'Enregistrer',
'btn_hard_delete_user'           => 'Supprimer cet utilisateur',
'btn_disable_user'               => 'Désactiver cet utilisateur',
'btn_next'                       => 'Suivant',

// Fields labels
'field_username'                 => 'Identifiant',
'field_password'                 => 'Mot de passe',
'field_email'                    => 'Addresse e-mail',
'field_old_password'             => 'Ancien mot de passe',
'field_new_password'             => 'Nouveau mot de passe',
'field_password_confirm'         => 'Confirmer le mot de passe',
'field_usertype'                 => 'Type d\'utilisateur',
'field_user_active'              => 'Activé',
'field_deleted_users_display'    => 'Afficher les utilisateurs désactivés',
'field_login_input'              => 'Identifiant ou e-mail',
'field_verification_code'        => 'Code de vérification',

// Error messages
'msg_err_user_not_exist'         => 'L\'utilisateur sélectionné n\'existe pas',
'msg_err_user_already_inactive'  => 'L\'utilisateur est déjà inactif',
'msg_err_user_already_active'    => 'L\'utilisateur est déjà actif',
'msg_err_user_type_not_exist'    => 'Le type d\'utilisateur n\'existe pas',
'msg_err_username_not_unique'    => 'Cet identifiant est déjà utilisé, merci d\'en choisir un autre',
'msg_err_useremail_not_unique'   => 'Cette adresse e-mail est déjà utilisée, merci d\'en choisir une autre',
'msg_err_access_denied_header'   => 'Accès interdit',
'msg_err_access_denied_message'  => 'Vous n\'êtes pas autorisé à accéder à cette fonction',
'msg_err_invalid_password'       => 'L\'identifiant et le mot de passe ne sont pas valides',
'msg_err_invalid_old_password'   => 'L\'ancien mot de passe n\'est pas valide',
'msg_err_password_not_matches'   => 'Le mot de passe ne coïncide pas avec la confirmation du mot de passe.',
'msg_err_azure_unauthorized'     => 'La connexion avec Microsoft Azure est indisponible. Veuillez vérifier la validité du secret client',
'msg_err_default'                => 'Une erreur est survenue',
'msg_err_azure_no_token'         => 'Azure n\'a pas répondu',
'msg_err_azure_mismatch'         => 'Les tokens ne correspondent pas',
'msg_err_validation_code'        => 'Le code de vérification entré est erroné.',
'msg_err_attempts'               => 'Tentatives restantes: ',

// Error code messages
'azure_error'                    => 'Azure',
'code_error_401'                 => '401 - Non autorisé',
'code_error_403'                 => '403 - Accès refusé',

// Other texts
'what_to_do'                     => 'Que souhaitez-vous faire ?',
'user'                           => 'Utilisateur',
'user_delete'                    => 'Désactiver ou supprimer cet utilisateur',
'user_reactivate'                => 'Réactiver cet utilisateur',
'user_disabled_info'             => 'Cet utilisateur est désactivé. Vous pouvez le réactiver en cliquant sur le lien correspondant.',
'user_delete_explanation'        => 'La désactivation d\'un compte utilisateur permet de le rendre inutilisable tout en conservant ses informations dans les archives. '
                                         .'Cela permet notamment de garder l\'historique de ses actions.<br><br>'
                                         .'En cas de suppression définitive, toutes les informations concernant cet utilisateur seront supprimées.',
'user_allready_disabled'         => 'Cet utilisateur est déjà désactivé. Voulez-vous le supprimer définitivement ?',
'user_update_usertype_himself'   => 'Vous ne pouvez pas modifier votre propre type d\'utilisateur. Cette opération doit être faite par un autre administrateur.',
'user_delete_himself'            => 'Vous ne pouvez pas désactiver ou supprimer votre propre compte. Cette opération doit être faite par un autre administrateur.',
'page_my_password_change'        => 'Modification de mon mot de passe',
'user_first_azure_connexion'     => 'Vous utilisez la connexion Microsoft pour la première fois. Afin d\'enregistrer votre compte, merci d\'indiquer votre adresse e-mail se terminant par @formation.orif.ch ou @orif.ch.',
'user_validation_code'           => 'Un code de vérification a été envoyé sur votre adresse e-mail.<br>Merci d\'entrer ce code.'

];
