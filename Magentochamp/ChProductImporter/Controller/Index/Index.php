<?php
namespace Magentochamp\ChProductImporter\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_objectManager;

    protected $datetime;

    protected $importModel;
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Magento\ImportExport\Model\Import $importModel,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\Stdlib\DateTime\DateTime $datetime
    ) {
        $this->datetime = $datetime;
        $this->importModel = $importModel;
        parent::__construct($context);
        $this->_objectManager = $objectManager;
        $this->_resource = $resource;
    }

    public function execute()
    {
		$connection = $this->_resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
		$data = file_get_contents('http://www.coachhouse.com/feed/stockfeed.xml');
		$dataArr = array();
		$dataArr['file'] = $data;
		$dataArr['created_at'] = $this->datetime->gmtDate();
		$dataArr['updated_at'] = $this->datetime->gmtDate();
		$dataArr['status'] = '1';
		//$this->_objectManager->create('Magentochamp\ChProductImporter\Helper\Data')->insertData($dataArr);
		$fetchData = $this->_objectManager->create('Magentochamp\ChProductImporter\Helper\Data')->fetchData();
		$data = 'http://www.coachhouse.com/feed/stockfeed.xml';
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
			$i++;
		}
		$this->importSimpleProducts($createArr, $this->_objectManager);
		/*$jsonData = json_encode($createArr);
		$createData = array();
		$createData['entity'] = 'catalog_product';
		$createData['behavior'] = 'append';
		$createData['data'] = $jsonData;

		$connection->insert('importexport_importdata',$createData);
		$data = array('entity' => 'catalog_product','behavior'=>'append','validation_strategy'=>'validation-stop-on-errors','allowed_error_count'=>'10');

		$this->importModel->setData($data);
		$errorAggregator = $this->importModel->getErrorAggregator();
		try {
			$this->importModel->importSource();echo "Done";
		} catch (\Exception $e) {
			echo $e;
			echo "error";
		}

		if ($this->importModel->getErrorAggregator()->hasToBeTerminated()) {
			echo __('Maximum error count has been reached or system error is occurred!');
		} else {
			echo __('Import successfully done');
		}*/
    	echo "<pre>";print_r($createArr);
    	die('sdfs');
    }
    ## import bulk product using array ##
	function importSimpleProducts( $importProducts, $objectManager ) {
		$filesystem = $objectManager->create('Magento\Framework\Filesystem');
		$io = $objectManager->create('Magento\Framework\Filesystem\Io\File');
		$mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
		foreach( $importProducts as $importProduct ) {
		try {
				if($this->productValidate($importProduct['sku']) === false){
				continue;
			}

			$file = '';
			$getSku = $importProduct['sku'];
			$firstletter = strtolower(substr($getSku,0,1));
			$secondletter = strtolower(substr($getSku,1,1));
			$mediaPath = $mediaDirectory->getAbsolutePath().'catalog/product/'.$firstletter.'/'.$secondletter.'/';
			if (!is_dir($mediaPath)) {
				$io->mkdir($mediaPath, 0775);
			}
				$file = 'http://www.coachhouse.com/images/product/large/'.$getSku.'.jpg';
				$file_headers = @get_headers($file);
				if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
		  		$exists = false;
				}else {
				$image_url  = str_replace("https://", "http://", $file); // replace https tp http
				$image_type = substr(strrchr($image_url,"."),1); //find the image extension
				$filename   = $getSku.'.'.$image_type;
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
		    $skuload = $objectManager->create('Magento\Catalog\Model\Product')->getIdBySku($importProduct['sku']);
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
		  		$product->addImageToMediaGallery($filepath, array('image', 'small_image', 'thumbnail'), false, false);
		        $product->setName($importProduct['name']); 
		        $product->setDescription($importProduct['description']);
		        $product->save();
		        echo "Created product:: ".count($skuload)."\n";
			}else{
				$product = $objectManager->create('\Magento\Catalog\Model\Product');
		        $product->setWebsiteIds(array(1));
		        $product->setAttributeSetId(4);
		        $product->setTypeId('simple');
		        $product->setCreatedAt(strtotime('now')); 
		        $product->addImageToMediaGallery($filepath, array('image', 'small_image', 'thumbnail'), false, false);
		        $product->setName($importProduct['name']); 
		        $product->setSku($importProduct['sku']);
		        $product->setWeight($importProduct['weight']);
		        $product->setStatus($importProduct['status']);
		        $category_id = array(1,2);
		        $product->setCategoryIds($category_id); 
		        $product->setTaxClassId(0); // (0 - none, 1 - default, 2 - taxable, 4 - shipping)
		        $product->setVisibility(4); // catalog and search visibility
		        $product->setColor(24);
		        $product->setPrice($importProduct['price']) ;
		        $product->setCost(1); 
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
		        $product->save();
				echo "Created product:: ".count($product->getId())."\n";
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
}