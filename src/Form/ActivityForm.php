<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.08.2018
 * Time: 15:58
 */

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('intern')
            ->add('log')
            ->add('duration')
            ->add('details')
            ->add('staff')
            ->add('owner')
            ->add('lunchbreak');
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\ActivityLog'
        ]);
    }
}