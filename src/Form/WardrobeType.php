<?php

namespace App\Form;

use App\Entity\Wardrobe;
use App\Entity\User;
use App\Repository\CapRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class WardrobeType extends AbstractType
{
    private $capRepository;
    private $security;

    public function __construct(CapRepository $capRepository, Security $security)
    {
        $this->capRepository = $capRepository;
        $this->security = $security;
    }
    private function getAvailableCaps()
    {
        $user = $this->security->getUser();

        if (!$user) {
            return [];
        }

        return $this->capRepository->findCapsForUser($user);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('isVisible')
            ->add('member')
            ->add('cap', null, [ 'multiple' => true, 'expanded' => true]);
            //->add('cap', null, [
            //    'query_builder' => function (CapRepository $er) use ($user) {
            //        return $er->createQueryBuilder('c')
            //            ->leftJoin('c.inventory', 'i')
            //            ->leftJoin('i.member', 'm') 
            //            ->leftJoin('m.user', 'u') 
            //            ->where('u = :user')
            //            ->setParameter('user', $user)
            //            ->orderBy('c.id', 'ASC');
            //    },
            //    'by_reference' => false,
            //    'multiple' => true,
            //    'expanded' => true
            //]);   
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wardrobe::class,
        ]);
    }
}
