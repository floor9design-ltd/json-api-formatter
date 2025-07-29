<?php
/**
 * Link.php
 *
 * Link class
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

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;
use Floor9design\JsonApiFormatter\Interfaces\LinkInterface;
use Floor9design\JsonApiFormatter\Interfaces\MetaInterface;

/**
 * Class Link
 *
 * Class to offer methods/properties to prepare data for a Link object
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
 * @link      https://jsonapi.org/format/#document-links-link-object
 * @since     File available since pre-release development cycle
 * @see       Links
 */
class Link implements LinkInterface
{
    // properties

    /**
     * a string whose value is a URI-reference [RFC3986 Section 4.1] pointing to the link's target.
     * @var string
     */
    protected string $href;

    /**
     * a string indicating the link's relation type. The string MUST be a valid link relation type.
     *
     * @see $link_relation_types
     * @var string|null
     */
    protected ?string $rel = null;

    /**
     * a link to a description document (e.g. OpenAPI or JSON Schema) for the link target
     * @var LinkInterface|string|null
     */
    protected LinkInterface|string|null $described_by = null;

    /**
     * List of all valid relation types
     *
     * @link https://www.rfc-editor.org/rfc/rfc8288#section-2.1
     * @var array<string>
     */
    protected array $link_relation_types = [
        'about',
        'acl',
        'alternate',
        'amphtml',
        'appendix',
        'apple-touch-icon',
        'apple-touch-startup-image',
        'archives',
        'author',
        'blocked-by',
        'bookmark',
        'canonical',
        'chapter',
        'cite-as',
        'collection',
        'contents',
        'convertedfrom',
        'copyright',
        'create-form',
        'current',
        'describedby',
        'describes',
        'disclosure',
        'dns-prefetch',
        'duplicate',
        'edit',
        'edit-form',
        'edit-media',
        'enclosure',
        'external',
        'first',
        'glossary',
        'help',
        'hosts',
        'hub',
        'icon',
        'index',
        'intervalafter',
        'intervalbefore',
        'intervalcontains',
        'intervaldisjoint',
        'intervalduring',
        'intervalequals',
        'intervalfinishedby',
        'intervalfinishes',
        'intervalin',
        'intervalmeets',
        'intervalmetby',
        'intervaloverlappedby',
        'intervaloverlaps',
        'intervalstartedby',
        'intervalstarts',
        'item',
        'last',
        'latest-version',
        'license',
        'linkset',
        'lrdd',
        'manifest',
        'mask-icon',
        'media-feed',
        'memento',
        'micropub',
        'modulepreload',
        'monitor',
        'monitor-group',
        'next',
        'next-archive',
        'nofollow',
        'noopener',
        'noreferrer',
        'opener',
        'openid2.local_id',
        'openid2.provider',
        'original',
        'p3pv1',
        'payment',
        'pingback',
        'preconnect',
        'predecessor-version',
        'prefetch',
        'preload',
        'prerender',
        'prev',
        'preview',
        'previous',
        'prev-archive',
        'privacy-policy',
        'profile',
        'publication',
        'related',
        'restconf',
        'replies',
        'ruleinput',
        'search',
        'section',
        'self',
        'service',
        'service-desc',
        'service-doc',
        'service-meta',
        'sip-trunking-capability',
        'sponsored',
        'start',
        'status',
        'stylesheet',
        'subsection',
        'successor-version',
        'sunset',
        'tag',
        'terms-of-service',
        'timegate',
        'timemap',
        'type',
        'ugc',
        'up',
        'version-history',
        'via',
        'webmention',
        'working-copy',
        'working-copy-of'
    ];

    /**
     * a string which serves as a label for the destination of a link such that it can be used as a human-readable
     * identifier (e.g., a menu entry).
     *
     * @var string|null
     */
    protected ?string $title = null;

    /**
     * a string indicating the media type of the link's target
     *
     * @var string|null
     */
    protected ?string $type = null;

    /**
     * a string or an array of strings indicating the language(s) of the link's target. An array of strings indicates
     * that the link's target is available in multiple languages. Each string MUST be a valid language tag [RFC5646].
     *
     * @link https://www.rfc-editor.org/rfc/rfc5646
     * @var array<string>|string|null
     */
    protected null|array|string $hreflang = null;

    /**
     * a meta object containing non-standard meta-information about the link
     *
     * @var MetaInterface|null
     */
    protected ?MetaInterface $meta = null;

    // accessors

    /**
     * @return string
     * @see $href
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @param string|null $href
     * @return LinkInterface
     * @see $href
     *
     */
    public function setHref(?string $href): LinkInterface
    {
        $this->href = $href;
        return $this;
    }

    /**
     * @return string|null
     * @see $rel
     */
    public function getRel(): ?string
    {
        return $this->rel;
    }

    /**
     * @param string|null $rel
     * @return LinkInterface
     * @throws JsonApiFormatterException
     * @see $rel
     */
    public function setRel(?string $rel): LinkInterface
    {
        if (
            // null is allowed
            $rel === null ||
            // else validate
            $this->validateRel($rel)
        ) {
            $this->rel = $rel;
        } else {
            $message = 'The provided rel was not valid (see Link - $link_relation_types)';
            throw new JsonApiFormatterException($message);
        }

        return $this;
    }

    /**
     * @return LinkInterface|string|null
     * @see $described_by
     *
     */
    public function getDescribedBy(): LinkInterface|string|null
    {
        return $this->described_by;
    }

    /**
     * @param LinkInterface|string|null $described_by
     * @return LinkInterface
     * @see $described_by
     *
     */
    public function setDescribedBy(LinkInterface|string|null $described_by): LinkInterface
    {
        $this->described_by = $described_by;
        return $this;
    }

    /**
     * @return array<string>
     * @see $link_relation_types
     *
     */
    public function getLinkRelationTypes(): array
    {
        return $this->link_relation_types;
    }

    /**
     * @param array<string> $link_relation_types
     * @return LinkInterface
     * @see $link_relation_types
     *
     */
    public function setLinkRelationTypes(array $link_relation_types): LinkInterface
    {
        $this->link_relation_types = $link_relation_types;
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
     * @return LinkInterface
     * @see $title
     */
    public function setTitle(?string $title): LinkInterface
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     * @see $type
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return LinkInterface
     * @see $type
     */
    public function setType(?string $type): LinkInterface
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return array<string>|string|null
     * @see $hreflang
     */
    public function getHreflang(): array|string|null
    {
        return $this->hreflang;
    }

    /**
     * @param array<string>|string|null $hreflang
     * @return LinkInterface
     * @see $hreflang
     */
    public function setHreflang(array|string|null $hreflang): LinkInterface
    {
        $this->hreflang = $hreflang;
        return $this;
    }

    /**
     * @return MetaInterface|null
     * @see $meta
     */
    public function getMeta(): ?MetaInterface
    {
        return $this->meta;
    }

    /**
     * @param MetaInterface|null $meta
     * @return LinkInterface
     * @see $meta
     */
    public function setMeta(?MetaInterface $meta): LinkInterface
    {
        $this->meta = $meta;
        return $this;
    }

    // constructor

    /**
     * Link constructor.
     *
     * @param string|null $href
     * @param Link|null $described_by
     * @param string|null $rel
     * @param string|null $title
     * @param string|null $type
     * @param array<string>|string|null $hreflang
     * @param MetaInterface|null $meta
     * @throws JsonApiFormatterException
     */
    public function __construct(
        string $href,
        LinkInterface|string|null $described_by = null,
        ?string $rel = null,
        ?string $title = null,
        ?string $type = null,
        null|array|string $hreflang = null,
        ?MetaInterface $meta = null
    ) {
        $this
            ->setHref($href)
            ->setDescribedBy($described_by)
            ->setRel($rel)
            ->setTitle($title)
            ->setType($type)
            ->setHreflang($hreflang)
            ->setMeta($meta);
    }

    // validation

    protected function validateRel(string $rel): bool
    {
        if (in_array($rel, $this->getLinkRelationTypes())) {
            return true;
        }
        return false;
    }

    /**
     * @return array<string, array<mixed>|string|null>
     * @throws JsonApiFormatterException
     */
    public function process(): array
    {
        $response = ['href' => $this->getHref()];

        if ($this->getRel()) {
            $response['rel'] = $this->getRel();
        }

        if ($this->getDescribedBy()) {
            if (is_string($this->getDescribedBy())) {
                $response['describedby'] = $this->getDescribedBy();
            } else {
                $response['describedby'] = $this->getDescribedBy()->process();
            }
        }

        if ($this->getTitle()) {
            $response['title'] = $this->getTitle();
        }

        if ($this->getType()) {
            $response['type'] = $this->getType();
        }

        if ($this->getHreflang()) {
            $response['hreflang'] = $this->getHreflang();
        }

        if ($this->getMeta()) {
            $response['meta'] = $this->getMeta()->process();
        }

        return $response;
    }

}
