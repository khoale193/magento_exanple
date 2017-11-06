<?php
namespace Isobar\Repository\Api\Data;

interface EmployeeInterface {

    /**
     *
     */
    const NAME = 'name';

    /**
     *
     */
    const CREATED_AT = 'created_at';

    /**
     *
     */
    const UPDATED_AT = 'updated_at';

    /**
     *
     */
    const IS_FEMALE = 'is_female';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param integer $id
     * @return mixed
     */
    public function setId($id);

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param string $name
     * @return mixed
     */
    public function setName($name);

    /**
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * @param string $timeStamp
     * @return mixed
     */
    public function setCreatedAt($timeStamp);

    /**
     * @return mixed
     */
    public function getUpdatedAt();

    /**
     * @param string $timeStamp
     * @return mixed
     */
    public function setUpdatedAt($timeStamp);

    /**
     * @return mixed
     */
    public function getIsFemale();

    /**
     * @param boolean $isFemale
     * @return mixed
     */
    public function setIsFemale($isFemale);
}
