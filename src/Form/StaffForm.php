<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.08.2018
 * Time: 9:45
 */

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StaffForm extends AbstractType
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
                    'Utilizator'    => 'ROLE_USER',
                    'Sef Departament Mentenanta' => 'ROLE_MENTAINANCE_BOSS',
                    'Subordonat Departament Mentenanta' => 'ROLE_MENTAINANCE_TEAM'
                 ),
                'multiple' => true,
            ))
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Staff',
            'validation_groups' => array('registration')
        ]);
    }
}