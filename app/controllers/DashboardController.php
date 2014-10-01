<?php

/**
 * Dashboard Controller
 *
 * @package Laravel Core
 */
class DashboardController extends BaseController
{
    public function __construct()
    {

    }

    public function getIndex()
    {
        return View::make('dashboards/index');
    }
}
