<?php
namespace AppBundle\Form;

use AppBundle\Model\Image;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use League\Flysystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\ImageType;

class ReplyFormType extends AbstractType
{
    /**
     * @var Filesystem
     */
    private $fileSystem;
    /**
     * @var string
     */
    private $symlinkDir;

    /**
     * ReplyFormType constructor.
     * @param Filesystem $fileSystem
     * @param $symlinkDir
     */
    public function __construct(
        Filesystem $fileSystem,
        $symlinkDir
    ) {
        $this->fileSystem = $fileSystem;
        $this->symlinkDir = $symlinkDir;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Title'))
            ->add('imageFile', FilePreviewType::class, array('label' => 'New Image'));
    }

    public function configureOptions(
        OptionsResolver $resolver
    ) {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'method'             => 'post',
            'data_class'         => Image::class,
            'csrf_protection'    => false,
            'allow_extra_fields' => true,

        ]);
    }

}