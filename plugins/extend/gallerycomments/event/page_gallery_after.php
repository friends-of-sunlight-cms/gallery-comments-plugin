<?php

use Sunlight\Post\PostService;
use Sunlight\Settings;

return function (array $args) {
    $args['output'] .= PostService::renderList(
        PostService::RENDER_PLUGIN_POSTS,
        $args['page']['id'],
        [
            Settings::get('commentsperpage'), // comments per page
            true, // can post
            false, // locked
            $this->getOptions()['extra']['gallery_comments_flag'], // plugin flag
            true, // desc
            _lang('posts.comments'), // title
            null // page vars
        ]
    );
};
