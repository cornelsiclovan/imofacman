<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.08.2018
 * Time: 10:53
 */

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StaffEditForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('staffType')
            ->add('roles', ChoiceType::class, array(
                'choices' => array(
                    'Administrator' => 'ROLE_ADMIN',
                    'Utilizator'    => 'ROLE_USER'
                ),
                'multiple' => true,
            ));
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Staff',
            'validation_groups' => array('staff_edit')
        ]);
    }
}