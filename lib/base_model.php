<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach($this->validators as $validator){
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
        // $metodin_nimi = 'testi_metodi';
        // $this->{$metodin_nimi}();
        $validator_errors = $this->{$validator}();
        if ($validator_errors != null) {
          $errors[] = $validator_errors;
        }
        
      }

      return $errors;     
    }

    public function validate_field_not_null($string, $message){
      if($string == '' || $string == null){
        return $message;
      }
    }

  }
