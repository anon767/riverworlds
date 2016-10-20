<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Player
 */
class Player
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
     * @var integer
     */
    private $hp;

    /**
     * @var integer
     */
    private $x;

    /**
     * @var integer
     */
    private $y;


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
     * @return Player
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
     * Set hp
     *
     * @param integer $hp
     * @return Player
     */
    public function setHp($hp)
    {
        $this->hp = $hp;

        return $this;
    }

    /**
     * Get hp
     *
     * @return integer 
     */
    public function getHp()
    {
        return $this->hp;
    }

    /**
     * Set x
     *
     * @param integer $x
     * @return Player
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
     * @return Player
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
     * @var integer
     */
    private $conId;


    /**
     * Set conId
     *
     * @param integer $conId
     * @return Player
     */
    public function setConId($conId)
    {
        $this->conId = $conId;

        return $this;
    }

    /**
     * Get conId
     *
     * @return integer 
     */
    public function getConId()
    {
        return $this->conId;
    }
    /**
     * @var \Map
     */
    private $map;


    /**
     * Set map
     *
     * @param \Map $map
     * @return Player
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
    private $pwd;


    /**
     * Set pwd
     *
     * @param string $pwd
     * @return Player
     */
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;

        return $this;
    }

    /**
     * Get pwd
     *
     * @return string 
     */
    public function getPwd()
    {
        return $this->pwd;
    }
    /**
     * @var integer
     */
    private $online;


    /**
     * Set online
     *
     * @param integer $online
     * @return Player
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }

    /**
     * Get online
     *
     * @return integer 
     */
    public function getOnline()
    {
        return $this->online;
    }
    /**
     * @var string
     */
    private $email;


    /**
     * Set email
     *
     * @param string $email
     * @return Player
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @var string
     */
    private $sprite;


    /**
     * Set sprite
     *
     * @param string $sprite
     * @return Player
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
     * @var booleam
     */
    private $gameMaster;


    /**
     * Set gameMaster
     *
     * @param \booleam $gameMaster
     * @return Player
     */
    public function setGameMaster(\booleam $gameMaster)
    {
        $this->gameMaster = $gameMaster;

        return $this;
    }

    /**
     * Get gameMaster
     *
     * @return \booleam 
     */
    public function getGameMaster()
    {
        return $this->gameMaster;
    }
    /**
     * @var integer
     */
    private $level;

    /**
     * @var integer
     */
    private $experience;


    /**
     * Set level
     *
     * @param integer $level
     * @return Player
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set experience
     *
     * @param integer $experience
     * @return Player
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * Get experience
     *
     * @return integer 
     */
    public function getExperience()
    {
        return $this->experience;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $items;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add items
     *
     * @param \Item $items
     * @return Player
     */
    public function addItem(\Item $items)
    {
        $this->items[] = $items;

        return $this;
    }

    /**
     * Remove items
     *
     * @param \Item $items
     */
    public function removeItem(\Item $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }
    /**
     * @var string
     */
    private $ip;

    /**
     * @var integer
     */
    private $lastJoin;


    /**
     * Set ip
     *
     * @param string $ip
     * @return Player
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set lastJoin
     *
     * @param integer $lastJoin
     * @return Player
     */
    public function setLastJoin($lastJoin)
    {
        $this->lastJoin = $lastJoin;

        return $this;
    }

    /**
     * Get lastJoin
     *
     * @return integer 
     */
    public function getLastJoin()
    {
        return $this->lastJoin;
    }
}
