<?php

namespace Stock\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class FilterusrrequestBf implements FilterInterface
{
	/**
	 * Do whatever processing this filter needs to do.
	 * By default it should not return anything during
	 * normal execution. However, when an abnormal state
	 * is found, it should return an instance of
	 * CodeIgniter\HTTP\Response. If it does, script
	 * execution will end and that Response will be
	 * sent back to the client, allowing for error pages,
	 * redirects, etc.
	 *
	 * @param RequestInterface $request
	 * @param array|null       $arguments
	 *
	 * @return mixed
	 */
	public function before(RequestInterface $request, $arguments = null)
	{
	    if (is_numeric(strpos($request->uri->getRoutePath(),"user/admin/save_user"))){
	        $userId=0;
	         (is_numeric((explode('/',$request->uri->getRoutePath()))[count(explode('/',$request->uri->getRoutePath()))-1])?$userId=(explode('/',$request->uri->getRoutePath()))[count(explode('/',$request->uri->getRoutePath()))-1]:null);
	         return redirect()->to(base_url('stock/admin/save_user/'.$userId));
        } else if (is_numeric(strpos($request->uri->getRoutePath(),"user/admin/list_user"))){
			return redirect()->to(base_url('stock/admin/list_user'));
	   	} else if (is_numeric(strpos($request->uri->getRoutePath(),"user/admin/delete_user"))) {
            $userId=0;
	         (is_numeric((explode('/',$request->uri->getRoutePath()))[count(explode('/',$request->uri->getRoutePath()))-1])?$userId=(explode('/',$request->uri->getRoutePath()))[count(explode('/',$request->uri->getRoutePath()))-1]:null);
            return redirect()->to(base_url('stock/admin/delete_user/'.$userId));
        }
	}

	/**
	 * Allows After filters to inspect and modify the response
	 * object as needed. This method does not allow any way
	 * to stop execution of other after filters, short of
	 * throwing an Exception or Error.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param array|null        $arguments
	 *
	 * @return mixed
	 */
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		//
	}
}
