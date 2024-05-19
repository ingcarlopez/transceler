<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{

    protected $table = "control.tb_cuentas";

    protected $primaryKey = 'idcuenta';

    public $timestamps = false;

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'idcuenta', 'idcuenta');
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'idcuenta', 'idcuenta');
    }

    public function contactos()
    {
        return $this->hasMany(Contacto::class, 'idcuenta', 'idcuenta');
    }
}
