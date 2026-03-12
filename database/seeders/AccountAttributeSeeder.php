<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccountAttribute;
use App\Models\Account;

class AccountAttributeSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = Account::all();
        
        foreach ($accounts as $account) {
            $game = $account->gameCategory->game;
            $attributes = $game->attributes;
            
            foreach ($attributes as $attribute) {
                $value = '';
                if ($attribute->type == 'select' && is_array($attribute->options) && count($attribute->options) > 0) {
                    $value = $attribute->options[array_rand($attribute->options)];
                } elseif ($attribute->type == 'number') {
                    $value = (string) rand(10, 100);
                } else {
                    $value = 'Giá trị mẫu '. rand(1, 10);
                }

                AccountAttribute::create([
                    'account_id' => $account->id,
                    'attribute_id' => $attribute->id,
                    'value' => $value,
                ]);
            }
        }
    }
}
