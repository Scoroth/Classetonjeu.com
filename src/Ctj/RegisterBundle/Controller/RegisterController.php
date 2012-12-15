<?php

namespace Ctj\RegisterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ctj\RegisterBundle\Entity\Jeux;
use Ctj\RegisterBundle\Form\JeuxType;
use Ctj\RegisterBundle\Form\JeuxHandler;
use Ctj\RegisterBundle\Entity\JeuxRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use JMS\SecurityExtraBundle\Annotation\Secure;


class RegisterController extends Controller
{
    public function indexAction()
    {   
                                
       $repository = $this->getDoctrine()
          ->getManager()
          ->getRepository('CtjRegisterBundle:Jeux');  
       
       $users = $repository->findBy(
         array(),
         array('date' => 'DESC'),
                5,
                0
        );
       
       
        
        return $this->render('CtjRegisterBundle:Register:index.html.twig',array('users' => $users));
    }
    
    public function addAction()
    {
        $entity  = new Jeux();
        $request = $this->getRequest();
        $form    = $this->createForm(new JeuxType(), $entity);
        $form->bind($request);
 
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
 
            return $this->redirect($this->generateUrl('ctj_register_games'));
    }
    
    return $this->render('CtjRegisterBundle:Register:formulaire.html.twig',array(
        'form' => $form->createView(),
            ));
}

    public function games_listAction($page,$id)
    {   
        
         //increment
        $jeu  = new Jeux;
        $request = $this->get('request');
        $form= $this->createFormBuilder($jeu)
        ->add('votes', 'hidden')
        ->getForm();
        
        $session = $this->getRequest()->getSession();
        
        if(($request->getMethod()=='POST') AND ($session->get('control') !== '1')){
            
            $cookie = new Cookie('vote',time() + 3600 * 24,time() + 3600 * 24);
            $response = new Response();
            $response->headers->setCookie($cookie);
            $response->sendHeaders();  
        $stmt = $this->getDoctrine()->getEntityManager()
               ->getConnection()
               ->prepare("update Jeux set votes = votes+1 where `id` = :id");
                $stmt->bindValue('id',$id);
                $stmt->execute();
                $date=time();
                
                
                $session->set('control', '1');
                
               
       $repository = $this->getDoctrine()
          ->getManager()
          ->getRepository('CtjRegisterBundle:Jeux');  
       
       $users = $repository->findBy(
         array(),
         array('date' => 'DESC'),
                5,
                0
        );
                
                 
        return $this->render('CtjRegisterBundle:Register:index.html.twig', array(
                       'date'=>$date,
                       'users' => $users
                    
                       ) );
      
        }

                
        $charactere = substr_replace($page,'%',2,1);
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
        'SELECT j FROM CtjRegisterBundle:Jeux j WHERE j.titre LIKE :charactere'
        )
        ->setParameter(':charactere',$charactere);
        $jeux = $query->getResult();
       // var_dump($query2->getResult());
        $list=range('A','Z');
        array_push($list,0,1,2,3,4,5,6,7,8,9);
        
        $date='';
        if(isset($_COOKIE['vote'])){
        $secondes=ceil((($_COOKIE['vote']- time())));
        $date = date("H:i:s",$secondes);
        
        }
        return $this->render('CtjRegisterBundle:Register:games.html.twig', array(
            'jeux' => $jeux,
            'alphabet' => $list,
            'form' => $form->createView(),
            'date'=>$date
            
        ));
        return $this->render('CtjRegisterBundle:Register:games.html.twig');
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function editAction($id)
    {
         $em = $this->getDoctrine()->getEntityManager();
        
        if(! $jeux = $em->getRepository('Ctj\RegisterBundle\Entity\Jeux')->find($id) )
        {
            throw $this->createNotFoundException('Jeux[id='.$id.'] inexistant');
        }
                // On passe le $jeux récupéré au formulaire
        $form  = $this->createForm(new JeuxType, $jeux);
        
        $formHandler = new JeuxHandler($form, $this->get('request'), $em);
        
                if($formHandler->process())
        {
            $this->get('session')->setFlash('info', 'Modigication effectuée avec succès');
        }
        
        
        
         return $this->render('CtjRegisterBundle:Register:edit.html.twig',array(
        'form' => $form->createView(),
            ));
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function admAction($page,$id){
        
        $jeu  = new Jeux;
        $request = $this->get('request');
        $form= $this->createFormBuilder($jeu)
        ->add('votes', 'hidden')
        ->getForm();
        
        
         if($request->getMethod()=='POST') {
     
        $stmt = $this->getDoctrine()->getEntityManager()
               ->getConnection()
               ->prepare("delete from Jeux where `id` = :id");
                $stmt->bindValue('id',$id);
                $stmt->execute();
               
         }   
                
                
        
        $charactere = substr_replace($page,'%',2,1);
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
        'SELECT j FROM CtjRegisterBundle:Jeux j WHERE j.titre LIKE :charactere'
        )
        ->setParameter(':charactere',$charactere);
        $jeux = $query->getResult();
       // var_dump($query2->getResult());
        $list=range('A','Z');
        array_push($list,0,1,2,3,4,5,6,7,8,9);
     

        return $this->render('CtjRegisterBundle:Register:adm.html.twig', array(
            'jeux' => $jeux,
            'alphabet' => $list,
            'form' => $form->createView()
          
            
        ));
        return $this->render('CtjRegisterBundle:Register:adm.html.twig');
        
        
    }
    
    

}

