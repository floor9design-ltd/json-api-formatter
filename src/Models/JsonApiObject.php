<?php
/**
 * JsonApiObject.php
 *
 * JsonApiObject class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.1
 * @link      https://www.floor9design.com
 * @since     File available since pre-release development cycle
 *
 */

namespace Floor9design\JsonApiFormatter\Models;

use Floor9design\JsonApiFormatter\Interfaces\JsonApiObjectInterface;

/**
 * Class JsonApiObject
 *
 * Class to offer methods/properties to prepare data for a JsonApiObject object
 * These are set to the v1.1 specification, defined at https://jsonapi.org/format/
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.1
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @link      https://jsonapi.org/format/#document-jsonapi-object
 * @since     File available since pre-release development cycle
 */
class JsonApiObject implements JsonApiObjectInterface
{
    // properties

    /**
     * A string indicating the highest JSON:API version supported
     * @var string
     */
    protected string $version = '1.1';

    /**
     * URIs for all applied extensions.
     * @var array|null
     */
    protected ?array $ext;

    /**
     * URIs for all applied profiles.
     * @var array|null 
     */
    protected ?array $profile;

    /**
     * @var Meta|null 
     */
    protected ?Meta $meta;

    // accessors

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return JsonApiObjectInterface
     */
    public function setVersion(string $version): JsonApiObjectInterface
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getExt(): ?array
    {
        return $this->ext;
    }

    /**
     * @param array|null $ext
     * @return JsonApiObjectInterface
     */
    public function setExt(?array $ext): JsonApiObjectInterface
    {
        $this->ext = $ext;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getProfile(): ?array
    {
        return $this->profile;
    }

    /**
     * @param array|null $profile
     * @return JsonApiObjectInterface
     */
    public function setProfile(?array $profile): JsonApiObjectInterface
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * @return Meta|null
     */
    public function getMeta(): ?Meta
    {
        return $this->meta;
    }

    /**
     * @param Meta|null $meta
     * @return JsonApiObjectInterface
     */
    public function setMeta(?Meta $meta): JsonApiObjectInterface
    {
        $this->meta = $meta;
        return $this;
    }

    // constructor

    /**
     * JsonApiObject constructor.
     * Automatically sets up the provided array as properties
     * @param string $version
     * @param array|null $ext
     * @param array|null $profile
     * @param Meta|null $meta
     */
    public function __construct(
        string $version = '1.1',
        ?array $ext = null,
        ?array $profile = null,
        ?Meta $meta = null
    )
    {
        $this->setVersion($version)
            ->setExt($ext)
            ->setProfile($profile)
            ->setMeta($meta);
    }

    /**
     * @return array<mixed>
     */
    public function process(): array
    {
        $array = [
            'version' => $this->getVersion(),
        ];

        if($this->getExt()) {
            $array['ext'] = $this->getExt();
        }

        if($this->getProfile()) {
            $array['profile'] = $this->getProfile();
        }

        if($this->getMeta()) {
            $array['meta'] = $this->getMeta();
        }

        return $array;
    }

}
