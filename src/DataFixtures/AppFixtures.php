<?php

namespace App\DataFixtures;

use App\Factory\RutaFactory;
use App\Factory\UsuarioFactory;
use App\Factory\ValoracionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UsuarioFactory::createMany(10);
        RutaFactory::createMany(15, function (){
            return [
                'usuario' => UsuarioFactory::random()
            ];
        });
        ValoracionFactory::createMany(15, function (){
            return [
                'ruta' =>RutaFactory::random(),
                'usuario' => UsuarioFactory::random()
            ];
        });
        $manager->flush();
    }
}
