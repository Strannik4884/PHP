<?php
// include util classes
require_once ("Person.php");
require_once ("Database.php");
// source xml file
$file_path = "sample.xml";
if(file_exists($file_path)){
    $data = file_get_contents($file_path);
    // start parsing
    $persons = parseXmlData($data);
    saveToDatabase($persons);
}
else{
    print("Error: Can't load xml file!");
    die();
}

// data parsing function
function parseXmlData($data){
    // check the xml file for correct structure
    if(@simplexml_load_string($data)) {
        $xml = simplexml_load_string($data);
        print("Persons count in xml file: " . $xml->children()->count() . "\n");
        print("Starting parsing...\n");
        $i = 0;
        $persons = array($xml->children()->count());
        // parse each root's child
        foreach ($xml as $item) {
            print("Person №" . ++$i . "... ");
            $person = new Person();
            // prepare data
            $json = json_encode($item);
            $item_properties = json_decode($json, true);
            // check each Person's property
            if(isset($item_properties["URI"])){
                // checking mandatory field
                if(!empty($item_properties["URI"])){
                    $person->setURI($item_properties["URI"]);
                }
                else{
                    print("Error:\n\tMandatory field must be set!\n");
                    continue;
                }
            }
            else{
                print("Error:\n\tMandatory field must be set!\n");
                continue;
            }
            if(isset($item_properties["publicAccess"])){
                $person->setPublicAccess($item_properties["publicAccess"]);
            }
            if(isset($item_properties["profileState"])){
                $person->setProfileState($item_properties["profileState"]);
            }
            if(isset($item_properties["firstName"])){
                // checking mandatory field
                if(!empty($item_properties["firstName"])){
                    $person->setFirstName($item_properties["firstName"]);
                }
                else{
                    print("Error:\n\tMandatory field must be set!\n");
                    continue;
                }
            }
            else{
                print("Error:\n\tMandatory field must be set!\n");
                continue;
            }
            if(isset($item_properties["secondName"])){
                // checking mandatory field
                if(!empty($item_properties["secondName"])){
                    $person->setSecondName($item_properties["secondName"]);
                }
                else{
                    print("Error:\n\tMandatory field must be set!\n");
                    continue;
                }
            }
            else{
                print("Error:\n\tMandatory field must be set!\n");
                continue;
            }
            if(isset($item_properties["created"])){
                $person->setCreatedDate($item_properties["created"]);
            }
            if(isset($item_properties["lastLoggedIn"])){
                $person->setLastLoggedInDate($item_properties["lastLoggedIn"]);
            }
            if(isset($item_properties["modified"])) {
                $person->setModifiedDate($item_properties["modified"]);
            }
            $persons[$i - 1] = $person;
            print("Done\n");
        }
        print("Job done!\n\n");
        return $persons;
    }
    else{
        print("Error: Invalid xml file!");
        die();
    }
}

// database write function
function saveToDatabase($data){
    $database = new Database();
    // try to connect to database
    $connection = $database->connect();
    if(!empty($connection)){
        // prepare sql statement
        $prepared = $connection->prepare("INSERT INTO person(id, uri, public_access, profile_state, first_name, second_name, created_date, last_logged_in_date, modified_date)
                                                   VALUES (:id, :uri, :public_access, :profile_state, :first_name, :second_name, :created_date, :last_logged_in_date, :modified_date)");
        print("Saving to database...\n");
        // insert all data to database
        foreach ($data as $item) {
            $prepared->bindValue(":id", $item->getId(), PDO::PARAM_INT);
            $prepared->bindValue(":uri", $item->getURI(), PDO::PARAM_STR);
            $prepared->bindValue(":public_access", $item->getPublicAccess(), PDO::PARAM_STR);
            $prepared->bindValue(":profile_state", $item->getProfileState(), PDO::PARAM_STR);
            $prepared->bindValue(":first_name", $item->getFirstName(), PDO::PARAM_STR);
            $prepared->bindValue(":second_name", $item->getSecondName(), PDO::PARAM_STR);
            $prepared->bindValue(":created_date", $item->getCreatedDate(), PDO::PARAM_STR);
            $prepared->bindValue(":last_logged_in_date", $item->getLastLoggedInDate(), PDO::PARAM_STR);
            $prepared->bindValue(":modified_date", $item->getModifiedDate(), PDO::PARAM_STR);
            try {
                $prepared->execute();
            } catch (PDOException $exception){
                print($exception->getMessage());
            }
        }
        print("\nJob done!");
        $database->close();
    }
}