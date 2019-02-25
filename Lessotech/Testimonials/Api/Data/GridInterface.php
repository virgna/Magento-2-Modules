<?php
/**
 * Lessotech
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the lessotech.com license that is
 * available through the world-wide-web at this URL:
 * https://www.lessotech.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Lessotech
 * @package     Lessotech_Testimonials
 * @copyright   Copyright (c) Lessotech (http://www.lessotech.com/)
 * @license     http://www.lessotech.com/LICENSE.txt
 */
 
/**
 * Lessotech_Testimonials Grid Interface.
 */
namespace Lessotech\Testimonials\Api\Data;
 
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
