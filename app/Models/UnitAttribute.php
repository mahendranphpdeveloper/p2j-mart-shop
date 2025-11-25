<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitAttribute extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function setTableName($tableName)
    {
        $this->setTable($tableName);
        return $this;
    }
}
