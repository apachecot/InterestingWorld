<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Image;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class LocationController
 * @package ApiBundle\Controller
 */
class ImagesController extends FOSRestController
{
    /**
     * @Rest\Get("/last/images", name="getLastImages")
     * @Rest\QueryParam(name="limit", nullable=true, description="How many images to return", requirements="\d+")
     * @Rest\QueryParam(name="page", nullable=true, description="Actual page", requirements="\d+")
     *
     * @ApiDoc(
     *     section="Images",
     *     resource=true,
     *     description="Get last 20 images ordered by creation date"
     * )
     */
    public function getLastImagesAction(ParamFetcher $parameters)
    {
        $limit = $parameters->get('limit', true) ?: Image::LIMIT;
        $page = $parameters->get('page', true) ?: 1;

        $locations = $this->getDoctrine()->getRepository('AppBundle:Image')->findLastImages($limit, $page);

        return $locations;
    }

    /**
     * @Rest\Get("/uploaded/images/{userId}", name="getUploadedImagesByUser")
     * @Rest\QueryParam(name="limit", nullable=true, description="How many images to return", requirements="\d+")
     * @Rest\QueryParam(name="page", nullable=true, description="Actual page", requirements="\d+")
     *
     * @ApiDoc(
     *     section="Images",
     *     resource=true,
     *     description="Get uploaded images by user",
     *     requirements={
     *      {
     *          "name"="userId",
     *          "dataType"="integer",
     *          "description"="User id"
     *      }
     *  }
     * )
     */
    public function getUploadedImagesByUser($userId, ParamFetcher $parameters)
    {
        $limit = $parameters->get('limit', true) ?: Image::LIMIT;
        $page = $parameters->get('page', true) ?: 1;

        $images = $this->getDoctrine()->getRepository('AppBundle:Image')
            ->findUploadedImagesByUser($userId, $limit, $page);

        return $images;
    }

    /**
     * @Rest\Get("/location/images/{locationId}", name="getLocationImages")
     * @Rest\QueryParam(name="limit", nullable=true, description="How many images to return", requirements="\d+")
     * @Rest\QueryParam(name="page", nullable=true, description="Actual page", requirements="\d+")
     *
     * @ApiDoc(
     *     section="Images",
     *     resource=true,
     *     description="Get location images",
     *     requirements={
     *      {
     *          "name"="locationId",
     *          "dataType"="integer",
     *          "description"="Location id"
     *      }
     *  }
     * )
     */
    public function getLocationImages($locationId, ParamFetcher $parameters)
    {
        $limit = $parameters->get('limit', true) ?: Image::LIMIT;
        $page = $parameters->get('page', true) ?: 1;

        $images = $this->getDoctrine()->getRepository('AppBundle:Image')
            ->findLocationImages($locationId, $limit, $page);

        return $images;
    }

    /**
     * @Rest\Get("/images/rated/{userId}", name="getRatedImagesByUser")
     * @Rest\QueryParam(name="limit", nullable=true, description="How many images to return", requirements="\d+")
     * @Rest\QueryParam(name="page", nullable=true, description="Actual page", requirements="\d+")
     *
     * @ApiDoc(
     *     section="Images",
     *     resource=true,
     *     description="Get images rated by user",
     *     requirements={
     *      {
     *          "name"="userId",
     *          "dataType"="integer",
     *          "description"="User id"
     *      }
     *  }
     * )
     */
    public function getRatedImagesByUser($userId, ParamFetcher $parameters)
    {
        $limit = $parameters->get('limit', true) ?: Image::LIMIT;
        $page = $parameters->get('page', true) ?: 1;

        $images = $this->getDoctrine()->getRepository('AppBundle:ImageRating')
            ->findRatedImagesByUser($userId, $limit, $page);

        return $images;
    }

    /**
     * @Rest\Get("/image/rating/{imageId}", name="getImageRating")
     *
     * @ApiDoc(
     *     section="Images",
     *     resource=true,
     *     description="Get rating of specific image",
     *     requirements={
     *      {
     *          "name"="imageId",
     *          "dataType"="integer",
     *          "description"="Image id"
     *      }
     *  }
     * )
     */
    public function getImageRating($imageId)
    {
        $rating = $this->getDoctrine()->getRepository('AppBundle:ImageRating')->countImageRating($imageId);

        return $rating;
    }
}
