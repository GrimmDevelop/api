<?php

namespace App\Http\Controllers\ApiV1;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response as IlluminateResponse;
use InvalidArgumentException;
use App\Http\Controllers\Controller;
use App\Transformers\TransformerInterface;

abstract class ApiController extends Controller {

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
     * @param array $meta
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($data, array $meta = [])
    {
        return response()->json(array_merge($meta, [
            'data' => $data,
        ]), $this->getStatusCode());
    }

    /**
     * @param $item
     * @param TransformerInterface $transformer
     * @param array $meta
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseItem($item, TransformerInterface $transformer, array $meta = [])
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_OK)
            ->response($transformer->transform($item), $meta);
    }

    /**
     * @param array $items
     * @param TransformerInterface $transformer
     * @param array $meta
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseCollection(array $items, TransformerInterface $transformer, array $meta = [])
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_OK)
            ->response($transformer->transformCollection($items), $meta);
    }

    /**
     * @param LengthAwarePaginator $items
     * @param TransformerInterface $transformer
     * @param array $meta
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithPagination(LengthAwarePaginator $items, TransformerInterface $transformer, array $meta = [])
    {
        return $this->responseCollection($items->items(), $transformer, array_merge($meta, [
            'paginator' => [
                'total_count' => $items->total(),
                'total_pages' => $items->lastPage(),
                'current_page' => $items->currentPage(),
                'links' => [
                    'self' => $items->url($items->currentPage()),
                    'prev' => $items->previousPageUrl(),
                    'next' => $items->nextPageUrl(),
                ],
            ]
        ]));
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

        return response()->json([
            'error' => $message
        ], $this->getStatusCode());
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