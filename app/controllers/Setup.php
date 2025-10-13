<?php
/**
 * Setup Controller
 * Database setup and testing
 */
class Setup extends Controller
{
    public function index()
    {
        // Database setup content
        $data = [
            'title' => 'Database Setup',
        ];
        
        $this->view('frontend/setup/index', $data);
    }
}
?>