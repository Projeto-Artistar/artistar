<?php

namespace Source\Model\Helpers;

class Translator {

    protected $lang;
    protected $dictionary = [];
    protected $page;

    public function __construct($lang = 'pt-br') {
        $this->setLang($lang);
    }

    public function setLang($lang) {
        $this->lang = $lang;
    }

    public function getLang() {
        return $this->lang;
    }

    public function setDictionary($dictionary) {
        $this->dictionary = $dictionary;
    }

    public function getDictionary() {
        return $this->dictionary;
    }

    public function setPage($page) {
        $this->page = $page;
    }

    public function getPage() {
        return $this->page;
    }

    public function loadTranslation($page = null) {
        $language = $this->getLang();
        $this->setPage($page);
        $translationFile = dirname(__DIR__, 3) . "/assets/lang/{$language}/{$page}.json";
        if (file_exists($translationFile)) {
            $dictionary = json_decode(file_get_contents($translationFile), true);
            $this->setDictionary($dictionary);
        }
        return $this;
    }

    public function translate($key) {
        $dictionary = $this->getDictionary();
        return isset($dictionary[$key]) ? $dictionary[$key] : $key;
    }

}