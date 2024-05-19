<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moneda extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;
    use SoftDeletes;

    const DELETED_AT = 'deleted_at';

    protected $table = "maestras.tb_monedas";

    protected $primaryKey = 'idmoneda';

    public $incrementing = false;

    public $timestamps = false;

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'idmoneda', $value)->withTrashed()->firstOrFail();
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('moneda', 'like', '%'.Str::headline($search).'%');
            $query->orWhere('idmoneda', 'like', '%'.Str::upper($search).'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
