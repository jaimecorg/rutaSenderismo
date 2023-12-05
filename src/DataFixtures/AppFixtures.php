<?php

namespace App\DataFixtures;

use App\Entity\Ruta;
use App\Entity\Usuario;
use App\Factory\ImagenFactory;
use App\Factory\RutaFactory;
use App\Factory\UsuarioFactory;
use App\Factory\ValoracionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        UsuarioFactory::createMany(15);
        $usuarios = $manager->getRepository(Usuario::class)->findAll();

        ImagenFactory::createMany(15, function (){
            return [
                'direccion' => 'public/img/carrusel1.jpg'
            ];
        });
        RutaFactory::createMany(15, function () use ($usuarios, $manager) {
            return [
                'usuario' => UsuarioFactory::random(),
                'imagenes' => ImagenFactory::randomRange(3, 5)
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
