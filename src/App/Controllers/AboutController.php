<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

/* class AboutController {
    private TemplateEngine $view;

    public function __construct() {
        $this->view = new TemplateEngine(Paths::VIEW);
    }
    public function about() {
        echo $this->view->render("about.php", [
            'title' => 'About Page',
            'danger' => '<script>alert()</script>'
        ]);
    }
} */

class AboutController {
    public function __construct(private TemplateEngine $view) {
    }
    public function about() {
        echo $this->view->render("about.php", [
            'title' => 'About',
            'danger' => '<script>alert()</script>'
        ]);
    }
}
