<?php

namespace GP_CUSTOMIZE_SCRIPTS;

use WP_Customize_Code_Editor_Control;
use WP_Customize_Manager;

class WP_Customize_Scripts
{
    const CAPACITY = Info::CAPACITY;

    private $namespace;
    private $domain;
    private $page_title;
    private $option_head;
    private $option_body;
    private $option_footer;

    public function __construct()
    {
        add_action('customize_register', [$this, 'customize_register']);
        add_action('admin_menu', [$this, 'add_menu_item'], 100);

        $this->namespace     = Info::get_option_namespace();
        $this->domain        = Info::get_text_domain();

        $this->page_title    = __('Custom scripts', $this->domain);
        $this->option_head   = $this->namespace . '_head';
        $this->option_body   = $this->namespace . '_body';
        $this->option_footer = $this->namespace . '_footer';

        $this->output();
    }

    /**
     * @param WP_Customize_Manager $wp_customize
     */
    public function customize_register($wp_customize)
    {
        // Define new section in wordpress customizer
        $wp_customize->add_section(
            $this->namespace,
            [
                'title'       => $this->page_title,
                'description' =>sprintf(
                    __('%s Use the corresponding tag %s', $this->domain),
                    '<p>',
                    '</p><code>'.htmlentities(
                        '<script> // code </script>'
                    ).'</code>'
                ),
                'priority'    => 190,
            ]
        );

        /**
         * Head
         */
        $wp_customize->add_setting(
            $this->option_head,
            [
                'type' => 'option',
            ]
        );
        $wp_customize->add_control(
            new WP_Customize_Code_Editor_Control(
                $wp_customize,
                $this->option_head,
                [
                    'label'       => 'Script HEAD',
                    'description' => sprintf(
                        __('Insert your code in the  %s head %s section (Google analytics)', $this->domain),
                        '<code>',
                        '</code>'
                    ),
                    'code_type'   => 'javascript',
                    'settings'    => $this->option_head,
                    'section'     => $this->namespace,
                ]
            )
        );

        /**
         * Body
         */
        $wp_customize->add_setting(
            $this->option_body,
            [
                'type' => 'option',
            ]
        );
        $wp_customize->add_control(
            new WP_Customize_Code_Editor_Control(
                $wp_customize,
                $this->option_body,
                [
                    'label'       => esc_html__('Script Open Body', $this->domain),
                    'code_type'   => 'javascript',
                    'description' => sprintf(
                        __('Insert your code right after the opening tag %s body %s', $this->domain),
                        '<code>',
                        '</code>'
                    ),
                    'settings'    => $this->option_body,
                    'section'     => $this->namespace,
                ]
            )
        );

        /**
         * Footer
         */
        $wp_customize->add_setting(
            $this->option_footer,
            [
                'type' => 'option',
            ]
        );
        $wp_customize->add_control(
            new WP_Customize_Code_Editor_Control(
                $wp_customize,
                $this->option_footer,
                [
                    'label'       => esc_html__('Script Footer', $this->domain),
                    'description' =>  sprintf(
                        __('Insert your code in %s footer %s section (Recommended for code using Jquery)', $this->domain),
                        '<code>',
                        '</code>'
                    ),
                    'code_type'   => 'javascript',
                    'settings'    => $this->option_footer,
                    'section'     => $this->namespace,
                ]
            )
        );
    }

    /**
     * Add to Option link to submenu
     */
    public function add_menu_item()
    {
        $menu_slug_url = add_query_arg(
            [
                'autofocus[section]' => $this->namespace
            ],
            'customize.php'
        );

        add_theme_page(
            $this->page_title,
            $this->page_title,
            self::CAPACITY,
            $menu_slug_url
        );

        add_options_page(
            $this->page_title,
            $this->page_title,
            self::CAPACITY,
            $menu_slug_url
        );
    }

    /**
     * Render scripts into specific Hook
     */
    public function output()
    {
        add_action(
            'wp_head',
            function () {
                $this->print_script($this->option_head);
            },
            1
        );

        add_action(
            'wp_footer',
            function () {
                $this->print_script($this->option_footer);
            }
        );

        add_action(
            'wp_body_open',
            function () {
                $this->print_script($this->option_body);
            }
        );
    }

    /**
     * @param $option_name
     */
    public function print_script($option_name)
    {
        $option = get_option($option_name);

        if ('' === $option) {
            return;
        } ?>

        <?php echo $option . "\n"; ?>
        <?php
    }
}
