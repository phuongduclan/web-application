<?php
class HomepageController extends BaseController
{
    public function index()
    {
    
        return $this->view('frontend.index');
    }
}