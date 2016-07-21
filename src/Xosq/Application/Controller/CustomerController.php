<?php
namespace Xosq\Application\Controller;

use Xosq\Inspiration\Rest\AbstractRestController;

class CustomerController extends AbstractRestController{

	public function findAll(){
        $customerProvider = $this->getApplication()->getDataProviderFactory()->get('Xosq\Application\Model\Customer');
        var_dump($customerProvider);

    }
}