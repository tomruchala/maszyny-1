<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Technology;
use AppBundle\Form\Type\TechnologyType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Common\Util\Debug;

/**
 * Procesy technologiczne
 * 
 * @package TechnologyController
 * @author Tomasz Ruchała; projektowaniestronsacz.pl
 * 
 * @version v. 1.0
 * @license MIT
 * 
 */
class TechnologyController extends BaseController {

    /**
     * @Route("/procesy-technologiczne", name="procesy")
     * 
     * @param type Symfony\Component\HttpFoundation\Request
     */
    public function indexAction(Request $request) {
        $crit = array();
        $qb = $this->repoTechnology()->many($crit, false, false, true);
        $this->setViewData('technologies', $this->paginate($qb, 15));
        return $this->render('AppBundle:Technology:index.html.twig');
    }

    /**
     * @Route("/procesy-technologiczne/dodaj", name="procesy_dodaj")
     * 
     * @param type Symfony\Component\HttpFoundation\Request
     */
    public function addAction(Request $request) {
        $viewData = array();
        $technology = new Technology();
        $form = $this->createForm(new TechnologyType(), $technology);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->ormPersistAndFlush($technology);
            return $this->redirect($this->generateUrl('procesy_edytuj', array('id' => $technology->getId())), 'Dodano proces technologiczny');
        }

        $this->setHeader('Dodawanie procesu technologicznego', 'Dodawanie procesu technologicznego');
        $this->setViewData('form', $form->createView());
        return $this->render('AppBundle:Technology:add.html.twig');
    }

    /**
     * @Route("/procesy-technologiczne/edytuj/{id}", name="procesy_edytuj")
     * @ParamConverter("technology", class="AppBundle:Technology")
     */
    public function editAction(Request $request, $technology) {
        $form = $this->createForm(new TechnologyType(), $technology);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->ormPersistAndFlush($technology);

            return $this->redirect($this->generateUrl('procesy', array('id' => $technology->getId())), 'Zakualizowano proces technologiczny');
        }

        $this->setHeader('Edycja procesu technologicznego: ' . $technology->getName());
        $this->setViewData('form', $form->createView());
        $this->setViewData('technology', $technology);
        return $this->render('AppBundle:Technology:edit.html.twig');
    }

    /**
     * @Route("/procesy-technologiczne/usun/{id}", name="procesy_usun")
     * @ParamConverter("technology", class="AppBundle:Technology")
     */
    public function deleteAction(Request $request, $technology) {
        $this->ormRemoveAndFlush($technology);
        return $this->redirect($this->generateUrl('procesy', array('id' => $technology->getId())), 'Usunięto proces technologiczny');
    }

}
