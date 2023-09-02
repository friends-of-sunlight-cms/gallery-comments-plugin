<?php

use Sunlight\Router;

return function (array $args) {
    if ($args['post']['flag'] == $this->getOptions()['extra']['gallery_comments_flag']) {
        $args['url'] = Router::page($args['post']['id']);
    }
};
