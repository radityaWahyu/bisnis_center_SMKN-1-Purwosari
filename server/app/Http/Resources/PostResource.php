<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PostResource extends JsonResource
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
            'content' => Str::limit(strip_tags($this->content),150),
            'image' => $this->image,
            'departement_id' => $this->departement,
            'departement_name' => $this->departements->name,
            'publish' => $this->is_publish,
            'viewers' => $this->view_count,
            'user_id' => $this->user,
            'user_name' => $this->users->name,
            'user_level' => $this->users->level,
            'created' => $this->created_at->format('d/m/Y h:i:s'),
            'updated' => $this->updated_at->format('d/m/Y h:i:s')
        ];
    }
}
