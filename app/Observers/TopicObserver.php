<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {	
    	// XSS 过滤
    	$topic->body = clean($topic->body, 'default');

        $topic->excerpt = make_excerpt($topic->body);

        if(!$topic->slug) {
        	$topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }
}