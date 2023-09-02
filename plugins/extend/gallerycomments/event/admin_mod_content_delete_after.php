<?php

use Sunlight\Database\Database as DB;
use Sunlight\Page\Page;
use Sunlight\Post\Post;

return function (array $args) {
    global $id, $continue, $query;
    if ($continue && $query['type'] == Page::GALLERY) {
        DB::delete('post', 'home=' . $query['id'] . ' AND type=' . Post::PLUGIN . ' AND flag=' . $this->getOptions()['extra']['gallery_comments_flag']);
    }
};