<?php

namespace App\Exports;

use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Throwable;

class CarsExport implements FromQuery, ShouldQueue
{
    use Exportable, Queueable;

    public $export;

    public function __construct($export)
    {
        $this->export = $export;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return Car::query();
    }

    public function failed(Throwable $exception)
    {
        $this->export->update([
            'status' => 'failed',
        ]);
    }
}
