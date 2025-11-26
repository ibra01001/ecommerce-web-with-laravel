<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Wilaya;

class WilayaSeeder extends Seeder
{
    public function run(): void
    {
        Wilaya::insert([
            ['name' => '1.Adrar', 'code' => '01', 'shipping_cost' => 500],
            ['name' => '2.Chlef', 'code' => '02', 'shipping_cost' => 450],
            ['name' => '3.Laghouat', 'code' => '03', 'shipping_cost' => 550],
            ['name' => '4.Oum El Bouaghi', 'code' => '04', 'shipping_cost' => 450],
            ['name' => '5.Batna', 'code' => '05', 'shipping_cost' => 450],
            ['name' => '6.Béjaïa', 'code' => '06', 'shipping_cost' => 450],
            ['name' => '7.Biskra', 'code' => '07', 'shipping_cost' => 500],
            ['name' => '8.Béchar', 'code' => '08', 'shipping_cost' => 600],
            ['name' => '9.Blida', 'code' => '09', 'shipping_cost' => 350],
            ['name' => '10.Bouira', 'code' => '10', 'shipping_cost' => 400],
            ['name' => '11.Tamanrasset', 'code' => '11', 'shipping_cost' => 900],
            ['name' => '12.Tébessa', 'code' => '12', 'shipping_cost' => 600],
            ['name' => '13.Tlemcen', 'code' => '13', 'shipping_cost' => 500],
            ['name' => '14.Tiaret', 'code' => '14', 'shipping_cost' => 450],
            ['name' => '15.Tizi Ouzou', 'code' => '15', 'shipping_cost' => 400],
            ['name' => '16.Algiers', 'code' => '16', 'shipping_cost' => 400],
            ['name' => '17.Djelfa', 'code' => '17', 'shipping_cost' => 500],
            ['name' => '18.Jijel', 'code' => '18', 'shipping_cost' => 450],
            ['name' => '19.Sétif', 'code' => '19', 'shipping_cost' => 450],
            ['name' => '20.Saïda', 'code' => '20', 'shipping_cost' => 450],
            ['name' => '21.Skikda', 'code' => '21', 'shipping_cost' => 500],
            ['name' => '22.Sidi Bel Abbès', 'code' => '22', 'shipping_cost' => 450],
            ['name' => '23.Annaba', 'code' => '23', 'shipping_cost' => 550],
            ['name' => '24.Guelma', 'code' => '24', 'shipping_cost' => 500],
            ['name' => '25.Constantine', 'code' => '25', 'shipping_cost' => 500],
            ['name' => '26.Médéa', 'code' => '26', 'shipping_cost' => 400],
            ['name' => '27.Mostaganem', 'code' => '27', 'shipping_cost' => 450],
            ['name' => '28.MSila', 'code' => '28', 'shipping_cost' => 450],
            ['name' => '29.Mascara', 'code' => '29', 'shipping_cost' => 450],
            ['name' => '30.Ouargla', 'code' => '30', 'shipping_cost' => 700],
            ['name' => '31.Oran', 'code' => '31', 'shipping_cost' => 600],
            ['name' => '32.El Bayadh', 'code' => '32', 'shipping_cost' => 650],
            ['name' => '33.Illizi', 'code' => '33', 'shipping_cost' => 900],
            ['name' => '34.Bordj Bou Arréridj', 'code' => '34', 'shipping_cost' => 450],
            ['name' => '35.Boumerdès', 'code' => '35', 'shipping_cost' => 350],
            ['name' => '36.El Tarf', 'code' => '36', 'shipping_cost' => 550],
            ['name' => '37.Tindouf', 'code' => '37', 'shipping_cost' => 900],
            ['name' => '38.Tissemsilt', 'code' => '38', 'shipping_cost' => 450],
            ['name' => '39.El Oued', 'code' => '39', 'shipping_cost' => 600],
            ['name' => '40.Khenchela', 'code' => '40', 'shipping_cost' => 500],
            ['name' => '41.Souk Ahras', 'code' => '41', 'shipping_cost' => 500],
            ['name' => '42.Tipaza', 'code' => '42', 'shipping_cost' => 350],
            ['name' => '43.Mila', 'code' => '43', 'shipping_cost' => 500],
            ['name' => '44.Aïn Defla', 'code' => '44', 'shipping_cost' => 450],
            ['name' => '45.Naâma', 'code' => '45', 'shipping_cost' => 650],
            ['name' => '46.Aïn Témouchent', 'code' => '46', 'shipping_cost' => 500],
            ['name' => '47.Ghardaïa', 'code' => '47', 'shipping_cost' => 650],
            ['name' => '48.Relizane', 'code' => '48', 'shipping_cost' => 450],
            // New wilayas (49–58)
            ['name' => '49.Timimoun', 'code' => '49', 'shipping_cost' => 800],
            ['name' => '50.Bordj Badji Mokhtar', 'code' => '50', 'shipping_cost' => 900],
            ['name' => '51.Ouled Djellal', 'code' => '51', 'shipping_cost' => 700],
            ['name' => '52.Béni Abbès', 'code' => '52', 'shipping_cost' => 800],
            ['name' => '53.In Salah', 'code' => '53', 'shipping_cost' => 900],
            ['name' => '54.In Guezzam', 'code' => '54', 'shipping_cost' => 950],
            ['name' => '55.Touggourt', 'code' => '55', 'shipping_cost' => 700],
            ['name' => '56.Djanet', 'code' => '56', 'shipping_cost' => 900],
            ['name' => '57.El Meghaier', 'code' => '57', 'shipping_cost' => 600],
            ['name' => '58.El Meniaa', 'code' => '58', 'shipping_cost' => 700],
        ]);
    }
}
