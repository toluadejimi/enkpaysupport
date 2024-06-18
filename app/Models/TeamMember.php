<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;
    protected $appends = ['image'];

    public function getImageAttribute(){
        if ($this->fileAttach){
            return $this->fileAttach->FileUrl;
        }
        return asset('no-image.jpg');

    }

    public function fileAttach()
    {
        return $this->morphOne(FileManager::class, 'origin');
    }
}
