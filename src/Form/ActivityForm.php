<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.08.2018
 * Time: 15:58
 */

namespace App\Form;
use App\Entity\Owner;
use App\Repository\OwnerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('intern', ChoiceType::class,[
                'choices' => [
                    'Da' => true,
                    'Nu'  =>false
                ]
            ])
            ->add('log')
            ->add('duration')
            ->add('details')
            ->add('staff')
            ->add('owner',EntityType::class,[
                'multiple' => true,
                'class'    => Owner::class,
                'query_builder' => function(OwnerRepository $repo){
                    return $repo->createAlphabeticalQueryBuilder();
                }
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
        $resolver->setDefaults([
            'data_class' => 'App\Entity\ActivityLog'
        ]);
    }
}