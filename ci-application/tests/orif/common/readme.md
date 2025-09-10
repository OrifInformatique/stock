# set de tests complet pour la liste common/items_list
- Affiche les en-têtes des colonnes dans l’ordre défini.
(`test_arrangement_columns_name`)
- Affiche les valeurs dans l’ordre et sous les bonnes colonnes.
(`test_arrangement_values_by_columns`)


- Affiche le titre si la variable est définie. (`test_title_is_shown`)
- N’affiche pas le titre si la variable est indéfinie. (`test_title_is_hidden`)


- Affiche le bouton d’ajout quand un lien d’ajouter est donné.
(`test_create_button_shown`)
- N’affiche pas le bouton d’ajout quand un lien d’ajout n’est pas donné.
(`test_create_button_hidden`)


- Affiche la case à cocher quand un lien de getView est donné.
(`test_checkbox_shown`)
- N’affiche la case à cocher quand un lien de getView n’est pas donné.
(`test_checkbox_hidden`)


- Affiche l’icône d’édition quand un lien d’édition est donné.
(`test_update_icon_shown`)
- N’affiche pas l’icône d’édition quand le lien d’édition n’est donné pas.
(`test_update_icon_hidden`)


- Affiche l’icône de détail quand un lien de détail est donné.
(`test_details_icon_shown`)
- N’affiche pas l’icône de détail quand le lien de détail n’est donné pas.
(`test_details_icon_hidden`)


- Affiche l’icône de suppression quand un lien de suppression est donné et que
la date de suppression est nulle. (`test_delete_icon_shown`)
- N’affiche pas l’icône de suppression quand le lien de suppression n’est pas
donné ou que la date de suppression est valide. (`test_delete_icon_hidden`)


- Affiche l’icône de suppression rouge quand un lien de suppression est donné
et que la date de suppression est valide. (`test_red_delete_icon_shown`)
- N'affiche pas l’icône de suppression rouge quand un lien de suppression n’est
pas donné ou que la date de suppression est nulle.
(`test_red_delete_icon_hidden`)


- Affiche l’icône de restauration quand un lien de restauration est donné et
que la date de suppression est valide. (`test_restore_icon_shown`)
- N'affiche pas l’icône de restauration quand le lien de restauration n’est pas
donné ou que la date de suppression est nulle. (`test_restore_icon_hidden`)


- Affiche l’icône de duplication quand un lien de duplication est donné.
(`test_duplicate_icon_shown`)
- N’affiche pas l’icône de duplication quand le lien de duplication n’est donné
pas. (`test_duplicate_icon_hidden`)





- Affiche le label par défaut pour le bouton d’ajout quand un lien est donné
mais pas un label. (`test_create_default_label_button_shown`)

- Utilise un nom d’ID par défaut quand le nom n’est pas spécifié.
(`test_default_name_id`)

- Si un nom de colonne n’est pas présent dans les données des objets, cela ne 
fais pas une erreur. (`test_when_column_not_in_item_data`)



# set de tests complet pour l’admin menu
- Affiche le lien pour la liste des utilisateurs
(`test_panel_config_with_administrator_session`)
