<?php

namespace WebVision\AdvanceConfigurable\Plugin\Block\ConfigurableProduct\Product\View\Type;

use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Json\DecoderInterface;

class Configurable
{
    /**
     * @var EncoderInterface
     */
    protected $jsonEncoder;
    
    /**
     * @var DecoderInterface
     */
    protected $jsonDecoder;
    
    /**
     * @param EncoderInterface $jsonEncoder
     * @param DecoderInterface $jsonDecoder
     */
    public function __construct(
        EncoderInterface $jsonEncoder,
        DecoderInterface $jsonDecoder
    ) {
        $this->jsonEncoder = $jsonEncoder;
        $this->jsonDecoder = $jsonDecoder;
    }
    /**
     * @param \Magento\ConfigurableProduct\Block\Product\View\Type\Configurable $subject
     * @param $result
     *
     * @return string
     */
    public function afterGetJsonConfig(
        \Magento\ConfigurableProduct\Block\Product\View\Type\Configurable $subject,
        $result
    ) {
        // $objectManager = Magento\Framework\App\ObjectManager::getInstance();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /*$productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
        $product = $productRepository->get($subject->getProduct()->getDap());*/
        $productId = $objectManager->get('Magento\Catalog\Model\Product')->getIdBySku($subject->getProduct()->getDap());
        
        /* $data = $this->catalogSession->getData('firebear_configurableproducts');
        if(isset($data['child_id'])) {
            $productId = $data['child_id']; */
            $config = $this->jsonDecoder->decode($result);
            $defaultValues = array();
            foreach ($config['attributes'] as $attributeId => $attribute) {
                foreach ($attribute['options'] as $option) {
                    $optionId = $option['id'];
                    if(in_array($productId, $option['products'])) {
                        $defaultValues[$attributeId] = $optionId;
                    }
                }
            }
            $config['defaultValues'] = $defaultValues;
            $result = $this->jsonEncoder->encode($config);
        /* } */
        /* $this->catalogSession->getData('firebear_configurableproducts', true); */
        return $result;
    }
}
