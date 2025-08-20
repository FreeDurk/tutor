<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
{
    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource, public $resourceClass = null)
    {
        parent::__construct($resource);
    }

    public function collect($resource)
    {
        return $this->resourceClass::collection($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'current_page' => $this->currentPage(),
            'data' => $this->collect($this->items()),
            'first_page_url' => $this->url(1),
            'from' => $this->firstItem(),
            'last_page' => $this->lastPage(),
            'last_page_url' => $this->url($this->lastPage()),
            'next_page_url' => $this->nextPageUrl(),
            'path' => $this->path(),
            'per_page' => $this->perPage(),
            'prev_page_url' => $this->previousPageUrl(),
            'to' => $this->lastItem(),
            'total' => $this->total(),
            'links' => $this->formatLinks()
        ];
    }

    protected function formatLinks()
    {
        $links = [];
        $lastPage = $this->lastPage();
        $currentPage = $this->currentPage();

        $links[] = [
            'url' => $this->previousPageUrl(),
            'label' => 'Prev',
            'active' => false,
        ];

        if ($lastPage <= 7) {

            for ($page = 1; $page <= $lastPage; $page++) {
                $links[] = [
                    'url' => $this->url($page),
                    'label' => (string) $page,
                    'active' => $currentPage === $page,
                ];
            }
        } else {

            for ($page = 1; $page <= 2; $page++) {
                $links[] = [
                    'url' => $this->url($page),
                    'label' => (string) $page,
                    'active' => $currentPage === $page,
                ];
            }


            if ($currentPage > 4) {
                $links[] = ['url' => null, 'label' => '...', 'active' => false];
            }


            $start = max(3, min($currentPage - 1, $lastPage - 4));
            $end = min($lastPage - 2, max($currentPage + 1, 5));

            for ($page = $start; $page <= $end; $page++) {
                $links[] = [
                    'url' => $this->url($page),
                    'label' => (string) $page,
                    'active' => $currentPage === $page,
                ];
            }


            if ($end < $lastPage - 2) {
                $links[] = ['url' => null, 'label' => '...', 'active' => false];
            }


            for ($page = $lastPage - 1; $page <= $lastPage; $page++) {
                $links[] = [
                    'url' => $this->url($page),
                    'label' => (string) $page,
                    'active' => $currentPage === $page,
                ];
            }
        }

        $links[] = [
            'url' => $this->nextPageUrl(),
            'label' => 'Next',
            'active' => false,
        ];

        return $links;
    }
}
