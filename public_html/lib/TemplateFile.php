<?php

/**
 * Description of TemplateFile
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
class TemplateFile {

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
    
    public function getSubject($subject){
        $template_pairs = strtr($subject, $this->getReplacementPairs());
        return preg_replace('{{.*}}', '', $template_pairs);;
    }

    public function __toString() {
        $template_pairs = strtr($this->getTemplateText(), $this->getReplacementPairs());
        $template_clean = preg_replace('{{.*}}', '', $template_pairs);
        return $template_clean;
    }

    private function getReplacementPairs() {
        $pairs = array();
        $pattern = '{{%s}}';
        foreach ($this->vars as $name => $value) {
            $pairs[sprintf($pattern, $name)] = $value;
        }
        return $pairs;
    }

}
