<?php

namespace Aslan\StoreBundle\Controller;

use Aslan\StoreBundle\Entity\User;
use Aslan\StoreBundle\Entity\Onemenu;
use Aslan\StoreBundle\Entity\Secondmenu;
use Aslan\StoreBundle\Entity\Thirdmenu;
use Aslan\StoreBundle\Entity\Page;
use Aslan\StoreBundle\Entity\ImgPage;
use Aslan\StoreBundle\Entity\News;
use Aslan\StoreBundle\Entity\Afisha;
use Aslan\StoreBundle\Entity\Category;
use Aslan\StoreBundle\Entity\Slider;
use Aslan\StoreBundle\Entity\Baner;
use Aslan\StoreBundle\Entity\Image;
use Aslan\StoreBundle\Entity\Albums;
use Aslan\StoreBundle\Entity\Video;
use Aslan\StoreBundle\Entity\Brand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Aslan\StoreBundle\Controller\VideoParser;

class StoreController extends Controller {

    public function videoFindAllAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em
                ->createQuery(
                'SELECT k FROM AslanStoreBundle:Video k order by k.id DESC');
        $pages = $query->getResult();
        return $pages;
    }

    public function findAllArrayAction($name, $type = null) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:' . $name);
        if ($type != null) {
            $page = $repository->findBy(array("type" => $type));
        } else {
            $page = $repository->findAll();
        }
        $images = array();
        $i = 0;
        foreach ($page as $im) {
            $images[$i]['id'] = $im->getId();
            $images[$i]['photo'] = $im->getSrc();
            $i++;
        }
        return json_encode($images);
    }

    public function findAllAction($name, $type = -1) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:' . $name);
        if ($type >= 0) {
            $page = $repository->findBy(array("type" => $type));
        } else {
            $page = $repository->findAll();
        }
        return $page;
    }

    public function findOneAction($name, $id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:' . $name);
        $page = $repository->find($id);
        if (!$page) {
            throw $this->createNotFoundException('No element found for id ' . $id);
        }
        return $page;
    }

    public function findOneSlugAction($name, $id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:' . $name);
        $page = $repository->findOneBy(array("slug" => $id));
        if (!$page) {
            throw $this->createNotFoundException('No element found for id ' . $id);
        }
        return $page;
    }    
    
    public function filterAction($poroda, $color, $pokr) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Page');
        if ($poroda != "") {
            $page = $repository->findBy(array("wood" => $poroda));
        } elseif ($color != "") {
            $page = $repository->findBy(array("description" => $color));
        } elseif ($pokr != "") {
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery(
                            'SELECT p FROM AslanStoreBundle:Page p WHERE p.text LIKE :text'
                    )->setParameter('text', '%' . $pokr . '%');

            $page = $query->getResult();
            // $page = $repository->findBy(array("text" => $pokr));
        } else {
            $page = $repository->findAll();
        }

        if ($poroda != "" && $color != "") {
            $page = $repository
                    ->findBy(array("wood" => $poroda, "description" => $color));
        }

        if ($poroda != "" && $pokr != "") {
            $page = $repository
                    ->findBy(array("wood" => $poroda, "text" => $pokr));
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery(
                            'SELECT p FROM AslanStoreBundle:Page p WHERE p.text LIKE :text AND p.wood LIKE :wood'
                    )->setParameters(array('text' => '%' . $pokr . '%', 'wood' => $poroda));

            $page = $query->getResult();
        }

        if ($color != "" && $pokr != "") {
            $page = $repository
                    ->findBy(array("wood" => $poroda, "text" => $pokr));
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery(
                            'SELECT p FROM AslanStoreBundle:Page p WHERE p.text LIKE :text AND p.description LIKE :description'
                    )->setParameters(array('text' => '%' . $pokr . '%', 'description' => $color));

            $page = $query->getResult();
        }

        if ($poroda != "" && $pokr != "" && $color != "") {
            $page = $repository
                    ->findBy(array("wood" => $poroda, "text" => $pokr));
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery(
                            'SELECT p FROM AslanStoreBundle:Page p WHERE p.text LIKE :text AND p.description LIKE :description AND p.wood LIKE :wood'
                    )->setParameters(array('text' => '%' . $pokr . '%', 'description' => $color, 'wood' => $poroda));

            $page = $query->getResult();
            //$page = array("poroda" => $poroda, "pokr" => $pokr, "color" => $color);
        }
        $pag = array();
        for ($i = 0; $i < count($page); $i++) {
            $pag[$i]['collection'] = $page[$i]->getBrand()->getName();
            $pag[$i]['article'] = $page[$i]->getArticle();
            $pag[$i]['thickness'] = $page[$i]->getThickness();
            $pag[$i]['length'] = $page[$i]->getLength();
            $pag[$i]['width'] = $page[$i]->getWidth();
            $pag[$i]['processing'] = $page[$i]->getProcessing();
            $pag[$i]['grade'] = $page[$i]->getGrade();
            $pag[$i]['pokr'] = $page[$i]->getText();
            $pag[$i]['wood'] = $page[$i]->getWood();
            $pag[$i]['color'] = $page[$i]->getDescription();
            $pag[$i]['img'] = $page[$i]->getImg();
            $pag[$i]['name'] = $page[$i]->getName();
            $pag[$i]['country'] = $page[$i]->getCountry();
            $pag[$i]['grade'] = $page[$i]->getGrade();
            $pag[$i]['processing'] = $page[$i]->getProcessing();
            $pag[$i]['width'] = $page[$i]->getWidth();
            $pag[$i]['length'] = $page[$i]->getLength();
            $pag[$i]['thickness'] = $page[$i]->getThickness();
            $pag[$i]['article'] = $page[$i]->getArticle();
            $pag[$i]['idd'] = $page[$i]->getId();
            $size_ = getimagesize('media/pictures/' . $pag[$i]['img']);
            $width_ = $size_[0];
            $height_ = $size_[1];
            $s = 205;
            $s2 = 205;
            $top2_ = 0;
            $left_ = 0;
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
            $pag[$i]['widthh'] = $width_;
            $pag[$i]['height'] = $height_;
            $pag[$i]['top'] = $top2_;
            $pag[$i]['left'] = $left_;
            $size_ = getimagesize('media/pictures/' . $pag[$i]['img']);
            $width_ = $size_[0];
            $height_ = $size_[1];
            $s = 500;
            $s2 = 440;
            $top2_ = 0;
            $left_ = 0;
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
            $pag[$i]['widthh2'] = $width_;
            $pag[$i]['height2'] = $height_;
            $pag[$i]['top2'] = $top2_;
            $pag[$i]['left2'] = $left_;
        }
        return $pag;
    }

    public function filterEnAction($poroda, $color, $pokr) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Page');
        if ($poroda != "") {
            $page = $repository->findBy(array("woodEn" => $poroda));
        } elseif ($color != "") {
            $page = $repository->findBy(array("descriptionEn" => $color));
        } elseif ($pokr != "") {
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery(
                            'SELECT p FROM AslanStoreBundle:Page p WHERE p.textEn LIKE :text'
                    )->setParameter('text', '%' . $pokr . '%');

            $page = $query->getResult();
            // $page = $repository->findBy(array("text" => $pokr));
        } else {
            $page = $repository->findAll();
        }

        if ($poroda != "" && $color != "") {
            $page = $repository
                    ->findBy(array("woodEn" => $poroda, "descriptionEn" => $color));
        }

        if ($poroda != "" && $pokr != "") {
            $page = $repository
                    ->findBy(array("woodEn" => $poroda, "textEn" => $pokr));
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery(
                            'SELECT p FROM AslanStoreBundle:Page p WHERE p.textEn LIKE :text AND p.woodEn LIKE :wood'
                    )->setParameters(array('text' => '%' . $pokr . '%', 'wood' => $poroda));

            $page = $query->getResult();
        }

        if ($color != "" && $pokr != "") {
            $page = $repository
                    ->findBy(array("woodEn" => $poroda, "textEn" => $pokr));
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery(
                            'SELECT p FROM AslanStoreBundle:Page p WHERE p.textEn LIKE :text AND p.descriptionEn LIKE :description'
                    )->setParameters(array('text' => '%' . $pokr . '%', 'description' => $color));

            $page = $query->getResult();
        }

        if ($poroda != "" && $pokr != "" && $color != "") {
            $page = $repository
                    ->findBy(array("woodEn" => $poroda, "textEn" => $pokr));
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery(
                            'SELECT p FROM AslanStoreBundle:Page p WHERE p.textEn LIKE :text AND p.descriptionEn LIKE :description AND p.woodEn LIKE :wood'
                    )->setParameters(array('text' => '%' . $pokr . '%', 'description' => $color, 'wood' => $poroda));

            $page = $query->getResult();
            //$page = array("poroda" => $poroda, "pokr" => $pokr, "color" => $color);
        }
        $pag = array();
        for ($i = 0; $i < count($page); $i++) {
            $pag[$i]['collection'] = $page[$i]->getBrand()->getNameEn();
            $pag[$i]['article'] = $page[$i]->getArticle();
            $pag[$i]['thickness'] = $page[$i]->getThickness();
            $pag[$i]['length'] = $page[$i]->getLength();
            $pag[$i]['width'] = $page[$i]->getWidth();
            $pag[$i]['processing'] = $page[$i]->getProcessingEn();
            $pag[$i]['grade'] = $page[$i]->getGradeEn();
            $pag[$i]['pokr'] = $page[$i]->getTextEn();
            $pag[$i]['wood'] = $page[$i]->getWoodEn();
            $pag[$i]['color'] = $page[$i]->getDescriptionEn();
            $pag[$i]['img'] = $page[$i]->getImg();
            $pag[$i]['name'] = $page[$i]->getNameEn();
            $pag[$i]['country'] = $page[$i]->getCountryEn();
            $pag[$i]['grade'] = $page[$i]->getGradeEn();
            $pag[$i]['processing'] = $page[$i]->getProcessingEn();
            $pag[$i]['width'] = $page[$i]->getWidth();
            $pag[$i]['length'] = $page[$i]->getLength();
            $pag[$i]['thickness'] = $page[$i]->getThickness();
            $pag[$i]['article'] = $page[$i]->getArticle();
            $pag[$i]['idd'] = $page[$i]->getId();
            $size_ = getimagesize('media/pictures/' . $pag[$i]['img']);
            $width_ = $size_[0];
            $height_ = $size_[1];
            $s = 205;
            $s2 = 205;
            $top2_ = 0;
            $left_ = 0;
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
            $pag[$i]['widthh'] = $width_;
            $pag[$i]['height'] = $height_;
            $pag[$i]['top'] = $top2_;
            $pag[$i]['left'] = $left_;
            $size_ = getimagesize('media/pictures/' . $pag[$i]['img']);
            $width_ = $size_[0];
            $height_ = $size_[1];
            $s = 500;
            $s2 = 440;
            $top2_ = 0;
            $left_ = 0;
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
            $pag[$i]['widthh2'] = $width_;
            $pag[$i]['height2'] = $height_;
            $pag[$i]['top2'] = $top2_;
            $pag[$i]['left2'] = $left_;
        }
        return $pag;
    }

    public function filterDeAction($poroda, $color, $pokr) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Page');
        if ($poroda != "") {
            $page = $repository->findBy(array("woodDe" => $poroda));
        } elseif ($color != "") {
            $page = $repository->findBy(array("descriptionDe" => $color));
        } elseif ($pokr != "") {
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery(
                            'SELECT p FROM AslanStoreBundle:Page p WHERE p.textDe LIKE :text'
                    )->setParameter('text', '%' . $pokr . '%');

            $page = $query->getResult();
            // $page = $repository->findBy(array("text" => $pokr));
        } else {
            $page = $repository->findAll();
        }

        if ($poroda != "" && $color != "") {
            $page = $repository
                    ->findBy(array("woodDe" => $poroda, "descriptionDe" => $color));
        }

        if ($poroda != "" && $pokr != "") {
            $page = $repository
                    ->findBy(array("woodDe" => $poroda, "textDe" => $pokr));
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery(
                            'SELECT p FROM AslanStoreBundle:Page p WHERE p.textDe LIKE :text AND p.woodDe LIKE :wood'
                    )->setParameters(array('text' => '%' . $pokr . '%', 'wood' => $poroda));

            $page = $query->getResult();
        }

        if ($color != "" && $pokr != "") {
            $page = $repository
                    ->findBy(array("woodDe" => $poroda, "textDe" => $pokr));
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery(
                            'SELECT p FROM AslanStoreBundle:Page p WHERE p.textDe LIKE :text AND p.descriptionDe LIKE :description'
                    )->setParameters(array('text' => '%' . $pokr . '%', 'description' => $color));

            $page = $query->getResult();
        }

        if ($poroda != "" && $pokr != "" && $color != "") {
            $page = $repository
                    ->findBy(array("woodDe" => $poroda, "textDe" => $pokr));
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery(
                            'SELECT p FROM AslanStoreBundle:Page p WHERE p.textDe LIKE :text AND p.descriptionDe LIKE :description AND p.woodDe LIKE :wood'
                    )->setParameters(array('text' => '%' . $pokr . '%', 'description' => $color, 'wood' => $poroda));

            $page = $query->getResult();
            //$page = array("poroda" => $poroda, "pokr" => $pokr, "color" => $color);
        }
        $pag = array();
        for ($i = 0; $i < count($page); $i++) {
            $pag[$i]['collection'] = $page[$i]->getBrand()->getNameDe();
            $pag[$i]['article'] = $page[$i]->getArticle();
            $pag[$i]['thickness'] = $page[$i]->getThickness();
            $pag[$i]['length'] = $page[$i]->getLength();
            $pag[$i]['width'] = $page[$i]->getWidth();
            $pag[$i]['processing'] = $page[$i]->getProcessingDe();
            $pag[$i]['grade'] = $page[$i]->getGradeDe();
            $pag[$i]['pokr'] = $page[$i]->getTextDe();
            $pag[$i]['wood'] = $page[$i]->getWoodDe();
            $pag[$i]['color'] = $page[$i]->getDescriptionDe();
            $pag[$i]['img'] = $page[$i]->getImg();
            $pag[$i]['name'] = $page[$i]->getNameDe();
            $pag[$i]['country'] = $page[$i]->getCountryDe();
            $pag[$i]['grade'] = $page[$i]->getGradeDe();
            $pag[$i]['processing'] = $page[$i]->getProcessingDe();
            $pag[$i]['width'] = $page[$i]->getWidth();
            $pag[$i]['length'] = $page[$i]->getLength();
            $pag[$i]['thickness'] = $page[$i]->getThickness();
            $pag[$i]['article'] = $page[$i]->getArticle();
            $pag[$i]['idd'] = $page[$i]->getId();
            $size_ = getimagesize('media/pictures/' . $pag[$i]['img']);
            $width_ = $size_[0];
            $height_ = $size_[1];
            $s = 205;
            $s2 = 205;
            $top2_ = 0;
            $left_ = 0;
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
            $pag[$i]['widthh'] = $width_;
            $pag[$i]['height'] = $height_;
            $pag[$i]['top'] = $top2_;
            $pag[$i]['left'] = $left_;
            $size_ = getimagesize('media/pictures/' . $pag[$i]['img']);
            $width_ = $size_[0];
            $height_ = $size_[1];
            $s = 500;
            $s2 = 440;
            $top2_ = 0;
            $left_ = 0;
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
            $pag[$i]['widthh2'] = $width_;
            $pag[$i]['height2'] = $height_;
            $pag[$i]['top2'] = $top2_;
            $pag[$i]['left2'] = $left_;
        }
        return $pag;
    }

    public function imgDeleteAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Slider');
        $page = $repository->findOneBy(array("id" => $id));
        print "id=" . $id;
        unlink("media/pictures/" . $page->getSrc());
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($page);
        $em->flush();
    }

    public function imgDelete2Action($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Baner');
        $page = $repository->findOneBy(array("id" => $id));
        print "id=" . $id;
        unlink("media/pictures/" . $page->getSrc());
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($page);
        $em->flush();
    }    
    
    public function imgNewAction($img, $href) {
        $em = $this->getDoctrine()->getEntityManager();
        $page = new Image();
        if ($img) {
            $page->setSrc($img);
        }
        $em->persist($page);
        $em->flush();
        return $page->getSrc();
    }

    public function imgAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Image');
        $page = $repository->findAll();
        return $page;
    }

    //Slider
    public function sliderDeleteAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Slider');
        $page = $repository->findOneBy(array("id" => $id));
        unlink("media/pictures/" . $page->getSrc());
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($page);
        $em->flush();
    }

    public function sliderNewAction($img, $href) {
        $em = $this->getDoctrine()->getEntityManager();
        $page = new Slider();
        if ($img) {
            $page->setSrc($img);
        }
        if ($href) {
            $page->setHref($href);
        }
        $page->setPriority(0);
        $em->persist($page);
        $em->flush();
        return $page->getSrc();
    }

    public function banerNewAction($img, $href) {
        $em = $this->getDoctrine()->getEntityManager();
        $page = new Baner();
        if ($img) {
            $page->setSrc($img);
        }
        if ($href) {
            $page->setHref($href);
        }
        $page->setPriority(0);
        $em->persist($page);
        $em->flush();
        return $page->getSrc();
    }

    public function sliderAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Slider');
        $page = $repository->findBy(array(), array('priority' => 'asc'));
        return $page;
    }

    public function banerAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Baner');
        $page = $repository->findBy(array(), array('priority' => 'asc'));
        return $page;
    }

    public function brandImgAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Brand');
        $page = $repository->find($id);
        if ($page->getSrc()) {
            $img = "/media/pictures/" . $page->getSrc();
        } else {
            return "";
        }
        return $img;
    }

    public function albumsImgAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Albums');
        $albums = $repository->find($id);
        $albumsimg = $albums->getImages();
        $imgs = array();
        for ($i = 0; $i < count($albumsimg); $i++) {
            $imgs[$i]['id'] = $albumsimg[$i]->getId();
            $imgs[$i]['src'] = $albumsimg[$i]->getSrc();
        }
        return json_encode($imgs);
    }

    public function oneMenuAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Onemenu');
        $page = $repository->find($id);
        if (!$page) {
            throw $this->createNotFoundException('No page found for id ' . $id);
        }
        return $page;
    }

    public function oneMenuSlugAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Page');
        $page = $repository->findOneBy(array("slug" => $id));
        return $page;
    }

    public function oneMenuAllAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Onemenu');
        $page = $repository->findAll();
        return $page;
    }

    public function pageAllAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Page');
        $page = $repository->findAll();
        return $page;
    }

    public function onePageAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Brand');
        $brand = $repository->findOneBy(array('id' => $id));
        return $brand->getPages();
    }

    public function oneBlogsAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:News');
        $page = $repository->findOneBy(array('id' => $id));
        return $page;
    }

    public function oneCategoryAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Category');
        $page = $repository->findOneBy(array('id' => $id));
        return $page;
    }

    public function oneAfishaAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Afisha');
        $page = $repository->findOneBy(array('id' => $id));
        return $page;
    }

    public function albumNewAction($id, $name, $img, $time, $place) {
        if ($id == '') {
            $page = new Albums();
        } else {
            $repository = $this->getDoctrine()
                    ->getRepository('AslanStoreBundle:Albums');
            $page = $repository->findOneBy(array('id' => $id));
        }
        $page->setName($name);
        $page->setTime($time);
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:News');
        $place = $repository->findOneBy(array('id' => $place));
        $page->setPlace($place);
        if ($img) {
            $page->setSrc($img);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($page);
        $em->flush();
        return $page->getId();
    }

    public function brandAllAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Brand');
        $page = $repository->findAll();
        return $page;
    }

    public function blogsAllAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:News');
        $page = $repository->findAll();
        return $page;
    }

    public function categoryAllAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Category');
        $page = $repository->findAll();
        return $page;
    }

    public function afishaAllAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Afisha');
        $page = $repository->findAll();
        return $page;
    }

    public function secondMenuAllAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Secondmenu');
        $page = $repository->findAll();
        return $page;
    }

    public function thirdMenuAllAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Thirdmenu');
        $page = $repository->findAll();
        return $page;
    }

    public function thirdPodMenuAllAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Thirdmenu');
        $page = $repository->findAll();
        $page2 = array();
        for ($i = 0, $j = 0; $i < count($page); $i++) {
            if (!$page[$i]->getSecondmenu()) {
                $page2[$j] = $page[$i];
                $j++;
            }
        }
        return $page2;
    }

    public function pagePodMenuAllAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Page');
        $page = $repository->findAll();
        $page2 = array();
        for ($i = 0, $j = 0; $i < count($page); $i++) {
            if (!$page[$i]->getThirdmenu()) {
                $page2[$j] = $page[$i];
                $j++;
            }
        }
        return $page2;
    }

    public function secondMenuUpdateAction($text, $id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Secondmenu');
        $secondmenu = $repository->findOneBy(array("id" => $id));
        $secondmenu->setName($text);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($secondmenu);
        $em->flush();
    }

    public function brandUpdateAction($text, $text2, $text3, $id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Brand');
        $brand = $repository->findOneBy(array("id" => $id));
        if ($text)
            $brand->setName($text);
        if ($text2)
            $brand->setNameEn($text2);
        if ($text3)
            $brand->setNameDe($text3);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($brand);
        $em->flush();
    }

    public function blogsUpdateAction($name, $text, $id) {
        if ($id == '') {
            $brand = new News();
        } else {
            $repository = $this->getDoctrine()
                    ->getRepository('AslanStoreBundle:News');
            $brand = $repository->findOneBy(array("id" => $id));
        }
        if ($text)
            $brand->setPage($text);
        if ($name)
            $brand->setHead($name);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($brand);
        $em->flush();
        $blogs = array();
        $blogs['id'] = $brand->getId();
        $blogs['head'] = $brand->getHead();
        return json_encode($blogs);
    }

    public function categoryUpdateAction($name, $fileName, $id) {
        if ($id == '') {
            $brand = new Category();
        } else {
            $repository = $this->getDoctrine()
                    ->getRepository('AslanStoreBundle:Category');
            $brand = $repository->findOneBy(array("id" => $id));
        }
        if ($name)
            $brand->setName($name);
        if ($fileName)
            $brand->setImg($fileName);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($brand);
        $em->flush();
        $blogs = array();
        $blogs['id'] = $brand->getId();
        $blogs['head'] = $brand->getName();
        $blogs['src'] = $brand->getImg();
        if ($id == '') {
            $blogs['edit'] = 0;
        } else {
            $blogs['edit'] = 1;
        }
        return json_encode($blogs);
    }

    public function afishaUpdateAction($name, $fileName, $id, $date, $place, $category, $text, $color) {
        if ($id == '') {
            $brand = new Afisha();
        } else {
            $repository = $this->getDoctrine()
                    ->getRepository('AslanStoreBundle:Afisha');
            $brand = $repository->findOneBy(array("id" => $id));
        }
        if ($name)
            $brand->setName($name);
        if ($date)
            $brand->setDate($date);
        if ($text)
            $brand->setText($text);
        if ($name)
            $brand->setName($name);
        if ($color)
            $brand->setColor($color);
        if ($fileName)
            $brand->setImg($fileName);

        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:News');
        $place = $repository->findOneBy(array("id" => $place));

        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Category');
        $category = $repository->findOneBy(array("id" => $category));

        if ($place)
            $brand->setPlace($place);

        if ($category)
            $brand->setCategory($category);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($brand);
        $em->flush();
        $blogs = array();
        $blogs['id'] = $brand->getId();
        $blogs['head'] = $brand->getName();
        $blogs['src'] = $brand->getImg();
        $blogs['color'] = $brand->getColor();
        if ($id == '') {
            $blogs['edit'] = 0;
        } else {
            $blogs['edit'] = 1;
        }
        return json_encode($blogs);
    }

    public function parkettImgAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:News');
        $page = $repository->find($id);
        $pageimg = $page->getPageimgs();
        $imgs = array();
        for ($i = 0; $i < count($pageimg); $i++) {
            $imgs[$i]['id'] = $pageimg[$i]->getId();
            $imgs[$i]['src'] = $pageimg[$i]->getImg();
        }
        return json_encode($imgs);
    }

    public function thirdMenuUpdateAction($text, $text2, $text3, $id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Thirdmenu');
        $thirdmenu = $repository->findOneBy(array("id" => $id));
        $thirdmenu->setText($text);
        $thirdmenu->setTextEn($text2);
        $thirdmenu->setTextDe($text3);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($thirdmenu);
        $em->flush();
    }

    public function secondMenuNewAction() {
        $secondmenu = new Secondmenu();
        $secondmenu->setName("Новый");
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($secondmenu);
        $em->flush();
        return $secondmenu->getId();
    }

    public function PageImgNewAction($id, $filename) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:News');
        $page = $repository->findOneBy(array("id" => $id));
        $brand = new ImgPage();
        $brand->setImg($filename);
        $brand->setPage($page);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($brand);
        $em->flush();
        return $brand->getId();
    }

    public function PageImgNew2Action($id, $filename) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Albums');
        $page = $repository->findOneBy(array("id" => $id));
        $brand = new Image();
        $brand->setSrc($filename);
        $brand->setAlbums($page);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($brand);
        $em->flush();
        return $brand->getId();
    }

    public function photoAlbumsAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Albums');
        $secondmenu = $repository->find($id);
        return $secondmenu->getImages();
    }

    public function thirdMenuIdAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Thirdmenu');
        $secondmenu = $repository->find($id);
        return $secondmenu;
    }

    public function thirdMenuAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Thirdmenu');
        $secondmenu = $repository->find($id);
        return $secondmenu->getPages();
    }

    public function thirdMenuAllesAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em
                ->createQuery(
                        'SELECT k FROM AslanStoreBundle:Page k WHERE k.thirdmenu IN (SELECT p FROM AslanStoreBundle:Thirdmenu p WHERE p.secondmenu IN (SELECT h FROM AslanStoreBundle:Secondmenu h WHERE h.id = :sec))')
                ->setParameter('sec', $id);
        $pages = $query->getResult();
        return $pages;
    }

    public function brandPageAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Brand');
        $secondmenu = $repository->findOneBy(array("id" => $id));
        return $secondmenu->getPages();
    }

    public function podMenuNewAction($id, $id2) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Secondmenu');
        $secondmenu = $repository->findOneBy(array("id" => $id));
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Thirdmenu');
        $thirdmenu = $repository->findOneBy(array("id" => $id2));
        $error = $thirdmenu->setSecondmenu($secondmenu);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($thirdmenu);
        $em->flush();
    }

    public function podThirdMenuNewAction($id, $id2) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Thirdmenu');
        $secondmenu = $repository->findOneBy(array("id" => $id));
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Page');
        $thirdmenu = $repository->findOneBy(array("id" => $id2));
        $error = $thirdmenu->setThirdmenu($secondmenu);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($thirdmenu);
        $em->flush();
    }

    public function podMenuRemoveAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Thirdmenu');
        $thirdmenu = $repository->findOneBy(array("id" => $id));
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Secondmenu');
        $secondmenu = $repository
                ->findOneBy(array("id" => $thirdmenu->getSecondmenu()->getId()));
        $secondmenu->getThirdmenus()->removeElement($thirdmenu);
        $thirdmenu->setSecondmenu(null);
        $em = $this->getDoctrine()->getEntityManager();
        $em->flush();
    }

    public function podThirdMenuRemoveAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Page');
        $thirdmenu = $repository->findOneBy(array("id" => $id));
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Thirdmenu');
        $secondmenu = $repository
                ->findOneBy(array("id" => $thirdmenu->getThirdmenu()->getId()));
        $secondmenu->getPages()->removeElement($thirdmenu);
        $thirdmenu->setThirdmenu(null);
        $em = $this->getDoctrine()->getEntityManager();
        $em->flush();
    }

    public function secondMenuRemoveAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Secondmenu');
        $secondmenu = $repository->findOneBy(array("id" => $id));
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($secondmenu);
        $em->flush();
    }

    public function brandRemoveAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Brand');
        $brand = $repository->findOneBy(array("id" => $id));
        if ($brand) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($brand);
            return $em->flush();
        }
    }

    public function afishaRemoveAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Afisha');
        $brand = $repository->findOneBy(array("id" => $id));
        if ($brand) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($brand);
            return $em->flush();
        }
    }    
    
    public function videoDeleteAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Video');
        $video = $repository->findOneBy(array('id' => $id));
        if (!$video) {
            return new Response(
                    '<script>alert("Ошибка удаления видео!");window.location.href="../admin/video";</script>');
        } else {
            $em = $this->getDoctrine()->getEntityManager();
            //unlink("media/pictures/" . $video->getImg());
            $em->remove($video);
            $em->flush();
            return new Response();
        }
    }

    public function albumsRemoveAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Albums');
        $album = $repository->findOneBy(array("id" => $id));
        if (file_exists("media/pictures/" . $album->getSrc()))
            unlink("media/pictures/" . $album->getSrc());
        if (file_exists("media/pictures/small" . $album->getSrc()))
            unlink("media/pictures/small" . $album->getSrc());
        $imgg = $album->getImages();
        for ($i = 0; $i < count($imgg); $i++) {
            unlink("media/pictures/" . $imgg[$i]->getSrc());
            unlink("media/pictures/small" . $imgg[$i]->getSrc());
        }
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($album);
        $em->flush();
    }

    public function blogRemoveAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:News');
        $page = $repository->findOneBy(array("id" => $id));
        if (file_exists("media/pictures/" . $page->getImg()))
            unlink("media/pictures/" . $page->getImg());
        if (file_exists("media/pictures/small" . $page->getImg()))
            unlink("media/pictures/small" . $page->getImg());
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($page);
        $em->flush();
    }

    public function pageImgRemoveAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:ImgPage');
        $page = $repository->findOneBy(array("id" => $id));
        if (file_exists("media/pictures/" . $page->getImg())) {
            unlink("media/pictures/" . $page->getImg());
        }
        if (file_exists("media/pictures/small" . $page->getImg())) {
            unlink("media/pictures/small" . $page->getImg());
        }
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($page);
        $em->flush();
    }

    public function pageImgRemove2Action($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Image');
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

    public function thirdMenuNewAction($id, $name, $text) {
        if ($id == '') {
            $thirdmenu = new Thirdmenu();
        } else {
            $repository = $this->getDoctrine()
                    ->getRepository('AslanStoreBundle:ThirdMenu');
            $thirdmenu = $repository->findOneBy(array('id' => $id));
        }
        $thirdmenu->setName($name);
        $thirdmenu->setText($text);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($thirdmenu);
        $em->flush();
        return $thirdmenu->getId();
    }

    public function thirdMenuRemoveAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Thirdmenu');
        $thirdmenu = $repository->findOneBy(array("id" => $id));
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($thirdmenu);
        $em->flush();
    }

    public function emailAllAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Email');
        $email = $repository->findAll();
        /* if (!$email) {
          throw $this->createNotFoundException('No email found');
          } */
        return $email;
    }

    public function emailOneFoundImageAction($email) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Email');
        $email = $repository->findOneBy(array('email' => $email, 'type' => 0));
        if (!$email) {
            return false;
        }
        return $email;
    }

    public function emailOneFoundVideoAction($email) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Email');
        $email = $repository->findOneBy(array('email' => $email, 'type' => 1));
        if (!$email) {
            return false;
        }
        return $email;
    }

    public function emailSetImageAction($text) {
        $email = new Email();
        $email->setEmail($text);
        $email->setType(0);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($email);
        $em->flush();
    }

    public function emailSetVideoAction($text) {
        $email = new Email();
        $email->setEmail($text);
        $email->setType(1);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($email);
        $em->flush();
    }

    public function emailRemoveAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Email');
        $email = $repository->findOneBy(array("id" => $id));
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($email);
        $em->flush();
    }

    public function imageAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Image');
        $image = $repository->findAll();
        for ($i = 0; $i < count($image); $i++) {
            $ext = strrchr($image[$i]->getSrc(), ".");
            $ext = ".jpeg";
            $medium = "image_" . $image[$i]->getId() . ".medium" . $ext;
            $thumbnail = "image_" . $image[$i]->getId() . ".thumbnail" . $ext;
            $image[$i]->setMedium($medium);
            $image[$i]->setThumbnail($thumbnail);
        }
        return $image;
    }

    public function categoryAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Category');
        $category = $repository->findAll();
        return $category;
    }

    public function movieAction() {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Video');
        $video = $repository->findAll();
        return $video;
    }

    public function oneMenuChangeAction($id, $text) {
        $page = $this->findOneAction('Page', $id);
        $page->setText($text);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($page);
        $em->flush();
    }

    public function userAction($login) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:User');
        $user = $repository->findOneBy(array('login' => $login));
        return $user;
    }

    public function videoSetAction($code, $head) {
        $video = new Video();
        $video->setHead($head);
        $vid = VideoParser::getVideo($code);
        $video->setCode($vid->html);
        $video->setImg($vid->thumbnail_url);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($video);
        $em->flush();
    }

    public function logGetAction($login, $hash) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:User');
        $log = $repository
                ->findOneBy(array('login' => $login, 'password' => $hash));
        return $log;
    }

    public function photoUploadAction($FILES) {

        function resize($file_input, $file_output, $w_o, $h_o, $percent = false) {
            list($w_i, $h_i, $type) = getimagesize($file_input);
            if (!$w_i || !$h_i) {
                echo 'Невозможно получить длину и ширину изображения';
                return;
            }
            $types = array('', 'gif', 'jpeg', 'png');
            $ext = $types[$type];
            if ($ext) {
                $func = 'imagecreatefrom' . $ext;
                $img = $func($file_input);
            } else {
                echo 'Некорректный формат файла';
                return;
            }
            if ($percent) {
                $w_o *= $w_i / 100;
                $h_o *= $h_i / 100;
            }
            if (!$h_o)
                $h_o = $w_o / ($w_i / $h_i);
            if (!$w_o)
                $w_o = $h_o / ($h_i / $w_i);
            $img_o = imagecreatetruecolor($w_o, $h_o);
            imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
            if ($type == 2) {
                return imagejpeg($img_o, $file_output, 100);
            } else {
                $func = 'image' . $ext;
                return $func($img_o, $file_output);
            }
        }

        function crop($opred, $file_input, $file_output, $crop = 'square', $percent = false) {
            list($w_i, $h_i, $type) = getimagesize($file_input);
            if (!$w_i || !$h_i) {
                echo 'Невозможно получить длину и ширину изображения';
                return;
            }
            $types = array('', 'gif', 'jpeg', 'png');
            $ext = $types[$type];
            if ($ext) {
                $func = 'imagecreatefrom' . $ext;
                $img = $func($file_input);
            } else {
                echo 'Некорректный формат файла';
                return;
            }
            if ($crop == 'square') {
                $min = $w_i;
                if ($w_i > $h_i)
                    $min = $h_i;
                $w_o = $h_o = $min;
            } else {
                list($x_o, $y_o, $w_o, $h_o) = $crop;
            }
            $img_o = imagecreatetruecolor($w_o, $h_o);
            if ($opred == 1) {
                imagecopy($img_o, $img, 0, 0, $x_o, 0, $w_o, $h_o + $h_0);
            } else {
                imagecopyresampled($img_o, $img, 0, 0, $x_o, $y_o, $w_o, $h_o, $w_o, $h_o);
            }
            if ($type == 2) {
                return imagejpeg($img_o, $file_output, 100);
            } else {
                $func = 'image' . $ext;
                return $func($img_o, $file_output);
            }
        }

        $image1 = $FILES["image"]["tmp_name"];
        $i = 0;
        if ($image1[0] != "") {
            $error = 0;
            while (isset($image1[$i])) {
                if ($FILES["image"]["size"][$i] > 1024 * 10 * 1024) {
                    return new Response(
                            "<script>alert('Размер файла превышает три мегабайта');");
                }
                if (is_uploaded_file($FILES["image"]["tmp_name"][$i])) {
                    $image = new Image();
                    $image->setSrc("");
                    $image->setHead('New head');
                    $image->setDescr('New description');
                    $image->setHeadRu('Новый заголовок');
                    $image->setDescrRu('Новое описание');
                    $em = $this->getDoctrine()->getEntityManager();
                    $em->persist($image);
                    $em->flush();
                    $maxid = $image->getId();
                    $repository = $this->getDoctrine()
                            ->getRepository('AslanStoreBundle:Image');
                    $image = $repository->findAll();
                    $ext = strrchr($FILES['image']['name'][$i], ".");
                    $ext = ".jpeg";
                    $namefile = "image_" . $maxid . $ext;
                    $repository = $this->getDoctrine()
                            ->getRepository('AslanStoreBundle:Image');
                    $image = $repository->findOneBy(array('id' => $maxid));
                    $image->setSrc($namefile);
                    $image->setHead('New head');
                    $image->setDescr('New description');
                    $image->setHeadRu('Новый заголовок');
                    $image->setDescrRu('Новое описание');
                    $em->flush();
                    $dir = $this->get('kernel')->getRootDir()
                            . "/../www/media/pictures/";
                    move_uploaded_file($FILES["image"]["tmp_name"][$i], $dir . $namefile);
                    $size = getimagesize($dir . $namefile);
                    $width = $size[0];
                    $height = $size[1];
                    $file_input = $dir . $namefile;
                    $file_output = $dir . 'temp' . $FILES["image"]["name"][$i];
                    $file_output2 = $dir . "image_" . $maxid . ".medium" . $ext;
                    if (($width > 600) || ($height > 600)) {
                        if (($width > 600) && ($height > 600)) {
                            if ($width > $height) {
                                $newheight = 600;
                                $newwidth = ($width / $height) * $newheight;
                                resize($file_input, $file_output, $newwidth, $newheight, false);
                                $x1 = ($newwidth - 600) / 2;
                                crop(0, $file_output, $file_output2, array($x1, 0, 600, 600));
                                unlink($file_output);
                            } else {
                                $newwidth = 600;
                                $newheight = ($height / $width) * $newidth;
                                resize($file_input, $file_output, $newwidth, $newheight, false);
                                $y1 = ($newheight - 600) / 2;
                                crop(1, $file_output, $file_output2, array(0, $y1, 600, 600));
                                unlink($file_output);
                            }
                        }
                    }
                    $file_output = $dir . 'temp2' . $FILES["image"]["name"][$i];
                    $file_output2 = $dir . "image_" . $maxid . ".thumbnail"
                            . $ext;
                    if (($width > 190) || ($height > 190)) {
                        if (($width > 190) && ($height > 190)) {
                            if ($width > $height) {
                                $newheight = 190;
                                $newwidth = ($width / $height) * $newheight;
                                resize($file_input, $file_output, $newwidth, $newheight, false);
                                $x1 = ($newwidth - 190) / 2;
                                crop(0, $file_output, $file_output2, array($x1, 0, 190, 190));
                                unlink($file_output);
                            } else {
                                $newwidth = 190;
                                $newheight = ($height / $width) * $newidth;
                                resize($file_input, $file_output, $newwidth, $newheight, false);
                                $y1 = ($newheight - 190) / 2;
                                crop(1, $file_output, $file_output2, array(0, $y1, 190, 190));
                                unlink($file_output);
                            }
                        }
                    }
                } else {
                    $error = 1;
                    //echo ("Ошибка загрузки файла1");
                }
                //echo "<script>alert('Новое(ые) изображение(я) успешно добавлено(ы)!');window.location.href='../';</script>";
                $i++;
            }
            if ($error == 1) {
                return new Response(
                        "<script>alert('При загрузке фотографий произошла ошибка!');window.location.href='../admin/photo';</script>");
            } else {
                return new Response(
                        "<script>alert('Новое(ые) изображение(я) успешно добавлено(ы)!');window.location.href='../admin/photo';</script>");
            }
        } else {
            return new Response(
                    "<script>alert('Вы не выбрали изображение! ');window.location.href='../admin/photo';</script>");
        }
    }

    public function codeChangeVideoAction($id, $code, $type) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Video');
        if (!$code) {
            return new Response(
                    '<script>alert("Введите код видео!");history.back();</script>');
        } else {
            $video = $repository->findOneBy(array('id' => $id));
            if ($type == 'code')
                $video->setCode($code);
            if ($type == 'head')
                $video->setHead($code);
            if ($type == 'descr')
                $video->setDescription($code);
            $em = $this->getDoctrine()->getEntityManager();
            $em->flush();
            return new Response();
        }
    }

    public function catChangeAction($id, $val) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Category');
        $category = $repository->findOneBy(array('id' => $id));
        $session = $this->getRequest()->getSession();
        $locale = $session->get('changeLocale');
        if ($locale == 0) {
            $category->setName($val);
        } else {
            $category->setNameRu($val);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $em->flush();
        return new Response();
    }

    public function headEditAction($id, $val) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Image');
        $category = $repository->findOneBy(array('id' => $id));
        $category->setHref($val);
        $em = $this->getDoctrine()->getEntityManager();
        $em->flush();
        return new Response();
    }

    public function descrEditAction($id, $val) {
        $repository = $this->getDoctrine()
                ->getRepository('AslanStoreBundle:Image');
        $category = $repository->findOneBy(array('id' => $id));
        $session = $this->getRequest()->getSession();
        $locale = $session->get('changeLocale');
        if ($locale == 0) {
            $category->setDescr($val);
        } else {
            $category->setDescrRu($val);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $em->flush();
        return new Response();
    }

}

