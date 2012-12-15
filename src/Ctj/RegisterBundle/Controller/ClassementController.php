<?php
namespace Ctj\RegisterBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ctj\RegisterBundle\Entity\Jeux;
use Ctj\RegisterBundle\Form\JeuxType;
use Ctj\RegisterBundle\Entity\JeuxRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;


class ClassementController extends Controller
{
    public function ClassementAction($max = 3)
    {   
       
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('CtjRegisterBundle:Jeux');
        
            
        $classement = $repository->findBy(
         array(),
         array('votes' => 'DESC'),
                20,
                0
        );
            
        
         return $this->render('CtjRegisterBundle:Register:classement.html.twig', array('classement' => $classement));
    }
}
?>
