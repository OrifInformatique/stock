# Liste de test
- La connexion avec un compte local fonctionne quand on met des identifiants
valides. (`testloginPagePostedWithoutSessionWithUsernameAndPassword`)
- La connexion avec un compte local ne fonctionne pas quand on met des
identifiants invalides.
(`testloginPagePostedWithoutSessionWithUsernameAndIncorrectPassword`)

- L’ajout d’un nouvel utilisateur fonctionne quand on est connecté avec un
compte administrateur. (`testsave_userWithUserId`)
- L’ajout d’un nouvel utilisateur ne fonctionne pas quand on n’est pas connecté
avec un compte administrateur.
- L’édition d’un utilisateur fonctionne quand on est connecté avec un compte
administrateur. (`testsave_userWithUserIdWithSameSessionUserId`)
- L’édition d’un utilisateur ne fonctionne pas quand on n’est pas connecté avec
un compte administrateur.
- La suppression d’un utilisateur fonctionne quand on est connecté avec un
compte administrateur. (`testdelete_userWitDeleteAction`)
- La suppression d’un utilisateur ne fonctionne pas quand on n’est pas connecté
avec un compte administrateur. (`testdelete_userWithoutSession`)
- La désactivation d’un utilisateur fonctionne quand on est connecté avec un
compte administrateur. (`testdelete_userWitDisableAction`)
- La désactivation d’un utilisateur ne fonctionne pas quand on n’est pas
connecté avec un compte administrateur.
- La réactivation d’un utilisateur fonctionne quand on est connecté avec un
compte administrateur. (`testreactivate_userWithExistingUser`)
- La réactivation d’un utilisateur ne fonctionne pas quand on n’est pas
connecté avec un compte administrateur.
 
- Mettre un utilisateur en administrateur fonctionne quand on est connecté avec
un compte administrateur. (`testsave_userWithUserId`)
- Mettre un utilisateur en administrateur ne fonctionne pas quand on n’est pas
connecté avec un compte administrateur.
- L'affichage de la liste des utilisateurs fonctionne quand on est connecté
avec un compte administrateur. (`testlist_userWithAdministratorSession`)
- L'affichage de la liste des utilisateurs ne fonctionne pas quand on n’est pas
connecté avec un compte administrateur.
 
- Modifier le mot de passe fonctionne quand on est connecté à un compte.
(`testpassword_change_user`)
- Modifier le mot de passe ne fonctionne pas quand on n’est pas connecté à un
compte. 
- Modifier le mot de passe ne fonctionne pas quand on ne met pas deux fois le
  même mot de passe.
  (`testpassword_change_userPostedWhenChangingPasswordWithError`)

- Se déconnecter (`testlogout`)

## admin test
- Asserts that the `list_user` page is loaded correctly with disabled users
(`testlist_userWithDisabledUsers`) 
- Asserts that the `list_user` page is loaded correctly without disabled
(after disabling user id 1) (`testlist_userWithoutDisabledUsers`)
- Asserts that the `password_change_user` page redirects to the `list_user` view
for a non existing user (`testpassword_change_userWithNonExistingUser`)
- Asserts that the `delete_user` page is loaded correctly for the user id 1
(with a session) (`testdelete_userWithSessionAndDefaultAction`) 
- Asserts that the `delete_user` page is loaded correctly with a warning
message (`testdelete_userWithSessionAndDefaultActionForADisabledUser`)
- Asserts that the `delete_user` page redirects to the `list_user` view when a
non existing user is given (`testdelete_userWithNonExistingUser`)
- Asserts that the `delete_user` page redirects to the `list_user` view when
fake action is given (`testdelete_userWitFakeAction`)
- Asserts that the `reactivate_user` page redirects to the `list_user` view
when a non existing user is given (`testreactivate_userWithNonExistingUser`)
- Asserts that the `form_user` page is loaded correctly for a new user (no
user id) (`testsave_userWithoutUserId`)
- Asserts that the `form_user` page is loaded correctly for a disabled user id
(`testsave_userWithDisabledUserId`)
- Asserts that the `password_change_user` page redirects to the `list_user` view
after updating the password (POST)
(`testpassword_change_userPostedWhenChangingPassword`)
- Asserts that the `save_user` page redirects to the `list_user` view after
inserting a new user (POST) (`testsave_userPostedForANewUser`)
- Asserts that the `save_user` page is loaded correctly displaying an error
message (`testsave_userPostedForANewUserWithError`)
- Asserts that the `save_user` page redirects to the `list_user` view after
updating an existing user (POST) (`testsave_userPostedForAnExistingUser`)

## authtest
- Asserts that the login page is loaded correctly (no session)
(`testloginPageWithoutSession`)
- Asserts that the session variable `after_login_redirect` is correctly set
when posting the login page
(testloginPagePostedAfterLoginRedirectWithoutSession)
- Asserts that the session variables are correctly set when posting the login
page (simulates a click on button login) email and password are specified
(meaning that the login works)
(`testloginPagePostedWithoutSessionWithUserEmailAndPassword`)
- Asserts that the login page is redirected (`testloginPageWithSession`)
- Asserts that the `change_password` page is redirected (no session)
(`testchange_passwordPageWithoutSession`)
- Asserts that the `change_password` page is loaded correctly (with session)
(`testchange_passwordPageWithSession`)
- Asserts that the `change_password` page redirects to the base url when the
password is changed successfully
(`testchange_passwordPagePostedWithSessionWithOldAndNewPasswords`)
- Asserts that the `change_password` page redirects to the base url when the old
password is invalid
(`testchange_passwordPagePostedWithSessionWithInvalidOldPassword`)
- Asserts that the `change_password` page redirects to the base url when the
confirmed password is invalid
(`testchange_passwordPagePostedWithSessionWithInvalidConfirmedPassword`)

## `User_modelTest`
- Tests that the `check_password_name` correctly checks the user password using
the username (`testcheck_password_name`)
- Tests that the `check_password_name` correctly checks the user password using
the username when the user does not exist in the database
(`testcheck_password_nameWithNonExistingUser`)
- Tests that the `check_password_email` correctly checks the user password using
the user email (`testcheck_password_email`)
- Tests that the `check_password_email` correctly checks the user password using
the username when the user does not exist in the database
(`testcheck_password_emailWithInvalidEmail`)
- Tests that the `check_password_email` correctly checks the user password using
the username when the user does not exist in the database
(`testcheck_password_emailWithNonExistingUserEmailAddress`)
- Tests that the `get_access_level` correctly returns the user access level
(`testget_access_level`)

## Azure
- La création du compte avec azure fonctionne.
    - Envoyer de mail (non testable en l’état)
    - Page de saisi de code reçu par mail, Validation avec le code
        - affiche la page (`test_azure_mail_existed_user_variable_created`)
        - Première tentative de code (`test_azure_mail_without_code`)
        - Échoue à mettre un code correct (`test_azure_mail_with_fake_code`)
        - Échoue 3x à mettre un code correct
        (`test_azure_mail_with_fake_code_all_attemps_done`)
        - Réussi à mettre un code correct
        (`test_azure_mail_with_correct_code_existing_user`)
    - Création du compte avec le bon nom d’utilisateur
    (`test_azure_mail_with_correct_code_new_user`)
- La connexion avec un compte azure fonctionne quand on met des identifiants
valides. (non testable en l’état)
- La connexion avec un compte azure ne fonctionne pas quand on met des
identifiants invalides. (non testable le visiteur reste bloqué chez Microsoft)
- La connexion ne doit pas fonctionner quand le .env n’a pas les bonnes valeurs
    (non testable depuis github action sans secrets)
    - secret client incorrect (`CLIENT_ID` .env)
    (`test_azure_login_begin_client_id_fake`)
    (non testable depuis github action sans secrets)
    - `redirect_uri` incorrect (`test_azure_begin_redirect_uri_fake`)
    (non testable depuis github action sans secrets)
    - `graph_user_scope` incorrect
    (`test_azure_begin_graph_user_scopes_fake`)
    (non testable depuis github action sans secrets)
    - `tenant_id` incorrect (`test_azure_begin_tenant_id_fake`)
    (non testable depuis github action sans secrets)
- La connexion doit continue à l’étape d’après si le .env est correct
(`test_login_begin_with_azure_account`)
- La connexion ne doit pas fonctionner quand code (id de la session qui a
appelé azure) est incorrect (`test_azure_login_code_fake`)
- le serveur SMTP fonctionne (non testable depuis github action sans secrets)
