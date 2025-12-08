<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    // Define properties
    public $status;
    public $message;
    public $resource;

    /**
     * __construct
     *
     * @param  mixed $status
     * @param  mixed $message
     * @param  mixed $resource
     * @return void
     */
    public function __construct($status, $message, $resource)
    {
        parent::__construct($resource);
        $this->status  = $status;
        $this->message = $message;
    }

    /**
     * toArray
     *
     * @param  mixed $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        // Check if resource is null
        if (!$this->resource) {
            return [
                'success' => $this->status,
                'message' => $this->message,
                'data'    => null, // No data available if resource is null
            ];
        }

        // Check if resource is a collection or paginator
        if ($this->resource instanceof \Illuminate\Pagination\AbstractPaginator) {
            $data = $this->resource->getCollection()->map(function ($post) {
                return [
                    'id'            => $post->id,
                    'image'         => $post->image,
                    'title'         => $post->title,
                    'content'       => $post->content,
                    'price'         => $post->price,
                    'is_preorder'   => (bool) $post->is_preorder,
                    'category_name' => $post->category ? $post->category->name : null,
                    'stock'         => $post->productStock ? $post->productStock->stock : null,
                    'created_at'    => $post->created_at,
                    'updated_at'    => $post->updated_at,
                ];
            });

            return [
                'success' => $this->status,
                'message' => $this->message,
                'data'    => [
                    'current_page' => $this->resource->currentPage(),
                    'data'         => $data,
                    'last_page'    => $this->resource->lastPage(),
                    'per_page'     => $this->resource->perPage(),
                    'total'        => $this->resource->total(),
                ],
            ];
        }

        // Single resource
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data'    => [
                'id'            => $this->resource->id,
                'image'         => $this->resource->image,
                'title'         => $this->resource->title,
                'content'       => $this->resource->content,
                'price'         => $this->resource->price,
                'is_preorder'   => (bool) $this->resource->is_preorder,
                'category_name' => $this->resource->category ? $this->resource->category->name : null,
                'stock'         => $this->resource->productStock ? $this->resource->productStock->stock : null,
                'created_at'    => $this->resource->created_at,
                'updated_at'    => $this->resource->updated_at,
            ],
        ];
    }
}
