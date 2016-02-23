<?php

namespace App\Http\Controllers\ApiV1;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response as IlluminateResponse;
use InvalidArgumentException;
use App\Http\Controllers\Controller;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

abstract class ApiController extends Controller {

    /**
     * @var Manager
     */
    private $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @var int
     */
    private $responseStatusCode = 200;

    /**
     * @param $limit
     * @param int $max
     * @param int $min
     * @return mixed
     */
    public function limit($limit, $max, $min = 1)
    {
        return min(max((int) $limit, $min), $max);
    }

    /**
     * @return int
     */
    protected function getStatusCode()
    {
        return $this->responseStatusCode;
    }

    /**
     * @param $code
     * @return ApiController
     */
    protected function setStatusCode($code)
    {
        $this->responseStatusCode = $code;

        return $this;
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($data)
    {
        return response()->json($data, $this->getStatusCode());
    }

    /**
     * @param $item
     * @param TransformerAbstract $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseItem($item, TransformerAbstract $transformer)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_OK)
            ->response($this->manager->createData(new Item($item, $transformer))->toArray());
    }

    /**
     * @param array $items
     * @param TransformerAbstract $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseCollection(array $items, TransformerAbstract $transformer)
    {
        $resource = new Collection($items, $transformer);

        return $this->setStatusCode(IlluminateResponse::HTTP_OK)
            ->response($this->manager->createData($resource)->toArray());
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @param TransformerAbstract $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithPagination(LengthAwarePaginator $paginator, TransformerAbstract $transformer)
    {
        $resource = new Collection($paginator->items(), $transformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $this->setStatusCode(IlluminateResponse::HTTP_OK)
            ->response($this->manager->createData($resource)->toArray());
    }

    /**
     * @param string $message
     * @return mixed
     */
    protected function responseNotFound($message = null)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)
            ->responseWithError($message);
    }

    /**
     * @param string $message
     * @return mixed
     */
    protected function responseValidationFailed($message = null)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->responseWithError($message);
    }

    /**
     * @param $message
     * @return mixed
     */
    protected function responseWithError($message = null)
    {
        if ($message === null) {
            $message = $this->tryCreateErrorMessage();
        }

        return $this->response([
            'error' => $message
        ]);
    }

    /**
     * @return mixed
     */
    private function tryCreateErrorMessage()
    {
        if (isset(IlluminateResponse::$statusTexts[$this->getStatusCode()])) {
            return IlluminateResponse::$statusTexts[$this->getStatusCode()];
        }

        throw new InvalidArgumentException('Cannot resolve error message by using code ' . $this->getStatusCode());
    }

}