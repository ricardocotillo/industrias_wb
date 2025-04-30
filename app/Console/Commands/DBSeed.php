<?php

namespace App\Console\Commands;

use App\Models\Equivalencia;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Producto;
use App\Models\ProductoModelo;
use Illuminate\Console\Command;

class DBSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:db-seed';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import product data from CSV file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file = fopen('datos.csv', 'r');
        
        // Skip header row
        fgetcsv($file);
        
        $products = [];
        $brands = [];
        $models = [];
        $data = [];
        
        // Read all data into array
        while (($row = fgetcsv($file)) !== false) {
            $data[] = $row;
        }
        fclose($file);
        
        // Create brands
        $this->info('Creating brands...');
        foreach ($data as $d) {
            $name = ucfirst(strtolower(trim($d[5])));
            if ($name && !isset($brands[$name])) {
                $brand = Marca::firstOrCreate([
                    'nombre' => $name,
                ]);
                $brands[$brand->nombre] = $brand;
            }
        }
        
        // Create models
        $this->info('Creating models...');
        foreach ($data as $d) {
            $name = ucfirst(strtolower(trim($d[6])));
            $brandName = ucfirst(strtolower(trim($d[5])));
            
            if ($name && !isset($models[$name])) {
                $brand = $brands[$brandName];
                $model = Modelo::firstOrCreate(
                    ['nombre' => $name],
                    ['marca_id' => $brand->id]
                );
                $models[$model->nombre] = $model;
            }
        }
        
        // Create products and product-model relationships
        $this->info('Creating products and associations...');
        foreach ($data as $d) {
            $code = strtoupper(trim($d[0]));
            if (!isset($products[$code])) {
                $product = Producto::firstOrCreate(
                    ['codigo' => $code],
                    [
                        'diametro_interno' => trim($d[1]) ?? null,
                        'diametro_externo' => trim($d[2]) ?? null,
                        # if $d[3] is empty, set it to null
                        'altura' => $d[3] ? trim($d[3]) : null,
                        'aplicaciones' => trim($d[4]) ?? null,
                        'tipo' => trim($d[8]) ?? null,
                        'descripcion' => trim($d[9]) ?? null,
                        'empaquetadura' => trim($d[10]) ?? null,
                        'valv_antidr' => $d[11] ? trim($d[11]) : null,
                        'valv_by_pass' => $d[12] ? trim($d[12]) : null,
                        'pzs_x_caja' => $d[13] ? trim($d[13]) : null,
                    ]
                );
                $products[$code] = $product;
            } else {
                $product = $products[$code];
            }
            
            $modelName = ucfirst(strtolower(trim($d[6])));
            if ($modelName) {
                $model = $models[$modelName];
                
                ProductoModelo::firstOrCreate([
                    'producto_id' => $product->id,
                    'modelo_id' => $model->id,
                    'ano' => (int)trim($d[7])
                ]);
            }
        }
        
        $this->info('Import completed successfully!');
        
        $handle = fopen('equivalencias.csv', 'r');
        
        // Skip header row
        fgetcsv($handle);
        
        $created = 0;
        $skipped = 0;
        
        while (($row = fgetcsv($handle)) !== false) {
            $codigo = trim($row[0]);
            $marca = trim($row[1]);
            $productoCodigo = trim($row[2]);
            
            $producto = Producto::where('codigo', $productoCodigo)->first();
            
            if ($producto) {
                $equivalencia = Equivalencia::firstOrCreate(
                    [
                        'codigo' => $codigo,
                        'marca' => $marca,
                        'producto_id' => $producto->id,
                    ]
                );
                
                if ($equivalencia->wasRecentlyCreated) {
                    $created++;
                } else {
                    $skipped++;
                }
            } else {
                $this->warn("Producto with codigo {$productoCodigo} not found");
                $skipped++;
            }
        }
        
        fclose($handle);
        
        $this->info("Import completed: {$created} created, {$skipped} skipped");
        return 0;
    }
}

