<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemDetailResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(!empty($this->departements->users)){
            $name = $this->departements->users->name;
            $phone = $this->departements->users->phone;
        } else {
            $name = null;
            $phone = null;
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'category_id' => $this->category,
            'category_name' => $this->categories->name,
            'departement_id' => $this->departement,
            'departement_name' => $this->departements->name,
            'user_id' => $this->user,
            'user_name' => $this->users->name,
            'contact' => $name,
            'contact_number' => $phone,
            'user_level' => $this->users->level,
            'is_best' => $this->is_best,
            'review' => $this->review_count,
            'viewer' => $this->view_count,
            'created' => $this->created_at->format('d/m/Y h:i:s'),
            'updated' => $this->updated_at->format('d/m/Y h:i:s')
        ];
    }
}
