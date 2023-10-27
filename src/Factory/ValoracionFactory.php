<?php

namespace App\Factory;

use App\Entity\Valoracion;
use App\Repository\ValoracionRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Valoracion>
 *
 * @method static Valoracion|Proxy createOne(array $attributes = [])
 * @method static Valoracion[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Valoracion[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Valoracion|Proxy find(object|array|mixed $criteria)
 * @method static Valoracion|Proxy findOrCreate(array $attributes)
 * @method static Valoracion|Proxy first(string $sortedField = 'id')
 * @method static Valoracion|Proxy last(string $sortedField = 'id')
 * @method static Valoracion|Proxy random(array $attributes = [])
 * @method static Valoracion|Proxy randomOrCreate(array $attributes = [])
 * @method static Valoracion[]|Proxy[] all()
 * @method static Valoracion[]|Proxy[] findBy(array $attributes)
 * @method static Valoracion[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Valoracion[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ValoracionRepository|RepositoryProxy repository()
 * @method Valoracion|Proxy create(array|callable $attributes = [])
 */
final class ValoracionFactory extends ModelFactory
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
            'puntuacion' => self::faker()->randomNumber(),
            'puntuacionMedia' => self::faker()->randomNumber(),
            'comentario' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Valoracion $valoracion): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Valoracion::class;
    }
}
