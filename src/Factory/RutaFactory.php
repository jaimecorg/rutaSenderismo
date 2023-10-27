<?php

namespace App\Factory;

use App\Entity\Ruta;
use App\Repository\RutaRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Ruta>
 *
 * @method static Ruta|Proxy createOne(array $attributes = [])
 * @method static Ruta[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Ruta[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Ruta|Proxy find(object|array|mixed $criteria)
 * @method static Ruta|Proxy findOrCreate(array $attributes)
 * @method static Ruta|Proxy first(string $sortedField = 'id')
 * @method static Ruta|Proxy last(string $sortedField = 'id')
 * @method static Ruta|Proxy random(array $attributes = [])
 * @method static Ruta|Proxy randomOrCreate(array $attributes = [])
 * @method static Ruta[]|Proxy[] all()
 * @method static Ruta[]|Proxy[] findBy(array $attributes)
 * @method static Ruta[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Ruta[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static RutaRepository|RepositoryProxy repository()
 * @method Ruta|Proxy create(array|callable $attributes = [])
 */
final class RutaFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'nombre' => self::faker()->word(),
            'direccion' => self::faker()->streetAddress(),
            'duracion' => self::faker()->dateTime(),
            'desnivel' => self::faker()->randomNumber(),
            'descripcion' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Ruta $ruta): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Ruta::class;
    }
}
