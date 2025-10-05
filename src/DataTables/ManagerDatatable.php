<?php

namespace ErfanMasboogh\Laran\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use ErfanMasboogh\Laran\DataTables\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;
use ErfanMasboogh\Laran\Models\Manager;

class ManagerDatatable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->filter(function ($query) {
                if (request('name')) {
                    $query->where('name', 'like', '%' . request('name') . '%');
                }
                if (request('family')) {
                    $query->where('family', 'like', '%' . request('family') . '%');
                }
                if (request('mobile')) {
                    $query->where('mobile', 'like', '%' . request('mobile') . '%');
                }
                return $query;
            })
            ->addColumn('image', function ($model) {
                return $this->showImage($model->imageSID);
            })
            ->editColumn('mobile', function ($model) {
                return '0' . $model->mobile;
            })
            ->addColumn('edit', function ($model) {
                return $this->editAction(route('admin.manager.edit', $model->ID));
            })
            ->rawColumns(['image', 'edit'])
            ->setTotalRecords($query->count())
            ->addIndexColumn()
            ->orderColumn('ID', ':column $1')
            ->setRowId('ID');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Manager $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->orderable(false),
            Column::make('image')->title(lt('Image preview'))->orderable(false),
            Column::make('name')->title(lt('Name'))->orderable(false),
            Column::make('family')->title(lt('Family'))->orderable(false),
            Column::make('mobile')->title(lt('Mobile'))->orderable(false),
            Column::make('edit')->title(lt('Edit'))->orderable(false),
        ];
    }
}
