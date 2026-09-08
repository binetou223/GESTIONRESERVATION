<?php
namespace App\Repository;

use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;
final class EloquentSalleRepository implements SalleRepositoryInterface
{
     public function lister():array {
        return Salle::all()->all();

     }
    public function retrouver(int $id):?Salle{
        return Salle::find($id);
    }
    public function enregistrer(Salle $salle):Salle{
        $salle->save();
        return $salle;
    }
}

