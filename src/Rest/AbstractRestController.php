<?php
namespace Inspiration\Rest;

abstract class AbstractRestController {

	private $header;
	private $request;
	private $response;
	private $body;
    private $application;

     /**
     * Gets the value of header.
     *
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Sets the value of header.
     *
     * @param mixed $header the header
     *
     * @return self
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Gets the value of request.
     *
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Sets the value of request.
     *
     * @param mixed $request the request
     *
     * @return self
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Gets the value of response.
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Sets the value of response.
     *
     * @param mixed $response the response
     *
     * @return self
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Gets the value of body.
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Sets the value of body.
     *
     * @param mixed $body the body
     *
     * @return self
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Gets the value of application.
     *
     * @return mixed
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Sets the value of application.
     *
     * @param mixed $application the application
     *
     * @return self
     */
    public function setApplication($application)
    {
        $this->application = $application;

        return $this;
    }
}