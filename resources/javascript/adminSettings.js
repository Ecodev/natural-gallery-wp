/**
 * Custom Gallery Setting
 */
//(function($) {
//    var media = wp.media;
//
//    // Wrap the render() function to append controls
//    media.view.Settings.Gallery = media.view.Settings.Gallery.extend({
//        render: function() {
//            media.view.Settings.prototype.render.apply(this, arguments);
//
//            // Append the custom template
//            this.$el.append(media.template('infinite-scroll-gallery-setting'));
//
//            // Custom fields default values
//            var newDefaults = {
//                'activate': true,
//                'format': 'natural',
//                'rows': 12,
//                'margin': 1,
//                'rounded': 0,
//                'size': 'medium'
//            };
//
//            // extend existing default values
//            _.extend(media.gallery.defaults, newDefaults);
//
//            console.log('defaults', media.gallery.defaults);
//
//            // for each element, pre-fill inputs automatically on gallery edit
//            //var self = this;
//            //_.forEach(_.keys(newDefaults), function(el) {
//            //    self.update.apply(self, [el]);
//            //});
//
//            return this;
//        }
//    });
//})(jQuery);


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
            return wp.media.template('gallery-settings')(view) + wp.media.template('infinite-scroll-gallery-setting')(view);
        }
    });

});
