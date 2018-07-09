<?php

namespace Magentochamp\ChProductImporter\Helper;
use Magento\Store\Model\ScopeInterface;
use Magentochamp\ChProductImporter\Logger\Logger;
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{  
    const XML_PATH_CHIMPORT = 'chproductimporter/';
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;
    
    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;
    protected $eavConfig;
    protected $attributeOptionManagement;
    protected $optionLabelFactory;
    protected $optionFactory;
    protected $_productFactory;
    protected $datetime;
    protected $importModel;
    private $logger;
    protected $scopeConfig;
    protected $importLogger;

    public function __construct(
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Eav\Api\AttributeOptionManagementInterface $attributeOptionManagement,
        \Magento\Eav\Api\Data\AttributeOptionLabelInterfaceFactory $optionLabelFactory,
        \Magento\Eav\Api\Data\AttributeOptionInterfaceFactory $optionFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\ImportExport\Model\Import $importModel,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\Stdlib\DateTime\DateTime $datetime,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $logger,
        Logger $importLogger,
        \Magento\Framework\App\Helper\Context $context
    ) {
        $this->_objectManager= $objectManager;
        $this->eavConfig= $eavConfig;
        $this->attributeOptionManagement= $attributeOptionManagement;
        $this->optionLabelFactory= $optionLabelFactory;
        $this->optionFactory= $optionFactory;
        $this->_productFactory = $productFactory;
        $this->_resource = $resource;
        $this->datetime = $datetime;
        $this->importModel = $importModel;
        $this->scopeConfig = $scopeConfig;
        $this->_objectManager = $objectManager;
        $this->_resource = $resource;
        $this->importLogger = $importLogger;
        parent::__construct($context);
    }

    public function executeProcess()
    {
        try {
            
            $connection = $this->_resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
            $feedUrl = $this->getGeneralConfig('feedurl');
            $data = file_get_contents($feedUrl);
            $dataArr = array();
            $dataArr['file'] = $data;
            $dataArr['created_at'] = $this->datetime->gmtDate();
            $dataArr['updated_at'] = $this->datetime->gmtDate();
            $dataArr['status'] = '1';
            $fetchData = $this->fetchData();
            $parsed_xml = simplexml_load_string($fetchData['file'],null, LIBXML_NOCDATA);
            $productArray = json_decode(json_encode((array) $parsed_xml), true);
            $createArr = array();
            $i = 0;       
            foreach($productArray['StockItem'] as $product){

                $createArr[$i]['sku'] = $product['Code'];
                $createArr[$i]['name'] = $product['Description'];
                $createArr[$i]['weight'] = 1;
                $createArr[$i]['cost'] = $product['SellingPrice'];
                $createArr[$i]['price'] = $product['SellingPrice']*3;
                $createArr[$i]['special_price'] = $product['SellingPrice']*2.1;
                $createArr[$i]['product_type'] = 'simple';
                $createArr[$i]['attribute_set_code'] = 'Default';
                $createArr[$i]['description'] = $product['Description'];
                $createArr[$i]['short_description'] = $product['Description'];
                $createArr[$i]['store_view_code'] = '';
                $createArr[$i]['tax_class_name'] = 'Taxable Goods';
                $createArr[$i]['visibility'] = 'Catalog, Search';
                $createArr[$i]['qty'] = $product['FreeStock'];
                $createArr[$i]['is_in_stock'] = 1;
                $createArr[$i]['website_id'] = 1;
                $createArr[$i]['_attribute_set'] = 'Default';
                $createArr[$i]['_product_websites'] = 'base';
                $createArr[$i]['status'] = 1;
                $createArr[$i]['has_options'] = 0;
                $createArr[$i]['quantity_and_stock_status'] = 'In Stock';
                $createArr[$i]['required_options'] = 0;
                $createArr[$i]['merchant_qty'] = 9;
                $createArr[$i]['item_length'] = (int)preg_replace("/[^A-Za-z0-9 .]/", '', $product['Dimensions']['Item']['Length']);
                $createArr[$i]['item_width'] = (int)preg_replace("/[^A-Za-z0-9 .]/", '',$product['Dimensions']['Item']['Width']);
                $createArr[$i]['item_height'] = (int)preg_replace("/[^A-Za-z0-9 .]/", '',$product['Dimensions']['Item']['Height']);
                $createArr[$i]['item_depth'] = (int)preg_replace("/[^A-Za-z0-9 .]/", '',$product['Dimensions']['Item']['Depth']);
                $createArr[$i]['item_diameter'] = (int)preg_replace("/[^A-Za-z0-9 .]/", '',$product['Dimensions']['Item']['Diameter']);
            // $createArr[$i]['item_width'] = 10;
                $i++;
            }                                 
            $this->importSimpleProducts($createArr, $this->_objectManager);
            echo count($createArr)." products imported successfully...";   

        } catch (\Exception $e) {
                $dataArr = array();
                $dataArr['file'] = 'error';
                $dataArr['created_at'] = $this->datetime->gmtDate();
                $dataArr['updated_at'] = $this->datetime->gmtDate();
                $dataArr['status'] = 'Error log path:- /var/log/customfile.log';

                $this->insertData($dataArr);
                echo $e->getMessage();
                $this->importLogger->debug($e->getMessage());
            }
        }

        public function insertData($dataArr){
            $connection = $this->_resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
            $connection->insert('chproductimporter',$dataArr);
        }

        public function fetchData(){
            $connection = $this->_resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
            $query = " SELECT * FROM chproductimporter ORDER BY id DESC LIMIT 1";
            return $connection->fetchRow($query);
        }

        public function addAttributeOption($attributeCode, $value)
        {
            /** @var \Magento\Eav\Model\Entity\Attribute\OptionLabel $optionLabel */
            $optionLabel = $this->optionLabelFactory->create();
            $optionLabel->setStoreId(0);
            $optionLabel->setLabel($value);

            $option = $this->optionFactory->create();
            $option->setLabel($optionLabel);
            $option->setStoreLabels([$optionLabel]);
            $option->setSortOrder(0);
            $option->setIsDefault(false);

            $this->attributeOptionManagement->add(
                'catalog_product',
                $attributeCode,
                $option
            );

        // Get the inserted ID. Should be returned from the installer, but it isn't.
            $attribute = $this->eavConfig->getAttribute('catalog_product', $attributeCode);
            $optionId = $attribute->getSource()->getOptionId($value);

            return $optionId;
        }

        public function checkAttribute($attibuteCode,$label){
            $attr = $this->_productFactory->create()->getResource()->getAttribute($attibuteCode);
            if($attr){
                $optionId = '';
                $getId = $attr->getSource()->getOptionId($label);
                if(!empty($getId)){
                    $optionId = $getId;
                }else{
                    $optionId = $this->addAttributeOption($attibuteCode,$label);
                }

                return $optionId;      
            }
        }
        function importSimpleProducts( $importProducts, $objectManager ) {
            $filesystem = $objectManager->create('Magento\Framework\Filesystem');
            $loggerObj = $objectManager->create('Magentochamp\ChProductImporter\Logger\Logger');
            echo $loggerObj->getData('fileName');die;
            $io = $objectManager->create('Magento\Framework\Filesystem\Io\File');


            $mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
            $i = 0;

            foreach( $importProducts as $importProduct ) {
                try {
                    if($this->productValidate($importProduct['sku']) === false){
                        continue;
                    }
                    $filearr = array();
                    $file = '';
                    $getSku = '';
                    $getSku = $importProduct['sku'];
                    $firstletter = strtolower(substr($getSku,0,1));
                    $secondletter = strtolower(substr($getSku,1,1));
                    $mediaPath = $mediaDirectory->getAbsolutePath().'catalog/product/'.$firstletter.'/'.$secondletter.'/';
                    if (!is_dir($mediaPath)) {
                        $io->mkdir($mediaPath, 0775);
                    }
                    $file = '';
                    $filename = '';
                    $filepath = '';
                    while($i <= 3){
                        if($i == 0){
                            $file = 'http://www.coachhouse.com/images/product/large/'.$getSku.'.jpg';
                        }else{
                            $file = 'http://www.coachhouse.com/images/product/large/'.$getSku.'_'.$i.'_'.'.jpg';
                        }
                        $file_headers = @get_headers($file);
                        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                            $exists = false;
                            $i = 0;
                            break;    
                        }else {
                        $image_url  = str_replace("https://", "http://", $file); // replace https tp http
                        $image_type = substr(strrchr($image_url,"."),1); //find the image extension
                        if($i == 0){
                            $filename   = $getSku.'.'.$image_type;
                        }else{
                            $filename   = $getSku.'_'.$i.'_'.'.'.$image_type;
                        }    
                        $filepath = $mediaPath.$filename;
                        $curl_handle = curl_init();
                        curl_setopt($curl_handle, CURLOPT_URL,$file);
                        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
                        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Cirkel');
                        $query = curl_exec($curl_handle);
                        curl_close($curl_handle);
                        file_put_contents($filepath, $query);
                        $exists = true;
                    }
                    $i++;      
                    array_push($filearr,$filepath);
                }
                $skuload = $objectManager->create('Magento\Catalog\Model\Product')->getIdBySku($importProduct['sku']);
                $checkLength =  $this->checkAttribute('item_length',$importProduct['item_length']);
                $checkWidth =  $this->checkAttribute('item_width',$importProduct['item_width']);
                $checkHeight =  $this->checkAttribute('item_height',$importProduct['item_height']);
                $checkDepth =  $this->checkAttribute('item_depth',$importProduct['item_depth']);
                $checkDiameter =  $this->checkAttribute('item_diameter',$importProduct['item_diameter']);
                if($skuload){
                    $productFactory = $objectManager->get('\Magento\Catalog\Model\ProductFactory');
                    $product = $productFactory->create()->setStoreId(1)->load($skuload);
                    $productRepository = $objectManager->create('Magento\Catalog\Api\ProductRepositoryInterface');
                    $existingMediaGalleryEntries = $product->getMediaGalleryEntries();
                    foreach ($existingMediaGalleryEntries as $key => $entry) {
                        unset($existingMediaGalleryEntries[$key]);
                    }
                    $product->setMediaGalleryEntries($existingMediaGalleryEntries);
                    $productRepository->save($product);
                    foreach($filearr as $fileObj){
                        $product->addImageToMediaGallery($fileObj, array('image', 'small_image', 'thumbnail'), false, false);
                    }
                    $product->setName($importProduct['name']); 
                    $product->setPrice($importProduct['price']) ;
                    $product->setSpecialPrice($importProduct['special_price']) ;
                    $product->setCost($importProduct['cost']);
                    $product->setDescription($importProduct['description']);
                    $product->setItemLength($checkLength);
                    $product->setItemWidth($checkWidth);
                    $product->setItemHeight($checkHeight);
                    $product->setItemDepth($checkDepth);
                    $product->setItemDiameter($checkDiameter);
                    $product->save();
                }else{
                    $product = $objectManager->create('\Magento\Catalog\Model\Product');
                    $product->setWebsiteIds(array(1));
                    $product->setAttributeSetId(4);
                    $product->setTypeId('simple');
                    $product->setCreatedAt(strtotime('now')); 
                    //                    $product->addImageToMediaGallery($filepath, array('image', 'small_image', 'thumbnail'), false, false);
                    foreach($filearr as $fileObj){
                        $product->addImageToMediaGallery($fileObj, array('image', 'small_image', 'thumbnail'), false, false);
                    }
                    $product->setName($importProduct['name']); 
                    $product->setSku($importProduct['sku']);
                    $product->setWeight($importProduct['weight']);
                    $product->setStatus($importProduct['status']);
                    $category_id = array(1,2);
                    $product->setCategoryIds($category_id); 
                    $product->setTaxClassId(0); // (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                    $product->setVisibility(4); // catalog and search visibility
                    $product->setPrice($importProduct['price']) ;
                    $product->setSpecialPrice($importProduct['special_price']) ;
                    $product->setCost($importProduct['cost']); 
                    $product->setDescription($importProduct['description']);
                    $product->setShortDescription($importProduct['description']);
                    $product->setStockData(
                        array('use_config_manage_stock' => 0,
                            'manage_stock' => 1,
                            'min_sale_qty' => 1,
                            'max_sale_qty' => 2,
                            'is_in_stock' => 1,
                            'qty' => (int)$importProduct['qty'])
                    );
                    $product->setItemLength($checkLength);
                    $product->setItemWidth($checkWidth);
                    $product->setItemHeight($checkHeight);
                    $product->setItemDepth($checkDepth);
                    $product->setItemDiameter($checkDiameter);
                    $product->save();
                }
            }catch(Exception $e){ 
                echo 'Something failed for product import ' . $importProduct['name'] . PHP_EOL;
                print_r($e);
            }
        }
    }

    public function productValidate($sku){
        if($sku){
            return true;
        }else{
            return false;
        }
    }
    
    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_CHIMPORT .'general/'. $code, $storeId);
    }
    
    public function getCronConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_CHIMPORT .'cron/'. $code, $storeId);
    }
    
    /**
    * get config value
    * @param string $field
    * @param int|null $storeId
    * @return string 
    */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }
}
