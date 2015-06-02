<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、MySQL、テーブル接頭辞、秘密鍵、ABSPATH の設定を含みます。
 * より詳しい情報は {@link http://wpdocs.sourceforge.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86 
 * wp-config.php の編集} を参照してください。MySQL の設定情報はホスティング先より入手できます。
 *
 * このファイルはインストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さず、このファイルを "wp-config.php" という名前でコピーして直接編集し値を
 * 入力してもかまいません。
 *
 * @package WordPress
 */

// 注意: 
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.sourceforge.jp/Codex:%E8%AB%87%E8%A9%B1%E5%AE%A4 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'jawhm_fair');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'root');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', 'root');

/** MySQL のホスト名 */
define('DB_HOST', 'localhost');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'cHyw-?BOyD(xWZN1J{V#.v^uwX.4NJC{E L~ng-g#{N>}Q:9g)^E+JSE*#g@]w@,');
define('SECURE_AUTH_KEY',  'F}?fOGn,,`j$2wRn!3>+_&|s;~H-SSANyEnR%z4GQ7=(.t30+R{N>(P.y!n4+~V ');
define('LOGGED_IN_KEY',    'rm<!im8AtO?y$?|g&qQ;%fWQaj3*.vlNRY(X9#QU}@w{LwPd@!N~J>2xBBI`4+mO');
define('NONCE_KEY',        'oO2zv++L%@I)s/#sxRAC#-*A|Z..~d;$lQeJ!R>jEt|W@m Q!U]0KnspDXea/>j7');
define('AUTH_SALT',        ',:~o0fJ6TL5lROK}ddy[?~N7,}#2hdmO~^r138$pYyzWB+s:-xKZCe~=`:}j6Odd');
define('SECURE_AUTH_SALT', 'a?Y,y;i0N%*Sr{KlX[=yhmDE+M+9-omhGNlz*#$/avu4UC/XJ}F_5O?)6xcD~$QA');
define('LOGGED_IN_SALT',   '3B#9p+@X~y]KI6#+:jP}k50#Cjoy|w8iunX&>oy]QWktqQJ$xA$-S GU_5Ojxo(;');
define('NONCE_SALT',       'te,VL9+O)<Pv4;R+R7u-r0eg=*5[`3AH<+$@UT85$%6.I.lD4+nTjc=tXNT,XaE=');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 */
define('WP_DEBUG', false);

//multi site
define('WP_ALLOW_MULTISITE', true);
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'jawhm.localhost');
define('PATH_CURRENT_SITE', '/fair/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

define('FS_METHOD', 'direct');

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
