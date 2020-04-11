<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            break;
          
          case 'App\Category':
            $model_name = "Kategori";
            break;
          
          case 'App\Departement':
            $model_name = "Jurusan";
            break;
          
          case 'App\Item':
            $model_name = "Produk atau Jasa";
            break;
          
          case 'App\Review':
            $model_name = "Ulasan";
            break;
          
          case 'App\User':
            $model_name = "User";
            break;
          
          default:
            $model_name = "User";
            break;
        }
      
        return [
            'id' => $this->id,
            'type' => $this->description,
            'model' => $model_name,
            'user_name' => $this->causer_id == null ? 'Pengunjung' : $this->users->name,
            'ip_address' => $this->ip_address,
            'browser_name' => $this->browser_name,
            'os_name' => $this->os_name,
            'created' => $this->created_at->format('d/m/Y h:i:s'),
            'updated' => $this->updated_at->format('d/m/Y h:i:s')
        ];
    }
}
