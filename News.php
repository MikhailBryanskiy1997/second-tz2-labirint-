<?php

require 'dbConnect.php';
class News {
    protected $id;
    protected $title;
    protected $text;
    protected $announce;
    protected $tags;
    protected $data_time;

    function __construct($attributes=[]){
            $this->id = $attributes['id'] ?? null;
            $this->title = $attributes['title'] ?? null;
            $this->text = $attributes['text'] ?? null;       
            $this->announce = $attributes['announce'] ?? null;
            $this->tags = $attributes['tags'] ?? null;
            $this->data_time = $attributes['data_time'] ?? null;
    }
    public function getId() {
        return $this->id;
    }

    public function getDataTime(){
        return $this->data_time;
    }

    public function getTitle(){
        return $this->title;
    }
    public function setTitle($title){
        return $this->title = $title;
    }
   public function getText(){
       return $this->text;
   }
   public function setText($text){
       return $this->text = $text;
   }
   public function getAnnounce(){
       return $this->announce;
   }
   public function setAnnounce ($announce){
       return $this->announce=$announce;
   }
   public function getTags(){
       return $this->tags;
   }
   public function setTags($tags){
       return $this->tags = $tags;
   }

    public static function getNewsItem($id = null,$title=''){
    // Запрос к БД
        if (!empty($id)){
        $db = new PDO('mysql:host='.HOST.';dbname='.DBNAME.';', USER, PASSWORD);
        $result = $db->prepare('SELECT * FROM news WHERE id= :id');
        $result->execute(['id'=>$id]);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $newsItem = $result->fetch();
        $newNews = new News($newsItem);
        return $newNews;      
        }else if(!empty($title)){
        $db = new PDO('mysql:host='.HOST.';dbname='.DBNAME.';', USER, PASSWORD);
        $stmt= $db->prepare('SELECT * FROM news WHERE title like \'%:title%\'');
        $stmt->execute(['title' => $title]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $newsItem = $stmt->fetch();
        $newNews = new News($newsItem);
        }else{
            return null;
        }
       
    }

    public static function deleteNewsById($id){
        if($id){
            $db = new PDO('mysql:host='.HOST.';dbname='.DBNAME.';', USER, PASSWORD);
            $stmt= $db->prepare('DELETE FROM news WHERE id= :id');
            $result=$stmt->execute(['id' => $id]);
            return $result;
        }
    }

    public static function addNews($text,$title,$announce =null,$tags=null){
        $data = new DateTime();
        $db = new PDO('mysql:host='.HOST.';dbname='.DBNAME.';', USER, PASSWORD);  
        $stmt = $db->prepare("INSERT INTO news (`title`,`announce`,`text`,`tags`,`data`) VALUES (:title,:announce,:text,:tags,:data)");
        $result = $stmt->execute(['title'=>$title,'announce'=>$announce,'text'=>$text,'tags'=>$tags,'data'=>$data->format('Y-m-d h:i:s')]);         
        if($result){
            return $db->lastInsertId();
        }else{
            return false;    
        }

    }

}