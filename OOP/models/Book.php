<?php
/**
 * Book Model Class
 * 
 * OOP Concepts Used:
 * 1. ENCAPSULATION: Private properties with public getters/setters
 * 2. DATA MODELING: Represents a Book entity with its attributes and behaviors
 * 3. VALIDATION: Input validation methods ensure data integrity
 * 4. TYPE SAFETY: Proper data types for each property
 */

namespace Models;

class Book {
    // ENCAPSULATION: Private properties - data hiding
    private $id;
    private $title;
    private $author;
    private $type;
    private $description;
    private $createdAt;
    private $updatedAt;
    
    // Valid book types - CONSTANTS for data integrity
    const VALID_TYPES = ['Adventure', 'Crime', 'Fantasy', 'Horror'];
    
    /**
     * Constructor - OBJECT INITIALIZATION
     * @param array $data Initial data for the book
     */
    public function __construct($data = []) {
        if (!empty($data)) {
            $this->populateFromArray($data);
        }
    }
    
    /**
     * ENCAPSULATION: Populate object from array data
     * @param array $data Data array
     */
    private function populateFromArray($data) {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? '';
        $this->author = $data['author'] ?? '';
        $this->type = $data['type'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->createdAt = $data['created_at'] ?? null;
        $this->updatedAt = $data['updated_at'] ?? null;
    }
    
    // ENCAPSULATION: Getter methods - controlled access to private properties
    public function getId() {
        return $this->id;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getAuthor() {
        return $this->author;
    }
    
    public function getType() {
        return $this->type;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function getCreatedAt() {
        return $this->createdAt;
    }
    
    public function getUpdatedAt() {
        return $this->updatedAt;
    }
    
    // ENCAPSULATION: Setter methods with validation - controlled modification
    public function setId($id) {
        $this->id = (int)$id;
    }
    
    public function setTitle($title) {
        if ($this->validateTitle($title)) {
            $this->title = trim($title);
        } else {
            throw new \InvalidArgumentException("Title must be between 1 and 255 characters");
        }
    }
    
    public function setAuthor($author) {
        if ($this->validateAuthor($author)) {
            $this->author = trim($author);
        } else {
            throw new \InvalidArgumentException("Author must be between 1 and 255 characters");
        }
    }
    
    public function setType($type) {
        if ($this->validateType($type)) {
            $this->type = $type;
        } else {
            throw new \InvalidArgumentException("Invalid book type. Must be one of: " . implode(', ', self::VALID_TYPES));
        }
    }
    
    public function setDescription($description) {
        $this->description = trim($description);
    }
    
    // VALIDATION METHODS - DATA INTEGRITY
    private function validateTitle($title) {
        return !empty(trim($title)) && strlen(trim($title)) <= 255;
    }
    
    private function validateAuthor($author) {
        return !empty(trim($author)) && strlen(trim($author)) <= 255;
    }
    
    private function validateType($type) {
        return in_array($type, self::VALID_TYPES);
    }
    
    /**
     * VALIDATION: Validate entire object
     * @return bool True if valid, false otherwise
     */
    public function isValid() {
        return $this->validateTitle($this->title) && 
               $this->validateAuthor($this->author) && 
               $this->validateType($this->type);
    }
    
    /**
     * DATA TRANSFORMATION: Convert object to array
     * @return array Object data as array
     */
    public function toArray() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'type' => $this->type,
            'description' => $this->description,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
    
    /**
     * OBJECT REPRESENTATION: String representation of the object
     * @return string
     */
    public function __toString() {
        return "Book: {$this->title} by {$this->author} ({$this->type})";
    }
}
?>
