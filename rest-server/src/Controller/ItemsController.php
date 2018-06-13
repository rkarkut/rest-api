<?php declare(strict_types=1);

namespace App\Controller;

use App\Controller\Presenter\ItemPresenter;
use App\Controller\Presenter\ItemsPresenter;
use App\Domain\Items\CreateItemCommand;
use App\Domain\Items\ItemsException;
use App\Domain\Items\ItemsService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class ItemsController
 * @package App\Controller
 */
class ItemsController extends Controller
{
    /**
     * @param Request $request
     * @param ItemsService $service
     * @return JsonResponse
     */
    public function getItemsAction(Request $request, ItemsService $service): Response
    {
        $items = $service->getAllItems(Filter::createFromRequest($request));
        $presenter = new ItemsPresenter($items);
        return $this->json($presenter->present());
    }

    /**
     * @param Request $request
     * @param ItemsService $service
     * @return Response
     */
    public function createItemAction(Request $request, ItemsService $service): Response
    {
        try {
            $item = $service->createItem(
                CreateItemCommand::createFromRequest(json_decode($request->getContent(), true))
            );
            $itemPresenter = new ItemPresenter($item);
            return $this->json($itemPresenter->present(), Response::HTTP_CREATED);

        } catch (ItemsException $e) {
            return $this->json(
                ['error' => 'Invalid params', 'details' => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * @param int $id
     * @param ItemsService $service
     * @return Response
     */
    public function deleteItemAction(int $id, ItemsService $service): Response
    {
        $service->deleteItem($id);
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param int $id
     * @param Request $request
     * @param ItemsService $service
     * @return Response
     */
    public function updateItemAction(int $id, Request $request, ItemsService $service): Response
    {
        try {
            $item = $service->updateItem(
                $id,
                CreateItemCommand::createFromRequest(json_decode($request->getContent(), true))
            );
            $itemPresenter = new ItemPresenter($item);
            return $this->json($itemPresenter->present(), Response::HTTP_OK);

        } catch (ItemsException $e) {
            return $this->json(
                ['error' => 'Incorrect request', 'details' => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
