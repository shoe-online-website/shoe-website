<?php
namespace App\Repositories\Size;

use App\Models\Size;
use App\Repositories\BaseRepository;
use App\Repositories\Size\SizeRepositoryInterface;

class SizeRepository extends BaseRepository implements SizeRepositoryInterface{
    public function getModel(){
        return Size::class;
    }
    public function getSizeBySizeNumber($sizeNumber) {
        return $this->model->where('size_number', $sizeNumber)->first();
    }
}