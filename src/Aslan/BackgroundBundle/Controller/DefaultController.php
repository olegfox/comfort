<?php

namespace Aslan\BackgroundBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Aslan\BackgroundBundle\Entity\Background;

class DefaultController extends Controller {

    //поиск всех записей втаблице
    public function findAllAction($name) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanBackgroundBundle:' . $name);
        $page = $repository->findAll();
        return $page;
    }

    //поиск в таблице по id
    public function findOneAction($name, $id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanBackgroundBundle:' . $name);
        $page = $repository->find($id);
        if (!$page) {
            throw $this->createNotFoundException('No element found for id ' . $id);
        }
        return $page;
    }

    //Удаление фона
    public function pageImgRemoveAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanBackgroundBundle:Background');
        $page = $repository->findOneBy(array("id" => $id));
        if (file_exists("media/pictures/" . $page->getSrc())) {
            unlink("media/pictures/" . $page->getSrc());
        }
        if (file_exists("media/pictures/small" . $page->getSrc())) {
            unlink("media/pictures/small" . $page->getSrc());
        }
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($page);
        $em->flush();
    }

    public function adminRemovePageImgAction(Request $request) {
        $id = $request->request->get('id');
        $this->pageImgRemoveAction($id);
        return new Response();
    }

    //Создание нового фона в базе данных 
    public function PageImgNewAction($filename, $position) {
        $brand = new Background();
        $brand->setSrc($filename);
	$brand->setPosition($position);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($brand);
        $em->flush();
        return $brand->getId();
    }

    //Загрузка нового фона
    public function adminPageImgNewAction(Request $request) {
        $fileName2 = array();
        $send = array();
	$position = $request->request->get('position');
        if ($request->getMethod() == 'POST') {
            if (isset($_FILES['files'])) {
                foreach ($_FILES['files']['name'] as $k => $f) {
                    if (!$_FILES['files']['error'][$k]) {
                        if (is_uploaded_file($_FILES['files']['tmp_name'][$k])) {
                            $extension = ".jpg";
                            $fileName2[$k] = 'img' . $k . date('YmdHis') . '.'
                                    . $extension;
                            if (move_uploaded_file(
                                            $_FILES['files']['tmp_name'][$k], "media/pictures/" . $fileName2[$k])) {
                                
                            }
                        }
                    }
                }
            }
            for ($i = 0; $i < count($fileName2); $i++) {
                $idd = $this->PageImgNewAction($fileName2[$i], $position);
                $send[$i]['id'] = $idd;
                $send[$i]['src'] = $fileName2[$i];
            }
        }
        return new Response(json_encode($send));
    }

    //функция обработки страницы загрузки фоновых картинок
    public function indexAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            $pag = $this->findAllAction('Background');
            return $this
                            ->render(
                                    'AslanBackgroundBundle:Default:index.html.twig', array("img" => $pag, 'menu' => 5));
        }
    }

}
