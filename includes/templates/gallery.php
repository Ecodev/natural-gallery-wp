<?php

$output = <<<HTML
<div class="natural-gallery">

    <script type="text/javascript">
        window.naturalGalleries = window.naturalGalleries || [];

        var naturalGallery = {};
        naturalGallery.images = {$items};
        naturalGallery.thumbnailMaximumHeight = Number('{$attr['thumbnailmaximumheight']}');
        naturalGallery.round = Number('{$attr['round']}');
        naturalGallery.thumbnailFormat = '{$attr['thumbnailformat']}';
        naturalGallery.imagesPerRow = Number('{$attr['columns']}');
        naturalGallery.margin = Number('{$attr['margin']}');
        naturalGallery.limit = Number('{$attr['limit']}');
        naturalGallery.lightbox = '{$attr['lightbox']}' == 'true';
        naturalGallery.showLabels = '{$attr['showlabels']}';

        window.naturalGalleries.push(naturalGallery);
    </script>
HTML;

$header = '<div class="natural-gallery-header">';

if ($attr['showFilters'] === 'true') {
    $header .= <<<HTML
        <div class="natural-gallery-searchTerm sectionContainer">
            <svg viewBox="0 0 100 100"><use xlink:href="#icon-search"></use></svg>
            <input type="text" required />
            <label class="sectionName">Rechercher</label>
            <span class="bar"></span>
        </div>
HTML;
}

$header .= <<<HTML

        <div class="natural-gallery-images sectionContainer">
            <svg viewBox="0 0 100 100"><use xlink:href="#icon-pict"></use></svg>
            <div class="sectionName">Images</div>
            <span class="natural-gallery-visible"></span> / <span class="natural-gallery-total"></span>
        </div>
    </div>
HTML;


if ($attr['showheader'] === 'true') {
    $output .= $header;
}

$output .= <<<HTML
    <div class="natural-gallery-body">
        <div class="natural-gallery-noresults">
            <svg viewBox="0 0 100 100"><use xlink:href="#icon-noresults"></use></svg>
        </div>
    </div>

    <div class="natural-gallery-footer">
        <a class="natural-gallery-next">
            <svg viewBox="0 0 100 100"><use xlink:href="#icon-next"></use></svg>
        </a>
    </div>
</div>
HTML;

return $output;
