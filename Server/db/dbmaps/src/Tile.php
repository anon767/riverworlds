<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Tile
 */
class Tile
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $walkable;

    /**
     * @var \Map
     */
    private $product;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set walkable
     *
     * @param string $walkable
     * @return Tile
     */
    public function setWalkable($walkable)
    {
        $this->walkable = $walkable;

        return $this;
    }

    /**
     * Get walkable
     *
     * @return string 
     */
    public function getWalkable()
    {
        return $this->walkable;
    }

    /**
     * Set product
     *
     * @param \Map $product
     * @return Tile
     */
    public function setProduct(\Map $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Map 
     */
    public function getProduct()
    {
        return $this->product;
    }
    /**
     * @var \Map
     */
    private $map;


    /**
     * Set map
     *
     * @param \Map $map
     * @return Tile
     */
    public function setMap(\Map $map = null)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Get map
     *
     * @return \Map 
     */
    public function getMap()
    {
        return $this->map;
    }
    /**
     * @var string
     */
    private $sprite;


    /**
     * Set sprite
     *
     * @param string $sprite
     * @return Tile
     */
    public function setSprite($sprite)
    {
        $this->sprite = $sprite;

        return $this;
    }

    /**
     * Get sprite
     *
     * @return string 
     */
    public function getSprite()
    {
        return $this->sprite;
    }
    /**
     * @var integer
     */
    private $x;

    /**
     * @var integer
     */
    private $y;


    /**
     * Set x
     *
     * @param integer $x
     * @return Tile
     */
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get x
     *
     * @return integer 
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set y
     *
     * @param integer $y
     * @return Tile
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Get y
     *
     * @return integer 
     */
    public function getY()
    {
        return $this->y;
    }
    /**
     * @var string
     */
    private $frame;


    /**
     * Set frame
     *
     * @param string $frame
     * @return Tile
     */
    public function setFrame($frame)
    {
        $this->frame = $frame;

        return $this;
    }

    /**
     * Get frame
     *
     * @return string 
     */
    public function getFrame()
    {
        return $this->frame;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $maps;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->maps = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add maps
     *
     * @param \Map $maps
     * @return Tile
     */
    public function addMap(\Map $maps)
    {
        $this->maps[] = $maps;

        return $this;
    }

    /**
     * Remove maps
     *
     * @param \Map $maps
     */
    public function removeMap(\Map $maps)
    {
        $this->maps->removeElement($maps);
    }

    /**
     * Get maps
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMaps()
    {
        return $this->maps;
    }
    /**
     * @var integer
     */
    private $layer;


    /**
     * Set layer
     *
     * @param integer $layer
     * @return Tile
     */
    public function setLayer($layer)
    {
        $this->layer = $layer;

        return $this;
    }

    /**
     * Get layer
     *
     * @return integer 
     */
    public function getLayer()
    {
        return $this->layer;
    }
}
