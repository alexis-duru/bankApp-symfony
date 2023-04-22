<?php

namespace App\Form;

use App\Entity\Account;
use App\Service\RandomAccountNumberGenerator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountFormType extends AbstractType
{
    private $randomAccountNumberGenerator;

    public function __construct(RandomAccountNumberGenerator $randomAccountNumberGenerator)
    {
        $this->randomAccountNumberGenerator = $randomAccountNumberGenerator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('accountNumber', null, [
                'data' => $this->randomAccountNumberGenerator->generateAccountNumber(),
                'disabled' => true,
            ])
            ->add('balance')
            ->add('owner');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
        ]);
    }
}
