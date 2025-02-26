<?php

/*
+-----------------------------------------------------------------------+
| language/fi_FI/messages.inc                                           |
|                                                                       |
| Language file of the Roundcube Webmail client                         |
| Copyright (C) 2005-2010, The Roundcube Dev Team                       |
| Licensed under the GNU GPL                                            |
|                                                                       |
+-----------------------------------------------------------------------+
| Author: Ville Alatalo <ville@alatalo.org>                             |
|         Veljo Velling <veve@utu.fi>                                   |
|         Jorma Tuomainen <jt@wiza.fi>                                  |
+-----------------------------------------------------------------------+

@version $Id: messages.inc 4410 2011-01-12 18:25:02Z thomasb $

*/

$messages = array();
$messages['loginfailed'] = 'Sisäänkirjautuminen epäonnistui';
$messages['cookiesdisabled'] = 'Selaimesi ei hyväksy evästeitä';
$messages['sessionerror'] = 'Sessio ei kelpaa tai ei ole enää voimassa';
$messages['imaperror'] = 'Yhteys IMAP-palvelimeen epäonnistui';
$messages['servererror'] = 'Palvelin virhe!';
$messages['invalidrequest'] = 'Kelpaamaton pyyntö! Tietoa ei tallennettu.';
$messages['nomessagesfound'] = 'Kansiossa ei ole sähköpostiviestejä';
$messages['loggedout'] = 'Sinut on kirjattu ulos järjestelmästä.';
$messages['mailboxempty'] = 'Kansio on tyhjä';
$messages['loading'] = 'Ladataan...';
$messages['uploading'] = 'Ladataan tiedostoa palvelimelle...';
$messages['loadingdata'] = 'Ladataan tietoja...';
$messages['checkingmail'] = 'Tarkistetaan saapuneita viestejä...';
$messages['sendingmessage'] = 'Lähetetään viestiä...';
$messages['messagesent'] = 'Viesti lähetetty';
$messages['savingmessage'] = 'Tallennetaan viestiä...';
$messages['messagesaved'] = 'Viesti tallennettu "Luonnokset" -kansioon';
$messages['successfullysaved'] = 'Tallennus onnistui';
$messages['addedsuccessfully'] = 'Kontakti lisätty osoitekirjaan';
$messages['contactexists'] = 'Samalla sähköpostiosoitteella on jo olemassa kontakti';
$messages['blockedimages'] = 'Turvallisuussyistä viestin kuvia ei näytetty.';
$messages['encryptedmessage'] = 'Viesti on salattu, eikä sitä voida näyttää.';
$messages['nocontactsfound'] = 'Ei kontakteja';
$messages['contactnotfound'] = 'Pyydettyä yhteystietoa ei löytynyt';
$messages['sendingfailed'] = 'Viestin lähetys epäonnistui';
$messages['senttooquickly'] = 'Odota $sec sekunti(a) ennen viestin lähettämistä';
$messages['errorsavingsent'] = 'Lähetetyn viestin tallennuksessa tapahtui virhe';
$messages['errorsaving'] = 'Tallennuksessa tapahtui virhe';
$messages['errormoving'] = 'Viestiä ei voitu siirtää';
$messages['errorcopying'] = 'Viestiä ei voitu kopioida';
$messages['errordeleting'] = 'Viestiä ei voitu poistaa';
$messages['errormarking'] = 'Viestiä ei voitu merkiä';
$messages['deletecontactconfirm'] = 'Haluatko varmasti poistaa valitut kontaktit?';
$messages['deletemessagesconfirm'] = 'Haluatko varmasti poistaa valitut viestit?';
$messages['deletefolderconfirm'] = 'Haluatko varmasti poistaa kansion?';
$messages['purgefolderconfirm'] = 'Haluatko varmasti poistaa kaikki viestit kansiosta?';
$messages['folderdeleting'] = 'Poistetaan kansiota...';
$messages['foldermoving'] = 'Siirretään kansiota...';
$messages['formincomplete'] = 'Lomakkeen tiedot olivat puutteelliset';
$messages['noemailwarning'] = 'Anna sähköpostiosoite';
$messages['nonamewarning'] = 'Anna nimi';
$messages['nopagesizewarning'] = 'Anna sivukoko';
$messages['nosenderwarning'] = 'Anna lähettäjän sähköpostiosoite';
$messages['norecipientwarning'] = 'Anna ainakin yksi vastaanottaja';
$messages['nosubjectwarning'] = '"Otsikko" -kenttä on tyhjä. Haluaisitko kirjoittaa viestillesi otsikon?';
$messages['nobodywarning'] = 'Lähetetäänkö viesti ilman tekstiä?';
$messages['notsentwarning'] = 'Viestiä ei lähetetty. Haluatko poistaa viestin?';
$messages['noldapserver'] = 'Valitse LDAP -palvelin';
$messages['nocontactsreturned'] = 'Yhtään kontaktia ei löytynyt';
$messages['nosearchname'] = 'Anna kontaktin nimi tai sähköpostiosoite';
$messages['notuploadedwarning'] = 'Kaikkia liitteitä ei ole vielä ladattu palvelimelle. Odota tai peruuta lataus.';
$messages['searchsuccessful'] = 'Löydetty $nr viestiä';
$messages['searchnomatch'] = 'Haku ei tuottanut tuloksia';
$messages['searching'] = 'Etsitään...';
$messages['checking'] = 'Tarkistetaan...';
$messages['nospellerrors'] = 'Kirjoitusvirheitä ei löytynyt';
$messages['folderdeleted'] = 'Kansio poistettu onnistuneesti';
$messages['deletedsuccessfully'] = 'Poistettu onnistuneesti';
$messages['converting'] = 'Poistetaan asettelu viestistä...';
$messages['messageopenerror'] = 'Virhe kopioitaessa viestiä palvelimelta';
$messages['fileuploaderror'] = 'Tiedoston lähettäminen epäonnistui';
$messages['filesizeerror'] = 'Lähetettävä tiedosto ylittää sallitun enimmäiskoon $size';
$messages['copysuccess'] = 'Kopioitu $nr osoitetta onnistuneesti';
$messages['copyerror'] = 'Yhtään osoitetta ei voitu kopioida';
$messages['sourceisreadonly'] = 'Tämän osoitteen lähde on kirjoitussuojattu';
$messages['errorsavingcontact'] = 'Yhteystietoa ei voitu tallentaa';
$messages['movingmessage'] = 'Siirretään viestiä...';
$messages['copyingmessage'] = 'Kopioidaan viestiä...';
$messages['receiptsent'] = 'Lukukuittaus lähetetty onnistuneesti';
$messages['errorsendingreceipt'] = 'Lukukuittausta ei voitu lähettää';
$messages['nodeletelastidentity'] = 'Et voi poistaa tätä identiteettiä, koska se on ainoa jäljelläoleva';
$messages['forbiddencharacter'] = 'Kansion nimessä on kiellettyjä merkkejä';
$messages['selectimportfile'] = 'Valitse lähetettävä tiedosto';
$messages['addresswriterror'] = 'Valittuun osoitekirjaan ei voi kirjoittaa';
$messages['contactaddedtogroup'] = 'Kontaktit lisätty ryhmään';
$messages['contactremovedfromgroup'] = 'Kontaktit poistettu ryhmästä';
$messages['importwait'] = 'Tuodaan, odota...';
$messages['importerror'] = 'Tuonti epäonnistui! Lähetetty tiedosto ei ole vCard -muodossa.';
$messages['importconfirm'] = '<b>$inserted kontaktia tuotu onnistuneesti $inserted kontaktioa, $skipped olemassaolevaa kontaktia hypättiin yli</b>:<p><em>$names</em></p>';
$messages['opnotpermitted'] = 'Toiminto ei ole sallittu!';
$messages['nofromaddress'] = 'Valittu identiteetti ei sisällä sähköpostiosoitetta';
$messages['editorwarning'] = 'Vaihtaminen tekstieditoriin aiheuttaa viestin muotoilun katoamisen. Haluatko jatkaa?';
$messages['httpreceivedencrypterror'] = 'Vakava virhe asetuksissa. Ota välittömästi yhteys ylläpitoon. <b>Viestiäsi ei voida lähettää.</b>';
$messages['smtpconnerror'] = 'SMTP-virhe ($code): Palvelimelle yhdistäminen epäonnistui';
$messages['smtpautherror'] = 'SMTP-virhe ($code): Tunnistus epäonnistui';
$messages['smtpfromerror'] = 'SMTP-virhe ($code): Lähettäjän "$from" asettaminen epäonnistui ($msg)';
$messages['smtptoerror'] = 'SMTP-virhe ($code): Vastaanottajan "$to" lisääminen epäonnistui ($msg)';
$messages['smtprecipientserror'] = 'SMTP-virhe: Ei voida jäsentää vastaanottajien listaa';
$messages['smtperror'] = 'SMTP-virhe: $msg';
$messages['emailformaterror'] = 'Väärä sähköpostiosoite: $email';
$messages['toomanyrecipients'] = 'Liikaa vastaanottajia. Vähennä vastaanottajien määrä maksimiin $max.';
$messages['maxgroupmembersreached'] = 'Ryhmän jäsenten määrä ylittää maksimin $max';

?>
