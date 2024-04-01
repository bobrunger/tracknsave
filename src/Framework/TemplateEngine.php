<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine {
    private array $globalTemplateData = [];
    public function __construct(private string $basePath) {
    }

    public function render(string $template, array $data = []) {

        extract($data, EXTR_SKIP); // takes every key in array and creates variable based on key names, important to be associative array
        //EXTR_SKIP - skip duplicate variable names
        extract($this->globalTemplateData, EXTR_SKIP);
        ob_start(); // store content until every line is finished or buffer is closed

        include $this->resolve($template); // causes render in browser

        //by default php sends content directly to browser, does not send entire document at once

        //output buffer instruct php not to send content by bits and pieces, we have option to close output buffer

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }

    public function resolve(string $path) {
        return "{$this->basePath}/{$path}";
    }

    public function addGlobal(string $key, mixed $value) {
        $this->globalTemplateData[$key] = $value;
    }
}
