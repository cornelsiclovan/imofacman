<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.08.2018
 * Time: 10:02
 */

namespace App\Form;
use App\Entity\ActivityLog;
use App\Entity\Owner;
use App\Repository\OwnerRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityOwnerFormMultiple extends AbstractType
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
                },
                'expanded' => true
            ])
            ->add('lunchBreak', null,[
                'help' => 'Pauza de masa este 1 ora de obicei 13-14'
            ])
            ->add('publishedAt', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                'html5' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ActivityLog::class,
            'validation_groups' => array('for_owner_data_input')
        ]);
    }

}