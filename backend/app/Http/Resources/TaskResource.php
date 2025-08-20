<?php

namespace App\Http\Resources;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status = TaskStatus::from($this->status);
        $prio = TaskPriority::from($this->priority);
        
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => [
                'label' => $status->label,
                'value' => $status->value
            ],
            'priority' => [
                'label' => $prio->label,
                'value' => $prio->value
            ],
            'order' => $this->order ?? 0,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
            'user' => $this->whenLoaded('user' , new UserResource($this->user))
        ];
    }
}
