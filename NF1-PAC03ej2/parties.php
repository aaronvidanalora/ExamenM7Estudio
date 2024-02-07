<?php
abstract class AbstractParty{
    private $displayName;

    public function setDisplayName($displayName){
        $this->displayName = $displayName;
    }

    public function getDisplayName(){
        return $this->displayName;
    }

    abstract public function getDescription();
}


class Person extends AbstractParty{
    private $FirstName;
    private $LastName;

    function __construct($displayName, $FirstName, $LastName){
        parent::setDisplayName($displayName);
        $this->setFirstName($FirstName);
        $this->setLastName($LastName);
    }

    public function setFirstName($FirstName){
        $this->FirstName=$FirstName;
    }

    public function getFirstName(){
        return $this->FirstName;
    }

    public function setLastName($LastName){
        $this->LastName=$LastName;
    }

    public function getLastName(){
        return $this->LastName;
    }

    public function getDescription(){
        return "Person: {$this->getDisplayName()}, {$this->getFirstName()} {$this->getLastName()}";
    }
}

class OrgUnit extends AbstractParty{
    private $Name;
    private $Employees = [];

    function __construct($Name){
        $this->setName($Name);
    }

    public function setName($Name){
        $this->Name=$Name;
    }

    public function getName(){
        return $this->Name;
    }

    public function addEmployee(Person $employee){
        $this->Employees[] = $employee;
    }

    public function getEmployees(){
        return $this->Employees;
    }

    public function getDescription(){
        $description = "OrgUnit: {$this->getDisplayName()}, {$this->getName()}\n";
        foreach ($this->Employees as $employee) {
            $description .= "- " . $employee->getDescription() . "<br>";
        }
        return $description;
    }
}

class Company extends AbstractParty{
    private $Name;
    private $Units = [];

    function __construct($Name){
        $this->setName($Name);
    }

    public function setName($Name){
        $this->Name=$Name;
    }

    public function getName(){
        return $this->Name;
    }

    public function addUnit(OrgUnit $unit){
        $this->Units[] = $unit;
    }

    public function getUnits(){
        return $this->Units;
    }

    public function getDescription(){
        $description = "Company: {$this->getDisplayName()}, {$this->getName()}\n";
        foreach ($this->Units as $unit) {
            $description .= "- " . $unit->getDescription() . "<br>";
        }
        return $description;
    }
}

// Creación de personas
$person1 = new Person("John Doe", "John", "Doe");
$person2 = new Person("Aaron", "vidaña", "Lora");

// Creación de unidad organizativa y asignación de empleados
$unit1 = new OrgUnit("Development"); // Establece el nombre en el constructor
$unit2 = new OrgUnit("Turaza"); // Establece el nombre en el constructor

$unit1->addEmployee($person1);
$unit2->addEmployee($person2);

// Creación de la compañía y agregación de unidades
$company = new Company("ACME Corp"); // Establece el nombre en el constructor
$company->addUnit($unit1);
$company->addUnit($unit2);

echo $company->getDescription();
