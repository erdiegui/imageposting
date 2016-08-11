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
            ->add('title', TextType::class)
            ->add('image', Image::class, [
                'entry_type'    => ImageType::class,
                'allow_add'     => true,
                'entry_options' => [
                    'required' => true,
                ],
            ])
            ;
        $builder->get('image')->addModelTransformer(new CallbackTransformer(
            function ($productImages) {
                $r = [];
                if (!is_array($productImages) && $productImages) {
                    $productImages = [$productImages];
                }
                if (!empty($productImages)) {
                    foreach ($productImages as $k => $productImage) {
                        if (!$productImage instanceof Image) {
                            $img = new Image();
                            $img->setSize($productImage['size']);
                            $img->setExtension($productImage['extension']);

                            $parsedFilePath = str_replace($this->symlinkDir, "", $productImage['image']);
                            $image = $this->fileSystem->read($parsedFilePath . "." . $productImage['extension']);
                            $img->setImage(base64_encode($image));
                        } else {
                            $img = $productImage;
                        }
                        $r[] = $img;
                    }
                }

                return $r;
            }
            ,
            function ($productImages) {
                if (is_array($productImages)) {
                    $r = [];
                    /** @var Image $image */
                    foreach ($productImages as $image) {
                        $img = $image->getImage();

                        if (!empty($img)) {
                            if (strpos($img, 'http') === 0) {
                                $img = base64_encode(file_get_contents($img));
                            } else {
                                if (strpos($image->getImage(), $this->symlinkDir) === 0) {
                                    $parsedFilePath = str_replace($this->symlinkDir, "", $image->getImage());
                                    if ($this->fileSystem->has($parsedFilePath)) {
                                        $img = $this->fileSystem->read($parsedFilePath);
                                    }
                                }
                            }
                            $image->setImage($img);
                            $r [$image->getSize()] = $image;
                        }
                    }

                    return $r;
                } else {
                    return $productImages;
                }

            }
        ));
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