<?php

function my_gallery_default_type_set_link( $settings ) {
    $settings['galleryDefaults']['link'] = 'file';
    $settings['galleryDefaults']['columns'] = 4;
    $settings['galleryDefaults']['size'] = 'medium';

    return $settings;
}
add_filter( 'media_view_settings', 'my_gallery_default_type_set_link');


class NaturalGallerySetting
{
    /**
     * Stores the class instance.
     * @var Custom_Gallery_Setting
     */
    private static $instance = null;

    /**
     * Returns the instance of this class.
     * It's a singleton class.
     * @return Custom_Gallery_Setting The instance
     */
    public static function get_instance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Initialises the plugin.
     */
    public function init_plugin()
    {
        $this->init_hooks();
    }

    /**
     * Initialises the WP actions.
     *  - admin_print_scripts
     */
    private function init_hooks()
    {
        add_action('wp_enqueue_media', array($this, 'wp_enqueue_media'));
        add_action('print_media_templates', array($this, 'print_media_templates'));
    }

    /**
     * Enqueues the script.
     */
    public function wp_enqueue_media()
    {
        if (!isset(get_current_screen()->id) || get_current_screen()->base != 'post') {
            return;
        }

        wp_enqueue_script('natural-gallery-admin-settings', plugins_url('../resources/javascript/adminSettings.js', __FILE__), array('media-views'));
    }

    /**
     * Outputs the view template with the custom setting.
     */
    public function print_media_templates()
    {
        if (!isset(get_current_screen()->id) || get_current_screen()->base != 'post') {
            return;
        }
        ?>
        <script type="text/html" id="tmpl-natural-gallery-setting">
            <label class="setting"><hr><h2>Natural gallery</h2></label>
            <label class="setting"> <span><?php _e('Activate'); ?></span> <input type="checkbox" data-setting="active" checked="checked"> </label>
            <label class="setting"> <span><?php _e('Format'); ?></span>
                <select data-setting="thumbnailformat">
                    <option value="natural"> <?php _e('Natural'); ?> </option>
                    <option value="square"> <?php _e('Square'); ?> </option>
                </select>
            </label>
            <label class="setting"> <span><?php _e('Rows'); ?></span> <input type="text" data-setting="limit" placeholder="0"> </label>
            <label class="setting"> <span><?php _e('Spacing'); ?></span> <input type="text" data-setting="margin" placeholder="1"> </label>
            <label class="setting"> <span><?php _e('Round'); ?></span> <input type="text" data-setting="round" placeholder="0"> </label>
            <label class="setting"> <span><?php _e('Header'); ?></span> <input type="checkbox" data-setting="showheader"> </label>
            <label class="setting"> <span><?php _e('Filters'); ?></span> <input type="checkbox" data-setting="showfilters"> </label>
            <label class="setting"> <span><?php _e('Lightbox'); ?></span> <input type="checkbox" data-setting="lightbox"> </label>
            <label class="setting"> <span><?php _e('Show labels'); ?></span>
                <select data-setting="showlabels">
                    <option value="hover"> <?php _e('On hover'); ?> </option>
                    <option value="true"> <?php _e('Always'); ?> </option>
                    <option value="false"> <?php _e('Never'); ?> </option>
                </select>
            </label>
        </script>
        <?php
    }

}

// Put your hands up...
add_action('admin_init', array(NaturalGallerySetting::get_instance(), 'init_plugin'), 20);
