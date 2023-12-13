<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NuevoUsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreUsuario')
            ->add('correo')
            ->add('clave')
            ->add('permisos', null, [
                'disabled' => true, // Hace que el campo sea no editable
            ])
            ->add('moderador', CheckboxType::class, [
                'label' => 'Moderador',
                'required' => false,
                'disabled' => true, // No se puede modificar
            ])
            ->add('administrador', CheckboxType::class, [
                'label' => 'Administrador',
                'required' => false,
                'disabled' => true, // No se puede modificar
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}