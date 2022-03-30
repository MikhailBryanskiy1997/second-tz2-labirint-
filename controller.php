<?php
require 'News.php';
class NewsController{
// Список новостей
public function actionDelete(){
    if($_GET['id']){
      $newsDeleted = News::deleteNewsById(htmlentities($_GET['id']));
      return $newsDeleted;
      include 'NewsTemplate.php';
    }
}

// Просмотр одной новости
public function actionView(){
             if (isset($_GET['id']) && !empty($_GET['id'])){
            $newsItem= News::getNewsItem(intval($_GET['id']));
            include 'NewsTemplate.php';
            exit;
        }else if(isset($_GET['q']) && !empty($_GET['q'])){
            $newsItem= News::getNewsItem(null,htmlentities($_GET['q']));
            include 'NewsTemplate.php';
            exit;
        }
    }
    
public function actionCreate(){
            if(!empty($_POST)){
                $newsTitle = !empty($_POST['title']) ?  htmlentities($_POST['title']) : '';
                $newsAnnounce = !empty($_POST['announce']) ?  htmlentities($_POST['announce']) : '';
                $newsText = !empty($_POST['text']) ?  htmlentities($_POST['text']) : '';
                $tags  = !empty($_POST['tags']) ?  htmlentities($_POST['tags']) : '';
                $newsCreated = News::addNews($newsText,$newsTitle,$newsAnnounce,$tags);
                if($newsCreated){
                    $newsItem= News::getNewsItem($newsCreated);
                    include 'NewsTemplate.php';
            
                }
            }
    }
}

