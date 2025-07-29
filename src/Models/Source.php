<?php
/**
 * Source.php
 *
 * Source class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.3
 * @link      https://www.floor9design.com
 * @since     File available since pre-release development cycle
 *
 */

namespace Floor9design\JsonApiFormatter\Models;

use Floor9design\JsonApiFormatter\Interfaces\SourceInterface;

/**
 * Class Source
 *
 * Class to offer methods/properties to prepare data for a Source object
 * These are set to the v1.1 specification, defined at https://jsonapi.org/format/
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.3
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     File available since pre-release development cycle
 * @see       https://jsonapi.org/format/
 */
class Source implements SourceInterface
{
    // properties

    /**
     * a JSON Pointer [RFC6901] to the value in the request document that caused the error
     * @link https://datatracker.ietf.org/doc/html/rfc6901
     * @var string|null
     */
    protected ?string $pointer = null;

    /**
     * a string indicating which URI query parameter caused the error.
     * @var string|null
     */
    protected ?string $parameter = null;

    /**
     * a string indicating the name of a single request header which caused the error.
     * @var string|null
     */
    protected ?string $header = null;

    // accessors

    /**
     * @return string|null
     */
    public function getPointer(): ?string
    {
        return $this->pointer;
    }

    /**
     * @param string|null $pointer
     * @return SourceInterface
     */
    public function setPointer(?string $pointer): SourceInterface
    {
        $this->pointer = $pointer;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParameter(): ?string
    {
        return $this->parameter;
    }

    /**
     * @param string|null $parameter
     * @return SourceInterface
     */
    public function setParameter(?string $parameter): SourceInterface
    {
        $this->parameter = $parameter;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHeader(): ?string
    {
        return $this->header;
    }

    /**
     * @param string|null $header
     * @return SourceInterface
     */
    public function setHeader(?string $header): SourceInterface
    {
        $this->header = $header;
        return $this;
    }

    // constructor

    /**
     * Source constructor.
     * Automatically sets up the provided array as properties
     * @param string|null $pointer
     * @param string|null $parameter
     * @param string|null $header
     */
    public function __construct(
        ?string $pointer = null,
        ?string $parameter = null,
        ?string $header = null
    ) {
        $this->setPointer($pointer)
            ->setParameter($parameter)
            ->setHeader($header);
    }

    /**
     * @return array<string>
     */
    public function process(): array
    {
        $array = [];

        if ($this->getPointer()) {
            $array['pointer'] = $this->getPointer();
        }

        if ($this->getParameter()) {
            $array['parameter'] = $this->getParameter();
        }

        if ($this->getHeader()) {
            $array['header'] = $this->getHeader();
        }

        return $array;
    }

}
