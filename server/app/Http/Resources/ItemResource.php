<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => $this->image,
            'category_name' => $this->categories->name,
            'departement_name' => $this->departements->name,
            'user_name' => $this->users->name,
            'user_level' => $this->users->level,
            'is_best' => $this->is_best,
            'review' => $this->review_count,
            'viewer' => $this->view_count,
            'created' => $this->created_at->format('d/m/Y h:i:s'),
            'updated' => $this->updated_at->format('d/m/Y h:i:s')
        ];
    }
}
