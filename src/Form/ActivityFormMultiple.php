<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.08.2018
 * Time: 15:58
 */

namespace App\Form;
use App\Entity\ActivityLog;
use App\Entity\Owner;
use App\Entity\Property;
use App\Repository\OwnerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityFormMultiple extends AbstractType
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
            ->add('property', EntityType::class,[
                'multiple'=>true,
                'class' => Property::class,
                'expanded' => true
            ])
            //->add('property', CollectionType::class,[
            //    'entry_type' => LogPropertyEmbededForm::class
            //])
            ->add('lunchBreak', null,[
                'help' => 'Pauza de masa este 1 ora de obicei 13-14'
            ])
            ->add('publishedAt', CollectionType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                'html5' => false,
            ]);
    }

    //public function finishView(FormView $view, FormInterface $form, array $options)
    //{
    //   $view['lunchBreak']->vars['help'] = "Pauza de masa este 1 ora de obicei 13-14";
    //}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ActivityLog::class,
            'validation_groups' => array('for_property_data_input')
        ]);
    }
}