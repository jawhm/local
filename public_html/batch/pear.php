<?php
include 'Net_POP3.php';

$pop3 =& new Net_POP3();

/*
 * Connect to localhost on usual port
 * If not given, defaults are localhost:110
 */
$pop3->connect('axd.sixcore.jp', 110);

/*
* Login using username/password. APOP will
* be tried first if supported, then basic.
*/
$pop3->login('zz_ooya@test.axd.co.jp', '11047');

/*
 * Get the raw headers of message 1
 */
echo '<h2>getRawHeaders()</h2>';
echo '<pre>' . htmlspecialchars($pop3->getRawHeaders(1)) . '</pre>';

/*
 * Get structured headers of message 1
 */
echo '<h2>getParsedHeaders()</h2> <pre>';
print_r($pop3->getParsedHeaders(1));
echo '</pre>';

/*
 * Get body of message 1
 */
echo '<h2>getBody()</h2>';
echo '<pre>' . htmlspecialchars($pop3->getBody(1)) . '</pre>';
/*
* Get number of messages in maildrop
*/
echo '<h2>getNumMsg</h2>';
echo '<pre>' . $pop3->numMsg() . '</pre>';

/*
 * Get entire message
 */
echo '<h2>getMsg()</h2>';
echo '<pre>' . htmlspecialchars($pop3->getMsg(1)) . '</pre>';

/*
 * Get listing details of the maildrop
 */
echo '<h2>getListing()</h2>';
echo '<pre>';
print_r($pop3->getListing());
echo '</pre>';

/*
 * Get size of maildrop
 */
echo '<h2>getSize()</h2>';
echo '<pre>' . $pop3->getSize() . '</pre>';

$pop3->disconnect();
?>