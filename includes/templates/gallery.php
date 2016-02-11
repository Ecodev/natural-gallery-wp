<?php

$output = <<<HTML
<div data-galleryid="{$galleryId}" class="natural-gallery" id="natural-gallery-{$galleryId}">

    <script type="text/javascript">
        window.naturalGalleries = window.naturalGalleries || [];

        var naturalGallery = {};
        naturalGallery.id = Number('{$galleryId}');
        naturalGallery.images = {$items};
        naturalGallery.thumbnailMaximumHeight = Number('{$attr['thumbnailmaximumheight']}');
        naturalGallery.round = Number('{$attr['round']}');
        naturalGallery.thumbnailFormat = '{$attr['thumbnailformat']}';
        naturalGallery.imagesPerRow = Number('{$attr['columns']}');
        naturalGallery.margin = Number('{$attr['margin']}');
        naturalGallery.limit = Number('{$attr['limit']}');
        naturalGallery.lightbox = '{$attr['lightbox']}' === 'true';

        window.naturalGalleries.push(naturalGallery);
    </script>
HTML;

$filters .= <<<HTML
filters
    <div>
        <form class="natural-gallery-form form-inline" id="natural-gallery-form-{$galleryId}" method="GET">
            <input type="search"
                   id="natural-gallery-searchTerm-{$galleryId}"
                   placeholder="Search"
                   class="natural-gallery-searchTerm search placeholder"
                   name="tx_naturalGallery_pi1[searchTerm]"/>
        </form>
    </div>
HTML;

if ($attr['showfilters'] === 'true') {
    $output .= $filters;
}

$output .= <<<HTML
    <div class="natural-gallery-main">
        <div class="natural-gallery-body">
            <div class="natural-gallery-noresults">{$translations['none']}</div>
        </div>
        <div class="natural-gallery-footer">
            <div class="natural-gallery-next">
                <a href=""><span>{$translations['more']}</span> &nbsp;</a>
            </div>
            <!--div class="natural-gallery-recordnumber">
                <span class="natural-gallery-numberOfVisibleImages"></span> /
                <span class="natural-gallery-totalImages"></span>
            </div-->
        </div>
    </div>
</div>
HTML;

return $output;
