<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.08.2018
 * Time: 14:28
 */

namespace App\Form;
use App\Entity\Staff;
use App\Entity\StaffType;
use App\Repository\StaffTypeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email', EmailType::class)
            ->add('plainPassword', RepeatedType::class, [
               'type' => PasswordType::class
            ])
            ->add('staffType',EntityType::class,[
                'class'    => StaffType::class,
                'query_builder' => function(StaffTypeRepository $repo){
                    return $repo->createAlphabeticalQueryBuilder();
                }
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Staff::class
        ]);
    }
}