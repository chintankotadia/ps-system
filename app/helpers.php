<?php

if (! function_exists('pp')) {
    /**
     * Pretty Print
     *
     * @param  array   $data
     * @param  integer $die
     * @return mixed
     */
    function pp($data, $die = 0)
    {
        echo '<pre>';
        echo print_r($data, 1);
        echo '</pre>';
        if ($die) { die(); }
    }
}

if(!function_exists('alert_message')) {
    /**
     * Show alert message
     *
     * @param string $type
     * @param string $message
     * @return html
     */
    function alert_message($type, $message)
    {
        if ($type == 'error') {
            $alert = '
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$message.'
                </div>';
        } elseif ($type == 'success') {
            $alert = '
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$message.'
                </div>';
        } elseif ($type == 'warning') {
            $alert = '
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $message . '
                </div>';
        } else {
            $alert = '
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $message . '
                </div>';
        }

        return $alert;
    }
}

if (! function_exists('checkAdmin')) {
    /**
     * Check is user is admin or not
     *
     * @return boolean
     */
    function checkAdmin()
    {
        return Sentry::getUser()->hasAccess('admin');
    }
}

if (! function_exists('configGet')) {
    /**
     * Get config varible
     *
     * @param string $var
     * @return mixed
     */
    function configGet($var)
    {
        return Config::get($var);
    }
}

?>
