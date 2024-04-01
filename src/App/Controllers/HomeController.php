<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;

class HomeController {
    // 

    public function __construct(private TemplateEngine $view) {
        // $this->view = new TemplateEngine(Paths::VIEW);
    }
    public function home() {
        //echo $this->view->render("/index.php", ['title' => 'Home page']);
        echo $this->view->render("/index.php");
    }
}

//

/*
 needs instance of template instance class, 
 but not every controller needs it, 
 sometime need file uploads or redirect
*/
