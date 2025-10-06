<?php

namespace ErfanMasboogh\Laran\DataTables;

use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable as BaseDataTable;

abstract class DataTable extends BaseDataTable
{
    public string $dataTableID = 'datatable';
    public string $pagingType = 'simple_numbers';
    public string $styleDataTable = "<'top'>rt<'row'<'col-sm-7'ip><'col-sm-5 index-dataTables_length'l>>";
    public string $disabled = 'style="cursor: not-allowed; opacity: 0.5;" onclick="return false;"';
    public string $orderDirection = 'desc'; // asc or desc
    public int $pageLength = 10;
    public int $orderByColumn = 0;

    /**
     * Optional method if you want to use the html builder.
     *
     * Example usage:
     * public function html(): HtmlBuilder
     * {
     * $html = parent::html();
     * $html->{sum method HtmlBuilder}();
     * return $html;
     * }
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId($this->dataTableID)
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->pageLength($this->pageLength)
            ->pagingType($this->pagingType)
            ->paging(true)
            ->parameters($this->parameters());
    }

    public function parameters(): array
    {
        return [
            'dom' => $this->styleDataTable,
            'paging' => true,
            'responsive' => true,
            'fixedHeader' => true,
            'processing' => true,
            'serverSide' => true,
            'lengthChange' => true,
            'searching' => false,
            'info' => true,
            'autoWidth' => false,
            'deferRender' => false,
            'scrollCollapse' => false,
            'scroller' => false,
            'language' => [
                'url' => asset('vendor/laran/libs/datatable/datatables-' . app()->getLocale() . '.json'),
            ],
            "order" => [
                [
                    $this->orderByColumn,
                    $this->orderDirection,
                ],
            ],
        ];
    }

    /**
     * Get getColumns definition.
     *
     * @return array
     */
    abstract public function getColumns(): array;

    public function showImage(string $imageSID = null): string
    {
        $imagePath = asset('vendor/laran/images/default.png');

        if ($imageSID) {
            $imagePath = route('storage.download', $imageSID);
        }

        return '<div><img src="' . $imagePath . '" style="width: 75px; height: 75px; border-radius: 10px" ></img></div>';
    }

    public function editAction(string $route): string
    {
        return '<div><a href="' . $route . '" class="btn btn-sm btn-outline-success"><i class="fa fa-lg fa-edit"></i></a></div>';
    }

    public function deleteAction(string $route): string
    {
        return '
    <div>
        <a href="' . $route . '"
       class="btn btn-sm btn-outline-danger"
       onclick="return confirm(\'' . lt('Deletion ensure') .'\')">
        <i class="fa fa-lg fa-trash"></i>
        </a>
    </div>';
    }
}
