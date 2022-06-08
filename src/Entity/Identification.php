<?phpnamespace App\Entity;use App\Repository\IdentificationRepository;use Doctrine\Common\Collections\ArrayCollection;use Doctrine\Common\Collections\Collection;use Doctrine\ORM\Mapping as ORM;/** * @ORM\Entity(repositoryClass=IdentificationRepository::class) */class Identification{    /**     * @ORM\Id     * @ORM\GeneratedValue     * @ORM\Column(type="integer")     */    private $id;    /**     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="vendeur")     */    private $vendeur;    /**     * @ORM\ManyToOne(targetEntity=Dossier::class, inversedBy="identifications")     */    private $dossier;

/**
 * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="acheteur")
 */
private $acheteur;    public function getId(): ?int    {        return $this->id;    }    public function getVendeur(): ?Client    {        return $this->vendeur;    }    public function setVendeur(?Client $vendeur): self    {        $this->vendeur = $vendeur;        return $this;    }    public function getDossier(): ?Dossier    {        return $this->dossier;    }    public function setDossier(?Dossier $dossier): self    {        $this->dossier = $dossier;        return $this;    }

public function getAcheteur(): ?Client
{
    return $this->acheteur;
}

public function setAcheteur(?Client $acheteur): self
{
    $this->acheteur = $acheteur;

    return $this;
}}