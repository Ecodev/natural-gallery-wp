/**
 * Custom Gallery Setting
 */

jQuery(document).ready(function(){

    _.extend(wp.media.gallery.defaults, {
        active: true,
        showfilters: false,
        thumbnailformat: 'natural',
        limit: 0,
        margin: 1,
        round:0
    });

    wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
        template: function(view){
            return wp.media.template('gallery-settings')(view) + wp.media.template('natural-gallery-setting')(view);
        }
    });

});
