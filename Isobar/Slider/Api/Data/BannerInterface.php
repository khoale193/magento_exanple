<?php
namespace Isobar\Slider\Api\Data;

interface BannerInterface
{
    const BANNER_ID = 'id';
    const BANNER_NAME = 'name';
    const BANNER_URL = 'url';
    const BANNER_ALT = 'alt';
    const BANNER_STATUS = 'status';
    const BANNER_IMAGE_DESTINATION = 'image_destination';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Get url
     *
     * @return string|null
     */
    public function getUrl();

    /**
     * Get alt
     *
     * @return string|null
     */
    public function getAlt();

    /**
     * Get status
     *
     * @return int|bool
     */
    public function getStatus();

    /**
     * Get image destination
     *
     * @return int|bool
     */
    public function getImageDestination();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Isobar\Slider\Api\Data\BannerInterface
     */
    public function setId($id);

    /**
     * Set name
     *
     * @param string $name
     * @return \Isobar\Slider\Api\Data\BannerInterface
     */
    public function setName($name);

    /**
     * Set url
     *
     * @param string $url
     * @return \Isobar\Slider\Api\Data\BannerInterface
     */
    public function setUrl($url);

    /**
     * Set alt
     *
     * @param string $alt
     * @return \Isobar\Slider\Api\Data\BannerInterface
     */
    public function setAlt($alt);

    /**
     * Set status
     *
     * @param int|bool $status
     * @return \Isobar\Slider\Api\Data\BannerInterface
     */
    public function setStatus($status);

    /**
     * Set image destination
     *
     * @param string $imageDestination
     */
    public function setImagePath($imageDestination);
}
