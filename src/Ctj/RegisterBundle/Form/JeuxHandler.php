<?php
// src/Sdz/BlogBundle/Form/ArticleHandler.php

namespace Ctj\RegisterBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Sdz\BlogBundle\Entity\Jeux;

class JeuxHandler
{
    protected $form;
    protected $request;
    protected $em;

    public function __construct(Form $form, Request $request, EntityManager $em)
    {
        $this->form    = $form;
        $this->request = $request;
        $this->em      = $em;
    }

    public function process()
    {
        
        if( $this->request->getMethod() == 'POST' )
        {
            $this->form->bindRequest($this->request);

            if( $this->form->isValid() )//dans isValid() il y a le service validator ($this->get('validator'))
            {
                $this->onSuccess($this->form->getData());

                return true;
            }
        }

        return false;
    }
    
    public function onSuccess($jeux)
    {
        $this->em->persist($jeux);
        $this->em->flush();
    }

 
}