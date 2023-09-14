<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class ReporteProductos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'producto:exports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando genera un reporte de los productos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return DB::table('detalle_facturas')
            ->join('productos', 'detalle_facturas.producto_id', '=', 'productos.id')
            ->select('detalle_facturas.producto_id', 'productos.nombre', DB::raw('SUM(detalle_facturas.cantidad) as total_cantidad'))
            ->groupBy('detalle_facturas.producto_id', 'productos.nombre')
            ->get();
    }
}
