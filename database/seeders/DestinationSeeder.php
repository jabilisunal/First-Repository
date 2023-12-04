<?php
/** @noinspection ALL */

namespace Database\Seeders;

use App\Models\DestinationTranslation;
use App\Models\Language;
use App\Models\Destination;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $data = '[{"name":"Ağdam"},{"name":"Ağdaş"},{"name":"Ağcabədi"},{"name":"Ağstafa"},{"name":"Ağsu"},{"name":"Astara"},{"name":"Babək"},{"name":"Baki"},{"name":"Balakən"},{"name":"Bərdə"},{"name":"Beyləqan"},{"name":"Biləsuvar"},{"name":"Cəbrayıl"},{"name":"Cəlilabad"},{"name":"Culfa"},{"name":"Daşkəsən"},{"name":"Füzuli"},{"name":"Gədəbəy"},{"name":"Goranboy"},{"name":"Göyçay"},{"name":"Göygöl"},{"name":"Hacıqabul"},{"name":"Xaçmaz"},{"name":"Xızı"},{"name":"Xocalı"},{"name":"Xocavənd"},{"name":"İmişli"},{"name":"İsmayıllı"},{"name":"Kəlbəcər"},{"name":"Kəngərli"},{"name":"Kürdəmir"},{"name":"Qəbələ"},{"name":"Qax"},{"name":"Qazax"},{"name":"Qobustan"},{"name":"Quba"},{"name":"Qubadlı"},{"name":"Qusar"},{"name":"Laçın"},{"name":"Lənkəran"},{"name":"Lerik"},{"name":"Masallı"},{"name":"Neftçala"},{"name":"Oğuz"},{"name":"Ordubad"},{"name":"Saatlı"},{"name":"Sabirabad"},{"name":"Sədərək"},{"name":"Salyan"},{"name":"Samux"},{"name":"Şabran"},{"name":"Şahbuz"},{"name":"Şəki"},{"name":"Şamaxı"},{"name":"Şəmkir"},{"name":"Şərur"},{"name":"Şuşa"},{"name":"Siyəzən"},{"name":"Tərtər"},{"name":"Tovuz"},{"name":"Ucar"},{"name":"Yardımlı"},{"name":"Yevlax"},{"name":"Zəngilan"},{"name":"Zaqatala"},{"name":"Zərdab"}]';

        $data = json_decode($data, true);

        $languages = Language::where(['status' => 1])->get();

        foreach ($data as $key => $value) {

            $insertData = [
                'status' => 1,
                'slug' => Str::slug($value['name']),
                'sort' => (int)($key + 1)
            ];

            foreach ($languages as $language) {
                $insertData[$language->code] = [
                    'name' => $value['name']
                ];
            }

            //dump($insertData);

            Destination::create($insertData);
        }
    }
}
