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
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The sources to load.
     *
     * @var \App\Models\Source
     */
    private $source;

    /**
     * ImportPostsFromSource constructor.
     *
     * @param  \App\Models\Source  $source
     */
    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    /**
     * Run the job.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->parseXML()->each(function (stdClass $postData) {
            $this->saveBrandPost($postData);
        });
    }

    /**
     * Parse the rss feed xml.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function parseXML(): Collection
    {
        $json = json_encode(
            simplexml_load_file($this->source->source_url, "SimpleXMLElement", LIBXML_NOCDATA)
        );

        return collect(json_decode($json)->channel->item);
    }

    /**
     * Save the post to the db.
     *
     * @param  \stdClass  $postData
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    protected function saveBrandPost(stdClass $postData)
    {
        if (Post::where('guid', $postData->guid)->count()) {
            return false;
        }

        return $this->source->brand->posts()->create(
            $this->mapPostData($postData)
        );
    }

    /**
     * Map post data to local model post data.
     *
     * @param  \stdClass  $postData
     * @return array
     */
    protected function mapPostData(stdClass $postData): array
    {
        $attributes = '@attributes';

        return [
            'guid' => $postData->guid,
            'brand_id' => $this->source->brand->id,
            'source_id' => $this->source->id,
            'title' => $postData->title,
            'description' => $postData->description,
            'source_url' => $postData->link,
            'image_url' => $postData->enclosure->$attributes->url,
        ];
    }
}
