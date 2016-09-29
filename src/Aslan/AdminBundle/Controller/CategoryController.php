<?php

namespace Aslan\AdminBundle\Controller;

use Aslan\StoreBundle\Controller\StoreController as StoreController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Aslan\AdminBundle\Form\Type\BrandType;
use Aslan\AdminBundle\Entity\Brands;
use Aslan\AdminBundle\Form\Type\CategoryType;
use Aslan\AdminBundle\Entity\Category;

class CategoryController extends StoreController {

    public function categoryImage($img, $val) {
        $blogsNew = array();
        $size = getimagesize($img);
        $width = $size[0];
        $height = $size[1];
        $const = $width / $height;
        $blogsNew['width'] = $val;
        $blogsNew['height'] = $val / $const;
        return $blogsNew;
    }

    public function adminImgAction(Request $request, $type) {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            //$onemenu = parent::oneMenuAction($id);
            $pag = parent::imgAction($type);
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
                $src = parent::imgNewAction($fileName, $href, $type);
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
                if ($type == "photo")
                    $menu = 2;
                else
                    $menu = 6;
                $form['href']->setData('http://');
                return $this
                                ->render(
                                        'AslanAdminBundle:Default:admin.slider.html.twig', array("img" => $pag, 'albums' => $albums, 'menu' => $menu,
                                    "form" => $form->createView(), "type" => $type));
            }
        }
    }

    public function adminImgDeleteAction(Request $request) {
        $id = $request->request->get('id');
        parent::imgDeleteAction($id);
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

    public function adminParkettAction(Request $request) {
        $idBrand = $request->request->get('id');
        return $this->idPageAction($idBrand);
        //return new Response($idBrand);
    }

    public function adminBrandImgAction(Request $request) {
        $id = $request->request->get('id');
        return new Response(parent::brandImgAction($id));
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

    public function adminCategoryFormAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            //$onemenu = parent::oneMenuAction($id);
            $page = new Category();
            $form = $this->createForm(new CategoryType(), $page);
            if ($request->getMethod() == 'POST') {
                $form->bindRequest($request);
                $file = $form['img']->getData();
                $name = $page->getName();
                if (!$name)
                    $name = '&nbsp;';
                $id = $page->getId();
                if (!$id)
                    $id = '';
                $fileName = '';
                if ($file) {
                    //$extension = $file->guessExtension();
                    $unlink = parent::oneCategoryAction($id);
                    if ($unlink) {
                        unlink("media/pictures/" . $unlink->getImg());
                    }
                    $extension = ".jpg";
                    $fileName = 'img' . date('YmdHis') . '.' . $extension;
                    $file->move('media/pictures/', $fileName);
                    $blogs = $this->categoryImage('media/pictures/' . $fileName, 250);
                    $this->get('image.handling')->open('media/pictures/' . $fileName)->resize($blogs['width'], $blogs['height'])->save('media/pictures/small' . $fileName);
                }
                $src = parent::categoryUpdateAction($name, $fileName, $id);
                return new Response($src);
            } else {
                return $this
                                ->render(
                                        'AslanAdminBundle:Category:admin.blogsForm.html.twig', array("form" => $form->createView()));
            }
        }
    }

    public function adminCategoryAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        if (!isset($user_id)) {
            return $this
                            ->render('AslanAdminBundle:Default:login.admin.html.twig');
        } else {
            //$onemenu = parent::oneMenuAction($id);
            $brandall = parent::categoryAllAction();

            return $this
                            ->render(
                                    'AslanAdminBundle:Category:admin.blogs.html.twig', array("secondmenuall" => $brandall,
                                'menu' => 8));
        }
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

    public function adminRemoveBrandAction(Request $request) {
        $id = $request->request->get('id');
        parent::brandRemoveAction($id);
        return new Response();
    }

    public function adminRemovePlaceAction(Request $request) {
        $id = $request->request->get('id');
        parent::blogRemoveAction($id);
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

    public function idCategoryAction(Request $request) {
        $id = $request->request->get('id');
        $page = parent::oneCategoryAction($id);
        $ret = array();
        $ret[0][0] = $page->getId();
        $ret[0][1] = $page->getName();
        return new Response(json_encode($ret));
    }

    public function adminRenameBrandAction(Request $request) {
        $text = $request->request->get('text');
        $text2 = $request->request->get('text2');
        $text3 = $request->request->get('text3');
        $id = $request->request->get('id');
        parent::brandUpdateAction($text, $text2, $text3, $id);
        return new Response($text);
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
                                                    'AslanAdminBundle_admin_homepage'), 301);
                }
            }
        }
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

    public function adminParkettImgAction(Request $request) {
        $id = $request->request->get('id');
        return new Response(parent::parkettImgAction($id));
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
                                $blogs = $this->placeImage('media/pictures/' . $fileName2[$k], 100);
                                $this->get('image.handling')->open('media/pictures/' . $fileName2[$k])->resize($blogs['width'], $blogs['height'])->save('media/pictures/small' . $fileName2[$k]);
                            }
                        }
                    }
                }
            }
            for ($i = 0; $i < count($fileName2); $i++) {
                $idd = parent::PageImgNewAction($id, $fileName2[$i]);
                $send[$i]['id'] = $idd;
                $send[$i]['src'] = $fileName2[$i];
            }
        }
        return new Response(json_encode($send));
    }

}
