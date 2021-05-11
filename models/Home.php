<?php
    namespace models;

    use \database\Query as Query;
    use \controllers\HomeController as HomeController;
    
class Home extends Model
{

    public function __construct()
    {
    }
        
    public function checkUsers()
    {
        $getUsers = Query::select('users')->done()->all();
  
        if (is_array($getUsers)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkAdmin()
    {
        $admin_exists = Query::select('users')->fields('id')->where(['role' => 'admin']);
        if (!empty($admin_exists))
            return 1;
        return 0;
    }

    public function createUser(string $fields, array $values)
    {
        
        //I need to send the data to this function in another way
        //$createUser = Query::insert('users')->set([])->done();

        if ($createUser === true) {
            return 1;
        } else {
            return $createUser;
        }
    }

    public function getArticles(int $offset = 0)
    {
        $articles = Query::select('articles')->where(['status' => 1])->orderBy('id DESC')->limit(5)->offset($offset)->done()->all();
        foreach ($articles as $k => $v) {
            $category = Query::select('categories')->where(['id' => $v['category']])->orderBy('id ASC')->done()->one();
            !empty($category) ?? $articles[$k]['category_name'] = $category['name'] :: $articles[$k]['category_name'] = 'No Category';
        }
        return $articles;
    }

    public function getAbout()
    { 
        $about = Query::select('about')->where(['id' => 1])->done()->one();
        return $about;
    }

    public function getArchives()
    {
        $rows = Query::select('articles')
                ->fields('COUNT(*) AS total, DATE_FORMAT(date, "%M %Y") AS date, DATE_FORMAT(date, "%m") as month, DATE_FORMAT(date, "%Y") as year')
                ->groupBy('DATE_FORMAT(date, "%M %Y"), DATE_FORMAT(date, "%m"), DATE_FORMAT(date, "%Y")')
                ->orderBy('year, month ASC')
                ->done()
                ->all();

        $archives = array();
        array_key_exists('Total', $rows) ? $archives[0] = $rows : $archives = $rows;
        return $archives;
    }

    public function getSocial()
    {
        $rows = Query::select('social')->where(['visible' => 1])->done()->all();
        $social = array();
        array_key_exists('name', $rows) ? $social[0] = $rows : $social = $rows;
        return $social;
    }

    public function getArticlesBySearch(array $searchItems)
    {
        $where = array();
        $data = array(1);
        foreach ($searchItems as $item) {
            if ($item !== "") {
                $where[] = "['title' => '".$item."']".", ".LIKE_SOMEWHERE; 
            }
        }
        if (empty($where)) {
            $where[] = ['1' => 1];
        }
        $articles = Query::select('articles')
                    ->where([implode(', ', $where)])
                    ->done()
                    ->all();
                    
        return $articles;
    }
}
