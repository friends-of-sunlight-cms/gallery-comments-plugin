<?php

use Sunlight\Database\Database as DB;
use Sunlight\Page\Page;

return function (array $args) {
    // check the existence of the gallery
    if (DB::count('page', 'id=' . $args['home'] . ' AND type=' . Page::GALLERY) !== 0) {
        $args['valid'] = true;
    }
};
