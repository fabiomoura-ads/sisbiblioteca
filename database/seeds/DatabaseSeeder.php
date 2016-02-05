<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserTableSeeder::class);

        $users = array(
                ['name' => 'Haelio Márcio', 'email' => 'haelioferreira@yahoo.com.br', 'password' => Hash::make('secret')],
                ['name' => 'Fábio Moura', 'email' => 'fabiomoura.ads@gmail.com', 'password' => Hash::make('secret')]
        );
            
        // Loop through each user above and create the record for them in the database
        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}
