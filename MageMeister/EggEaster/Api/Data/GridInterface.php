<?php
/**
 * MageMeister Inc.
 *
 * NOTICE OF LICENSE
 *
 * <!--LICENSETEXT-->
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://magemeister.com for more information.
 *
 * @category    MageMeister
 * @package     MageMeister_EggEaster
 * @copyright   Copyright (c) 2013-2018 MageMeister Inc. (http://magemeister.com)
 * @author      Virang Jethva <virang.jethva@magemeister.com>
 * @info        MageMeister Inc. <hello@magemeister.com>
 */
 
/**
 * MageMeister_Sellwithus Grid Interface.
 */
namespace MageMeister\EggEaster\Api\Data;
 
interface GridInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ID = 'id';
    const EGGCODE = 'eggcode';
    const EGGNAME = 'eggname';
    
    
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
     * Get getEggcode.
     *
     * @return varchar
     */
    public function getEggcode();
 
    /**
     * Set getEggcode.
     */
    public function setEggcode($eggcode);
 
    /**
     * Get getEggname.
     *
     * @return varchar
     */
    public function getEggname();
 
    /**
     * Set getEggname.
     */
    public function setEggname($eggname);
}