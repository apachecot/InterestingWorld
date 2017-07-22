<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Location;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class CommentController
 * @package ApiBundle\Controller
 */
class CommentController extends FOSRestController
{
    /**
     * @Rest\Get("/location/comments/{locationId}", name="getLocationComments")
     * @Rest\QueryParam(name="limit", nullable=true, description="How many comments to return", requirements="\d+")
     * @Rest\QueryParam(name="page", nullable=true, description="Actual page", requirements="\d+")
     *
     * @ApiDoc(
     *     section="Comment",
     *     resource=true,
     *     description="Get last comments from location"
     * )
     */
    public function getLocationCommentsAction($locationId, ParamFetcher $parameters)
    {
        $limit = $parameters->get('limit', true) ?: Location::LIMIT;
        $page = $parameters->get('page', true) ?: 1;

        $locations = $this->getDoctrine()->getRepository('AppBundle:Comment')
            ->findLocationComments($locationId, $limit, $page);

        return $locations;
    }

    /**
     * @Rest\Get("/user/comments/{userId}", name="getUserComments")
     * @Rest\QueryParam(name="limit", nullable=true, description="How many comments to return", requirements="\d+")
     * @Rest\QueryParam(name="page", nullable=true, description="Actual page", requirements="\d+")
     *
     * @ApiDoc(
     *     section="Comment",
     *     resource=true,
     *     description="Get comments from user"
     * )
     */
    public function getUserCommentsAction($userId, ParamFetcher $parameters)
    {
        $limit = $parameters->get('limit', true) ?: Location::LIMIT;
        $page = $parameters->get('page', true) ?: 1;

        $locations = $this->getDoctrine()->getRepository('AppBundle:Comment')
            ->findUserComments($userId, $limit, $page);

        return $locations;
    }
}
