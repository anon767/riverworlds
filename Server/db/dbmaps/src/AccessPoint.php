<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * AccessPoint
 */
class AccessPoint
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Map
     */
    private $fromMap;

    /**
     * @var \Map
     */
    private $toMap;


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
     * Set fromMap
     *
     * @param \Map $fromMap
     * @return AccessPoint
     */
    public function setFromMap(\Map $fromMap = null)
    {
        $this->fromMap = $fromMap;

        return $this;
    }

    /**
     * Get fromMap
     *
     * @return \Map 
     */
    public function getFromMap()
    {
        return $this->fromMap;
    }

    /**
     * Set toMap
     *
     * @param \Map $toMap
     * @return AccessPoint
     */
    public function setToMap(\Map $toMap = null)
    {
        $this->toMap = $toMap;

        return $this;
    }

    /**
     * Get toMap
     *
     * @return \Map 
     */
    public function getToMap()
    {
        return $this->toMap;
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
     * @return AccessPoint
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
     * @return AccessPoint
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
}
