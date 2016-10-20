<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Npc
 */
class Npc
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $speech;

    /**
     * @var integer
     */
    private $x;

    /**
     * @var integer
     */
    private $y;

    /**
     * @var \Map
     */
    private $map;


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
     * Set name
     *
     * @param string $name
     * @return Npc
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
     * Set speech
     *
     * @param string $speech
     * @return Npc
     */
    public function setSpeech($speech)
    {
        $this->speech = $speech;

        return $this;
    }

    /**
     * Get speech
     *
     * @return string 
     */
    public function getSpeech()
    {
        return $this->speech;
    }

    /**
     * Set x
     *
     * @param integer $x
     * @return Npc
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
     * @return Npc
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
     * Set map
     *
     * @param \Map $map
     * @return Npc
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
     * @return Npc
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
}
