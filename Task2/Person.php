<?php

class Person
{
    private $Id;
    private $URI;
    private $publicAccess;
    private $profileState;
    private $firstName;
    private $secondName;
    private $createdDate;
    private $lastLoggedInDate;
    private $modifiedDate;

    public function setId($Id){
        $this->Id = $Id;
    }

    public function getId(){
        return $this->Id;
    }

    public function setURI($URI){
        if(isset($URI["@attributes"]["primary"]) and isset($URI["@attributes"]["resource"])){
            $this->Id = str_replace("http://vk.com/id", "", $URI["@attributes"]["resource"]);
            $this->URI = $URI["@attributes"]["resource"];
        }
        else if(isset($URI[0]["@attributes"]["primary"]) and isset($URI[0]["@attributes"]["resource"])){
            $this->Id = str_replace("http://vk.com/id", "", $URI[0]["@attributes"]["resource"]);
            if(isset($URI[1]["@attributes"]["resource"]) and !isset($URI[1]["@attributes"]["primary"])){
                $this->URI = $URI[1]["@attributes"]["resource"];
            }
            else{
                $this->URI = $URI[0]["@attributes"]["resource"];
            }
        }
    }

    public function getURI(){
        return $this->URI;
    }

    public function setPublicAccess($publicAccess){
        $this->publicAccess = $publicAccess;
    }

    public function getPublicAccess(){
        return $this->publicAccess;
    }

    public function setProfileState($profileState){
        $this->profileState = $profileState;
    }

    public function getProfileState(){
        return $this->profileState;
    }

    public function setFirstName($firstName){
        $this->firstName = $firstName;
    }

    public function getFirstName(){
        return $this->firstName;
    }

    public function setSecondName($secondName){
        $this->secondName = $secondName;
    }

    public function getSecondName(){
        return $this->secondName;
    }

    public function setCreatedDate($createdDate){
        if(isset($createdDate["@attributes"]["date"])){
            $this->createdDate = DateTime::createFromFormat("Y-m-d\TH:i:sP", $createdDate["@attributes"]["date"]);
        }
    }

    public function getCreatedDate(){
        if($this->createdDate === null){
            return null;
        }
        return date_format($this->createdDate, 'Y-m-d H:i:s');
    }

    public function setLastLoggedInDate($lastLoggedInDate){
        if(isset($lastLoggedInDate["@attributes"]["date"])){
            $this->lastLoggedInDate = DateTime::createFromFormat("Y-m-d\TH:i:sP", $lastLoggedInDate["@attributes"]["date"]);
        }
    }

    public function getLastLoggedInDate(){
        if($this->lastLoggedInDate === null){
            return null;
        }
        return date_format($this->lastLoggedInDate, 'Y-m-d H:i:s');
    }

    public function setModifiedDate($modifiedDate){
        if(isset($modifiedDate["@attributes"]["date"])){
            $this->modifiedDate = DateTime::createFromFormat("Y-m-d\TH:i:sP", $modifiedDate["@attributes"]["date"]);
        }
    }

    public function getModifiedDate(){
        if($this->modifiedDate === null){
            return null;
        }
        return date_format($this->modifiedDate, 'Y-m-d H:i:s');
    }
}