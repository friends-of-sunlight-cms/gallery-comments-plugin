<?php

namespace SunlightExtend\Gallerycomments;

use Sunlight\Database\Database as DB;
use Sunlight\Page\Page;
use Sunlight\Plugin\ExtendPlugin;
use Sunlight\Post\Post;
use Sunlight\Post\PostService;
use Sunlight\Router;
use Sunlight\Settings;

class GalleryCommentsPlugin extends ExtendPlugin
{
    private const GALLERY_COMMENTS_FLAG = 1000;

    /**
     * Callback to view the comment
     */
    public function onCommentsShow(array $args): void
    {
        $args['output'] .= PostService::renderList(
            PostService::RENDER_PLUGIN_POSTS,
            $args['page']['id'],
            [
                Settings::get('commentsperpage'), // comments per page
                true, // can post
                false, // locked
                self::GALLERY_COMMENTS_FLAG, // plugin flag
                true, // desc
                _lang('posts.comments'), // title
                null // page vars
            ]
        );
    }

    /**
     * Callback for comment validation
     */
    public function onCommentsValidate(array $args): void
    {
        // check the existence of the gallery
        if (DB::count('page', 'id=' . $args['home'] . ' AND type=' . Page::GALLERY) !== 0) {
            $args['valid'] = true;
        }
    }

    /**
     * Callback for comment editing
     */
    public function onCommentsLink(array $args): void
    {
        if ($args['post']['flag'] == self::GALLERY_COMMENTS_FLAG) {
            $args['url'] = Router::page($args['post']['id']);
        }
    }

    /**
     * Callback for backlink comment editing
     */
    public function onCommentsEditBacklink(array $args): void
    {
        if ($args['post']['flag'] == self::GALLERY_COMMENTS_FLAG) {
            $args['backlink'] = Router::page($args['post']['id']) . '#posts';
        }
    }

    /**
     * Callback to delete a comment when deleting a gallery
     */
    public function onCommentsClean(array $args): void
    {
        global $id, $continue, $query;
        if ($continue && $query['type'] == Page::GALLERY) {
            DB::delete('post', 'home=' . $query['id'] . ' AND type=' . Post::PLUGIN . ' AND flag=' . self::GALLERY_COMMENTS_FLAG);
        }
    }
}
