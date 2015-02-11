<?php

/**
 * Description of Template
 *
 * @author khangld
 * 
 * return string
 * 
 * $string = new TemplateFile($template, $data);
 * template is string or file
 * data is an array(key => value)
 * 
 */
class Template {

    /**
     * @var string
     */
    private $file;

    /**
     * @var string[] varname => string value
     */
    private $vars;

    public function __construct($file, array $vars = array()) {
        $this->file = (string) $file;
        $this->setVars($vars);
    }

    public function setVars(array $vars) {
        $this->vars = $vars;
    }

    public function getTemplateText() {
        if (is_file($this->file)){
            return file_get_contents($this->file);
        } else {
            return $this->file;
        }
    }

    public function __toString() {
        $template_pairs = strtr($this->getTemplateText(), $this->getReplacementPairs());
        $template_clean = preg_replace('{{.*}}', '', $template_pairs);
        return $template_clean;
    }

    private function getReplacementPairs() {
        $pairs = array();
        $pattern = '{{%s}}';
        $i = 0;
        foreach ($this->vars as $name => $value) {
            if(preg_match_all($pattern, $this->file)){
                echo $i++;
                echo $this->vars;
            }
            $pairs[sprintf($pattern, $name)] = $value;
        }
        return $pairs;
    }
    
    public function render(){
        //
        $pairs = $this->getReplacementPairs();
        $template = strtr($this->getTemplateText(), $this->getReplacementPairs());
        $template_clean = preg_replace('{{.*}}', '', $template);
        return $template_clean;
    }

}
