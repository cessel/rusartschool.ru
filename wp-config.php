<?php
/**
 * Основные параметры WordPress.
 *
 * Этот файл содержит следующие параметры: настройки MySQL, префикс таблиц,
 * секретные ключи, язык WordPress и ABSPATH. Дополнительную информацию можно найти
 * на странице {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Кодекса. Настройки MySQL можно узнать у хостинг-провайдера.
 *
 * Этот файл используется сценарием создания wp-config.php в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать этот файл
 * с именем "wp-config.php" и заполнить значения.
 *
 * @package WordPress
 */
// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */


define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
define('DOMAIN_CURRENT_SITE', 'rusartschool.ru');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

define('DB_NAME', 'cesselhm_wp3');

/** Имя пользователя MySQL */
define('DB_USER', 'cesselhm_wp3');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'tffqeZqkV');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется снова авторизоваться.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'D Pspr|,#<-dm<$w`|Jz9{Pz,[mL|JGFF{5;vQTUu1~!,)=D$Rq!]$xF{GsYU[I_');
define('SECURE_AUTH_KEY',  '+et3bC4RAe(WF&pY24&qGcC%}&>~VFNE+%{dSBr0D6kRRa]~K}xevSZD|P3RLR};');
define('LOGGED_IN_KEY',    'g-`Txxf~T0Y{hpc+i_+1]<V0PfzfX 3[iK5ZhV.P=%l[y5%wx!5!_#bq~sW(R]6~');
define('NONCE_KEY',        'TXOb#.$I/z9{K(Q8i-F2K:5TG%%3,<J7SdTb_m^=|n]Td6#doY_>,3^Z7EvpJ5N=');
define('AUTH_SALT',        ',c!dq;9eM0UERZsS)v/hlxrBsLn$W-ilh[&^Q$X}M)RGt]ihkU!4ZG/K`wU%z^1p');
define('SECURE_AUTH_SALT', '.(Pj16ySp+JsxEE;LN1^f#%P|w-{}pHGiINM%o+EcZ>XD>R*IdyV#|:WS$XJ$|9i');
define('LOGGED_IN_SALT',   'f|+XAz_I+h8Ohk^W&Od93JXi##v>6XoM1>V8A63-d`pZR1h>[<o]  GLYng/Il|A');
define('NONCE_SALT',       'Bi(2- s;xmPD8Fu-L:-+Q+N|-79+H Ql SJXq VA{sTj8-yIY|sLLUZk/vfL31/(');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько блогов в одну базу данных, если вы будете использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Язык локализации WordPress, по умолчанию английский.
 *
 * Измените этот параметр, чтобы настроить локализацию. Соответствующий MO-файл
 * для выбранного языка должен быть установлен в wp-content/languages. Например,
 * чтобы включить поддержку русского языка, скопируйте ru_RU.mo в wp-content/languages
 * и присвойте WPLANG значение 'ru_RU'.
 */
define('WPLANG', 'ru_RU');

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Настоятельно рекомендуется, чтобы разработчики плагинов и тем использовали WP_DEBUG
 * в своём рабочем окружении.
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );
//define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', true );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
