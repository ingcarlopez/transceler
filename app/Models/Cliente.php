<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;
    use SoftDeletes;

    const DELETED_AT = 'deleted_at';

    protected $table = "ids.tb_clientes";

    protected $primaryKey = 'idcliente';

    public $timestamps = false;

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'idcliente', $value)->withTrashed()->firstOrFail();
    }

    public function contactos()
    {
        return $this->hasMany(Contacto::class, 'idcliente', 'idcliente');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('cliente', 'like', '%'.Str::headline($search).'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
