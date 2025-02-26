<?php

/*
 +-----------------------------------------------------------------------+
 | program/steps/mail/addcontact.inc                                     |
 |                                                                       |
 | This file is part of the Roundcube Webmail client                     |
 | Copyright (C) 2005-2009, The Roundcube Dev Team                       |
 | Licensed under the GNU GPL                                            |
 |                                                                       |
 | PURPOSE:                                                              |
 |   Add the submitted contact to the users address book                 |
 |                                                                       |
 +-----------------------------------------------------------------------+
 | Author: Thomas Bruederli <roundcube@gmail.com>                        |
 +-----------------------------------------------------------------------+

 $Id: addcontact.inc 4933 2011-07-18 16:57:15Z thomasb $

*/

// only process ajax requests
if (!$OUTPUT->ajax_call)
  return;

$abook = $RCMAIL->config->get('default_addressbook');

// Get configured addressbook
$CONTACTS = $RCMAIL->get_address_book($abook, true);

// Get first writeable addressbook if the configured doesn't exist
// This can happen when user deleted the addressbook (e.g. Kolab folder)
if ($abook == null || !is_object($CONTACTS)) {
  $source = reset($RCMAIL->get_address_sources(true));
  $CONTACTS = $RCMAIL->get_address_book($source['id'], true);
}

if (!empty($_POST['_address']) && is_object($CONTACTS))
{
  $contact_arr = $IMAP->decode_address_list(get_input_value('_address', RCUBE_INPUT_POST, true), 1, false);

  if (!empty($contact_arr[1]['mailto'])) {
    $contact = array(
      'email' => $contact_arr[1]['mailto'],
      'name' => $contact_arr[1]['name']
    );

    // Validity checks
    if (empty($contact['email'])) {
      $OUTPUT->show_message('errorsavingcontact', 'error');
      $OUTPUT->send();
    }
    
    $email = rcube_idn_to_ascii($contact['email']);
    if (!check_email($email, false)) {
      $OUTPUT->show_message('emailformaterror', 'error', array('email' => $contact['email']));
      $OUTPUT->send();
    }

    $contact['email'] = rcube_idn_to_utf8($contact['email']);
    $contact['name'] = rcube_addressbook::compose_display_name($contact);

    // check for existing contacts
    $existing = $CONTACTS->search('email', $contact['email'], true, false);

    if ($done = $existing->count)
      $OUTPUT->show_message('contactexists', 'warning');
    else {
      $plugin = $RCMAIL->plugins->exec_hook('contact_create', array('record' => $contact, 'source' => null));
      $contact = $plugin['record'];

      $done = !$plugin['abort'] ? $CONTACTS->insert($contact) : $plugin['result'];

      if ($done)
        $OUTPUT->show_message('addedsuccessfully', 'confirmation');
    }
  }
}

if (!$done)
  $OUTPUT->show_message($plugin['message'] ? $plugin['message'] : 'errorsavingcontact', 'error');

$OUTPUT->send();

