<?php

namespace App\Http\Resources\DatosAlumnoAcademico;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DatosAlumnoAcademicoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * or
     * null
     */

    public function toArray(Request $request): ?array
    {
        // Verifica si el dato es nulo
        if ($this->resource === null) {
            // Puedes devolver un arreglo vacío u algún valor predeterminado, según tus necesidades.
            return null;
        }
        return [
            'codsem' => $this->codsem,
            'codalumno' => $this->codalumno,
            'tdocumento' => $this->tdocumento,
            'appaterno' => $this->appaterno,
            'apmaterno' => $this->apmaterno,
            'nombre' => $this->nombre,
            'sexo' => $this->sexo,
            'direccion' => $this->direccion,
            'fecnac' => $this->fecnac,
            'mod_ingreso' => $this->mod_ingreso,
            'nombrecolegio' => $this->nombrecolegio,
            'ubigeo' => $this->ubigeo,
            'nomesp' => $this->nomesp,
            'nomfac' => $this->nomfac,
            'telcelular' => $this->telcelular,
            'tel_ref' => $this->tel_ref,
            'email' => $this->email,
            'emailinst' => $this->emailinst,
            'nume_sem_cur' => $this->nume_sem_cur,
            'est_mat_act' => $this->est_mat_act,
            'credmat' => $this->credmat,
            'pps' => $this->pps,
            'ppa' => $this->ppa,
            'artincurso' => $this->artincurso,
            'artpermanencia' => $this->artpermanencia,
            'tca' => $this->tca,
        ];
    }
}
