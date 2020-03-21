<?php

namespace GP_CUSTOMIZE_SCRIPTS;

/**
 * The class containing information about the plugin.
 */
class Info
{
    const SLUG = 'gp-customize-scripts';

    const CAPACITY = 'manage_options';

    /**
     * @return string The plugin TextDomain
     */
    public static function get_text_domain()
    {
        return self::get_plugin_data('TextDomain');
    }

    /**
     * @return mixed
     */
    public static function get_version()
    {
        return self::get_plugin_data();
    }

    /**
     * @return string
     */
    public static function get_path()
    {
        return plugin_dir_path(dirname(__FILE__)) . self::SLUG . '.php';
    }

    /**
     * @return string|string[]
     */
    public static function get_option_namespace()
    {
        return str_replace('-', '_', self::SLUG); // gp_customize_custom_scripts
    }

    /**
     * @param string $value
     * @return mixed
     */
    private static function get_plugin_data($value = 'Version')
    {
        if (!function_exists('get_plugin_data')) {
            require_once(ABSPATH . '/wp-admin/includes/plugin.php');
        }

        $plugin_data = get_plugin_data(self::get_path());
        return $plugin_data[$value];
    }
}
