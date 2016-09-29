<?php

namespace Aslan\PageBundle\Controller;

use Aslan\StoreBundle\Controller\StoreController as StoreController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Aslan\PageBundle\Form\Type\EmailType;
use Aslan\PageBundle\Entity\Email;
use Aslan\BackgroundBundle\Entity\Background;

class PageController extends StoreController {

    //возврат рандомного фона
    public function backgroundRandAction() {

        $repository = $this->getDoctrine()
                ->getRepository('AslanBackgroundBundle:Background');
        $img = $repository->findAll();
//        $session = $this->getRequest()->getSession();
//        $randSession = $session->get('rand');
//        $rand = rand(1, count($img));
//        if ($randSession != '') {
//            $flag = 0;
//            while ($flag != 1) {
//                $rand = rand(1, count($img));
//                if ($randSession != $rand)
//                    $flag = 1;
//            }
//            $session->set('rand', $rand);
//        } else {
//            $session->set('rand', $rand);
//        }
//        $ret = array();
//        $ret['src'] = $img[$rand - 1]->getSrc();
//        $ret['position'] = $img[$rand - 1]->getPosition();
        return $img;
    }

    public function sizes($width, $height, $img_, $id) {
        $siz_ = array();
        $s = $width;
        $s2 = $height;
        if ($img_) {
            $left_ = 0;
            $top2_ = 0;
            $size_ = getimagesize('media/pictures/' . $img_);
            $width_ = $size_[0];
            $height_ = $size_[1];
            if ($height_ > $width_) {
                $width_ = $s;
                $height_ = ($size_[1] / $size_[0]) * $width_;
                if ($height_ > $s) {
                    $top2_ = ($height_ - $s) / 2;
                } else {
                    $top2_ = 0;
                }
            } else {
                $height_ = $s2;
                $width_ = ($size_[0] / $size_[1]) * $height_;
                if ($width_ > $s) {
                    $left_ = ($width_ - $s) / 2;
                } else {
                    $left_ = 0;
                }
            }
            $siz_['top'] = $top2_;
            $siz_['left'] = $left_;
            $siz_['width'] = $width_;
            $siz_['height'] = $height_;
            $siz_['id'] = $id;
        }
        return $siz_;
    }

    public function videoPreviewAction() {
        return $this
                        ->render('AslanPageBundle:Default:videoPreview.html.twig');
    }

    public function sizess($width, $height, $img_, $id) {
        $siz_ = array();
        $s = $width;
        $s2 = $height;
        if ($img_) {
            $left_ = 0;
            $top2_ = 0;
            $size_ = getimagesize('media/pictures/' . $img_);
            $width_ = $size_[0];
            $height_ = $size_[1];
            if ($height_ < $width_) {
                $width_ = $s;
                $height_ = ($size_[1] / $size_[0]) * $width_;
                //if ($height_ > $s) {
                $top2_ = ($s2 - $height_) / 2;
                //} else {
                $left_ = 0;
                //}
            } else {
                $height_ = $s2;
                $width_ = ($size_[0] / $size_[1]) * $height_;
                //if ($width_ > $s) {
                //$left_ = ($s - $width_) / 2;
                //} else {
                $left_ = 0;
                $top2_ = 0;
                //}
            }
            $siz_['top'] = $top2_;
            $siz_['left'] = $left_;
            $siz_['width'] = $width_;
            $siz_['height'] = $height_;
            $siz_['id'] = $id;
        }
        return $siz_;
    }

    public function blogAction(Request $request) {
        $number = $request->request->get('id');
        $blogs = parent::oneBlogsAction($number);
        $blog = array();
        $blog['name'] = $blogs->getHead();
        $blog['text'] = $blogs->getPage();
        return new Response(json_encode($blog));
    }

    public function blogsAction() {
        $blogs = parent::findAllAction('News');
        $contacts = parent::findOneAction('Page', 2);
        $about = parent::findOneAction('Page', 3);
        $bgr = $this->backgroundRandAction();
        return $this
                        ->render('AslanPageBundle:Default:blogs.html.twig', array("title" => 'Blog', "blogs" => $blogs,
                            'imgRand' => $bgr,
                            "contacts" => $contacts->getText(),
                            "about" => $about->getText()
        ));
    }

    public function videosAction(Request $request) {
        $number = $request->request->get('id');
        $blogs = parent::findOneAction('Video', $number);
        $blog = array();
        $blog['video'] = $blogs->getCode();
        return new Response(json_encode($blog));
    }

    public function searchAction() {
        $poroda = @$_POST['poroda'];
        $color = @$_POST["color"];
        $pokr = @$_POST["pokr"];
        $locale = $this->get('request')->getLocale();
        if ($locale == 'ru')
            $send = parent::filterAction($poroda, $color, $pokr);
        if ($locale == 'en')
            $send = parent::filterEnAction($poroda, $color, $pokr);
        if ($locale == 'de')
            $send = parent::filterDeAction($poroda, $color, $pokr);
        return new Response(json_encode($send));
    }

    public function searchBrandAction($id) {
        $page = parent::brandPageAction($id);
        $secondmenu = parent::secondMenuAllAction();
        $thirdmenu = parent::thirdMenuAllAction();
        $siz_ = array();
        $s = 230;
        $s2 = 172;
        if ($page) {
            $left_ = 0;
            $top2_ = 0;
            for ($i = 0; $i < count($page); $i++) {
                $img_ = $page[$i]->getImg();
                if ($img_) {
                    $size_ = getimagesize('media/pictures/' . $img_);
                    $width_ = $size_[0];
                    $height_ = $size_[1];
                    if ($height_ > $width_) {
                        $width_ = $s;
                        $height_ = ($size_[1] / $size_[0]) * $width_;
                        if ($height_ > $s) {
                            $top2_ = ($height_ - $s) / 2;
                        } else {
                            $top2_ = 0;
                        }
                    } else {
                        $height_ = $s2;
                        $width_ = ($size_[0] / $size_[1]) * $height_;
                        if ($width_ > $s) {
                            $left_ = ($width_ - $s) / 2;
                        } else {
                            $left_ = 0;
                        }
                    }
                    $siz_[$i]['top'] = $top2_;
                    $siz_[$i]['left'] = $left_;
                    $siz_[$i]['top'] = $top2_;
                    $siz_[$i]['width'] = $width_;
                    $siz_[$i]['height'] = $height_;
                    $siz_[$i]['id'] = $page[$i]->getId();
                    $top2_ = '';
                    $width_ = '';
                    $height_ = '';
                    $left_ = '';
                }
            }
        } else {
            $top2_ = '';
            $width_ = '';
            $height_ = '';
            $left_ = '';
        }
        return $this
                        ->render('AslanPageBundle:Default:searchId.html.twig', array("title" => "Поиск", "secondmenu" => $secondmenu,
                            "thirdmenu" => $thirdmenu, "search" => "1",
                            "page" => $page, 'siz' => $siz_));
    }

    public function thirdmenuVseAction($number) {
        $secondmenu = parent::secondMenuAllAction();
        $thirdmenu = parent::thirdMenuAllAction();
        $page = parent::thirdMenuIdAction($number);
        $blogs = parent::blogsAllAction();
        $men = $_GET['men'];
        $id = '0';
        return $this
                        ->render('AslanPageBundle:Default:thirdmenu.html.twig', array("title" => 'Страница',
                            "secondmenu" => $secondmenu,
                            "thirdmenu" => $thirdmenu, 'men' => $men,
                            'id' => $id, "page" => $page, 'blogs' => $blogs));
    }

    public function pageAction($id) {
        $secondmenu = parent::secondMenuAllAction();
        $onemenu = parent::oneMenuAction($id);
        $thirdmenu = parent::thirdMenuAllAction();
        $baner = parent::findAllAction('Baner');
        return $this
                        ->render('AslanPageBundle:Default:page.html.twig', array("title" => $onemenu->getName(),
                            "onemenu" => $onemenu,
                            "secondmenu" => $secondmenu,
                            "baner" => $baner,
                            "thirdmenu" => $thirdmenu, "id" => $id));
    }

    public function albumsAction() {
        $img = parent::findAllAction('Albums');
        $bgr = $this->backgroundRandAction();
        $top_menu = parent::findAllAction('Page', 0);
        $bottom_menu = parent::findAllAction('Page', 1);
        $baner = parent::findAllAction('Baner');
        $months = array("", "Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
        return $this
                        ->render('AslanPageBundle:Default:albums.html.twig', array(
                            "title" => 'Фото',
                            "albums" => $img,
                            'imgRand' => $bgr,
                            "top_menu" => $top_menu,
                            "bottom_menu" => $bottom_menu,
                            "months" => $months,
                            "baner" => $baner
        ));
    }

    public function afishaJsonAction(Request $request) {
        $id = explode(":", (string)$request->get('id'));
        //return new Response(json_encode($id));
        $response = array();
        $i = 0;
        foreach($id as $val){
            $afisha = parent::findOneAction('Afisha', $val);
            $response[$i]['id'] = $afisha->getId();
            $response[$i]['slug'] = $afisha->getSlug();
            $response[$i]['name'] = $afisha->getName();
            $response[$i]['date'] = $afisha->getDate();
            $response[$i]['img'] = $afisha->getImg();
            $i++;
        }
        $months = array("", "Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
        return $this
                        ->render('AslanPageBundle:Default:afishaOne.html.twig', array(
                            "afisha" => $response,
                            "months" => $months
        ));
    }

    public function afishaAction() {
        $img = parent::findAllAction('Afisha');
        $i = 0;
        $dat = array();
        foreach ($img as $item) {
            $op = 0;
            if (count($dat) > 0) {
                foreach ($dat as $val) {
                    if ($val['date'] == $item->getDate())
                        $op = 1;
                }
                if ($op == 0) {
                    $dat[$i]['date'] = $item->getDate();
                    $dat[$i]['count'] = 0;
                    $dat[$i]['ev'] = '';
                    $i++;
                } else {
                    $op = 0;
                }
            } else {
                $dat[$i]['date'] = $item->getDate();
                $dat[$i]['count'] = 0;
                $dat[$i]['ev'] = '';

                $i++;
            }
        }
        $i = 0;
        $d = array();

        foreach ($img as $item) {
            for ($j = 0; $j < count($dat); $j++) {
                if ($item->getDate() == $dat[$j]['date']) {
                    if(isset($d[$j])){
                        $d[$j] = $d[$j].(string)$item->getId().':';
                    }else{
                        $d[$j] = (string)$item->getId().':';
                    }
                    $dat[$j]['count'] = $dat[$j]['count'] + 1;
                    $dat[$j]['title'] = '<a href="#" onclick="openDay(\'' . $d[$j] . '\'); return false;">' . $dat[$j]['count'] . '</a>';
                    $dat[$j]['start'] = $dat[$j]['date'];
                    $dat[$j]['end'] = $dat[$j]['date'];
                }
            }
        }
        $afisha = json_encode($dat);
        $bgr = $this->backgroundRandAction();
        $top_menu = parent::findAllAction('Page', 0);
        $bottom_menu = parent::findAllAction('Page', 1);
        $months = array("", "Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
        $baner = parent::findAllAction('Baner');
        return $this
                        ->render('AslanPageBundle:Default:afisha.html.twig', array(
                            "title" => 'Фото',
                            "afisha" => $img,
                            "afisha_json" => $afisha,
                            'imgRand' => $bgr,
                            "top_menu" => $top_menu,
                            "bottom_menu" => $bottom_menu,
                            "months" => $months,
                            "baner" => $baner
        ));
    }

    public function afishaOneAction($slug) {
        $img = parent::findOneSlugAction('Afisha', $slug);
        $bgr = $this->backgroundRandAction();
        $top_menu = parent::findAllAction('Page', 0);
        $bottom_menu = parent::findAllAction('Page', 1);
        $months = array("", "Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
        $baner = parent::findAllAction('Baner');
        return $this
                        ->render('AslanPageBundle:Default:page.html.twig', array(
                            "title" => 'Фото',
                            "page" => $img,
                            'imgRand' => $bgr,
                            "top_menu" => $top_menu,
                            "bottom_menu" => $bottom_menu,
                            "months" => $months,
                            "baner" => $baner
        ));
    }

    public function placeAction() {
        $img = parent::findAllAction('News');
        $bgr = $this->backgroundRandAction();
        $top_menu = parent::findAllAction('Page', 0);
        $bottom_menu = parent::findAllAction('Page', 1);
        $months = array("", "Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
        $baner = parent::findAllAction('Baner');
        return $this
                        ->render('AslanPageBundle:Default:place.html.twig', array(
                            "title" => 'Фото',
                            "place" => $img,
                            'imgRand' => $bgr,
                            "top_menu" => $top_menu,
                            "bottom_menu" => $bottom_menu,
                            "months" => $months,
                            "baner" => $baner
        ));
    }

    public function placeOneAction($slug) {
        $img = parent::findOneSlugAction('News', $slug);
        $bgr = $this->backgroundRandAction();
        $top_menu = parent::findAllAction('Page', 0);
        $bottom_menu = parent::findAllAction('Page', 1);
        $months = array("", "Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
        $baner = parent::findAllAction('Baner');
        return $this
                        ->render('AslanPageBundle:Default:placeOne.html.twig', array(
                            "title" => 'Фото',
                            "place" => $img,
                            'imgRand' => $bgr,
                            "top_menu" => $top_menu,
                            "bottom_menu" => $bottom_menu,
                            "months" => $months,
                            "baner" => $baner
        ));
    }

    public function categoriiAction() {
        $img = parent::findAllAction('Category');
        $bgr = $this->backgroundRandAction();
        $top_menu = parent::findAllAction('Page', 0);
        $bottom_menu = parent::findAllAction('Page', 1);
        $months = array("", "Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
        $baner = parent::findAllAction('Baner');
        return $this
                        ->render('AslanPageBundle:Default:categorii.html.twig', array(
                            "title" => 'Фото',
                            "category" => $img,
                            'imgRand' => $bgr,
                            "top_menu" => $top_menu,
                            "bottom_menu" => $bottom_menu,
                            "months" => $months,
                            "baner" => $baner
        ));
    }

    public function albumAction($name) {
        $img = parent::findAllAction('Image');
        $bgr = $this->backgroundRandAction();
        $top_menu = parent::findAllAction('Page', 0);
        $bottom_menu = parent::findAllAction('Page', 1);
        $months = array("", "Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
        $baner = parent::findAllAction('Baner');
        return $this
                        ->render('AslanPageBundle:Default:album.html.twig', array(
                            "title" => 'Фото',
                            "album" => $img,
                            'imgRand' => $bgr,
                            "top_menu" => $top_menu,
                            "bottom_menu" => $bottom_menu,
                            "months" => $months,
                            "baner" => $baner
        ));
    }

    public function photoAction() {
        $img = parent::findAllAction('Image', "photo");
        $contacts = parent::findOneAction('Page', 2);
        $about = parent::findOneAction('Page', 3);
        $columns = array();
        $c = 0;
        foreach ($img as $i) {
            $columns[$c % 4][] = $i;
            $c++;
        }
        $random = array();
        $sizes = array();
        $locale = $this->get('request')->getLocale();
        for ($j = 0; $j < count($img); $j++) {
            $sizes[$j] = $this
                    ->sizes(205, 205, $img[$j]->getSrc(), $img[$j]->getId());
        }
        $bgr = $this->backgroundRandAction();
        $images = parent::findAllArrayAction('Image', "photo");
        $baner = parent::findAllAction('Baner');
        return $this
                        ->render('AslanPageBundle:Default:catalog.html.twig', array("title" => 'Фото',
                            "columns" => $columns, "images" => $images, "siz" => $sizes, 'imgRand' => $bgr,
                            "contacts" => $contacts->getText(),
                            "about" => $about->getText(),
                            "baner" => $baner
        ));
    }

    public function lifeAction() {
        $img = parent::findAllAction('Image', "life");
        $contacts = parent::findOneAction('Page', 2);
        $about = parent::findOneAction('Page', 3);
        $columns = array();
        $c = 0;
        foreach ($img as $i) {
            $columns[$c % 4][] = $i;
            $c++;
        }
        $random = array();
        $sizes = array();
        $locale = $this->get('request')->getLocale();
        for ($j = 0; $j < count($img); $j++) {
            $sizes[$j] = $this
                    ->sizes(205, 205, $img[$j]->getSrc(), $img[$j]->getId());
        }
        $bgr = $this->backgroundRandAction();
        $images = parent::findAllArrayAction('Image', "life");
        return $this
                        ->render('AslanPageBundle:Default:catalog.html.twig', array("title" => 'Фото',
                            "columns" => $columns, "images" => $images, "siz" => $sizes, 'imgRand' => $bgr,
                            "contacts" => $contacts->getText(),
                            "about" => $about->getText()
        ));
    }

    public function pageimgidAction(Request $request) {
        $id = $request->request->get('id');
        $pageimg = parent::oneParkettAction($id);
        $send = array();
        $pageimgs = $pageimg->getPageimgs();
        for ($i = 0; $i < count($pageimgs); $i++) {
            $send[$i]['src'] = $pageimgs[$i]->getImg();
            $m = $this->sizess(500, 440, $send[$i]['src'], $id);
            $send[$i]['top'] = $m['top'];
            $send[$i]['left'] = $m['left'];
            $send[$i]['width'] = $m['width'];
            $send[$i]['height'] = $m['height'];
        }
        return new Response(json_encode($send));
    }

    public function homeAction() {
        $page = parent::findOneAction('Page', 1);
        $top_menu = parent::findAllAction('Page', 0);
        $bottom_menu = parent::findAllAction('Page', 1);
        $bgr = $this->backgroundRandAction();
        $sliders = parent::sliderAction();
        $places = parent::findAllAction('News');
        $albums = parent::findAllAction('Albums');
        $afisha = parent::findAllAction('Afisha');
        $baner = parent::findAllAction('Baner');
        $months = array("", "Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
        return $this
                        ->render(
                                'AslanPageBundle:Default:main.html.twig', array(
                            'title' => '',
                            "page" => $page,
                            'imgRand' => $bgr,
                            "top_menu" => $top_menu,
                            "bottom_menu" => $bottom_menu,
                            "sliders" => $sliders,
                            "places" => $places,
                            "albums" => $albums,
                            "months" => $months,
                            "afisha" => $afisha,
                            "baner" => $baner
        ));
    }

    public function aboutAction() {
        $page = parent::findOneAction('Page', 1);
        $about = parent::findOneAction('Page', 3);
        $contacts = parent::findOneAction('Page', 2);
        $bgr = $this->backgroundRandAction();
        return $this
                        ->render(
                                'AslanPageBundle:Default:page.html.twig', array('title' => '', "page" => $page, "about" => $about->getText(), 'imgRand' => $bgr, "contacts" => $contacts->getText()));
    }

    public function pageMenuAction($slug) {
        $page = parent::oneMenuSlugAction($slug);
        if(count($page) <= 0){
            $page = parent::findOneSlugAction('News', $slug);
        }
        $top_menu = parent::findAllAction('Page', 0);
        $bottom_menu = parent::findAllAction('Page', 1);
        $sliders = parent::sliderAction();
        $places = parent::findAllAction('News');
        return $this
                        ->render(
                                'AslanPageBundle:Default:page.html.twig', array(
                                    'title' => '',
                                    "page" => $page,
                                    "top_menu" => $top_menu,
                                    "bottom_menu" => $bottom_menu,
                                    "sliders" => $sliders,
                                    "places" => $places
                ));
    }

    public function videoAction(Request $request) {
        $video = parent::videoFindAllAction();
        $top_menu = parent::findAllAction('Page', 0);
        $bottom_menu = parent::findAllAction('Page', 1);
        $baner = parent::findAllAction('Baner');
        return $this
                        ->render('AslanPageBundle:Default:video.html.twig', array("title" => 'Мультики',
                            "video" => $video,
                            "top_menu" => $top_menu,
                            "bottom_menu" => $bottom_menu,
                            "baner" => $baner
        ));
    }

}
