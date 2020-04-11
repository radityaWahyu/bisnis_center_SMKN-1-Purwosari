<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityDetailResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        switch ($this->subject_type) {
          case 'App\Post':
            $model_name = "Berita";
            $subject = $this->posts['title'];
            break;
          
          case 'App\Category':
            $model_name = "Kategori";
            $subject = $this->categories['name'];
            break;
          
          case 'App\Departement':
            $model_name = "Jurusan";
            $subject = $this->departements['name'];
            break;
          
          case 'App\Item':
            $model_name = "Produk atau Jasa";
            $subject = $this->items['title'];
            break;
          
          case 'App\Review':
            $model_name = "Ulasan";
            $subject = $this->reviews['message'];
            break;
          
          case 'App\User':
            $model_name = "User";
            $subject = $this->userSubject['name'];
            break;
        }
      
        return [
            'id' => $this->id,
            'type' => $this->description,
            'model' => $model_name,
            'user_name' => $this->users->name,
            'subject' => $subject,
            'description' => $this->properties,
            'ip_address' => $this->ip_address,
            'browser_name' => $this->browser_name,
            'os_name' => $this->os_name,
            'created' => $this->created_at->format('d/m/Y h:i:s'),
            'updated' => $this->updated_at->format('d/m/Y h:i:s')
        ];
    }
}
