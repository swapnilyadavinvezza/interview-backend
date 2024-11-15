<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ModuleExport implements FromCollection, WithHeadings
{
    private $model,$query,$heading;

    public function __construct($model = null,$query = [],$heading=[])
    {
        $this->model = $model;
        $this->query = $query;
        $this->heading = $heading;
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return $this->query;
        /*$query = $this->model::select(
                "id",
                "name",
                "email",
                "mobile",
                "status",
                "created_at"
            );
        return $query->get();*/
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        return $this->heading;
        /*return [
            "id",
            "name",
            "email",
            "mobile",
            "status",
            "created_at",
        ];*/
    }
}
