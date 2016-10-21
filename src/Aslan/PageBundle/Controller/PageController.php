<?php

namespace Aslan\PageBundle\Controller;

use Aslan\StoreBundle\Controller\StoreController as StoreController;

class PageController extends StoreController
{
    /**
     * Главная страница
     *
     * @return Response
     */
    public function indexAction()
    {
        $categories = parent::findAllAction('News');

        return $this->render('AslanPageBundle:Main:index.html.twig', array(
            "categories" => $categories
        ));
    }

    /**
     * Страница категории
     *
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function oneAction($slug) {
        $repository = $this->getDoctrine()->getRepository('AslanStoreBundle:News');
        $category = $repository->findOneBy(array("slug" => $slug));

        return $this->render('AslanPageBundle:Category:index.html.twig', array(
            "category" => $category
        ));
    }
}
