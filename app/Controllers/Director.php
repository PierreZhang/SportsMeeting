<?php
namespace Controllers;

use Core\View;
use Core\Controller;

class Director extends Controller
{

    /**
     * Call the parent construct
     */
    public function __construct()
    {
        if((strpos(\Helpers\Session::get('ROLES'),'A'))===false)
            \Helpers\Url::redirect('login');
        parent::__construct();
        $this -> model_statistics = new \Models\Statistics();
    }

    /**
     * Define Index page title and load template files
     */
    public function index()
    {
        $data['statistics'] = $this -> model_statistics -> statistics(null, null, true);
        View::renderTemplate('header', $data);
        View::render('director/index', $data);
        View::renderTemplate('footer', $data);
    }

    public function statistics_for_institutions()
    {
        $data['statistics_for_institutions'] = $this -> model_statistics -> statistics(null, null);
        $data['institutions_name'] = $this -> model_statistics -> query_institutions_name();
        View::render('director/statistics_for_institutions', $data);
    }

}
