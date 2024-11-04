<?php

namespace Vidamrr\Notas\models; // Define el espacio de nombres para organizar el código.
use Vidamrr\Notas\lib\Database; // Importa la clase Database para su uso en esta clase.
use PDO;

class Note extends Database
{ // La clase Note hereda de Database para poder usar sus métodos y propiedades.

    private string $uuid; // Propiedad privada para almacenar un identificador único (UUID) de la nota.

    // Constructor que recibe el título y el contenido de la nota.
    public function __construct(private string $title, private string $content)
    {
        parent::__construct(); // Llama al constructor de la clase padre (Database) para establecer la conexión.
        $this->uuid = uniqid(); // Genera un UUID único para la nota.
    }

    // Método para guardar la nota en la base de datos.
    public function save()
    {
        // Prepara la consulta SQL para insertar una nueva nota.
        $query = $this->connect()->prepare("INSERT INTO notes (uuid, title, content, updated) VALUES (:uuid, :title, :content, NOW())");

        // Ejecuta la consulta con los valores de las propiedades de la nota.
        $query->execute([
            'uuid' => $this->uuid, // Asocia el UUID generado para identificar la nota.
            'title' => $this->title, // Agrega el título de la nota.
            'content' => $this->content // Agrega el contenido de la nota.
        ]);
    }

    // Método para actualizar una nota en la base de datos.
    public function update()
    {
        // Prepara la consulta SQL para actualizar una nota existente en la base de datos.
        $query = $this->connect()->prepare("UPDATE notes SET title = :title, content = :content, updated=NOW() WHERE uuid = :uuid");

        // Ejecuta la consulta con los valores actuales de las propiedades.
        $query->execute([
            'title' => $this->title, // Asocia el título actualizado de la nota.
            'content' => $this->content, // Asocia el contenido actualizado de la nota.
            'uuid' => $this->uuid, // Usa el UUID para identificar la nota que se actualizará.
        ]);
    }

    public static function get($uuid)
    {
        $db = new Database(); // Crea una instancia de Database
        $query = $db->connect()->prepare("SELECT * FROM notes WHERE uuid = :uuid");
        $query->execute(['uuid' => $uuid]);
    
        $result = $query->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            return Note::createFromArray($result);
        } else {
            return null; // O lanzar una excepción
        }
    }
    

    public static function getAll()
    {
        // Inicializa un arreglo vacío para almacenar las notas que se obtendrán de la base de datos.
        $notes = [];
    
        // Crea una instancia de la clase Database.
        $database = new Database();
        $connection = $database->connect(); // Llama al método de instancia.
    
        // Ejecuta una consulta SQL para seleccionar todas las filas de la tabla "notes".
        $query = $connection->query("SELECT * FROM notes");
    
        // Itera sobre cada fila de resultados obtenida de la consulta.
        while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
            // Crea una instancia de Note utilizando los datos de la fila actual.
            $note = Note::createFromArray($r);
    
            // Agrega el objeto Note creado al arreglo de notas.
            array_push($notes, $note);
        }
    
        // Retorna el arreglo completo de notas, cada una representada como un objeto Note.
        return $notes;
    }
    

    // Método estático para crear una instancia de Note a partir de un arreglo de datos.
    public static function createFromArray($arr): Note
    {
        // Crea una nueva nota usando los valores de título y contenido del arreglo.
        $note = new Note($arr['title'], $arr['content']);

        // Asigna el UUID proporcionado en el arreglo a la nota creada.
        $note->setUUID($arr['uuid']);

        return $note; // Retorna la instancia de Note creada.
    }

    // Método estático para eliminar una nota de la base de datos usando su UUID.
    public static function delete($uuid)
    {
        // Crea una instancia de la clase Database.
        $database = new Database();
    
        // Prepara la consulta SQL para eliminar una nota basada en su UUID.
        $query = $database->connect()->prepare("DELETE FROM notes WHERE uuid = :uuid");
    
        // Ejecuta la consulta pasando el UUID como parámetro.
        $query->execute(['uuid' => $uuid]);
    
        // Retorna verdadero si la eliminación fue exitosa o falso si no.
        return $query->rowCount() > 0;
    }
    

    // Método para obtener el UUID de la nota.
    public function getUUID()
    {
        return $this->uuid; // Retorna el valor del UUID.
    }

    // Método para establecer el UUID de la nota.
    public function setUUID($value)
    {
        $this->uuid = $value; // Asigna el valor proporcionado a la propiedad UUID.
    }

    // Método para obtener el título de la nota.
    public function getTitle()
    {
        return $this->title; // Retorna el valor de la propiedad título.
    }

    // Método para establecer el título de la nota.
    public function setTitle($value)
    {
        $this->title = $value; // Asigna el valor proporcionado a la propiedad título.
    }

    // Método para obtener el contenido de la nota.
    public function getContent()
    {
        return $this->content; // Retorna el valor de la propiedad contenido.
    }

    // Método para establecer el contenido de la nota.
    public function setContent($value)
    {
        $this->content = $value; // Asigna el valor proporcionado a la propiedad contenido.
    }
}
