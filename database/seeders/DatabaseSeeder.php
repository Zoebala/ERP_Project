<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Direction;
use App\Models\Entreprise;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $lib=["Systematik","Quisine"];
        $id=0;
        $direction=["Developpeur","communication"];
        foreach($lib as $l){
            
            Entreprise::create([
                "lib" =>$l       
                
            ]);
        }
        foreach($direction as $dir){
            $id+=1;
            Direction::create([
                "lib"=>$dir,
                "entreprise_id"=>$id
            ]);
        }
        $users=["Zoé Bala"];
        $email="zoebala288@gmail.com";
        $password="password";
        foreach($users as $user){
            User::create([
                "name"=>$user,
                "email"=>$email,
                "password"=>$password
            ]);
       }
}
}