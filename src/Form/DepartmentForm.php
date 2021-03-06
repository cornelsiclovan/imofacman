<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.08.2018
 * Time: 15:48
 */

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepartmentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('addDataFor', ChoiceType::class, array(
                'choices' => array(
                    'Proprietate' => 'Proprietate',
                    'Proprietar'    => 'Proprietar'
                )
            ))
         ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\StaffType'
        ]);
    }
}