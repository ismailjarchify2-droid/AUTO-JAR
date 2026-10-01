<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVehicleCompatibility;
use App\Models\Setting;
use App\Models\User;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\VehicleYear;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@pieceauto.ma'],
            [
                'name' => 'Administrateur',
                'password' => 'password',
                'is_admin' => true,
                'phone' => '0522000000',
            ]
        );

        $settings = [
            'company_name' => 'AUTO-JAR',
            'company_tagline' => 'Votre pièce automobile, simplement.',
            'phone' => '0522123456',
            'phone_display' => '05 22 12 34 56',
            'mobile' => '0612345678',
            'mobile_display' => '06 12 34 56 78',
            'whatsapp' => '212612345678',
            'whatsapp_display' => '06 12 34 56 78',
            'email' => 'contact@pieceauto.ma',
            'address' => 'Boulevard Zerktouni, Casablanca',
            'city' => 'Casablanca',
            'hours' => 'Lun–Sam : 09h00 – 19h00',
            'facebook' => '#',
            'instagram' => '#',
            'meta_description' => 'Catalogue de pièces automobiles au Maroc. Trouvez la pièce adaptée à votre véhicule à Casablanca, Rabat, Marrakech et partout au Maroc.',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value, 'general');
        }

        $categories = [
            ['name' => 'Freinage', 'slug' => 'freinage', 'description' => 'Plaquettes, disques, étriers et freins à main.'],
            ['name' => 'Filtres', 'slug' => 'filtres', 'description' => 'Filtres à huile, air, habitacle et carburant.'],
            ['name' => 'Allumage', 'slug' => 'allumage', 'description' => 'Bougies, bobines et câbles d\'allumage.'],
            ['name' => 'Suspension', 'slug' => 'suspension', 'description' => 'Amortisseurs, rotules et triangles.'],
            ['name' => 'Éclairage', 'slug' => 'eclairage', 'description' => 'Phares, feux, ampoules LED et H7.'],
            ['name' => 'Embrayage', 'slug' => 'embrayage', 'description' => 'Kits d\'embrayage et butées.'],
            ['name' => 'Distribution', 'slug' => 'distribution', 'description' => 'Courroies, galets et pompes à eau.'],
            ['name' => 'Refroidissement', 'slug' => 'refroidissement', 'description' => 'Radiateurs, thermostats et durites.'],
            ['name' => 'Électricité', 'slug' => 'electricite', 'description' => 'Alternateurs, démarreurs et batteries.'],
            ['name' => 'Carrosserie', 'slug' => 'carrosserie', 'description' => 'Rétroviseurs, pare-chocs et accessoires.'],
        ];

        foreach ($categories as $i => $cat) {
            Category::query()->updateOrCreate(
                ['slug' => $cat['slug']],
                array_merge($cat, ['is_active' => true, 'sort_order' => $i + 1])
            );
        }

        $partBrands = ['Bosch', 'Valeo', 'NGK', 'Mann-Filter', 'Sachs', 'Monroe', 'Brembo', 'Delphi', 'Continental', 'Febi'];
        foreach ($partBrands as $name) {
            Brand::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'is_active' => true]
            );
        }

        $vehicles = [
            'Dacia' => ['Logan', 'Sandero', 'Duster', 'Lodgy'],
            'Renault' => ['Clio', 'Megane', 'Symbol', 'Kangoo', 'Captur'],
            'Peugeot' => ['208', '301', '308', '2008', 'Partner'],
            'Citroën' => ['C3', 'C4', 'Berlingo', 'C-Elysée'],
            'Volkswagen' => ['Golf', 'Polo', 'Passat', 'Tiguan'],
            'Toyota' => ['Yaris', 'Corolla', 'Hilux', 'RAV4'],
            'Hyundai' => ['i10', 'i20', 'Tucson', 'Accent'],
            'BMW' => ['Série 1', 'Série 3', 'X1', 'X3'],
            'Mercedes-Benz' => ['Classe A', 'Classe C', 'Classe E', 'GLA'],
            'Fiat' => ['Punto', 'Tipo', 'Doblo', '500'],
        ];

        foreach ($vehicles as $brandName => $models) {
            $vBrand = VehicleBrand::query()->updateOrCreate(
                ['slug' => Str::slug($brandName)],
                ['name' => $brandName, 'is_active' => true]
            );

            foreach ($models as $modelName) {
                $vModel = VehicleModel::query()->updateOrCreate(
                    [
                        'vehicle_brand_id' => $vBrand->id,
                        'slug' => Str::slug($modelName),
                    ],
                    ['name' => $modelName, 'is_active' => true]
                );

                foreach (range(2015, 2024) as $year) {
                    VehicleYear::query()->firstOrCreate([
                        'vehicle_model_id' => $vModel->id,
                        'year' => $year,
                    ]);
                }
            }
        }

        $this->seedProducts();
    }

    private function seedProducts(): void
    {
        $products = [
            ['name' => 'Plaquettes de frein avant', 'ref' => 'BF-DAC-001', 'brand' => 'Brembo', 'cat' => 'freinage', 'price' => 289.00, 'stock' => 45, 'vehicle' => ['Dacia', 'Logan']],
            ['name' => 'Disques de frein avant ventilés', 'ref' => 'BF-REN-014', 'brand' => 'Bosch', 'cat' => 'freinage', 'price' => 520.00, 'stock' => 22, 'vehicle' => ['Renault', 'Clio']],
            ['name' => 'Filtre à huile', 'ref' => 'FO-MAN-220', 'brand' => 'Mann-Filter', 'cat' => 'filtres', 'price' => 65.00, 'stock' => 120, 'vehicle' => ['Peugeot', '208']],
            ['name' => 'Filtre à air habitacle', 'ref' => 'FA-BOS-088', 'brand' => 'Bosch', 'cat' => 'filtres', 'price' => 95.00, 'stock' => 80, 'vehicle' => ['Volkswagen', 'Golf']],
            ['name' => 'Filtre à carburant diesel', 'ref' => 'FC-DEL-331', 'brand' => 'Delphi', 'cat' => 'filtres', 'price' => 145.00, 'stock' => 35, 'vehicle' => ['Dacia', 'Duster']],
            ['name' => 'Bougies d\'allumage iridium', 'ref' => 'BA-NGK-412', 'brand' => 'NGK', 'cat' => 'allumage', 'price' => 180.00, 'stock' => 60, 'vehicle' => ['Toyota', 'Corolla']],
            ['name' => 'Bobine d\'allumage', 'ref' => 'BO-BOS-019', 'brand' => 'Bosch', 'cat' => 'allumage', 'price' => 340.00, 'stock' => 18, 'vehicle' => ['Hyundai', 'i20']],
            ['name' => 'Amortisseur avant gauche', 'ref' => 'AM-MON-501', 'brand' => 'Monroe', 'cat' => 'suspension', 'price' => 475.00, 'stock' => 12, 'vehicle' => ['Renault', 'Megane']],
            ['name' => 'Rotule de suspension', 'ref' => 'RS-FEB-077', 'brand' => 'Febi', 'cat' => 'suspension', 'price' => 210.00, 'stock' => 40, 'vehicle' => ['Peugeot', '308']],
            ['name' => 'Kit d\'embrayage 3 pièces', 'ref' => 'KE-SAC-090', 'brand' => 'Sachs', 'cat' => 'embrayage', 'price' => 1250.00, 'stock' => 8, 'vehicle' => ['Dacia', 'Sandero']],
            ['name' => 'Courroie de distribution kit', 'ref' => 'CD-CON-215', 'brand' => 'Continental', 'cat' => 'distribution', 'price' => 890.00, 'stock' => 15, 'vehicle' => ['Citroën', 'C3']],
            ['name' => 'Pompe à eau', 'ref' => 'PE-VAL-044', 'brand' => 'Valeo', 'cat' => 'distribution', 'price' => 390.00, 'stock' => 20, 'vehicle' => ['Fiat', 'Punto']],
            ['name' => 'Radiateur de refroidissement', 'ref' => 'RR-VAL-118', 'brand' => 'Valeo', 'cat' => 'refroidissement', 'price' => 780.00, 'stock' => 6, 'vehicle' => ['BMW', 'Série 3']],
            ['name' => 'Thermostat moteur', 'ref' => 'TH-BOS-033', 'brand' => 'Bosch', 'cat' => 'refroidissement', 'price' => 165.00, 'stock' => 28, 'vehicle' => ['Mercedes-Benz', 'Classe C']],
            ['name' => 'Ampoule H7 LED', 'ref' => 'AH-BOS-707', 'brand' => 'Bosch', 'cat' => 'eclairage', 'price' => 220.00, 'stock' => 90, 'vehicle' => ['Volkswagen', 'Polo']],
            ['name' => 'Phare avant droit', 'ref' => 'PA-VAL-203', 'brand' => 'Valeo', 'cat' => 'eclairage', 'price' => 1450.00, 'stock' => 4, 'vehicle' => ['Renault', 'Clio']],
            ['name' => 'Alternateur 120A', 'ref' => 'AL-VAL-560', 'brand' => 'Valeo', 'cat' => 'electricite', 'price' => 1680.00, 'stock' => 5, 'vehicle' => ['Toyota', 'Hilux']],
            ['name' => 'Démarreur', 'ref' => 'DE-BOS-441', 'brand' => 'Bosch', 'cat' => 'electricite', 'price' => 980.00, 'stock' => 7, 'vehicle' => ['Hyundai', 'Tucson']],
            ['name' => 'Rétroviseur gauche électrique', 'ref' => 'RE-GEN-019', 'brand' => 'Febi', 'cat' => 'carrosserie', 'price' => 420.00, 'stock' => 11, 'vehicle' => ['Peugeot', '2008']],
            ['name' => 'Plaquettes frein arrière BMW', 'ref' => 'BF-BMW-330', 'brand' => 'Brembo', 'cat' => 'freinage', 'price' => 410.00, 'stock' => 0, 'vehicle' => ['BMW', 'Série 3'], 'availability' => 'out_of_stock'],
            ['name' => 'Filtre à huile Dacia Logan', 'ref' => 'FO-DAC-101', 'brand' => 'Mann-Filter', 'cat' => 'filtres', 'price' => 55.00, 'stock' => 200, 'vehicle' => ['Dacia', 'Logan']],
            ['name' => 'Amortisseur arrière Monroe', 'ref' => 'AM-MON-812', 'brand' => 'Monroe', 'cat' => 'suspension', 'price' => 390.00, 'stock' => 14, 'vehicle' => ['Dacia', 'Duster']],
            ['name' => 'Kit freinage avant complet', 'ref' => 'KF-BRE-050', 'brand' => 'Brembo', 'cat' => 'freinage', 'price' => 980.00, 'stock' => 9, 'vehicle' => ['Volkswagen', 'Golf']],
            ['name' => 'Bougies NGK Platinum', 'ref' => 'BA-NGK-900', 'brand' => 'NGK', 'cat' => 'allumage', 'price' => 250.00, 'stock' => 50, 'vehicle' => ['Hyundai', 'Accent']],
        ];

        foreach ($products as $i => $data) {
            $brand = Brand::query()->where('slug', Str::slug($data['brand']))->first();
            $category = Category::query()->where('slug', $data['cat'])->first();
            $vBrand = VehicleBrand::query()->where('name', $data['vehicle'][0])->first();
            $vModel = $vBrand
                ? VehicleModel::query()->where('vehicle_brand_id', $vBrand->id)->where('name', $data['vehicle'][1])->first()
                : null;

            $product = Product::query()->updateOrCreate(
                ['reference' => $data['ref']],
                [
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name'].'-'.$data['ref']),
                    'brand_id' => $brand?->id,
                    'category_id' => $category?->id,
                    'price' => $data['price'],
                    'stock' => $data['stock'],
                    'availability' => $data['availability'] ?? ($data['stock'] > 0 ? 'available' : 'out_of_stock'),
                    'short_description' => $data['name'].' de qualité pour le marché marocain. Compatible '.($data['vehicle'][0] ?? '').' '.($data['vehicle'][1] ?? '').'.',
                    'description' => "Pièce automobile professionnelle destinée au parc automobile marocain.\n\nRéférence : {$data['ref']}\nMarque : {$data['brand']}\n\nLivraison et disponibilité sur Casablanca, Rabat, Marrakech, Fès, Tanger, Agadir et Meknès. Contactez-nous par WhatsApp pour vérifier le stock.",
                    'features' => [
                        'Qualité OEM / Aftermarket premium',
                        'Garantie constructeur',
                        'Compatible véhicules marocains',
                        'Référence : '.$data['ref'],
                    ],
                    'is_active' => true,
                    'is_featured' => $i < 8,
                    'meta_title' => $data['name'].' '.$data['ref'].' | AUTO-JAR',
                    'meta_description' => 'Achetez '.$data['name'].' ('.$data['ref'].') au Maroc. Prix en DH. Demande rapide par WhatsApp.',
                ]
            );

            if ($vBrand) {
                ProductVehicleCompatibility::query()->updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'vehicle_brand_id' => $vBrand->id,
                        'vehicle_model_id' => $vModel?->id,
                    ],
                    [
                        'year_from' => 2016,
                        'year_to' => 2024,
                        'notes' => 'Compatibilité vérifiée pour le marché marocain',
                    ]
                );
            }
        }
    }
}
