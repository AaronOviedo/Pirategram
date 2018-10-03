<?php

use Illuminate\Database\Seeder;
use Pirategram\myUser;
use Pirategram\Post;
use Pirategram\Multimedia;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $default_cover = new Multimedia();
        $default_cover->strLink = 'http://www.timelinecoverphotomaker.com/sites/default/files/styles/medium_preview/public/facebook-cover-photos/2014/06/Be%20Original%20Facebook%20Cover%20Photo.png?itok=v-h_Ulke';
        $default_cover->save();

        $default_profile = new Multimedia();
        $default_profile->strLink = "https://www.eldiario.es/static/EDIDiario/images/facebook-default-photo.jpg";
        $default_profile->save();

        Multimedia::create([
            "strLink" =>    'http://tierraaltatuito.com/wp-content/uploads/2017/11/WERE-WORKING.jpg'
        ]);

        myUser::create([
            'strName'               =>  'Aaron Oviedo',
            'strEmail'              =>  'aaron.t.o@hotmail.com',
            'strPassword'           =>  'luisaron97',
            'dateBirth'             =>  '1997-07-15 00:00:00',
            'strGender'             =>  'male',
            'strUserDescription'    =>  'Default user',
            'intProfile'            =>  1,
            'intCover'              =>  0
        ]);
        
        Post::create([
            'strTitle'          =>  'Default post',
            'strDescription'    =>  'This is the default post for the default user',
            'intLikes'          =>  0,
            'intUserID'         =>  0,
            'intMultimediaID'   =>  2
        ]);

    }
}
