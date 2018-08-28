<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.08.2018
 * Time: 17:31
 */

namespace App\Form;
use App\Entity\ActivityLogProperty;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogPropertyEmbededForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('property', EntityType::class,[
                    'class' => Property::class,
                    'choice_label' => 'name',
                    'query_builder' => function(PropertyRepository $repo){
                        return $repo->findAll();
                    }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => ActivityLogProperty::class
        ]);
    }

}