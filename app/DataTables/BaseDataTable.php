<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;

class BaseDataTable extends DataTable
{
    protected $fastExcel = true;
    protected $baseRoute;
    protected $baseView;

    /**
     * Get the value of baseRoute
     */ 
    public function getBaseRoute()
    {
        return $this->baseRoute;
    }

    /**
     * Set the value of baseRoute
     *
     * @return  self
     */ 
    public function setBaseRoute($baseRoute)
    {
        $this->baseRoute = $baseRoute;

        return $this;
    }

    /**
     * Get the value of baseView
     */ 
    public function getBaseView()
    {
        return $this->baseView;
    }

    /**
     * Set the value of baseView
     *
     * @return  self
     */ 
    public function setBaseView($baseView)
    {
        $this->baseView = $baseView;

        return $this;
    }
}
