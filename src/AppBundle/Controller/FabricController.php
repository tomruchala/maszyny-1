<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Fabric;
use AppBundle\Form\Type\FabricType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Common\Util\Debug;

/**
 * Materaiły
 */
class FabricController extends BaseController
{

    /**
     * @Route("/materialy", name="materialy")
     */
    public function indexAction(Request $request)
    {

        $search = $request->query->get('search', array());

        $crit = array();
        if (!empty($search['q']))
        {
            $crit['q'] = $search['q'];
        }
        if (!empty($search['category']))
        {
            $crit['category'] = $this->repoFabricCategory()->one(array('id' => $search['category']));
        }

        $qb = $this->repoFabric()->many($crit, false, false, true);
        $this->setViewData('fabrics', $this->paginate($qb, 15));
        $this->setViewData('categories', $this->repoFabricCategory()->many());
        $this->setViewData('search', $search);

        return $this->render('AppBundle:Fabric:index.html.twig');
    }

    /**
     * @Route("/material/dodaj", name="material_dodaj")
     */
    public function addAction(Request $request)
    {
        $viewData = array();
        $fabric = new Fabric();
        $form = $this->createForm(new FabricType(), $fabric);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $fabric->setUser($this->getUserEntity());
            $this->ormPersistAndFlush($fabric);
            return $this->redirect($this->generateUrl('materialy'), 'Dodano materiał');
        }

        $this->setHeader('Dodawanie materiału', 'Dodawanie materiału');
        $this->setViewData('form', $form->createView());
        return $this->render('AppBundle:Fabric:add.html.twig');
    }

    /**
     * @Route("/material/edytuj/{id}", name="material_edytuj")
     * @ParamConverter("fabric", class="AppBundle:Fabric")
     */
    public function editAction(Request $request, $fabric)
    {
        $form = $this->createForm(new FabricType(), $fabric);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->ormPersistAndFlush($fabric);

            return $this->redirect($this->generateUrl('materialy'), 'Zakualizowano material');
        }

        $this->setHeader('Edycja materiału: ' . $fabric->getName());
        $this->setViewData('form', $form->createView());
        return $this->render('AppBundle:Fabric:edit.html.twig');
    }

    /**
     * @Route("/material/usun/{id}", name="material_usun")
     * @ParamConverter("fabric", class="AppBundle:Fabric")
     */
    public function deleteAction(Request $request, $fabric)
    {
        $this->ormRemoveAndFlush($fabric);
        return $this->redirect($this->generateUrl('materialy'), 'Usunięto material');
    }

    /**
     * @Route("/material/szukaj", name="material_szukaj")
     * 
     */
    public function axSearchAction(Request $request)
    {
        $return = array();
        $term = $request->query->get('term');

        $fabrics = $this->repoFabric()->many(
                array('q' => $term), 0, 10
        );

        if (is_array($fabrics) && !empty($fabrics))
        {
            foreach ($fabrics as $fabric)
            {
                $return[] = array(
                    'id' => $fabric->getId(),
                    'value' => $fabric->getName() . ' [' . $fabric->getCode() . ']',
                    'label' => $fabric->getName() . ' [' . $fabric->getCode() . ']',
                    'data' => array(
                        'fabric_id' => $fabric->getId(),
                        'fabric_name' => $fabric->getName(),
                        'unit_unit' => $fabric->getUnit()->getUnit()
                    )
                );
            }
        }
        return new JsonResponse($return);
    }

}
