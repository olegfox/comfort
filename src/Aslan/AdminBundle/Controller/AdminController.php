<?php

namespace Aslan\AdminBundle\Controller;

use Aslan\StoreBundle\Controller\StoreController as StoreController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Aslan\AdminBundle\Form\Type\PageType;
use Aslan\AdminBundle\Entity\Pages;
use Aslan\AdminBundle\Form\Type\ThirdMenuType;
use Aslan\AdminBundle\Entity\ThirdMenus;
use Aslan\AdminBundle\Form\Type\ImageType;
use Aslan\AdminBundle\Entity\Images;
use Aslan\StoreBundle\Entity\Slider;
use Aslan\StoreBundle\Entity\Baner;
use Aslan\AdminBundle\Form\Type\BrandType;
use Aslan\AdminBundle\Entity\Brands;
use Aslan\AdminBundle\Form\Type\BlogsType;
use Aslan\AdminBundle\Entity\Blogs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AdminController extends StoreController {

    public function blogsImage($img, $val) {
        $blogsNew = array();
        $size = getimagesize($img);
        $width = $size[0];
        $height = $size[1];
        $const = $width / $height;
        $blogsNew['width'] = $val;
        $blogsNew['height'] = $val / $const;
        return $blogsNew;
    }

    public function adminBanerAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            //$onemenu = parent::oneMenuAction($id);
            $pag = parent::banerAction();
            $page = new Baner();
            $form = $this->createForm(new ImageType(), $page);
            if ($request->getMethod() == 'POST') {
                $form->bindRequest($request);
                $file = $form['src']->getData();
                $href = $form['href']->getData();
                $fileName = '';
                if ($file) {
                    //$extension = $file->guessExtension();
                    $extension = ".jpg";
                    $fileName = 'img' . date('YmdHis') . '.' . $extension;
                    $file->move('media/pictures/', $fileName);
                }
                //$found = parent::emailOneFoundImageAction($text);
                $src = parent::banerNewAction($fileName, $href);
                return new Response($src);
                /* if (!$found) {
                  parent::emailSetImageAction($text);
                  return new Response(
                  $this->get('translator')
                  ->trans("Thank you! We'll notify you."));
                  } else {
                  return new Response(
                  $this->get('translator')
                  ->trans(
                  "Sorry, but this email already exists!"));
                  } */
            } else {
                $form['href']->setData('http://');
                return $this
                                ->render(
                                        'AslanAdminBundle:Default:admin.baner.html.twig', array("img" => $pag, 'menu' => 10,
                                    "form" => $form->createView()));
            }
        }
    }
    
    public function adminSliderAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            //$onemenu = parent::oneMenuAction($id);
            $pag = parent::sliderAction();
            $page = new Slider();
            $form = $this->createForm(new ImageType(), $page);
            if ($request->getMethod() == 'POST') {
                $form->bindRequest($request);
                $file = $form['src']->getData();
                $href = $form['href']->getData();
                $fileName = '';
                if ($file) {
                    //$extension = $file->guessExtension();
                    $extension = ".jpg";
                    $fileName = 'img' . date('YmdHis') . '.' . $extension;
                    $file->move('media/pictures/', $fileName);
                }
                //$found = parent::emailOneFoundImageAction($text);
                $src = parent::sliderNewAction($fileName, $href);
                return new Response($src);
                /* if (!$found) {
                  parent::emailSetImageAction($text);
                  return new Response(
                  $this->get('translator')
                  ->trans("Thank you! We'll notify you."));
                  } else {
                  return new Response(
                  $this->get('translator')
                  ->trans(
                  "Sorry, but this email already exists!"));
                  } */
            } else {
                $form['href']->setData('http://');
                return $this
                                ->render(
                                        'AslanAdminBundle:Default:admin.slider.html.twig', array("img" => $pag, 'menu' => 7,
                                    "form" => $form->createView()));
            }
        }
    }

    public function adminSliderDeleteAction(Request $request) {
        $id = $request->request->get('id');
        parent::sliderDeleteAction($id);
        return new Response();
    }

    public function adminImgAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            //$onemenu = parent::oneMenuAction($id);
            $pag = parent::imgAction();
            $albums = parent::findAllAction('Albums');
            $page = new Images();
            $form = $this->createForm(new ImageType(), $page);
            if ($request->getMethod() == 'POST') {
                $form->bindRequest($request);
                $file = $form['img']->getData();
                $href = $form['href']->getData();
                $fileName = '';
                if ($file) {
                    //$extension = $file->guessExtension();
                    $extension = ".jpg";
                    $fileName = 'img' . date('YmdHis') . '.' . $extension;
                    $file->move('media/pictures/', $fileName);
                }
                //$found = parent::emailOneFoundImageAction($text);
                $src = parent::imgNewAction($fileName, $href);
                return new Response($src);
                /* if (!$found) {
                  parent::emailSetImageAction($text);
                  return new Response(
                  $this->get('translator')
                  ->trans("Thank you! We'll notify you."));
                  } else {
                  return new Response(
                  $this->get('translator')
                  ->trans(
                  "Sorry, but this email already exists!"));
                  } */
            } else {
                $form['href']->setData('http://');
                return $this
                                ->render(
                                        'AslanAdminBundle:Default:admin.slider--.html.twig', array("img" => $pag, 'albums' => $albums, 'menu' => 2,
                                    "form" => $form->createView()));
            }
        }
    }

    public function adminImgDeleteAction(Request $request) {
        $id = $request->request->get('id');
        parent::imgDeleteAction($id);
        return new Response();
    }

    public function adminImgDelete2Action(Request $request) {
        $id = $request->request->get('id');
        parent::imgDelete2Action($id);
        return new Response();
    }    
    
    public function adminAction() {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        $session = $this->getRequest()->getSession();
        $locale = $session->get('changeLocale');
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            return $this
                            ->redirect(
                                    $this
                                    ->generateUrl(
                                            'AslanAdminBundle_admin_place'), 301);
        }
    }

    public function adminVideoAction() {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            $video = parent::findAllAction('Video');
            return $this
                            ->render('AslanAdminBundle:Default:video.admin.html.twig', array("video" => $video, 'menu' => 3));
        }
    }

    public function adminEmailAction() {
        $email = parent::emailAllAction();
        return $this
                        ->render('AslanAdminBundle:Default:email.html.twig', array("email" => $email));
    }

    public function adminEmailDeleteAction(Request $request) {
        $id = $request->request->get('id');
        parent::emailRemoveAction($id);
        return new Response();
    }

    public function adminPhotoAction() {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            $image = parent::imageAction();
            $category = parent::categoryAction();
            $session = $this->getRequest()->getSession();
            $locale = $session->get('changeLocale');
            if (!isset($locale)) {
                $locale = 0;
            }
            return $this
                            ->render('AslanAdminBundle:Default:photo.admin.html.twig', array("image" => $image,
                                "category" => $category[0],
                                "changeLocale" => $locale));
        }
    }

    public function adminPageAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if ($request->getMethod() == 'POST') {
            $session->set('onemenu_id', $request->request->get('id'));
            return new Response();
        }
        $id = $session->get('onemenu_id');
        if (!isset($id)) {
            $id = 1;
            $session->get('onemenu_id', 1);
        }
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            $onemenu = parent::findOneAction('Page', $id);
            $onemenuall = parent::findAllAction('Page');
            return $this
                            ->render('AslanAdminBundle:Default:admin.html.twig', array("id" => $id, "onemenu" => $onemenu,
                                "onemenuall" => $onemenuall, 'menu' => 1));
        }
    }

    public function adminParkettAction(Request $request) {
        $idBrand = $request->request->get('id');
        return $this->idPageAction($idBrand);
        //return new Response($idBrand);
    }

    public function adminMiddleMenuAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            //$onemenu = parent::oneMenuAction($id);
            $secondmenuall = parent::secondMenuAllAction();
            $thirdmenuall = parent::thirdPodMenuAllAction();
            return $this
                            ->render(
                                    'AslanAdminBundle:Default:admin.middlemenu.html.twig', array(/* "onemenu" => $onemenu, */ "thirdmenuall" => $thirdmenuall,
                                "secondmenuall" => $secondmenuall,
                                'menu' => 2));
        }
    }

    public function adminBrandImgAction(Request $request) {
        $id = $request->request->get('id');
        return new Response(parent::brandImgAction($id));
    }

    public function adminAlbumsImgAction(Request $request) {
        $id = $request->request->get('id');
        return new Response(parent::albumsImgAction($id));
    }

    public function adminBrandAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            //$onemenu = parent::oneMenuAction($id);
            $brandall = parent::brandAllAction();
            $page = new Brands();
            $form = $this->createForm(new BrandType(), $page);
            if ($request->getMethod() == 'POST') {
                $form->bindRequest($request);
                $name = $form['name']->getData();
                $id = $form['id']->getData();
                //$found = parent::emailOneFoundImageAction($text);
                $src = parent::brandUpdateAction($name, $id);
                return new Response($src);
                /* if (!$found) {
                  parent::emailSetImageAction($text);
                  return new Response(
                  $this->get('translator')
                  ->trans("Thank you! We'll notify you."));
                  } else {
                  return new Response(
                  $this->get('translator')
                  ->trans(
                  "Sorry, but this email already exists!"));
                  } */
            } else {
                return $this
                                ->render(
                                        'AslanAdminBundle:Default:admin.brand.html.twig', array("secondmenuall" => $brandall,
                                    'menu' => 5,
                                    "form" => $form->createView()));
            }
        }
    }

    public function adminBlogsFormAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            //$onemenu = parent::oneMenuAction($id);
            $page = new Blogs();
            $form = $this->createForm(new BlogsType(), $page);
            if ($request->getMethod() == 'POST') {
                $form->bindRequest($request);
                $file = $form['img']->getData();
                $text = $page->getText();
                if (!$text)
                    $text = '&nbsp;';
                $head = $page->getHeader();
                if (!$head)
                    $head = '&nbsp;';
                $date = $page->getDate();
                if (!$date)
                    $date = '&nbsp;';
                $name = $page->getName();
                if (!$name)
                    $name = '&nbsp;';
                $id = $page->getId();
                if (!$id)
                    $id = '';
                $fileName = '';
                if ($file) {
                    //$extension = $file->guessExtension();
                    $unlink = parent::oneBlogsAction($id);
                    if ($unlink) {
                        unlink("media/pictures/" . $unlink->getImg());
                    }
                    $extension = ".jpg";
                    $fileName = 'img' . date('YmdHis') . '.' . $extension;
                    $file->move('media/pictures/', $fileName);
                    $blogs = $this->blogsImage('media/pictures/' . $fileName, 250);
                    $this->get('image.handling')->open('media/pictures/' . $fileName)->resize($blogs['width'], $blogs['height'])->save('media/pictures/small' . $fileName);
                }
                $src = parent::blogsUpdateAction($head, $date, $name, $text, $fileName, $id);
                return new Response($src);
            } else {
                return $this
                                ->render(
                                        'AslanAdminBundle:Default:admin.blogsForm.html.twig', array("form" => $form->createView()));
            }
        }
    }

    public function adminBlogsAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            //$onemenu = parent::oneMenuAction($id);
            $brandall = parent::blogsAllAction();

            return $this
                            ->render(
                                    'AslanAdminBundle:Default:admin.blogs.html.twig', array("secondmenuall" => $brandall,
                                'menu' => 4));
        }
    }

    public function adminPageImgNewAction(Request $request) {
        $fileName2 = array();
        $send = array();
        $id = $request->request->get('idImg');
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
                                $blogs = $this->blogsImage('media/pictures/' . $fileName2[$k], 250);
                                $this->get('image.handling')->open('media/pictures/' . $fileName2[$k])->zoomCrop(250, 250)->save('media/pictures/small' . $fileName2[$k]);
                            }
                        }
                    }
                }
            }
            for ($i = 0; $i < count($fileName2); $i++) {
                $idd = parent::PageImgNew2Action($id, $fileName2[$i]);
                $send[$i]['id'] = $idd;
                $send[$i]['src'] = $fileName2[$i];
            }
        }
        return new Response(json_encode($send));
    }

    public function adminAlbomAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            //$albums = parent::findAllAction('Albums');
            $page = new Pages();
            $placeall = parent::blogsAllAction();
            $form = $this->createForm(new PageType($placeall), $page);
            if ($request->getMethod() == 'POST') {
                $form->bindRequest($request);
                $id = $page->getId();
                $name = $page->getName();
                $time = $page->getTime();
                $place = $page->getPlace();
                $file = $form['img']->getData();
                $fileName = '';
                if ($file) {
                    if ($id != '') {
                        $unlink = parent::findOneAction('Albums', $id);
                        if ($unlink) {
                            if (file_exists("media/pictures/" . $unlink->getSrc()))
                                unlink("media/pictures/" . $unlink->getSrc());
                        }
                    }
                    $extension = ".jpg";
                    $fileName = 'img' . date('YmdHis') . '.' . $extension;
                    $file->move('media/pictures/', $fileName);
                    $blogs = $this->blogsImage('media/pictures/' . $fileName, 250);
                    $this->get('image.handling')->open('media/pictures/' . $fileName)->resize($blogs['width'], $blogs['height'])->save('media/pictures/small' . $fileName);
                }
                if (!$id)
                    $id = '';
                $id = parent::albumNewAction($id, $name, $fileName, $time, $place);
                $send = array("id" => $id, "name" => $name, "filename" => $fileName, "time" => $page->getTime());
                return new Response(json_encode($send));
            } else {
                return new Response(
                        $this
                                ->render(
                                        'AslanAdminBundle:Default:admin.albumsForm.html.twig', array("form" => $form->createView())));
            }
        }
    }

    public function adminNewMiddleMenuAction() {
        $id = parent::secondMenuNewAction();
        return new Response($id);
    }

    public function adminPodMiddleMenuAction(Request $request) {
        $id = $request->request->get('id');
        $id2 = $request->request->get('id2');
        $idd = parent::podMenuNewAction($id, $id2);
        return new Response($idd);
    }

    public function adminBrandPageAction(Request $request) {
        $id = $request->request->get('id');
        $pod = parent::brandPageAction($id);
        $ret = array();
        for ($i = 0; $i < count($pod); $i++) {
            $ret[$i][0] = $pod[$i]->getId();
            $ret[$i][1] = $pod[$i]->getName();
        }
        return new Response(json_encode($ret));
    }

    public function adminPodMiddle2MenuAction(Request $request) {
        $id = $request->request->get('id');
        parent::podMenuRemoveAction($id);
        return new Response();
    }

    public function adminPodMiddleMenuViewAction(Request $request) {
        $id = $request->request->get('id');
        $pod = parent::podMenuAction($id);
        $ret = array();
        for ($i = 0; $i < count($pod); $i++) {
            $ret[$i][0] = $pod[$i]->getId();
            $ret[$i][1] = $pod[$i]->getName();
        }
        return new Response(json_encode($ret));
    }

    public function adminPodThirdMenuViewAction(Request $request) {
        $id = $request->request->get('id');
        $pod = parent::thirdMenuAction($id);
        $ret = array();
        for ($i = 0; $i < count($pod); $i++) {
            $ret[$i][0] = $pod[$i]->getId();
            $ret[$i][1] = $pod[$i]->getName();
        }
        return new Response(json_encode($ret));
    }

    public function adminPodThird2MenuAction(Request $request) {
        $id = $request->request->get('id');
        parent::podThirdMenuRemoveAction($id);
        return new Response();
    }

    public function adminPodThirdMenuAction(Request $request) {
        $id = $request->request->get('id');
        $id2 = $request->request->get('id2');
        $idd = parent::podThirdMenuNewAction($id, $id2);
        return new Response($idd);
    }

    public function adminRemoveMiddleMenuAction(Request $request) {
        $id = $request->request->get('id');
        parent::secondMenuRemoveAction($id);
        return new Response();
    }

    public function adminRemoveBrandAction(Request $request) {
        $id = $request->request->get('id');
        parent::brandRemoveAction($id);
        return new Response();
    }

    public function adminRemoveAlbumsAction(Request $request) {
        $id = $request->request->get('id');
        parent::albumsRemoveAction($id);
        return new Response();
    }

    public function adminRemoveBlogAction(Request $request) {
        $id = $request->request->get('id');
        parent::blogRemoveAction($id);
        return new Response();
    }

    public function hameleonAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Page');
        $page = $repository->findAll();
        for ($i = 0; $i < count($page); $i++) {
            $blogs = $this->blogsImage('media/pictures/' . $page[$i]->getImg(), 250);
            $this->get('image.handling')->open('media/pictures/' . $page[$i]->getImg())->resize($blogs['width'], $blogs['height'])->save('media/pictures/small' . $page[$i]->getImg());
            $imgg = $page[$i]->getPageimgs();
            for ($j = 0; $j < count($imgg); $j++) {
                $blogs = $this->blogsImage('media/pictures/' . $imgg[$j]->getImg(), 100);
                $this->get('image.handling')->open('media/pictures/' . $imgg[$j]->getImg())->resize($blogs['width'], $blogs['height'])->save('media/pictures/small' . $imgg[$j]->getImg());
            }
        }
        return new Response("yse");
    }

    public function adminRemovePageImgAction(Request $request) {
        $id = $request->request->get('id');
        parent::pageImgRemoveAction($id);
        return new Response();
    }

    public function adminRemovePageImg2Action(Request $request) {
        $id = $request->request->get('id');
        parent::pageImgRemove2Action($id);
        return new Response();
    }    
    
    public function idPageAction($id) {
        $page = parent::onePageAction($id);
        $ret = array();
        if ($page) {
            for ($i = 0; $i < count($page); $i++) {
                $ret[$i][0] = $page[$i]->getId();
                $ret[$i][1] = $page[$i]->getName();
                $ret[$i][2] = $page[$i]->getImg();
                $ret[$i][3] = $page[$i]->getDescription();
                $ret[$i][4] = $page[$i]->getText();
                $ret[$i][5] = $page[$i]->getWood();
                $ret[$i][6] = $page[$i]->getCountry();
                $ret[$i][7] = $page[$i]->getGrade();
                $ret[$i][8] = $page[$i]->getProcessing();
                $ret[$i][9] = $page[$i]->getWidth();
                $ret[$i][10] = $page[$i]->getLength();
                $ret[$i][11] = $page[$i]->getThickness();
                $ret[$i][12] = $page[$i]->getArticle();
                $ret[$i][13] = $page[$i]->getBrand()->getId();
                /* for ($i = 0, $j = 14; $i < count($page->getPageimgs()); $i++ . $j++) {
                  $pag = $page->getPageimgs();
                  $ret[0][$j] = $pag[$i]->getImg();
                  } */
            }
        }
        return new Response(json_encode($ret));
    }

    public function idAlbumsAction(Request $request) {
        $id = $request->request->get('id');
        $page = parent::findOneAction('Albums', $id);
        $ret = array();
        $ret[0][0] = $page->getId();
        $ret[0][1] = $page->getName();
        $ret[0][2] = $page->getSrc();
        $ret[0][3] = $page->getPlace()->getId();
        return new Response(json_encode($ret));
    }

    public function idBlogsAction(Request $request) {
        $id = $request->request->get('id');
        $page = parent::oneBlogsAction($id);
        $ret = array();
        $ret[0][0] = $page->getId();
        $ret[0][1] = $page->getName();
        $ret[0][2] = $page->getPage();
        $ret[0][3] = $page->getHead();
        $ret[0][4] = $page->getDate();
        return new Response(json_encode($ret));
    }

    public function idThirdMenuAction(Request $request) {
        $id = $request->request->get('id');
        $page = parent::thirdMenuIdAction($id);
        $ret = array();
        $ret[0][0] = $page->getId();
        $ret[0][1] = $page->getName();
        $ret[0][2] = $page->getText();
        return new Response(json_encode($ret));
    }

    public function adminThirdMenuAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if ($request->getMethod() == 'POST') {
            $session->set('thirdmenu_id', $request->request->get('id'));
            return new Response();
        }
        $id = $session->get('thirdmenu_id');
        if (!isset($id)) {
            $id = 1;
            $session->get('thirdmenu_id', 1);
        }
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            $onemenu = parent::thirdMenuIdAction($id);
            $onemenuall = parent::thirdMenuAllAction();
            return $this
                            ->render('AslanAdminBundle:Default:admin.thirdmenu.html.twig', array("id" => $id, "onemenu" => $onemenu,
                                "onemenuall" => $onemenuall, 'menu' => 3));
        }
    }

    public function adminRenameSecondmenuAction(Request $request) {
        $text = $request->request->get('text');
        $id = $request->request->get('id');
        parent::secondMenuUpdateAction($text, $id);
        return new Response();
    }

    public function adminRenameBrandAction(Request $request) {
        $text = $request->request->get('text');
        $text2 = $request->request->get('text2');
        $text3 = $request->request->get('text3');
        $id = $request->request->get('id');
        parent::brandUpdateAction($text, $text2, $text3, $id);
        return new Response($text);
    }

    public function adminRenameThirdmenuAction(Request $request) {
        $text = $request->request->get('text');
        $text2 = $request->request->get('text2');
        $text3 = $request->request->get('text3');
        $id = $request->request->get('id');
        parent::thirdMenuUpdateAction($text, $text2, $text3, $id);
        return new Response();
    }

    public function adminNewThirdMenuAction() {
        $id = parent::thirdMenuNewAction();
        return new Response($id);
    }

    public function adminRemoveThirdMenuAction(Request $request) {
        $id = $request->request->get('id');
        parent::thirdMenuRemoveAction($id);
        return new Response();
    }

    public function adminChangeLocaleAction(Request $request) {
        $locale = $request->request->get('locale');
        $session = $this->getRequest()->getSession();
        $session->set('changeLocale', $locale);
        return new Response();
    }

    public function adminChangeOneMenuAction(Request $request) {
        $id = $request->request->get('id');
        $text = $request->request->get('text');
        if (!$id || !$text) {
            return new Response(
                    '<script>alert("Ошибка изменения текста страницы!");window.location.href="/admin";</script>');
        } else {
            parent::oneMenuChangeAction($id, $text);
            return new Response();
        }
    }

    public function logAction(Request $request) {
        $login = $request->request->get('login');
        $password = $request->request->get('password');
        if (!$password || !$login) {
            return new Response(
                    '<script>alert("Не все поля заполнены!");window.location.href="/admin";</script>');
        } else {
            $user = parent::userAction($login);
            if (!$user) {
                return new Response(
                        '<script>alert("Неверный логин или пароль!");window.location.href="/admin";</script>');
            } else {
                $hash = hash("sha256", $password);
                $log = parent::logGetAction($login, $hash);
                if (!$log) {
                    return new Response(
                            '<script>alert("Неверный логин или пароль!");window.location.href="/admin";</script>');
                } else {
                    $session = $this->getRequest()->getSession();
                    $user_id = $session->set('user_id', 1);
                    return $this
                                    ->redirect(
                                            $this
                                            ->generateUrl(
                                                    'AslanAdminBundle_admin_place'), 301);
                }
            }
        }
    }

    public function adminVideoUploadAction(Request $request) {
        $code = $request->request->get('code');
        $head = $request->request->get('head');
        $fileName2 = array();
        if (!$code) {
            return new Response(
                    '<script>alert("Введите код видео!");history.back();</script>');
        } else {
//            if (isset($_FILES['files'])) {
//                foreach ($_FILES['files']['name'] as $k => $f) {
//                    if (!$_FILES['files']['error'][$k]) {
//                        if (is_uploaded_file($_FILES['files']['tmp_name'][$k])) {
//                            $extension = ".jpg";
//                            $fileName2[$k] = 'img' . $k . date('YmdHis') . '.'
//                                    . $extension;
//                            if (move_uploaded_file(
//                                            $_FILES['files']['tmp_name'][$k], "media/pictures/" . $fileName2[$k])) {
//                                
//                            }
//                        }
//                    }
//                }
//            }
            parent::videoSetAction($code, $head);
            return $this
                            ->redirect(
                                    $this
                                    ->generateUrl(
                                            'AslanAdminBundle_admin_video'), 301);
        }
    }

    public function adminVideoDeleteAction(Request $request) {
        $id = $request->request->get('id');
        return parent::videoDeleteAction($id);
    }

    public function adminVideoChangeCodeAction(Request $request) {
        $id = $request->request->get('id');
        $code = $request->request->get('code');
        $type = $request->request->get('type');
        return parent::codeChangeVideoAction($id, $code, $type);
    }

    public function adminPhotoDeleteAction(Request $request) {
        $id = $request->request->get('id');
        return parent::photoDeleteAction($id);
    }

    public function adminDescrEditAction(Request $request) {
        $id = $request->request->get('id');
        $val = $request->request->get('val');
        return parent::descrEditAction($id, $val);
    }

    public function adminHeadEditAction(Request $request) {
        $id = $request->request->get('id');
        $val = $request->request->get('val');
        return parent::headEditAction($id, $val);
    }

    public function adminCatChangeAction(Request $request) {
        $id = $request->request->get('id');
        $val = $request->request->get('val');
        return parent::catChangeAction($id, $val);
    }

    public function adminPhotoUploadAction() {
        return parent::photoUploadAction($_FILES);
    }

}
