<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Location;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class LocationController
 * @package ApiBundle\Controller
 */
class LocationController extends FOSRestController
{
    /**
     * @Rest\Get("/last/locations", name="getLastLocations")
     * @Rest\QueryParam(name="limit", nullable=true, description="How many locations to return", requirements="\d+")
     * @Rest\QueryParam(name="page", nullable=true, description="Actual page", requirements="\d+")
     *
     * @ApiDoc(
     *     section="Location",
     *     resource=true,
     *     description="Get last 20 locations ordered by creation date"
     * )
     */
    public function getLastLocationsAction(ParamFetcher $parameters)
    {
        $limit = $parameters->get('limit', true) ?: Location::LIMIT;
        $page = $parameters->get('page', true) ?: 1;

        $locations = $this->getDoctrine()->getRepository('AppBundle:Location')->findLastLocations($limit, $page);

        return $locations;
    }

    /**
     * @Rest\Get("/location/{id}", name="getLocation")
     *
     * @ApiDoc(
     *     section="Location",
     *     resource=true,
     *     description="Get a specific location",
     *     requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "description"="Location id"
     *      }
     *  }
     * )
     */
    public function getLocationAction($id)
    {
        $locations = $this->getDoctrine()->getRepository('AppBundle:Location')->find($id);

        return $locations;
    }

    /**
     * @Rest\Get("/location/rating/{id}", name="getLocationRating")
     *
     * @ApiDoc(
     *     section="Location",
     *     resource=true,
     *     description="Get rating from a specific location",
     *     requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "description"="Location id"
     *      }
     *  }
     * )
     */
    public function getLocationRating($id)
    {
        $locations = $this->getDoctrine()->getRepository('AppBundle:LocationRating')->countLocationRating($id);

        return $locations;
    }

    /**
     * @Rest\Get("/locations/rated/{userId}", name="getRatedLocationsByUser")
     * @Rest\QueryParam(name="limit", nullable=true, description="How many locations to return", requirements="\d+")
     * @Rest\QueryParam(name="page", nullable=true, description="Actual page", requirements="\d+")
     *
     * @ApiDoc(
     *     section="Location",
     *     resource=true,
     *     description="Get rated locations by user",
     *     requirements={
     *      {
     *          "name"="userId",
     *          "dataType"="integer",
     *          "description"="User id"
     *      }
     *  }
     * )
     */
    public function getLocationsRatedByUser($userId, ParamFetcher $parameters)
    {
        $limit = $parameters->get('limit', true) ?: Location::LIMIT;
        $page = $parameters->get('page', true) ?: 1;

        $locations = $this->getDoctrine()->getRepository('AppBundle:LocationRating')
            ->findLocationsRatedByUser($userId, $limit, $page);

        return $locations;
    }

    /**
     * @Rest\Get("/locations/visited/{userId}", name="getLocationVisited")
     * @Rest\QueryParam(name="limit", nullable=true, description="How many locations to return", requirements="\d+")
     * @Rest\QueryParam(name="page", nullable=true, description="Actual page", requirements="\d+")
     *
     * @ApiDoc(
     *     section="Location",
     *     resource=true,
     *     description="Get locations visited by user",
     *     requirements={
     *      {
     *          "name"="userId",
     *          "dataType"="integer",
     *          "description"="User id"
     *      }
     *  }
     * )
     */
    public function getLocationVisited($userId, ParamFetcher $parameters)
    {
        $limit = $parameters->get('limit', true) ?: Location::LIMIT;
        $page = $parameters->get('page', true) ?: 1;

        $locations = $this->getDoctrine()->getRepository('AppBundle:LocationVisited')
            ->findLocationsVisitedByUser($userId, $limit, $page);

        return $locations;
    }

    /**
     * @Rest\Get("/locations/near", name="getNearestLocations")
     * @Rest\QueryParam(name="lat", nullable=false, description="Latitude")
     * @Rest\QueryParam(name="lng", nullable=false, description="Longitude")
     * @Rest\QueryParam(name="distance", nullable=false, description="Delimeter distance to search locations")
     * @Rest\QueryParam(name="category", nullable=true, description="Filter by a specific category")
     *
     * @param ParamFetcher $parameters
     *
     * @ApiDoc(
     *     section="Location",
     *     resource=true,
     *     description="Get the nearest locations",
     * )
     *
     * @return JsonResponse
     */
    public function getNearestLocationsAction(ParamFetcher $parameters)
    {
        $lat = $parameters->get('lat', true);
        $lng = $parameters->get('lng', true);
        $distance = $parameters->get('distance', true);
        $category = $parameters->get('category') ?: null;

        $locations = $this->getDoctrine()->getRepository('AppBundle:Location')
            ->findNearestLocations($lat, $lng, $distance, $category);

        return $locations;
    }
}
