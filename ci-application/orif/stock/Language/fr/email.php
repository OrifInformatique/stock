<?php 

return[ 

/**
 * System messages translation for CodeIgniter(tm)
 * @author	CodeIgniter community
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 */
'email_must_be_array'         => "La méthode de validation d'email n'accepte que les tableaux associatifs (array).",
'email_invalid_address'       => "Adresse email invalide : %s",
'email_attachment_missing'    => "Impossible de localiser le fichier joint suivant : %s",
'email_attachment_unreadable' => "Impossible d'ouvrir ce fichier joint : %s",
'email_no_from'               => "Impossible d'envoyer un email sans en-tête \"From\".",
'email_no_recipients'         => "Vous devez spécifier des destinataires: To, Cc, ou Bcc",
'email_send_failure_phpmail'  => "Impossible d'envoyer des emails avec la fonction mail() de PHP. Votre serveur ne doit pas être configuré pour pouvoir utiliser cette méthode.",
'email_send_failure_sendmail' => "Impossible d'envoyer des emails avec la méthode Sendmail de PHP. Votre serveur ne doit pas être configuré pour pouvoir utiliser cette méthode.",
'email_send_failure_smtp'     => "Impossible d'envoyer des emails avec la méthode SMTP de PHP. Votre serveur ne doit pas être configuré pour pouvoir utiliser cette méthode.",
'email_sent'                  => "Votre message a bien été expédié par le protocole suivant : %s",
'email_no_socket'             => "Impossible d'ouvrir un socket avec Sendmail. Veuillez vérifier la configuration de votre environnement.",
'email_no_hostname'           => "Vous n'avez pas spécificé d'hôte SMTP.",
'email_smtp_error'            => "L'erreur SMTP suivante s'est produite : %s",
'email_no_smtp_unpw'          => "Erreur : Vous devez spécifier un nom d'utilisateur et un mot de passe SMTP.",
'email_failed_smtp_login'     => "Échec lors de l'envoi de la commande AUTH LOGIN. Erreur : %s",
'email_smtp_auth_un'          => "Impossible d'identifier le nom d'utilisateur. Erreur : %s",
'email_smtp_auth_pw'          => "Impossible d'identifier le mot de passe. Erreur : %s",
'email_smtp_data_failure'     => "Impossible d'envoyer les données : %s",
'email_exit_status'           => "Code de retour : %s",

 ];