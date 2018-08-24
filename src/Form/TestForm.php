<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 22.08.2018
 * Time: 14:49
 */

namespace App\Form;
use App\Entity\ActivityLog;
use App\Entity\Owner;
use App\Entity\Property;
use App\Repository\OwnerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('intern', ChoiceType::class,[
            'choices' => [
                'Da' => true,
                'Nu' => false
            ]
        ])
            ->add('log')
            ->add('duration')
            ->add('details')
            ->add('owner',EntityType::class,[
                'multiple' => true,
                'class'    => Owner::class,
                'query_builder' => function(OwnerRepository $repo){
                    return $repo->createAlphabeticalQueryBuilder();
                }
            ])
            ->add('property', EntityType::class,[
                'multiple'=>true,
                'class' => Property::class
            ])
            ->add('lunchBreak')
            ->add('publishedAt', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                'html5' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' =>  ActivityLog::class,
        ));
    }
}