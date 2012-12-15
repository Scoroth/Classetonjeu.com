<?php
namespace Ctj\RegisterBundle\Form;
use Symfony\Component\Form\FormBuilderInterface;//remplace "FormBuilder" qui ne semble pas fonctionner
use Symfony\Component\Form\AbstractType;

class JeuxType extends AbstractType
{

          public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
            ->add('titre',   'text')
            ->add('auteur',  'text')
            ->add('image')//Comme utilisation de la contrainte File, Symfony2 va automatiquement deviner que le champ du formulaire est un champ d'upload de fichier(d'ou le enctype en multipart)
            ;
    }
    
     public function getName()
    {
        return 'ctj_registerbundle_jeuxtype';
    }
       
            
         
    
}

?>
