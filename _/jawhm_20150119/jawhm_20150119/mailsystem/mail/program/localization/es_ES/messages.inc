<?php

/*

+------------------------------------------------------------------------+
| language/es_ES/messages.inc                                            |
|                                                                        |
| Language file of the Roundcube Webmail client                          |
| Copyright (C) 2005-2010, The Roundcube Dev Team                        |
| Licensed under the GNU GPL                                             |
|                                                                        |
+------------------------------------------------------------------------+
| Authors: Javier Smaldone <javier@smaldone.com.ar>                      |
|          David Grajal Blanco <dgrabla@gmail.com>                       |
|          Lito Jornero <jornero@gmail.com>                              |
|          Ángel Bueno Prieto <info@mediaiberia.com>                     |
|          José M. Ciordia <ciordia@gmail.com>                           |
+------------------------------------------------------------------------+

@version $Id: messages.inc 4671 2011-04-20 08:47:44Z thomasb $
*/

$messages = array();
$messages['loginfailed'] = 'Contraseña o nombre de usuario incorrecto';
$messages['cookiesdisabled'] = 'Su navegador no acepta cookies';
$messages['sessionerror'] = 'Su sesión no es válida o ha expirado';
$messages['imaperror'] = 'Error de conexión con el servidor IMAP';
$messages['servererror'] = '¡Error del servidor!';
$messages['servererrormsg'] = 'Error de servidor: $msg';
$messages['errorreadonly'] = 'No se ha podido hacer. La bandeja es sólo de lectura';
$messages['errornoperm'] = 'No se ha podido hacer. Permiso denegado';
$messages['invalidrequest'] = '¡Petición no válida! No se han guardado los datos.';
$messages['nomessagesfound'] = 'No se han encontrado mensajes en esta casilla';
$messages['loggedout'] = 'Ha cerrado bien la sesión. ¡Hasta pronto!';
$messages['mailboxempty'] = 'La casilla está vacía';
$messages['loading'] = 'Cargando...';
$messages['uploading'] = 'Subiendo fichero...';
$messages['loadingdata'] = 'Cargando datos...';
$messages['checkingmail'] = 'Verificando si hay nuevos mensajes...';
$messages['sendingmessage'] = 'Enviando mensaje...';
$messages['messagesent'] = 'Mensaje enviado correctamente';
$messages['savingmessage'] = 'Guardar mensaje...';
$messages['messagesaved'] = 'Mensaje guardado en borradores';
$messages['successfullysaved'] = 'Guardado correctamente';
$messages['addedsuccessfully'] = 'Contacto añadido correctamente a la libreta de direcciones';
$messages['contactexists'] = 'Ya existe un contacto con esta dirección de correo';
$messages['blockedimages'] = 'Para proteger su privacidad, las imágenes externas han sido bloqueadas en este mensaje';
$messages['encryptedmessage'] = 'Este es un mensaje cifrado y no puede ser mostrado. ¡Lo siento!';
$messages['nocontactsfound'] = 'No hay contactos';
$messages['contactnotfound'] = 'El contacto solicitado no existe';
$messages['sendingfailed'] = 'Error al enviar mensaje';
$messages['senttooquickly'] = 'Por favor, espere $sec segundo(s) antes de mandar este mensaje';
$messages['errorsavingsent'] = 'Ha ocurrido un error al guardar el mensaje enviado';
$messages['errorsaving'] = 'Ocurrió un error mientras se guardaba';
$messages['errormoving'] = 'No se ha podido mover el mensaje';
$messages['errorcopying'] = 'No se ha podido copiar el/los mensaje(s)';
$messages['errordeleting'] = 'No se ha podido eliminar el mensaje';
$messages['errormarking'] = 'No se ha podido marcar el mensaje';
$messages['deletecontactconfirm'] = '¿Realmente quiere eliminar los contactos seleccionados?';
$messages['deletemessagesconfirm'] = '¿Realmente quiere eliminar los mensajes seleccionados?';
$messages['deletefolderconfirm'] = '¿Realmente quiere eliminar esta bandeja?';
$messages['purgefolderconfirm'] = '¿Realmente quiere eliminar todos los mensajes de esta bandeja?';
$messages['folderdeleting'] = 'Borrando bandeja...';
$messages['foldermoving'] = 'Moviendo bandeja...';
$messages['foldersubscribing'] = 'Suscribiendo bandeja...';
$messages['folderunsubscribing'] = 'Anulando suscripción a bandeja...';
$messages['formincomplete'] = 'No ha rellenado todos los campos del formulario';
$messages['noemailwarning'] = 'Por favor, introduzca un email válido';
$messages['nonamewarning'] = 'Por favor, introduzca su nombre';
$messages['nopagesizewarning'] = 'Por favor, introduzca un tamaño de página';
$messages['nosenderwarning'] = 'Por favor, introduzca el email del emisor';
$messages['norecipientwarning'] = 'Por favor, introduzca al menos un destinatario';
$messages['nosubjectwarning'] = 'El campo "Asunto" está vacío. ¿Desea completarlo en este momento?';
$messages['nobodywarning'] = '¿Quiere enviar este mensaje sin texto?';
$messages['notsentwarning'] = 'El mensaje no ha sido enviado. ¿Desea descartar su mensaje?';
$messages['noldapserver'] = 'Por favor, seleccione un servidor LDAP para buscar';
$messages['nocontactsreturned'] = 'No se han encontrado contactos';
$messages['nosearchname'] = 'Por favor, introduzca un nombre o la dirección de e-mail';
$messages['notuploadedwarning'] = 'No se han subido aún todos los adjuntos. Por favor espere o cancele la subida.';
$messages['searchsuccessful'] = 'Se encontraron $nr mensajes';
$messages['searchnomatch'] = 'No se obtuvieron resultados';
$messages['searching'] = 'Buscando...';
$messages['checking'] = 'Revisando...';
$messages['nospellerrors'] = 'No se encontraron errores ortográficos';
$messages['folderdeleted'] = 'Bandeja eliminada correctamente';
$messages['foldersubscribed'] = 'Suscripción a bandeja anulada correctamente';
$messages['folderunsubscribed'] = 'Suscrito a bandeja correctamente';
$messages['folderpurged'] = 'Bandeja purgada correctamente';
$messages['folderexpunged'] = 'Bandeja vaciada correctamente';
$messages['deletedsuccessfully'] = 'Eliminado correctamente';
$messages['converting'] = 'Quitando el formato del mensaje...';
$messages['messageopenerror'] = 'No puedo descargar el mensaje del servidor';
$messages['fileuploaderror'] = 'Error al subir archivos';
$messages['filesizeerror'] = 'El archivo excede el tamaño máximo ($size)';
$messages['copysuccess'] = '$nr direcciones copiadas correctamente';
$messages['copyerror'] = 'No se pudo copiar ninguna dirección';
$messages['sourceisreadonly'] = 'Esta dirección es de sólo lectura';
$messages['errorsavingcontact'] = 'No se pudo guardar la dirección de contacto';
$messages['movingmessage'] = 'Moviendo mensaje...';
$messages['copyingmessage'] = 'Copiando mensaje...';
$messages['deletingmessage'] = 'Eliminando mensaje(s)...';
$messages['markingmessage'] = 'Marcando mensaje(s)...';
$messages['receiptsent'] = 'La notificación de lectura se ha enviado correctamente.';
$messages['errorsendingreceipt'] = 'No se ha podido enviar la notificación de lectura.';
$messages['nodeletelastidentity'] = 'No se puede borrar esta identidad puesto que es la última.';
$messages['forbiddencharacter'] = 'El nombre de la bandeja contiene un carácter prohibido';
$messages['selectimportfile'] = 'Por favor, seleccione un archivo para subir';
$messages['addresswriterror'] = 'No se puede escribir la dirección de contacto seleccionada';
$messages['contactaddedtogroup'] = 'Se han añadido correctamente los contactos a este grupo.';
$messages['contactremovedfromgroup'] = 'Se han borrado correctamente los contactos de este grupo.';
$messages['importwait'] = 'Importando, espere...';
$messages['importerror'] = '¡Error al importar! Este archivo no es un formato válido vCard.';
$messages['importconfirm'] = '<b>Se han insertado: $inserted contactos, y se han omitido: $skipped porque ya existían</b>:<p><em>$names</em></p>';
$messages['importconfirmskipped'] = 'Ignorar $skipped entradas existentes';
$messages['opnotpermitted'] = '¡Operación no permitida!';
$messages['nofromaddress'] = 'El contacto seleccionado no tiene dirección de e-mail';
$messages['editorwarning'] = 'Cambiando a texto plano perderá el formato del mensaje. ¿Desea continuar?';
$messages['httpreceivedencrypterror'] = 'Ha ocurrido un error fatal de configuración. Contacte inmediatamente a su administrador. <b>Su mensaje no ha sido enviado.</b>';
$messages['smtpconnerror'] = 'Error SMTP ($code): Ha fallado la conexión al servidor';
$messages['smtpautherror'] = 'Error SMTP ($code): Error de autenticación';
$messages['smtpfromerror'] = 'Error SMTP ($code): No se ha podido asignar el emisor "$from" ($msg)';
$messages['smtptoerror'] = 'Error SMTP ($code): No se ha podido establecer remitente "$to" ($msg)';
$messages['smtprecipientserror'] = 'Error SMTP: No es posible analizar la lista de destinatarios';
$messages['smtpdsnerror'] = 'Error SMTP: No hay soporte para los acuses de recibo';
$messages['smtperror'] = 'Error SMTP: $msg';
$messages['emailformaterror'] = 'Dirección e-mail incorrecta: $email';
$messages['toomanyrecipients'] = 'Hay demasiados destinatarios. Reduzca el número de destinatarios a $max.';
$messages['maxgroupmembersreached'] = 'El número de miembros del grupo excede el máximo de $max.';
$messages['internalerror'] = 'Ocurrió un error interno. Por favor, inténtalo de nuevo';
$messages['contactdelerror'] = 'No se ha podido eliminar el contacto(s)';
$messages['contactdeleted'] = 'Contacto(s) eliminado(s) correctamente';
$messages['groupdeleted'] = 'Grupo eliminado correctamente';
$messages['grouprenamed'] = 'Grupo renombrado correctamente';
$messages['groupcreated'] = 'Grupo creado correctamente';
$messages['messagedeleted'] = 'Mensaje(s) eliminado(s) correctamente';
$messages['messagemoved'] = 'Mensaje(s) movido(s) correctamente';
$messages['messagecopied'] = 'Mensaje(s) copiado(s) correctamente';
$messages['messagemarked'] = 'Mensaje(s) marcado(s) correctamente';
$messages['autocompletechars'] = 'Introduce al menos $min caracteres para autocompletar';
$messages['namecannotbeempty'] = 'Hay que poner el nombre';
$messages['nametoolong'] = 'El nombre es demasiado largo';
$messages['folderupdated'] = 'Bandeja actualizada correctamente';
$messages['foldercreated'] = 'Bandeja creada correctamente';
$messages['invalidimageformat'] = 'No es un formato de imagen válido';

?>
