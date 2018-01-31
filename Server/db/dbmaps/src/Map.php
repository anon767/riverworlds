<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Map
 */
class Map
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tiles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tiles = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add tiles
     *
     * @param \Tile $tiles
     * @return Map
     */
    public function addTile(\Tile $tiles)
    {
        $this->tiles[] = $tiles;

        return $this;
    }

    /**
     * Remove tiles
     *
     * @param \Tile $tiles
     */
    public function removeTile(\Tile $tiles)
    {
        $this->tiles->removeElement($tiles);
    }

    /**
     * Get tiles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTiles()
    {
        return $this->tiles;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $players;


    /**
     * Add players
     *
     * @param \Player $players
     * @return Map
     */
    public function addPlayer(\Player $players)
    {
        $this->players[] = $players;

        return $this;
    }

    /**
     * Remove players
     *
     * @param \Player $players
     */
    public function removePlayer(\Player $players)
    {
        $this->players->removeElement($players);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlayers()
    {
        return $this->players;
    }
    /**
     * @var integer
     */
    private $startX;

    /**
     * @var integer
     */
    private $startY;


    /**
     * Set startX
     *
     * @param integer $startX
     * @return Map
     */
    public function setStartX($startX)
    {
        $this->startX = $startX;

        return $this;
    }

    /**
     * Get startX
     *
     * @return integer 
     */
    public function getStartX()
    {
        return $this->startX;
    }

    /**
     * Set startY
     *
     * @param integer $startY
     * @return Map
     */
    public function setStartY($startY)
    {
        $this->startY = $startY;

        return $this;
    }

    /**
     * Get startY
     *
     * @return integer 
     */
    public function getStartY()
    {
        return $this->startY;
    }
    /**
     * @var string
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     * @return Map
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $accesPoints;


    /**
     * Add accesPoints
     *
     * @param \AccesPoinr $accesPoints
     * @return Map
     */
    public function addAccesPoint(\AccessPoint $accesPoints)
    {
        $this->accesPoints[] = $accesPoints;

        return $this;
    }

    /**
     * Remove accesPoints
     *
     * @param \AccesPoinr $accesPoints
     */
    public function removeAccesPoint(\AccessPoint $accesPoints)
    {
        $this->accesPoints->removeElement($accesPoints);
    }

    /**
     * Get accesPoints
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAccesPoints()
    {
        return $this->accesPoints;
    }
    /**
     * @var integer
     */
    private $width;

    /**
     * @var integer
     */
    private $height;


    /**
     * Set width
     *
     * @param integer $width
     * @return Map
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return Map
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer 
     */
    public function getHeight()
    {
        return $this->height;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $npcs;


    /**
     * Add npcs
     *
     * @param \Npc $npcs
     * @return Map
     */
    public function addNpc(\Npc $npcs)
    {
        $this->npcs[] = $npcs;

        return $this;
    }

    /**
     * Remove npcs
     *
     * @param \Npc $npcs
     */
    public function removeNpc(\Npc $npcs)
    {
        $this->npcs->removeElement($npcs);
    }

    /**
     * Get npcs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNpcs()
    {
        return $this->npcs;
    }
}
