<?php

namespace Config {
    function set_constants()
    {
        global $max_upload_size_bytes, $theme;
        //  CONSTANT DEFINITION
        //  Override default configuration
        define('USE_CUSTOM_CONFIG', true);
        //TFM version
        define('VERSION', '2.4.3');
        //Application Title
        define('APP_TITLE', 'Gestor de Archivos');

        //  Login Image
        define('LOGIN_IMAGE_PATH', 'sample_logo.png');

        // --- EDIT BELOW CAREFULLY OR DO NOT EDIT AT ALL ---

        // max upload file size
        define('MAX_UPLOAD_SIZE', $max_upload_size_bytes);

        define('FM_THEME', $theme);

        define('APP_HOMEPAGE', 'http://example.com/');

        //  Modes to display files: table|grid
        define('DISPLAY_MODE', 'table');

        // private key and session name to store to the session
        if (!defined('FM_SESSION_ID')) {
            define('FM_SESSION_ID', 'filemanager');
        }
    }

    function set_default_configuration()
    {
        global $CONFIG, $use_auth, $auth_users, $theme, $readonly_users, $use_highlightjs,
            $highlightjs_style, $edit_files, $default_timezone, $root_path, $root_url, $http_host,
            $directories_users, $iconv_input_encoding, $datetime_format, $allowed_file_extensions,
            $allowed_upload_extensions, $favicon_path, $online_viewer, $sticky_navbar,
            $exclude_items, $max_upload_size_bytes, $ip_ruleset, $ip_silent, $ip_whitelist, $ip_blacklist;

        //Default Configuration
        $CONFIG = '{"lang":"es","error_reporting":false,"show_hidden":false,"hide_Cols":true,"calc_folder":true}';
        /**
         * H3K | Tiny File Manager V2.4.3
         * CCP Programmers | ccpprogrammers@gmail.com
         * https://tinyfilemanager.github.io
         */


        // --- EDIT BELOW CONFIGURATION CAREFULLY ---

        // Auth with login/password 
        // set true/false to enable/disable it
        // Is independent from IP white- and blacklisting
        $use_auth = true;

        // Login user name and password
        // Users: array('Username' => 'Password', 'Username2' => 'Password2', ...)
        // Generate secure password hash - https://tinyfilemanager.github.io/docs/pwd.html
        $auth_users = array(
            'admin' => password_hash('admin', PASSWORD_DEFAULT),
            'user' => password_hash('user', PASSWORD_DEFAULT)
        );

        //set application theme
        //options - 'light' and 'dark'
        $theme = 'light';

        // Readonly users 
        // e.g. array('users', 'guest', ...)
        $readonly_users = array(
            'user'
        );

        // Enable highlight.js (https://highlightjs.org/) on view's page
        $use_highlightjs = true;

        // highlight.js style
        // for dark theme use 'ir-black'
        $highlightjs_style = 'vs';

        // Enable ace.js (https://ace.c9.io/) on view's page
        $edit_files = true;

        // Default timezone for date() and time()
        // Doc - http://php.net/manual/en/timezones.php
        $default_timezone = 'America/Managua'; // UTC

        // Root path for file manager
        // use absolute path of directory i.e: '/var/www/folder' or $_SERVER['DOCUMENT_ROOT'].'/folder'
        $root_path = $_SERVER["DOCUMENT_ROOT"] . "/content";

        // Root url for links in file manager.Relative to $http_host. Variants: '', 'path/to/subfolder'
        // Will not working if $root_path will be outside of server document root
        $root_url =  "";

        // Server hostname. Can set manually if wrong
        $http_host = $_SERVER['HTTP_HOST'];

        // user specific directories
        // array('Username' => 'Directory path', 'Username2' => 'Directory path', ...)
        $directories_users = array(
            "admin" => "content",
            "user" => "content/public"
        );

        // input encoding for iconv
        $iconv_input_encoding = 'UTF-8';

        // date() format for file modification date
        // Doc - https://www.php.net/manual/en/function.date.php
        $datetime_format = 'd.m.y H:i';

        // Allowed file extensions for create and rename files
        // e.g. 'txt,html,css,js'
        $allowed_file_extensions = '';

        // Allowed file extensions for upload files
        // e.g. 'gif,png,jpg,html,txt'
        $allowed_upload_extensions = '';

        // Favicon path. This can be either a full url to an .PNG image, or a path based on the document root.
        // full path, e.g http://example.com/favicon.png
        // local path, e.g images/icons/favicon.png
        $favicon_path = '?img=favicon';

        // Files and folders to excluded from listing
        // e.g. array('myfile.html', 'personal-folder', '*.php', ...)
        $exclude_items = array();

        // Online office Docs Viewer
        // Availabe rules are 'google', 'microsoft' or false
        // google => View documents using Google Docs Viewer
        // microsoft => View documents using Microsoft Web Apps Viewer
        // false => disable online doc viewer
        $online_viewer = 'google';

        // Sticky Nav bar
        // true => enable sticky header
        // false => disable sticky header
        $sticky_navbar = true;

        // Maximum file upload size
        // Increase the following values in php.ini to work properly
        // memory_limit, upload_max_filesize, post_max_size
        $max_upload_size_bytes = 2048;

        // Possible rules are 'OFF', 'AND' or 'OR'
        // OFF => Don't check connection IP, defaults to OFF
        // AND => Connection must be on the whitelist, and not on the blacklist
        // OR => Connection must be on the whitelist, or not on the blacklist
        $ip_ruleset = 'OFF';

        // Should users be notified of their block?
        $ip_silent = true;

        // IP-addresses, both ipv4 and ipv6
        $ip_whitelist = array(
            '127.0.0.1',    // local ipv4
            '::1'           // local ipv6
        );

        // IP-addresses, both ipv4 and ipv6
        $ip_blacklist = array(
            '0.0.0.0',      // non-routable meta ipv4
            '::'            // non-routable meta ipv6
        );
    }

    function override_configuration()
    {
        // if User has the customized config file, try to use it to override the default config above
        $config_file = './config.php';
        if (is_readable($config_file)) {
            @include($config_file);
        }
    }

    function define_global_variables()
    {
        global $cfg, $lang, $show_hidden_files, $report_errors, $hide_Cols, $calc_folder, 
            $lang_list;
        // Configuration
        $cfg = new FM_Config();

        // Default language
        $lang = isset($cfg->data['lang']) ? $cfg->data['lang'] : 'en';

        // Show or hide files and folders that starts with a dot
        $show_hidden_files = isset($cfg->data['show_hidden']) ? $cfg->data['show_hidden'] : true;

        // PHP error reporting - false = Turns off Errors, true = Turns on Errors
        $report_errors = isset($cfg->data['error_reporting']) ? $cfg->data['error_reporting'] : true;

        // Hide Permissions and Owner cols in file-listing
        $hide_Cols = isset($cfg->data['hide_Cols']) ? $cfg->data['hide_Cols'] : true;

        // Show directory size: true or speedup output: false
        $calc_folder = isset($cfg->data['calc_folder']) ? $cfg->data['calc_folder'] : true;

        //available languages
        $lang_list = array(
            'en' => 'English',
            'es' => 'Español'
        );

        if ($report_errors == true) {
            @ini_set('error_reporting', E_ALL);
            @ini_set('display_errors', 1);
        } else {
            @ini_set('error_reporting', E_ALL);
            @ini_set('display_errors', 0);
        }
    }

    /**
     * Save Configuration
     */
    class FM_Config
    {
        var $data;

        function __construct()
        {
            global $root_path, $root_url, $CONFIG;
            $fm_url = $root_url . $_SERVER["PHP_SELF"];
            $this->data = array(
                'lang' => 'es',
                'error_reporting' => true,
                'show_hidden' => true
            );
            $data = false;
            if (strlen($CONFIG)) {
                $data = fm_object_to_array(json_decode($CONFIG));
            } else {
                $msg = 'Tiny File Manager<br>Error: Cannot load configuration';
                if (substr($fm_url, -1) == '/') {
                    $fm_url = rtrim($fm_url, '/');
                    $msg .= '<br>';
                    $msg .= '<br>Seems like you have a trailing slash on the URL.';
                    $msg .= '<br>Try this link: <a href="' . $fm_url . '">' . $fm_url . '</a>';
                }
                die($msg);
            }
            if (is_array($data) && count($data)) $this->data = $data;
            else $this->save();
        }

        function save()
        {
            $fm_file = __FILE__;
            $var_name = '$CONFIG';
            $var_value = var_export(json_encode($this->data), true);
            $config_string = "<?php" . chr(13) . chr(10) . "//Default Configuration" . chr(13) . chr(10) . "$var_name = $var_value;" . chr(13) . chr(10);
            if (is_writable($fm_file)) {
                $lines = file($fm_file);
                if ($fh = @fopen($fm_file, "w")) {
                    @fputs($fh, $config_string, strlen($config_string));
                    for ($x = 3; $x < count($lines); $x++) {
                        @fputs($fh, $lines[$x], strlen($lines[$x]));
                    }
                    @fclose($fh);
                }
            }
        }
    }
}

namespace Utils\Http {

    function sanitize_request()
    {
        $_POST["fm_usr"] = strtolower(trim($_POST["fm_usr"]));
    }
}

namespace Utils\Files {
    /**
     * Returns a file extension using its path
     * @param string path
     * @return string
     */
    function get_file_extension($path) {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if($ext && !empty($ext)) {
            return $ext;
        } else {
            return "";
        }
    }
}

namespace Utils\Icons {
    /**
     * Get CSS classname for file
     * @param string $path
     * @return string
     */
    function fm_get_file_icon_class($path)
    {
        // get extension
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        switch ($ext) {
            case 'ico':
            case 'gif':
            case 'jpg':
            case 'jpeg':
            case 'jpc':
            case 'jp2':
            case 'jpx':
            case 'xbm':
            case 'wbmp':
            case 'png':
            case 'bmp':
            case 'tif':
            case 'tiff':
            case 'svg':
                $img = 'fa fa-picture-o';
                break;
            case 'passwd':
            case 'ftpquota':
            case 'sql':
            case 'js':
            case 'json':
            case 'sh':
            case 'config':
            case 'twig':
            case 'tpl':
            case 'md':
            case 'gitignore':
            case 'c':
            case 'cpp':
            case 'cs':
            case 'py':
            case 'map':
            case 'lock':
            case 'dtd':
                $img = 'fa fa-file-code-o';
                break;
            case 'txt':
            case 'ini':
            case 'conf':
            case 'log':
            case 'htaccess':
                $img = 'fa fa-file-text-o';
                break;
            case 'css':
            case 'less':
            case 'sass':
            case 'scss':
                $img = 'fa fa-css3';
                break;
            case 'zip':
            case 'rar':
            case 'gz':
            case 'tar':
            case '7z':
                $img = 'fa fa-file-archive-o';
                break;
            case 'php':
            case 'php4':
            case 'php5':
            case 'phps':
            case 'phtml':
                $img = 'fa fa-code';
                break;
            case 'htm':
            case 'html':
            case 'shtml':
            case 'xhtml':
                $img = 'fa fa-html5';
                break;
            case 'xml':
            case 'xsl':
                $img = 'fa fa-file-excel-o';
                break;
            case 'wav':
            case 'mp3':
                $img = 'fa fa-headphones';
                break;
            case 'mp2':
            case 'm4a':
            case 'aac':
            case 'ogg':
            case 'oga':
            case 'wma':
            case 'mka':
            case 'flac':
            case 'ac3':
            case 'tds':
                $img = 'fa fa-music';
                break;
            case 'm3u':
            case 'm3u8':
            case 'pls':
            case 'cue':
                $img = 'fa fa-headphones';
                break;
            case 'avi':
            case 'mpg':
            case 'mpeg':
            case 'mp4':
            case 'm4v':
            case 'flv':
            case 'f4v':
            case 'ogm':
            case 'ogv':
            case 'mov':
            case 'mkv':
            case '3gp':
            case 'asf':
            case 'wmv':
                $img = 'fa fa-file-video-o';
                break;
            case 'eml':
            case 'msg':
                $img = 'fa fa-envelope-o';
                break;
            case 'xls':
            case 'xlsx':
            case 'ods':
                $img = 'fa fa-file-excel-o';
                break;
            case 'csv':
                $img = 'fa fa-file-text-o';
                break;
            case 'bak':
                $img = 'fa fa-clipboard';
                break;
            case 'doc':
            case 'docx':
            case 'odt':
                $img = 'fa fa-file-word-o';
                break;
            case 'ppt':
            case 'pptx':
                $img = 'fa fa-file-powerpoint-o';
                break;
            case 'ttf':
            case 'ttc':
            case 'otf':
            case 'woff':
            case 'woff2':
            case 'eot':
            case 'fon':
                $img = 'fa fa-font';
                break;
            case 'pdf':
                $img = 'fa fa-file-pdf-o';
                break;
            case 'psd':
            case 'ai':
            case 'eps':
            case 'fla':
            case 'swf':
                $img = 'fa fa-file-image-o';
                break;
            case 'exe':
            case 'msi':
                $img = 'fa fa-file-o';
                break;
            case 'bat':
                $img = 'fa fa-terminal';
                break;
            default:
                $img = 'fa fa-info-circle';
        }

        return $img;
    }
}