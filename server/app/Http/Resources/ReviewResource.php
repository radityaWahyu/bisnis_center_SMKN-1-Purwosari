<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'message' => $this->message,
            'item_id' => $this->review_id,
            'item_name' => $this->items->title,
            'parent_id' => $this->parent_id,
            'is_reply' => $this->is_reply,
            'reply' => $this->replies,
            'created' => $this->created_at->format('d/m/Y h:i:s'),
            'updated' => $this->updated_at->format('d/m/Y h:i:s')
        ];
    }
}
