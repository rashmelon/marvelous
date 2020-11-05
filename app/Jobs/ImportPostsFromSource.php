<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\Source;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use stdClass;

class ImportPostsFromSource implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $source;

    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    public function handle()
    {
        $this->parseXML()->each(function (stdClass $postData) {
            $this->saveBrandPost($postData);
        });
    }

    protected function parseXML(): Collection
    {
        $json = json_encode(
            simplexml_load_file($this->source->source_url, "SimpleXMLElement", LIBXML_NOCDATA)
        );

        return collect(json_decode($json)->channel->item);
    }

    protected function saveBrandPost(stdClass $postData): Post
    {
        return $this->source->brand->posts()->create(
            $this->mapPostData($postData)
        );
    }

    protected function mapPostData(stdClass $postData): array
    {
        $attributes = '@attributes';

        return [
            'source_id' => $this->source->id,
            'title' => $postData->title,
            'description' => $postData->description,
            'source_url' => $postData->link,
            'image_url' => $postData->enclosure->$attributes->url,
        ];
    }
}
