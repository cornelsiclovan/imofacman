<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.08.2018
 * Time: 15:29
 */

namespace App\Form;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityLogEmbededForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('property', EntityType::class,[
                'class' => Property::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Property'
        ]);
    }
}