<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreUsuario')
            ->add('correo')
            ->add('clave')
            ->add('permisos')->add('permisos')
            ->add('moderador', CheckboxType::class, [
                'label' => 'Moderador',
                'required' => false, // No es un campo obligatorio
            ])
            ->add('administrador', CheckboxType::class, [
                'label' => 'Administrador',
                'required' => false, // No es un campo obligatorio
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}