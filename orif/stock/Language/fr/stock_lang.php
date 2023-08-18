<?php
/**
 * French translations for stock module
 * 
 * @author      Orif
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (http://www.orif.ch)
 */

return[
// Page titles
'title_tags'                            => 'Liste des tags',
'title_stocking_places'                 => 'Liste des lieux de stockage',
'title_suppliers'                       => 'Liste des fournisseurs',
'title_item_groups'                     => 'Liste des groupes d\'objets',
'title_entity_list'                     => 'Liste des sites',
'title_excel_export'                    => 'Exportation Excel',
'title_delete_item_common'              => 'Supprimer un objet commun',
'title_delete_item'                     => 'Supprimer un objet',


// Buttons
'btn_tags'                              => 'Tags',
'btn_stocking_places'                   => 'Lieux de stockage',
'btn_suppliers'                         => 'Fournisseurs',
'btn_item_groups'                       => 'Groupes d\'objets',
'btn_add_tag'                           => 'Ajouter un tag',
'btn_add_stocking_place'                => 'Ajouter un lieu de stockage',
'btn_add_supplier'                      => 'Ajouter un fournisseur',
'btn_add_item_group'                    => 'Ajouter un groupe d\'objets',
'btn_soft_delete_tag'                   => 'Désactiver ce tag',
'btn_delete_tag'                        => 'Supprimer ce tag',
'btn_soft_delete_stocking_place'        => 'Désactiver ce lieu de stockage',
'btn_delete_stocking_place'             => 'Supprimer ce lieu de stockage',
'btn_delete_supplier'                   => 'Supprimer ce fournisseur',
'btn_soft_delete_supplier'              => 'Désactiver ce fournisseur',
'btn_soft_delete_item_group'            => 'Désactiver ce groupe d\'objets',
'btn_delete_item_group'                 => 'Supprimer ce groupe d\'objets',
'btn_delete_item_common'                => 'Supprimer cet objet commun',
'btn_delete_item'                       => 'Supprimer cet objet',
'btn_export'                            => 'Exporter',


// Fields labels
'field_active'                          => 'Actif',
'field_name'                            => 'Nom',
'field_description'                     => 'Description',
'field_linked_file'                     => 'Fichier joint',
'field_short_name'                      => 'Nom court',
'field_address'                         => 'Adresse',
'field_first_address_line'              => 'Première ligne d\'adresse',
'field_second_address_line'             => 'Deuxième ligne d\'adresse',
'field_zip'                             => 'NPA',
'field_city'                            => 'Ville',
'field_country'                         => 'Pays',
'field_tel'                             => 'Téléphone',
'field_email'                           => 'E-mail',
'field_deleted_tags'                    => 'Afficher les tags désactivés',
'field_deleted_stocking_places'         => 'Afficher les lieux de stockage désactivés',
'field_deleted_suppliers'               => 'Afficher les fournisseurs désactivés',
'field_deleted_item_groups'             => 'Afficher les groupes d\'objets désactivés',
'field_user_entities'                   => 'Sites attribués',
'field_user_default_entity'             => 'Site principal',
'field_search_item_common'              => 'Rechercher un objet commun',
'field_item_common_name'                => 'Nom de l\'objet commun',
'field_item_common_description'         => 'Description de l\'objet commun',

// Admin other labels   
'admin_modify'                          => 'Modification',
'admin_delete'                          => 'Suppression',
'admin_add'                             => 'Création',
'admin_new'                             => 'Nouveau...',

// Other texts
'what_to_do'                            => 'Que souhaitez-vous faire ?',
'really_delete'                         => 'Voulez-vous vraiment supprimer ce tag?',
'tag'                                   => 'Tag',
'stocking_place'                        => 'Lieu de stockage',
'supplier'                              => 'Fournisseur',
'item_group'                            => 'Groupe d\'objets',
'item_common'                           => 'Objet commun',
'no_item_common_found'                  => 'Aucun objet commun n\'a été trouvé',
'add_item_common_info'                  => 'Un objet commun va être créé',
'add_item_info'                         => 'Un objet sera créé et lié à l\'objet commun:',
'all_item_groups'                       => 'Tous les groupes',

'tag_deletion_explanation'              => 'La désactivation d\'un tag permet de le rendre inutilisable tout en conservant ses informations dans les archives. ' 
                                                . 'Cela permet notamment de garder l\'historique de ses actions. <br> <br>' 
                                                . 'En cas de suppression définitive, toutes les informations concernant ce tag seront supprimées.',
'tag_already_disabled'                  => 'Ce tag est déjà désactivé. Voulez-vous le supprimer définitivement ?',
'delete_tag'                            => 'Désactiver ou supprimer ce tag',
'reactivate_tag'                        => 'Réactiver ce tag',
'hard_delete_tag'                       => 'Supprimer définitivement ce tag',

'delete_stocking_place'                 => 'Désactiver ou supprimer ce lieu de stockage',
'hard_delete_stocking_place'            => 'Supprimer définitivement ce lieu de stockage',
'reactivate_stocking_place'             => 'Réactiver ce lieu de stockage',
'stocking_place_already_disabled'       => 'Ce lieu de stockage est déjà désactivé. Voulez-vous le supprimer définitivement ?',
'stocking_place_deletion_explanation'   => 'La désactivation d\'un lieu de stockage permet de le rendre inutilisable tout en conservant ses informations dans les archives. ' 
                                                . 'Cela permet notamment de garder l\'historique de ses actions. <br> <br>' 
                                                . 'En cas de suppression définitive, toutes les informations concernant ce lieu de stockage seront supprimées.',
'item_common_delete_explanation'        => 'La suppression d\'un objet commun est définitive et toutes les informations des objets liés, ainsi que de l\'objet commun seront supprimées.',
'really_want_to_delete_item_common'     => 'Voulez-vous vraiment supprimer cet objet commun?',
'hard_delete_item_common_explanation'   => 'Toutes ses données ainsi que ses objets liés seront définitivement effacés.',
'item_common_no_item'                   => 'Aucun objet n\'est lié à cet objet commun.',

'item_delete_explanation'               => 'La suppression d\'un objet est définitive et toutes les informations des contrôles d\'inventaire et des prêts seront supprimées.',
'really_want_to_delete_item'            => 'Voulez-vous vraiment supprimer cet objet commun?',
'hard_delete_item_explanation'          => 'Toutes ses données ainsi que ses contrôles d\'inventaires et ses prêts liés seront définitivement effacés.',

'supplier_already_disabled'             => 'Ce fournisseur est déjà désactivé. Voulez-vous le supprimer définitivement ?',
'delete_supplier'                       => 'Désactiver ou supprimer ce fournisseur',
'hard_delete_supplier'                  => 'Supprimer définitivement ce fournisseur',
'reactivate_supplier'                   => 'Réactiver ce fournisseur',
'supplier_already_disabled'             => 'Ce fournisseur est déjà désactivé. Voulez-vous le supprimer définitivement ?',
'supplier_deletion_explanation'         => 'La désactivation d\'un fournisseur permet de le rendre inutilisable tout en conservant ses informations dans les archives. ' 
                                                . 'Cela permet notamment de garder l\'historique de ses actions. <br> <br>' 
                                                . 'En cas de suppression définitive, toutes les informations concernant ce fournisseur seront supprimées.',
'supplier_already_disabled'             => 'Ce fournisseur est déjà désactivé. Voulez-vous le supprimer définitivement ?',

'item_group_already_disabled'           => 'Ce groupe d\'objets est déjà désactivé. Voulez-vous le supprimer définitivement ?',
'delete_item_group'                     => 'Désactiver ou supprimer ce groupe d\'objets',
'hard_delete_item_group'                => 'Supprimer définitivement ce groupe d\'objets',
'reactivate_item_group'                 => 'Réactiver ce groupe d\'objets',
'item_group_already_disabled'           => 'Ce groupe d\'objets est déjà désactivé. Voulez-vous le supprimer définitivement ?',
'item_group_deletion_explanation'       => 'La désactivation d\'un groupe d\'objets permet de le rendre inutilisable tout en conservant ses informations dans les archives. ' 
                                        . 'Cela permet notamment de garder l\'historique de ses actions. <br> <br>' 
                                        . 'En cas de suppression définitive, toutes les informations concernant ce groupe d\'objets seront supprimées.',
'item_group_already_disabled'           => 'Ce groupe d\'objets est déjà désactivé. Voulez-vous le supprimer définitivement ?',
'name'                                  => 'Nom',
'entity_name'                           => 'Nom du site',
'zip_code'                              => 'Numéro postal',
'locality'                              => 'Ville',
'tagname'                               => 'Tag',
'add_entity'                            => 'Ajouter un site',
'update_entity'                         => 'Modifier le site',
'save_and_quit'                         => 'Sauvegarder et revenir au formulaire',
'no_id_found_for_update_error'          => 'Pour modifier un site, il vous faut fournir son id dans l\'url',
'delete_entity_what_to_do'              => 'La désactivation d\'un site permet de le rendre inutilisable tout en conservant ses informations dans les archives.
                                            Cela permet notamment de conserver l\'historique de ses actions.<br><br>
                                            En cas de suppression, toutes les information associées à ce site seront suprimées.',
'group_by'                              => 'Grouper par',
'export_excel_default_service'          => 'Professionnel',
'export_excel_default_section'          => 'Section Informatique',
'export_excel_default_type'             => 'Élément',
'export_excel_default_path'             => 'Services/finances/Interne/Inventaires/Lists/Pomy_22',
'export_excel_site'                     => 'Site',
'export_excel_service'                  => 'Secteur/Service',
'export_excel_section'                  => 'Section/Structure/Ensemble',
'export_excel_piece'                    => 'Pièce/Affectation',
'export_excel_quantity'                 => 'Quantité',
'export_excel_designation'              => 'Désignation',
'export_excel_acquisition_date'         => 'Date d\'acquisition',
'export_excel_unit_price'               => 'Prix unitaire',
'export_excel_total_price'              => 'Prix total',
'export_excel_supplier'                 => 'Fournisseur',
'export_excel_item_responsible'         => 'Responsable de l\'objet',
'export_excel_lifespan'                 => 'Durée de vie',
'export_excel_replacement_date'         => 'Date remplacement',
'export_excel_pick_up_date'             => 'Date de retrait',
'export_excel_pick_up_reason'           => 'Raison du retrait',
'export_excel_type'                     => 'Type d\'élément',
'export_excel_path'                     => 'Chemin d\'accès',

/** ERRORS */
'unauthorized_entity_list'              => 'Vous n\'êtes pas autorisé à consulter le(s) sites demandés',
'msg_err_unique_name'                   => 'Ce nom est déjà utilisé dans ce site',
'msg_err_unique_short_name'             => 'Ce nom court est déjà utilisé dans ce site',
'msg_err_item_group_has_same_entity'    => 'Ce groupe d\'objets ne peut pas être transféré sur un autre site, car des objets lui sont liés.',
'msg_err_stocking_place_has_same_entity'=> 'Ce lieu de stockage ne peut pas être transféré sur un autre site, car des objets lui sont liés.',

/** BTN */
'excel_export_btn'                      => 'Exporter',
/** LABELS **/
'lbl_filter_to_use'                     => 'Filtre à utiliser pour l\'exportation',

// Warning
'no_entity'                             => 'Aucun site n\'a été créé jusqu\'à présent, vous ne pouvez donc pas utiliser la fonction d\'exportation avec les sites.',
'no_selected_entity'                    => 'Aucun site n\'a été sélectionné.',
'no_entity_excel_export'                => 'Vous n\'avez pas accès à la fonctionnalité d\'exportation en Excel, car vous n\'êtes pas encore lié à un site.',
'entity_has_no_items'                   => 'Le site que vous avez sélectionné n\'est lié à aucun objet.',
'msg_no_entities_exist'                 => 'Aucun site n\'a été créé, par défaut tous les objets sont affichés',
'msg_user_has_no_entities'              => 'Vous n\'êtes lié à aucun site, veuillez contacter votre administrateur',
'msg_entities_has_no_items'             => 'Aucun site n\'est lié à un objet',

];