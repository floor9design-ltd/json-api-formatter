<?php
/**
 * Error.php
 *
 * Error class
 *
 * php 7.4+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   1.3.1
 * @link      https://www.floor9design.com
 * @since     File available since pre-release development cycle
 *
 */

namespace Floor9design\JsonApiFormatter\Models;

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;

/**
 * Class Error
 *
 * Class to offer methods/properties to prepare data for an Error
 * These are set to the v1.0 specification, defined at https://jsonapi.org/format/
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   1.3.1
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     File available since pre-release development cycle
 * @see       https://jsonapi.org/format/
 */
class Error
{
    // Properties

    /**
     * @var string|null
     */
    var ?string $id = null;

    /**
     * @var Links|null
     */
    var ?Links $links = null;

    /**
     * @var string|null
     */
    var ?string $status = null;

    /**
     * @var string|null
     */
    var ?string $code = null;

    /**
     * @var string|null
     */
    var ?string $title = null;

    /**
     * @var string|null
     */
    var ?string $detail = null;

    /**
     * @var Source|null
     */
    var ?Source $source = null;

    /**
     * @var Meta|null
     */
    var ?Meta $meta = null;

    // accessors

    /**
     * @return string|null
     * @see $id
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return Error
     * @see $id
     */
    public function setId(?string $id): Error
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Links|null
     * @see $links
     */
    public function getLinks(): ?Links
    {
        return $this->links;
    }

    /**
     * @param Links|null $links
     * @return Error
     * @see $links
     */
    public function setLinks(?Links $links): Error
    {
        $this->links = $links;
        return $this;
    }

    /**
     * @return string|null
     * @see $status
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return Error
     * @see $status
     */
    public function setStatus(?string $status): Error
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string|null
     * @see $code
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return Error
     * @see $code
     */
    public function setCode(?string $code): Error
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string|null
     * @see $title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Error
     * @see $title
     */
    public function setTitle(?string $title): Error
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     * @see $detail
     */
    public function getDetail(): ?string
    {
        return $this->detail;
    }

    /**
     * @param string|null $detail
     * @return Error
     * @see $detail
     */
    public function setDetail(?string $detail): Error
    {
        $this->detail = $detail;
        return $this;
    }

    /**
     * @return Source|null
     * @see $source
     */
    public function getSource(): ?Source
    {
        return $this->source;
    }

    /**
     * @param Source|null $source
     * @return Error
     * @see $source
     */
    public function setSource(?Source $source): Error
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return Meta|null
     * @see $meta
     */
    public function getMeta(): ?Meta
    {
        return $this->meta;
    }

    /**
     * @param Meta|null $meta
     */
    public function setMeta(?Meta $meta): void
    {
        $this->meta = $meta;
    }

    // constructor

    /**
     * Error constructor.
     * @param string|null $id
     * @param Links|null $links
     * @param string|null $status
     * @param string|null $code
     * @param string|null $title
     * @param string|null $detail
     * @param Source|null $source
     * @param Meta|null $meta
     */
    public function __construct(
        ?string $id = null,
        ?Links $links = null,
        ?string $status = null,
        ?string $code = null,
        ?string $title = null,
        ?string $detail = null,
        ?Source $source = null,
        ?Meta $meta = null
    ) {
        $this
            ->setId($id)
            ->setLinks($links)
            ->setStatus($status)
            ->setCode($code)
            ->setTitle($title)
            ->setDetail($detail)
            ->setSource($source)
            ->setMeta($meta);
    }

    /**
     * @return array<mixed>
     * @throws JsonApiFormatterException
     */
    public function process(): array
    {
        // only include set values:

        $return = [];

        if($this->getId()) {
            $return['id'] = $this->getId();
        }

        if($this->getStatus()) {
            $return['status'] = $this->getStatus();
        }

        if($this->getCode()) {
            $return['code'] = $this->getCode();
        }

        if($this->getTitle()) {
            $return['title'] = $this->getTitle();
        }

        if($this->getDetail()) {
            $return['detail'] = $this->getDetail();
        }

        if($this->getSource()) {
            $return['source'] = $this->getSource()->process();
        }

        if($this->getMeta()) {
            $return['meta'] = (object)$this->getMeta()->process();
        }

        if($this->getLinks()) {
            $return['links'] = (object)$this->getLinks()->process();
        }

        // Spec 11.2 : An error object MAY have the following members, and MUST contain at least one of...
        if(count($return) == 0) {
            throw new JsonApiFormatterException('Errors must contain at least one member.');
        }

        return $return;
    }

}
