<?php

/*
 +-----------------------------------------------------------------------+
 | program/steps/mail/attachments.inc                                    |
 |                                                                       |
 | This file is part of the Roundcube Webmail client                     |
 | Copyright (C) 2005-2009, The Roundcube Dev Team                       |
 | Licensed under the GNU GPL                                            |
 |                                                                       |
 | PURPOSE:                                                              |
 |   Upload, remove, display attachments in compose form                 |
 |                                                                       |
 +-----------------------------------------------------------------------+
 | Author: Thomas Bruederli <roundcube@gmail.com>                        |
 +-----------------------------------------------------------------------+

 $Id: attachments.inc 5229 2011-09-16 19:13:27Z thomasb $

*/

// Upload progress update
if (!empty($_GET['_progress'])) {
  rcube_upload_progress();
}

$COMPOSE_ID = get_input_value('_id', RCUBE_INPUT_GPC);
$_SESSION['compose'] = $_SESSION['compose_data_'.$COMPOSE_ID];

if (!$_SESSION['compose']) {
  die("Invalid session var!");
}


// remove an attachment
if ($RCMAIL->action=='remove-attachment')
{
  $id = 'undefined';
  if (preg_match('/^rcmfile(\w+)$/', $_POST['_file'], $regs))
    $id = $regs[1];
  if ($attachment = $_SESSION['compose']['attachments'][$id])
    $attachment = $RCMAIL->plugins->exec_hook('attachment_delete', $attachment);
  if ($attachment['status']) {
    if (is_array($_SESSION['compose']['attachments'][$id])) {
      unset($_SESSION['compose']['attachments'][$id]);
      $OUTPUT->command('remove_from_attachment_list', "rcmfile$id");
    }
  }
  
  $OUTPUT->send();
  exit;
}

if ($RCMAIL->action=='display-attachment')
{
  $id = 'undefined';
  if (preg_match('/^rcmfile(\w+)$/', $_GET['_file'], $regs))
    $id = $regs[1];
  if ($attachment = $_SESSION['compose']['attachments'][$id])
    $attachment = $RCMAIL->plugins->exec_hook('attachment_display', $attachment);
    
  if ($attachment['status']) {
    if (empty($attachment['size']))
      $attachment['size'] = $attachment['data'] ? strlen($attachment['data']) : @filesize($attachment['path']);

    header('Content-Type: ' . $attachment['mimetype']);
    header('Content-Length: ' . $attachment['size']);
    
    if ($attachment['data'])
      echo $attachment['data'];
    else if ($attachment['path'])
      readfile($attachment['path']);
  }
  exit;
}

// attachment upload action

if (!is_array($_SESSION['compose']['attachments'])) {
  $_SESSION['compose']['attachments'] = array();
}

// clear all stored output properties (like scripts and env vars)
$OUTPUT->reset();

$uploadid = get_input_value('_uploadid', RCUBE_INPUT_GET);

if (is_array($_FILES['_attachments']['tmp_name'])) {
  foreach ($_FILES['_attachments']['tmp_name'] as $i => $filepath) {
    // Process uploaded attachment if there is no error
    $err = $_FILES['_attachments']['error'][$i];

    if (!$err) {
      $attachment = array(
        'path' => $filepath,
        'size' => $_FILES['_attachments']['size'][$i],
        'name' => $_FILES['_attachments']['name'][$i],
        'mimetype' => rc_mime_content_type($filepath, $_FILES['_attachments']['name'][$i], $_FILES['_attachments']['type'][$i]),
        'group' => $COMPOSE_ID,
      );

      $attachment = $RCMAIL->plugins->exec_hook('attachment_upload', $attachment);
    }

    if (!$err && $attachment['status'] && !$attachment['abort']) {
      $id = $attachment['id'];

      // store new attachment in session
      unset($attachment['status'], $attachment['abort']);
      $_SESSION['compose']['attachments'][$id] = $attachment;

      if (($icon = $_SESSION['compose']['deleteicon']) && is_file($icon)) {
        $button = html::img(array(
          'src' => $icon,
          'alt' => rcube_label('delete')
        ));
      }
      else {
        $button = Q(rcube_label('delete'));
      }

      $content = html::a(array(
        'href' => "#delete",
        'onclick' => sprintf("return %s.command('remove-attachment','rcmfile%s', this)", JS_OBJECT_NAME, $id),
        'title' => rcube_label('delete'),
      ), $button);

      $content .= Q($attachment['name']);

      $OUTPUT->command('add2attachment_list', "rcmfile$id", array(
        'html' => $content,
        'name' => $attachment['name'],
        'mimetype' => $attachment['mimetype'],
        'complete' => true), $uploadid);
    }
    else {  // upload failed
      if ($err == UPLOAD_ERR_INI_SIZE || $err == UPLOAD_ERR_FORM_SIZE) {
        $msg = rcube_label(array('name' => 'filesizeerror', 'vars' => array('size' => show_bytes(parse_bytes(ini_get('upload_max_filesize'))))));
      }
      else if ($attachment['error']) {
        $msg = $attachment['error'];
      }
      else {
        $msg = rcube_label('fileuploaderror');
      }

      $OUTPUT->command('display_message', $msg, 'error');
      $OUTPUT->command('remove_from_attachment_list', $uploadid);
    }
  }
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // if filesize exceeds post_max_size then $_FILES array is empty,
  // show filesizeerror instead of fileuploaderror
  if ($maxsize = ini_get('post_max_size'))
    $msg = rcube_label(array('name' => 'filesizeerror', 'vars' => array('size' => show_bytes(parse_bytes($maxsize)))));
  else
    $msg = rcube_label('fileuploaderror');
  $OUTPUT->command('display_message', $msg, 'error');
  $OUTPUT->command('remove_from_attachment_list', $uploadid);
}

// send html page with JS calls as response
$OUTPUT->command('auto_save_start', false);
$OUTPUT->send('iframe');

