<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class Pagination
{
    private int $current_page;
    private int $per_page;
    private int $total_pages;
    private array $buttons_data;
    private Collection $paginated_items;
    private Collection $items;
    private Request $request;

    /* Do not change this value because this pagination's algo would work well only with 3 buttons */
    private int $buttons_number = 3;


    public function __construct(Request $request, Collection $items)
    {
        $this->request = $request;
        $this->items = $items;
        $this->initPagination();
        $this->initButtonsData();
        $this->paginateItems();
    }

    public function initPagination()
    {
        $this->current_page = $this->request->has('page') ? $this->request->integer('page') : 1;
        $this->per_page = $this->request->has('per_page') ? $this->request->integer('per_page') : 10;
        $this->total_pages = (int) ceil($this->items->count() / $this->per_page);
    }

    public function getData()
    {
        $data = [
            'page' => $this->current_page,
            'per_page' => $this->per_page,
            'total_pages' => $this->total_pages,
            'pages' => $this->buttons_data,
            'items' => $this->paginated_items,
        ];

        return $data;
    }

    private function paginateItems()
    {
        if ($this->pageOutOfBoundaries())
        {
            $this->paginated_items = new Collection;
            return;
        }

        $this->paginated_items = $this->items->skip(($this->current_page - 1) * $this->per_page)->take($this->per_page)->values();
    }

    public function initButtonsData()
    {
        /*
            Button directions:
            - Left (active button = 3): <1> <2> 3
            - Right (active button = 1): 1 <2> <3>
            - Both (active button = 2): <1> 2 <3>
        */

        if ($this->onFirstPage())
        {
            $this->buttons_data = $this->buttonsFromCurrentPageToRight();
        }
        else if ($this->onLastPage())
        {
            $this->buttons_data = $this->buttonsFromCurrentPageToLeft();
        }
        else if (!$this->pageOutOfBoundaries())
        {
            $this->buttons_data = $this->buttonsFromCurrentPage();
        }
        else
        {
            $this->buttons_data = [];
        }
    }

    private function onFirstPage()
    {
        return $this->current_page == 1;
    }

    private function onLastPage()
    {
        return $this->current_page == $this->total_pages;
    }

    private function pageOutOfBoundaries(): bool
    {
        return $this->current_page < 1 || $this->current_page > $this->total_pages;
    }

    /**
     * Validates params passed to functions that generate pagination buttons data
     *
     * @param array &$params - Reference to the array of parameters
     *
     */
    private function validateParamsForPaginationButtons(array &$params)
    {
        // Set default parameters if none were given
        $params['set_active'] = !isset($params['set_active']) ? true : $params['set_active'];
        $params['last_page'] = !isset($params['last_page']) ? $this->total_pages : $params['last_page'];
        $params['buttons_limit'] = !isset($params['buttons_limit']) ? $this->buttons_number : $params['buttons_limit'];

        // Check if parameter types are matching
        if (
            !(gettype($params['set_active']) == 'boolean') ||
            !(gettype($params['last_page']) == 'integer') ||
            !(gettype($params['buttons_limit']) == 'integer')
        )
        {
            return false;
        }

        return true;
    }

    /**
     * When active button is in the middle
     */
    private function buttonsFromCurrentPage()
    {
        $buttons_one_side = (int) floor(($this->buttons_number - 1) / 2);
        $last_left_page = $this->current_page - $buttons_one_side;
        $last_right_page = $this->current_page + $buttons_one_side;

        $left_side_pages = $this->buttonsFromCurrentPageToLeft([
            'set_active' => false,
            'last_page' => $last_left_page
        ]);

        $right_side_pages = $this->buttonsFromCurrentPageToRight([
            'set_active' => false,
            'last_page' => $last_right_page
        ]);

        $current_page_arr = [$this->current_page => 'active'];

        $pagination_buttons_data = array_replace($left_side_pages, $current_page_arr, $right_side_pages);

        return $pagination_buttons_data;
    }

    /**
     * When active button is on the left
     *
     * @param array &$params - Reference to the array of parameters
     *
     */
    private function buttonsFromCurrentPageToRight(array $params = [])
    {
        if (!$this->validateParamsForPaginationButtons($params))
        {
            return [];
        }

        $last_page = $params['last_page'];
        $buttons_limit = $params['buttons_limit'];
        $set_active = $params['set_active'];

        $pagination_buttons_data = [];
        $page_counter = $this->current_page;
        $current_buttons_number = 1;

        if ($set_active)
            $pagination_buttons_data[$this->current_page] = 'active';

        while ($page_counter + 1 <= $last_page && $current_buttons_number + 1 <= $buttons_limit)
        {
            $page_counter++;
            $current_buttons_number++;
            $pagination_buttons_data[$page_counter] = 'inactive';
        }

        return $pagination_buttons_data;
    }

    /**
     * When active button is on the right
     *
     * @param array &$params - Reference to the array of parameters
     *
     */
    private function buttonsFromCurrentPageToLeft(array $params = [])
    {
        if (!isset($params['last_page'])) $params['last_page'] = 1;

        if (!$this->validateParamsForPaginationButtons($params))
        {
            return [];
        }

        $buttons_limit = $params['buttons_limit'];
        $set_active = $params['set_active'];
        $last_page = $params['last_page'];

        $pagination_buttons_data = [];
        $page_counter = $this->current_page;
        $current_buttons_number = 1;

        if ($set_active)
            $pagination_buttons_data[$this->current_page] = 'active';

        while ($page_counter - 1 >= $last_page && $current_buttons_number + 1 <= $buttons_limit)
        {
            $page_counter--;
            $current_buttons_number++;
            $pagination_buttons_data[$page_counter] = 'inactive';
        }

        ksort($pagination_buttons_data);

        return $pagination_buttons_data;
    }
}
