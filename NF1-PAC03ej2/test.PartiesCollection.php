<?php
require_once('class.collection.php'); // Incluye la clase Collection, que necesitamos para la PartyCollection.

abstract class AbstractParty{ // Definición de la clase abstracta AbstractParty.
    private $displayName; // Propiedad privada para el nombre de visualización.

    public function setDisplayName($displayName){ // Método para establecer el nombre de visualización.
        $this->displayName = $displayName;
    }

    public function getDisplayName(){ // Método para obtener el nombre de visualización.
        return $this->displayName;
    }

    abstract public function getDescription(); // Método abstracto para obtener la descripción (debe ser implementado por las subclases).
}

class PartyCollection extends Collection{ // Definición de la clase PartyCollection, que extiende la clase Collection.
    public function addParty(AbstractParty $party = null, $key = null){ // Método para agregar una fiesta a la colección.
        $this->addItem($party, $key); // Agrega un elemento a la colección.
    }
}

class Person extends AbstractParty{ // Definición de la clase Person, que hereda de AbstractParty.
    private $FirstName; // Propiedad privada para el primer nombre.
    private $LastName; // Propiedad privada para el apellido.

    function __construct($displayName, $FirstName, $LastName){ // Constructor de la clase.
        parent::setDisplayName($displayName); // Llama al método setDisplayName de la clase padre.
        $this->FirstName = $FirstName; // Inicializa la propiedad FirstName.
        $this->LastName = $LastName; // Inicializa la propiedad LastName.
    }

    public function getFirstName(){ // Método para obtener el primer nombre.
        return $this->FirstName;
    }

    public function getLastName(){ // Método para obtener el apellido.
        return $this->LastName;
    }

    public function getDescription(){ // Implementación del método abstracto getDescription.
        return "Person: {$this->getDisplayName()}, {$this->getFirstName()} {$this->getLastName()}"; // Devuelve la descripción de la persona.
    }
}

class OrgUnit extends AbstractParty{ // Definición de la clase OrgUnit, que hereda de AbstractParty.
    private $Name; // Propiedad privada para el nombre de la unidad.
    private $Employees; // Propiedad privada para los empleados de la unidad.

    function __construct($displayName, $Name){ // Constructor de la clase.
        parent::setDisplayName($displayName); // Llama al método setDisplayName de la clase padre.
        $this->Name = $Name; // Inicializa la propiedad Name.
        $this->Employees = new PartyCollection(); // Inicializa la colección de empleados.
    }

    public function addEmployee(AbstractParty $Employee){ // Método para agregar un empleado a la unidad.
        $this->Employees->addParty($Employee); // Agrega el empleado a la colección.
    }

    public function removeEmployee(AbstractParty $Employee){ // Método para eliminar un empleado de la unidad.
        $this->Employees->removeItem($Employee); // Elimina el empleado de la colección.
    }

    public function getName(){ // Método para obtener el nombre de la unidad.
        return $this->Name;
    }

    public function hasChildren() { // Método para verificar si la unidad tiene empleados.
        return $this->Employees->length() > 0;
    }

    public function getChild($i) { // Método para obtener un empleado de la unidad por índice.
        return $this->Employees->getItem($i);
    }

    public function getDescription(){ // Implementación del método abstracto getDescription.
        $description = "OrgUnit: {$this->getDisplayName()}, {$this->getName()}\n"; // Construye la descripción de la unidad.
        foreach ($this->Employees->keys() as $key) { // Recorre todos los empleados de la unidad.
            $description .= "- " . $this->Employees->getItem($key)->getDescription() . "<br>"; // Agrega la descripción de cada empleado.
        }
        return $description; // Devuelve la descripción completa.
    }
}

class Company extends AbstractParty{ // Definición de la clase Company, que hereda de AbstractParty.
    private $Name; // Propiedad privada para el nombre de la compañía.
    private $Units; // Propiedad privada para las unidades de la compañía.

    function __construct($displayName, $Name){ // Constructor de la clase.
        parent::setDisplayName($displayName); // Llama al método setDisplayName de la clase padre.
        $this->Name = $Name; // Inicializa la propiedad Name.
        $this->Units = new PartyCollection(); // Inicializa la colección de unidades.
    }

    public function addUnit(OrgUnit $Unit){ // Método para agregar una unidad a la compañía.
        $this->Units->addParty($Unit); // Agrega la unidad a la colección.
    }

    public function removeUnit(OrgUnit $Unit){ // Método para eliminar una unidad de la compañía.
        $this->Units->removeItem($Unit); // Elimina la unidad de la colección.
    }

    public function getName(){ // Método para obtener el nombre de la compañía.
        return $this->Name;
    }

    public function hasChildren() { // Método para verificar si la compañía tiene unidades.
        return $this->Units->length() > 0;
    }

    public function getChild($i) { // Método para obtener una unidad de la compañía por índice.
        return $this->Units->getItem($i);
    }

    public function getDescription() { // Implementación del método abstracto getDescription.
        $description = "Company: {$this->getDisplayName()}, {$this->getName()}\n"; // Construye la descripción de la compañía.
        foreach ($this->Units->keys() as $key) { // Recorre todas las unidades de la compañía.
            $description .= "- " . $this->Units->getItem($key)->getDescription() . "<br>"; // Agrega la descripción de cada unidad.
        }
        return $description; // Devuelve la descripción completa.
    }
}

$Units = new PartyCollection(); // Creación de una colección de partes.
$Units->addParty(new Company('Compañia 1', 'Compañia 1')); // Agrega una compañía a la colección.
$Units->addParty(new Company('Compañia 2', 'Compañia 2')); // Agrega una compañía a la colección.
$Units->addParty(new Company('Compañia 3', 'Compañia 3')); // Agrega una compañía a la colección.

// Creación de personas
$person1 = new Person("John Doe", "John", "Doe"); // Crea una persona.
$person2 = new Person("Jane Smith", "Jane", "Smith"); // Crea una persona.
$person3 = new Person("Alice Johnson", "Alice", "Johnson"); // Crea una persona.

// Creación de unidad organizativa y asignación de empleados
$unit1 = new OrgUnit("Development", ''); // Crea una unidad organizativa.
$unit2 = new OrgUnit("Sales", ''); // Crea una unidad organizativa.

$unit1->addEmployee($person1); // Agrega un empleado a la unidad.
$unit1->addEmployee($person2); // Agrega un empleado a la unidad.
$unit1->addEmployee($person3); // Agrega un empleado a la unidad.

$unit2->addEmployee($person3); // Agrega un empleado a la unidad.

// Creación de la compañía y agregación de unidades
$company = new Company("ACME Corp", 'ACME Corp'); // Crea una compañía.
$company->addUnit($unit1); // Agrega una unidad a la compañía.
$company->addUnit($unit2); // Agrega una unidad a la compañía.

echo $company->getDescription(); // Imprime la descripción de la compañía.
?>
