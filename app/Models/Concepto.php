<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concepto extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;
    use SoftDeletes;

    const DELETED_AT = 'deleted_at';

    protected $table = "maestras.tb_conceptos";

    protected $primaryKey = 'idconcepto';

    public $timestamps = false;

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'idconcepto', $value)->withTrashed()->firstOrFail();
    }

    public function tarifas()
    {
        return $this->hasMany(Tarifa::class, 'idconcepto', 'idconcepto');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('concepto_esp', 'like', '%'.Str::headline($search).'%');
            $query->orWhere('concepto_eng', 'like', '%'.Str::headline($search).'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

}
