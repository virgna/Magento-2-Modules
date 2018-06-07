<?php
/**
 * Magentochamp_Bulkorder Grid Interface.
 */
namespace Magentochamp\Bulkorder\Api\Data;
 
interface GridInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ID = 'id';
    const FIRSTNAME = 'firstname';
    const LASTNAME = 'lastname';
    const EMAIL = 'email';
    const CITY = 'city';
    
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getId();
 
    /**
     * Set EntityId.
     */
    public function setId($entityId);
 
    /**
     * Get getFirstname.
     *
     * @return varchar
     */
    public function getFirstname();
 
    /**
     * Set getFirstname.
     */
    public function setFirstname($firstname);
 
    /**
     * Get getLastname.
     *
     * @return varchar
     */
    public function getLastname();
 
    /**
     * Set getLastname.
     */
    public function setLastname($getLastname);
 
    /**
     * Get getEmail.
     *
     * @return varchar
     */
    public function getEmail();
 
    /**
     * Set getEmail.
     */
    public function setEmail($getEmail);

    /**
     * Get getCity.
     *
     * @return varchar
     */
    public function getCity();
 
    /**
     * Set getCity.
     */
    public function setCity($getCity);
}